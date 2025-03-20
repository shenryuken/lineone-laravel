<?php

namespace App\Console\Commands;

use App\Models\PendingPayment;
use App\Models\Transaction;
use App\Services\RediPayService;
use App\Services\StripeService;
use App\Services\WalletService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckPendingPayments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payments:check-pending {--provider=all} {--limit=50}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check pending payments and update their status';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $provider = $this->option('provider');
        $limit = (int) $this->option('limit');

        $this->info("Checking pending payments for provider: {$provider}");

        $query = PendingPayment::where('status', 'pending');

        if ($provider !== 'all') {
            $query->where('provider', $provider);
        }

        // Get payments that haven't been checked in the last 5 minutes or have never been checked
        $query->where(function ($q) {
            $q->whereNull('last_checked_at')
              ->orWhere('last_checked_at', '<', now()->subMinutes(5));
        });

        // Order by oldest first and limit the number of records
        $pendingPayments = $query->orderBy('created_at')->limit($limit)->get();

        $this->info("Found {$pendingPayments->count()} pending payments to check");

        foreach ($pendingPayments as $payment) {
            $this->info("Checking payment {$payment->id} with reference {$payment->reference_id}");

            try {
                // Update the last checked timestamp
                $payment->update(['last_checked_at' => now()]);

                // Check if the transaction already exists
                $existingTransaction = Transaction::where('reference_id', $payment->reference_id)
                    ->where(function($query) use ($payment) {
                        $query->where('metadata->provider', $payment->provider);
                    })
                    ->first();

                if ($existingTransaction) {
                    $this->info("Transaction already exists for payment {$payment->id}");

                    // Update the pending payment status
                    $payment->update([
                        'status' => 'completed',
                        'metadata' => array_merge($payment->metadata ?? [], [
                            'transaction_id' => $existingTransaction->id,
                            'completed_at' => now()->toIso8601String(),
                        ])
                    ]);

                    continue;
                }

                // Check the payment status with the provider
                if ($payment->provider === 'redipay') {
                    $this->checkRediPayPayment($payment);
                } elseif ($payment->provider === 'stripe') {
                    $this->checkStripePayment($payment);
                }
                // Add other providers as needed

            } catch (\Exception $e) {
                $this->error("Error checking payment {$payment->id}: {$e->getMessage()}");
                Log::error("Error checking pending payment", [
                    'payment_id' => $payment->id,
                    'reference_id' => $payment->reference_id,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
            }
        }

        $this->info("Finished checking pending payments");
        return 0;
    }

    /**
     * Check a RediPay payment status
     */
    private function checkRediPayPayment(PendingPayment $payment)
    {
        $this->info("Checking RediPay payment {$payment->reference_id}");

        try {
            $rediPayService = new RediPayService();
            $paymentStatus = $rediPayService->checkPaymentStatusByReference($payment->reference_id);

            // If no payment found or empty response
            if (empty($paymentStatus) || !isset($paymentStatus['status'])) {
                $this->warn("No payment status found for {$payment->reference_id}");
                return;
            }

            $status = strtolower($paymentStatus['status']);

            // Update the payment metadata with the status check result
            $payment->update([
                'metadata' => array_merge($payment->metadata ?? [], [
                    'status_check' => [
                        'time' => now()->toIso8601String(),
                        'result' => $paymentStatus
                    ]
                ])
            ]);

            // If payment is successful, process it
            if ($status === 'paid' || $status === 'success' || $status === 'successful') {
                $this->info("Payment {$payment->reference_id} is successful, processing deposit");

                // Process the deposit
                DB::beginTransaction();

                try {
                    // Get the wallet
                    $wallet = $payment->wallet;

                    if (!$wallet) {
                        throw new \Exception("Wallet not found for payment {$payment->id}");
                    }

                    // Use wallet service to process the deposit
                    $walletService = new WalletService();
                    $result = $walletService->deposit(
                        $wallet,
                        (float)$payment->amount,
                        "Deposit via RediPay",
                        'redipay',
                        $payment->reference_id
                    );

                    // Update the pending payment status
                    $payment->update([
                        'status' => 'completed',
                        'metadata' => array_merge($payment->metadata ?? [], [
                            'transaction_id' => $result['deposit']->id,
                            'completed_at' => now()->toIso8601String(),
                        ])
                    ]);

                    DB::commit();

                    $this->info("Successfully processed payment {$payment->reference_id}");

                } catch (\Exception $e) {
                    DB::rollBack();

                    $this->error("Error processing deposit for payment {$payment->id}: {$e->getMessage()}");

                    // Update the pending payment with the error
                    $payment->update([
                        'status' => 'failed',
                        'metadata' => array_merge($payment->metadata ?? [], [
                            'error' => $e->getMessage(),
                            'failed_at' => now()->toIso8601String(),
                        ])
                    ]);

                    Log::error("Error processing deposit for pending payment", [
                        'payment_id' => $payment->id,
                        'reference_id' => $payment->reference_id,
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                }
            } elseif ($status === 'failed' || $status === 'cancelled' || $status === 'expired') {
                $this->warn("Payment {$payment->reference_id} has failed or been cancelled");

                // Update the pending payment status
                $payment->update([
                    'status' => 'failed',
                    'metadata' => array_merge($payment->metadata ?? [], [
                        'failed_at' => now()->toIso8601String(),
                        'reason' => "Payment {$status} according to provider"
                    ])
                ]);
            } else {
                $this->info("Payment {$payment->reference_id} is still pending with status: {$status}");
            }

        } catch (\Exception $e) {
            $this->error("Error checking RediPay payment {$payment->id}: {$e->getMessage()}");
            Log::error("Error checking RediPay payment status", [
                'payment_id' => $payment->id,
                'reference_id' => $payment->reference_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    /**
     * Check a Stripe payment status
     */
    private function checkStripePayment(PendingPayment $payment)
    {
        $this->info("Checking Stripe payment {$payment->reference_id}");

        try {
            // Get the payment intent ID from the metadata
            $paymentIntentId = $payment->metadata['payment_intent_id'] ?? null;

            if (!$paymentIntentId) {
                $this->warn("No payment intent ID found for {$payment->reference_id}");
                return;
            }

            $stripeService = new StripeService();
            $paymentIntent = $stripeService->retrievePaymentIntent($paymentIntentId);

            // Update the payment metadata with the status check result
            $payment->update([
                'metadata' => array_merge($payment->metadata ?? [], [
                    'status_check' => [
                        'time' => now()->toIso8601String(),
                        'result' => [
                            'status' => $paymentIntent->status,
                            'amount' => $paymentIntent->amount,
                            'currency' => $paymentIntent->currency,
                        ]
                    ]
                ])
            ]);

            // If payment is successful, process it
            if ($paymentIntent->status === 'succeeded') {
                $this->info("Payment {$payment->reference_id} is successful, processing deposit");

                // Process the deposit
                DB::beginTransaction();

                try {
                    // Get the wallet
                    $wallet = $payment->wallet;

                    if (!$wallet) {
                        throw new \Exception("Wallet not found for payment {$payment->id}");
                    }

                    // Use wallet service to process the deposit
                    $walletService = new WalletService();
                    $result = $walletService->deposit(
                        $wallet,
                        (float)$payment->amount,
                        "Deposit via Stripe",
                        'stripe',
                        $payment->reference_id
                    );

                    // Update the pending payment status
                    $payment->update([
                        'status' => 'completed',
                        'metadata' => array_merge($payment->metadata ?? [], [
                            'transaction_id' => $result['deposit']->id,
                            'completed_at' => now()->toIso8601String(),
                        ])
                    ]);

                    DB::commit();

                    $this->info("Successfully processed payment {$payment->reference_id}");

                } catch (\Exception $e) {
                    DB::rollBack();

                    $this->error("Error processing deposit for payment {$payment->id}: {$e->getMessage()}");

                    // Update the pending payment with the error
                    $payment->update([
                        'status' => 'failed',
                        'metadata' => array_merge($payment->metadata ?? [], [
                            'error' => $e->getMessage(),
                            'failed_at' => now()->toIso8601String(),
                        ])
                    ]);

                    Log::error("Error processing deposit for pending payment", [
                        'payment_id' => $payment->id,
                        'reference_id' => $payment->reference_id,
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                }
            } elseif ($paymentIntent->status === 'canceled' || $paymentIntent->status === 'requires_payment_method') {
                $this->warn("Payment {$payment->reference_id} has failed or been cancelled");

                // Update the pending payment status
                $payment->update([
                    'status' => 'failed',
                    'metadata' => array_merge($payment->metadata ?? [], [
                        'failed_at' => now()->toIso8601String(),
                        'reason' => "Payment {$paymentIntent->status} according to provider"
                    ])
                ]);
            } else {
                $this->info("Payment {$payment->reference_id} is still pending with status: {$paymentIntent->status}");
            }

        } catch (\Exception $e) {
            $this->error("Error checking Stripe payment {$payment->id}: {$e->getMessage()}");
            Log::error("Error checking Stripe payment status", [
                'payment_id' => $payment->id,
                'reference_id' => $payment->reference_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
}

