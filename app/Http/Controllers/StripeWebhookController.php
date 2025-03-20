<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Webhook;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Models\User;
use App\Models\PendingPayment;
use App\Services\WalletService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class StripeWebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = config('services.stripe.webhook.secret');

        try {
            $event = Webhook::constructEvent(
                $payload, $sigHeader, $endpointSecret
            );
        } catch (SignatureVerificationException $e) {
            // Invalid signature
            Log::error('Stripe webhook signature verification failed', [
                'error' => $e->getMessage()
            ]);
            return response()->json(['error' => 'Webhook signature verification failed'], 400);
        }

        // Handle the event
        switch ($event->type) {
            case 'payment_intent.succeeded':
                $paymentIntent = $event->data->object;
                $this->handleSuccessfulPayment($paymentIntent);
                break;
            case 'payment_intent.payment_failed':
                $paymentIntent = $event->data->object;
                $this->handleFailedPayment($paymentIntent);
                break;
            default:
                Log::info('Unhandled Stripe webhook event', ['type' => $event->type]);
        }

        return response()->json(['status' => 'success']);
    }

    private function handleSuccessfulPayment($paymentIntent)
    {
        // Try to find a pending payment for this payment intent
        $pendingPayment = PendingPayment::where('metadata->payment_intent_id', $paymentIntent->id)
            ->where('status', 'pending')
            ->first();

        $referenceId = null;

        if ($pendingPayment) {
            $referenceId = $pendingPayment->reference_id;
            Log::info('Stripe webhook: Found pending payment', [
                'payment_intent_id' => $paymentIntent->id,
                'pending_payment_id' => $pendingPayment->id,
                'reference_id' => $referenceId
            ]);
        }

        // If we don't have a reference ID from the pending payment, try to get it from the payment intent metadata
        if (!$referenceId && isset($paymentIntent->metadata->reference_id)) {
            $referenceId = $paymentIntent->metadata->reference_id;
        }

        // If we still don't have a reference ID, generate one
        if (!$referenceId) {
            $referenceId = 'STRIPE-' . Str::upper(Str::random(10));
        }

        // Check if we already have a transaction for this payment intent or reference ID
        $existingTransaction = Transaction::where(function($query) use ($paymentIntent, $referenceId) {
                $query->where('metadata->payment_intent_id', $paymentIntent->id)
                    ->orWhere('reference_id', $referenceId);
            })
            ->where('type', Transaction::TYPE_DEPOSIT)
            ->first();

        if ($existingTransaction) {
            Log::info('Stripe webhook: Transaction already exists for payment intent', [
                'payment_intent_id' => $paymentIntent->id,
                'transaction_id' => $existingTransaction->id,
                'reference_id' => $referenceId
            ]);

            // Update the pending payment if it exists
            if ($pendingPayment) {
                $pendingPayment->update([
                    'status' => 'completed',
                    'last_checked_at' => now(),
                    'metadata' => array_merge($pendingPayment->metadata ?? [], [
                        'transaction_id' => $existingTransaction->id,
                        'completed_at' => now()->toIso8601String(),
                        'webhook_processed' => true
                    ])
                ]);
            }

            return;
        }

        // If transaction not found, we need to create one
        try {
            // Get the amount from the payment intent (already in cents)
            $amountCents = $paymentIntent->amount;
            $amount = $amountCents / 100; // Convert to dollars/ringgit

            // Get the user ID from the payment intent metadata or pending payment
            $userId = null;

            if ($pendingPayment) {
                $userId = $pendingPayment->user_id;
            } elseif (isset($paymentIntent->metadata->user_id)) {
                $userId = $paymentIntent->metadata->user_id;
            }

            if (!$userId) {
                Log::error('Stripe webhook: No user ID found', [
                    'payment_intent_id' => $paymentIntent->id,
                    'reference_id' => $referenceId
                ]);
                return;
            }

            $user = User::find($userId);
            if (!$user) {
                Log::error('Stripe webhook: User not found', [
                    'payment_intent_id' => $paymentIntent->id,
                    'user_id' => $userId,
                    'reference_id' => $referenceId
                ]);
                return;
            }

            // Get the wallet ID from the pending payment or payment intent metadata
            $walletId = null;

            if ($pendingPayment) {
                $walletId = $pendingPayment->wallet_id;
            } elseif (isset($paymentIntent->metadata->wallet_id)) {
                $walletId = $paymentIntent->metadata->wallet_id;
            }

            // If we don't have a wallet ID, use the user's default wallet
            if (!$walletId) {
                $wallet = $user->wallet();
            } else {
                $wallet = Wallet::find($walletId);
            }

            if (!$wallet) {
                Log::error('Stripe webhook: Wallet not found', [
                    'payment_intent_id' => $paymentIntent->id,
                    'user_id' => $userId,
                    'wallet_id' =>  => $paymentIntent->id,
                    'user_id' => $userId,
                    'wallet_id' => $walletId
                ]);
                return;
            }

            // Process the deposit using WalletService
            try {
                $walletService = new WalletService();
                $result = $walletService->deposit(
                    $wallet,
                    (float)$amount,
                    "Deposit via Stripe (webhook)",
                    'stripe',
                    $referenceId
                );

                // Update the pending payment if it exists
                if ($pendingPayment) {
                    $pendingPayment->update([
                        'status' => 'completed',
                        'last_checked_at' => now(),
                        'metadata' => array_merge($pendingPayment->metadata ?? [], [
                            'transaction_id' => $result['deposit']->id,
                            'completed_at' => now()->toIso8601String(),
                            'webhook_processed' => true
                        ])
                    ]);
                }

                Log::info('Stripe webhook: Created transactions from webhook', [
                    'deposit_transaction_id' => $result['deposit']->id,
                    'fee_transaction_id' => $result['fee']->id,
                    'payment_intent_id' => $paymentIntent->id,
                    'amount' => $amount,
                    'reference_id' => $referenceId
                ]);
            } catch (\Exception $e) {
                Log::error('Stripe webhook: Failed to create transaction', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                    'payment_intent_id' => $paymentIntent->id,
                    'reference_id' => $referenceId
                ]);

                // Update the pending payment with the error if it exists
                if ($pendingPayment) {
                    $pendingPayment->update([
                        'status' => 'failed',
                        'last_checked_at' => now(),
                        'metadata' => array_merge($pendingPayment->metadata ?? [], [
                            'error' => $e->getMessage(),
                            'failed_at' => now()->toIso8601String(),
                            'webhook_processed' => true
                        ])
                    ]);
                }
            }
        } catch (\Exception $e) {
            Log::error('Stripe webhook: Failed to process payment', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'payment_intent_id' => $paymentIntent->id
            ]);
        }
    }

    private function handleFailedPayment($paymentIntent)
    {
        // Try to find a pending payment for this payment intent
        $pendingPayment = PendingPayment::where('metadata->payment_intent_id', $paymentIntent->id)
            ->first();

        if ($pendingPayment) {
            // Update pending payment status to failed
            $pendingPayment->update([
                'status' => 'failed',
                'last_checked_at' => now(),
                'metadata' => array_merge($pendingPayment->metadata ?? [], [
                    'failure_message' => $paymentIntent->last_payment_error->message ?? 'Payment failed',
                    'failed_at' => now()->toIso8601String(),
                    'webhook_processed' => true
                ])
            ]);

            Log::info('Stripe webhook: Pending payment marked as failed', [
                'pending_payment_id' => $pendingPayment->id,
                'payment_intent_id' => $paymentIntent->id,
                'reference_id' => $pendingPayment->reference_id
            ]);
        } else {
            // Check if we already have a transaction for this payment intent
            $existingTransaction = Transaction::where('metadata->payment_intent_id', $paymentIntent->id)
                ->where('type', Transaction::TYPE_DEPOSIT)
                ->first();

            if ($existingTransaction) {
                // Update transaction status to failed
                $existingTransaction->update([
                    'status' => Transaction::STATUS_FAILED,
                    'metadata' => array_merge($existingTransaction->metadata, [
                        'failure_message' => $paymentIntent->last_payment_error->message ?? 'Payment failed',
                        'webhook_processed' => true
                    ])
                ]);

                Log::info('Stripe webhook: Transaction marked as failed', [
                    'transaction_id' => $existingTransaction->id,
                    'payment_intent_id' => $paymentIntent->id
                ]);
            } else {
                Log::warning('Stripe webhook: No pending payment or transaction found for failed payment intent', [
                    'payment_intent_id' => $paymentIntent->id
                ]);
            }
        }
    }
}

