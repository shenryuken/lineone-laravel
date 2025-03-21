<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PendingPayment;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use App\Services\WalletService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PendingPaymentController extends Controller
{
    /**
     * Display a listing of pending payments
     */
    public function index(Request $request)
    {
        $query = PendingPayment::query()
            ->with(['user', 'wallet'])
            ->orderBy('created_at', 'desc');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by provider
        if ($request->filled('provider')) {
            $query->where('provider', $request->provider);
        }

        // Filter by user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by reference ID
        if ($request->filled('reference_id')) {
            $query->where('reference_id', 'like', '%' . $request->reference_id . '%');
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $pendingPayments = $query->paginate(15)->withQueryString();

        // Get unique providers and statuses for filters
        $providers = PendingPayment::distinct('provider')->pluck('provider');
        $statuses = ['pending', 'completed', 'failed'];
        $users = User::orderBy('name')->get(['id', 'name', 'email']);

        return view('admin.pending-payments.index', compact(
            'pendingPayments',
            'providers',
            'statuses',
            'users'
        ));
    }

    /**
     * Display the specified pending payment
     */
    public function show(PendingPayment $pendingPayment)
    {
        $pendingPayment->load(['user', 'wallet']);

        // Check if there's a transaction for this payment
        $transaction = Transaction::where('reference_id', $pendingPayment->reference_id)
            ->where('wallet_id', $pendingPayment->wallet_id)
            ->first();

        return view('admin.pending-payments.show', compact('pendingPayment', 'transaction'));
    }

    /**
     * Update the status of a pending payment
     */
    public function updateStatus(Request $request, PendingPayment $pendingPayment)
    {
        $request->validate([
            'status' => 'required|in:pending,completed,failed',
            'notes' => 'nullable|string|max:500',
        ]);

        $oldStatus = $pendingPayment->status;
        $newStatus = $request->status;

        // If status is not changing, just update notes
        if ($oldStatus === $newStatus) {
            $pendingPayment->update([
                'metadata' => array_merge($pendingPayment->metadata ?? [], [
                    'admin_notes' => $request->notes,
                    'updated_by_admin' => auth()->user()->name,
                    'updated_at' => now()->toIso8601String(),
                ])
            ]);

            return redirect()->route('admin.pending-payments.show', $pendingPayment)
                ->with('toast', [
                    'type' => 'success',
                    'message' => 'Payment notes updated successfully'
                ]);
        }

        // If changing to completed, check if we need to process the payment
        if ($newStatus === 'completed' && $oldStatus !== 'completed') {
            // Check if transaction already exists
            $existingTransaction = Transaction::where('reference_id', $pendingPayment->reference_id)
                ->where('wallet_id', $pendingPayment->wallet_id)
                ->first();

            if (!$existingTransaction) {
                // Process the payment
                try {
                    DB::beginTransaction();

                    $wallet = Wallet::findOrFail($pendingPayment->wallet_id);
                    $walletService = new WalletService();

                    $result = $walletService->deposit(
                        $wallet,
                        (float)$pendingPayment->amount,
                        "Deposit via {$pendingPayment->provider} (manually processed by admin)",
                        $pendingPayment->provider,
                        $pendingPayment->reference_id
                    );

                    // Update the pending payment
                    $pendingPayment->update([
                        'status' => 'completed',
                        'last_checked_at' => now(),
                        'metadata' => array_merge($pendingPayment->metadata ?? [], [
                            'transaction_id' => $result['deposit']->id,
                            'completed_at' => now()->toIso8601String(),
                            'admin_notes' => $request->notes,
                            'processed_by' => auth()->user()->name,
                        ])
                    ]);

                    DB::commit();

                    return redirect()->route('admin.pending-payments.show', $pendingPayment)
                        ->with('toast', [
                            'type' => 'success',
                            'message' => 'Payment processed and marked as completed successfully'
                        ]);

                } catch (\Exception $e) {
                    DB::rollBack();

                    Log::error('Admin: Error processing pending payment', [
                        'payment_id' => $pendingPayment->id,
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);

                    return redirect()->route('admin.pending-payments.show', $pendingPayment)
                        ->with('toast', [
                            'type' => 'error',
                            'message' => 'Error processing payment: ' . $e->getMessage()
                        ]);
                }
            } else {
                // Transaction already exists, just update the status
                $pendingPayment->update([
                    'status' => 'completed',
                    'last_checked_at' => now(),
                    'metadata' => array_merge($pendingPayment->metadata ?? [], [
                        'transaction_id' => $existingTransaction->id,
                        'completed_at' => now()->toIso8601String(),
                        'admin_notes' => $request->notes,
                        'updated_by_admin' => auth()->user()->name,
                    ])
                ]);

                return redirect()->route('admin.pending-payments.show', $pendingPayment)
                    ->with('toast', [
                        'type' => 'success',
                        'message' => 'Payment marked as completed successfully'
                    ]);
            }
        } else {
            // Just update the status and notes
            $pendingPayment->update([
                'status' => $newStatus,
                'last_checked_at' => now(),
                'metadata' => array_merge($pendingPayment->metadata ?? [], [
                    $newStatus . '_at' => now()->toIso8601String(),
                    'admin_notes' => $request->notes,
                    'updated_by_admin' => auth()->user()->name,
                ])
            ]);

            return redirect()->route('admin.pending-payments.show', $pendingPayment)
                ->with('toast', [
                    'type' => 'success',
                    'message' => 'Payment status updated successfully'
                ]);
        }
    }

    /**
     * Check payment status with provider
     */
    public function checkStatus(PendingPayment $pendingPayment)
    {
        try {
            // Update last checked timestamp
            $pendingPayment->update(['last_checked_at' => now()]);

            // Check if transaction already exists
            $existingTransaction = Transaction::where('reference_id', $pendingPayment->reference_id)
                ->where('wallet_id', $pendingPayment->wallet_id)
                ->first();

            if ($existingTransaction) {
                // Update the pending payment status
                $pendingPayment->update([
                    'status' => 'completed',
                    'metadata' => array_merge($pendingPayment->metadata ?? [], [
                        'transaction_id' => $existingTransaction->id,
                        'completed_at' => now()->toIso8601String(),
                        'checked_by_admin' => auth()->user()->name,
                    ])
                ]);

                return redirect()->route('admin.pending-payments.show', $pendingPayment)
                    ->with('toast', [
                        'type' => 'success',
                        'message' => 'Payment is already completed with an existing transaction'
                    ]);
            }

            // Check with the appropriate payment provider
            $result = null;
            $message = '';

            if ($pendingPayment->provider === 'stripe') {
                // Check if we have a payment intent ID
                $paymentIntentId = $pendingPayment->metadata['payment_intent_id'] ?? null;

                if ($paymentIntentId) {
                    try {
                        $stripeService = app(\App\Services\StripeService::class);
                        $paymentIntent = $stripeService->retrievePaymentIntent($paymentIntentId);

                        // Update the payment metadata with the status check result
                        $pendingPayment->update([
                            'metadata' => array_merge($pendingPayment->metadata ?? [], [
                                'status_check' => [
                                    'time' => now()->toIso8601String(),
                                    'result' => [
                                        'status' => $paymentIntent->status,
                                        'amount' => $paymentIntent->amount,
                                        'currency' => $paymentIntent->currency,
                                    ]
                                ],
                                'checked_by_admin' => auth()->user()->name,
                            ])
                        ]);

                        $result = $paymentIntent->status;
                        $message = "Stripe payment status: {$paymentIntent->status}";

                        // If payment is successful, update status
                        if ($paymentIntent->status === 'succeeded') {
                            $pendingPayment->update(['status' => 'completed']);
                            $message = "Stripe payment is successful. Status updated to completed.";
                        }
                    } catch (\Exception $e) {
                        Log::error('Admin: Error checking Stripe payment status', [
                            'payment_id' => $pendingPayment->id,
                            'payment_intent_id' => $paymentIntentId,
                            'error' => $e->getMessage(),
                            'trace' => $e->getTraceAsString()
                        ]);

                        $message = "Error checking Stripe payment: " . $e->getMessage();

                        return redirect()->route('admin.pending-payments.show', $pendingPayment)
                            ->with('toast', [
                                'type' => 'error',
                                'message' => $message
                            ]);
                    }
                } else {
                    $message = "No payment intent ID found for this Stripe payment";

                    return redirect()->route('admin.pending-payments.show', $pendingPayment)
                        ->with('toast', [
                            'type' => 'warning',
                            'message' => $message
                        ]);
                }
            } elseif ($pendingPayment->provider === 'redipay') {
                try {
                    $rediPayService = app(\App\Services\RediPayService::class);
                    $paymentStatus = $rediPayService->checkPaymentStatusByReference($pendingPayment->reference_id);

                    // Update the payment metadata with the status check result
                    $pendingPayment->update([
                        'metadata' => array_merge($pendingPayment->metadata ?? [], [
                            'status_check' => [
                                'time' => now()->toIso8601String(),
                                'result' => $paymentStatus
                            ],
                            'checked_by_admin' => auth()->user()->name,
                        ])
                    ]);

                    $status = isset($paymentStatus['status']) ? strtolower($paymentStatus['status']) : 'unknown';
                    $result = $status;
                    $message = "RediPay payment status: {$status}";

                    // If payment is successful, update status
                    if ($status === 'paid' || $status === 'success' || $status === 'successful') {
                        $pendingPayment->update(['status' => 'completed']);
                        $message = "RediPay payment is successful. Status updated to completed.";

                        return redirect()->route('admin.pending-payments.show', $pendingPayment)
                            ->with('toast', [
                                'type' => 'success',
                                'message' => $message
                            ]);
                    }
                } catch (\Exception $e) {
                    Log::error('Admin: Error checking RediPay payment status', [
                        'payment_id' => $pendingPayment->id,
                        'reference_id' => $pendingPayment->reference_id,
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);

                    $message = "Error checking RediPay payment: " . $e->getMessage();

                    return redirect()->route('admin.pending-payments.show', $pendingPayment)
                        ->with('toast', [
                            'type' => 'error',
                            'message' => $message
                        ]);
                }
            } else {
                $message = "Status check not implemented for provider: {$pendingPayment->provider}";

                return redirect()->route('admin.pending-payments.show', $pendingPayment)
                    ->with('toast', [
                        'type' => 'warning',
                        'message' => $message
                    ]);
            }

            return redirect()->route('admin.pending-payments.show', $pendingPayment)
                ->with('toast', [
                    'type' => 'info',
                    'message' => $message
                ]);

        } catch (\Exception $e) {
            Log::error('Admin: Error checking payment status', [
                'payment_id' => $pendingPayment->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('admin.pending-payments.show', $pendingPayment)
                ->with('toast', [
                    'type' => 'error',
                    'message' => 'Error checking payment status: ' . $e->getMessage()
                ]);
        }
    }

    /**
     * Process a pending payment manually
     */
    public function processPayment(Request $request, PendingPayment $pendingPayment)
    {
        // Validate the request
        $request->validate([
            'confirm' => 'required|boolean|accepted',
            'notes' => 'nullable|string|max:500',
        ]);

        // Check if payment is already completed
        if ($pendingPayment->status === 'completed') {
            return redirect()->route('admin.pending-payments.show', $pendingPayment)
                ->with('toast', [
                    'type' => 'info',
                    'message' => 'This payment is already completed'
                ]);
        }

        // Check if transaction already exists
        $existingTransaction = Transaction::where('reference_id', $pendingPayment->reference_id)
            ->where('wallet_id', $pendingPayment->wallet_id)
            ->first();

        if ($existingTransaction) {
            // Update the pending payment status
            $pendingPayment->update([
                'status' => 'completed',
                'metadata' => array_merge($pendingPayment->metadata ?? [], [
                    'transaction_id' => $existingTransaction->id,
                    'completed_at' => now()->toIso8601String(),
                    'admin_notes' => $request->notes,
                    'processed_by' => auth()->user()->name,
                ])
            ]);

            return redirect()->route('admin.pending-payments.show', $pendingPayment)
                ->with('toast', [
                    'type' => 'success',
                    'message' => 'Payment marked as completed with existing transaction'
                ]);
        }

        // Process the payment
        try {
            DB::beginTransaction();

            $wallet = Wallet::findOrFail($pendingPayment->wallet_id);
            $walletService = new WalletService();

            $result = $walletService->deposit(
                $wallet,
                (float)$pendingPayment->amount,
                "Deposit via {$pendingPayment->provider} (manually processed by admin)",
                $pendingPayment->provider,
                $pendingPayment->reference_id
            );

            // Update the pending payment
            $pendingPayment->update([
                'status' => 'completed',
                'last_checked_at' => now(),
                'metadata' => array_merge($pendingPayment->metadata ?? [], [
                    'transaction_id' => $result['deposit']->id,
                    'completed_at' => now()->toIso8601String(),
                    'admin_notes' => $request->notes,
                    'processed_by' => auth()->user()->name,
                ])
            ]);

            DB::commit();

            return redirect()->route('admin.pending-payments.show', $pendingPayment)
                ->with('toast', [
                    'type' => 'success',
                    'message' => 'Payment processed successfully'
                ]);

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Admin: Error processing pending payment', [
                'payment_id' => $pendingPayment->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('admin.pending-payments.show', $pendingPayment)
                ->with('toast', [
                    'type' => 'error',
                    'message' => 'Error processing payment: ' . $e->getMessage()
                ]);
        }
    }
}

