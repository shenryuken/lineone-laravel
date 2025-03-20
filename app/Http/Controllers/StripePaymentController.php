<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Wallet;
use App\Models\PendingPayment;
use App\Services\StripeService;
use App\Services\WalletService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class StripePaymentController extends Controller
{
    /**
     * Create a payment intent and return the checkout view
     */
    public function checkout(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10',
            'wallet_id' => 'required|exists:wallets,id',
            'reference_id' => 'nullable|string'
        ]);

        $amount = $request->input('amount');
        $walletId = $request->input('wallet_id');
        $referenceId = $request->input('reference_id');

        // If no reference ID was provided, generate one
        if (!$referenceId) {
            $referenceId = 'STRIPE-' . Str::upper(Str::random(10));
        }

        $wallet = Wallet::findOrFail($walletId);

        // Ensure the wallet belongs to the authenticated user
        if ($wallet->user_id !== Auth::id()) {
            return redirect()->back()->with([
                'toast' => [
                    'type' => 'error',
                    'message' => 'Unauthorized wallet access'
                ]
            ]);
        }

        try {
            $stripeService = new StripeService();

            // Create a payment intent
            $paymentIntent = $stripeService->createPaymentIntent(
                Auth::user(),
                (float) $amount,
                strtolower($wallet->currency ?? 'myr')
            );

            // Calculate fee (5%)
            $feeAmount = round($amount * 0.05, 2);
            $netAmount = $amount - $feeAmount;

            // Store payment intent ID in session for verification later
            session([
                'stripe_payment_intent_id' => $paymentIntent->id,
                'stripe_payment_amount' => $amount,
                'stripe_payment_wallet_id' => $walletId,
                'stripe_payment_fee' => $feeAmount,
                'stripe_payment_net' => $netAmount,
                'stripe_payment_reference_id' => $referenceId
            ]);

            // Check if we already have a pending payment record
            $pendingPayment = PendingPayment::where('reference_id', $referenceId)
                ->where('user_id', Auth::id())
                ->first();

            // If no pending payment record exists, create one
            if (!$pendingPayment) {
                PendingPayment::create([
                    'user_id' => Auth::id(),
                    'wallet_id' => $walletId,
                    'reference_id' => $referenceId,
                    'provider' => 'stripe',
                    'amount' => $amount,
                    'status' => 'pending',
                    'metadata' => [
                        'payment_intent_id' => $paymentIntent->id,
                        'email' => Auth::user()->email,
                        'name' => Auth::user()->name,
                        'created_at' => now()->toIso8601String(),
                    ]
                ]);
            } else {
                // Update the existing pending payment with the new payment intent ID
                $pendingPayment->update([
                    'status' => 'pending',
                    'last_checked_at' => now(),
                    'metadata' => array_merge($pendingPayment->metadata ?? [], [
                        'payment_intent_id' => $paymentIntent->id,
                        'updated_at' => now()->toIso8601String(),
                    ])
                ]);
            }

            Log::info('Stripe payment intent created', [
                'payment_intent_id' => $paymentIntent->id,
                'amount' => $amount,
                'wallet_id' => $walletId,
                'reference_id' => $referenceId
            ]);

            return view('payments.stripe-checkout', [
                'clientSecret' => $paymentIntent->client_secret,
                'amount' => $amount,
                'wallet' => $wallet,
                'feeAmount' => $feeAmount,
                'netAmount' => $netAmount,
                'referenceId' => $referenceId
            ]);

        } catch (\Exception $e) {
            Log::error('Stripe: Payment intent creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()->with([
                'toast' => [
                    'type' => 'error',
                    'message' => 'Failed to initialize payment: ' . $e->getMessage()
                ]
            ]);
        }
    }

    /**
     * Handle successful payment
     */
    public function success(Request $request)
    {
        $paymentIntentId = $request->query('payment_intent');

        if (!$paymentIntentId) {
            return redirect()->route('dashboard')->with([
                'toast' => [
                    'type' => 'error',
                    'message' => 'Invalid payment information'
                ]
            ]);
        }

        // Verify this is the payment intent we created
        $sessionPaymentIntentId = session('stripe_payment_intent_id');
        $referenceId = session('stripe_payment_reference_id');

        if ($paymentIntentId !== $sessionPaymentIntentId) {
            Log::error('Stripe payment mismatch', [
                'expected' => $sessionPaymentIntentId,
                'received' => $paymentIntentId
            ]);

            return redirect()->route('dashboard')->with([
                'toast' => [
                    'type' => 'error',
                    'message' => 'Payment verification failed. Please contact support if funds were deducted.'
                ]
            ]);
        }

        try {
            $stripeService = new StripeService();
            $paymentIntent = $stripeService->retrievePaymentIntent($paymentIntentId);

            if ($paymentIntent->status !== 'succeeded') {
                Log::error('Stripe payment not successful', [
                    'payment_intent_id' => $paymentIntentId,
                    'status' => $paymentIntent->status
                ]);

                // Update the pending payment status
                if ($referenceId) {
                    $pendingPayment = PendingPayment::where('reference_id', $referenceId)
                        ->where('user_id', Auth::id())
                        ->first();

                    if ($pendingPayment) {
                        $pendingPayment->update([
                            'status' => 'failed',
                            'last_checked_at' => now(),
                            'metadata' => array_merge($pendingPayment->metadata ?? [], [
                                'status' => $paymentIntent->status,
                                'failed_at' => now()->toIso8601String(),
                            ])
                        ]);
                    }
                }

                return redirect()->route('dashboard')->with([
                    'toast' => [
                        'type' => 'error',
                        'message' => 'Payment was not successful. Status: ' . $paymentIntent->status
                    ]
                ]);
            }

            // Get the stored payment details
            $amount = session('stripe_payment_amount');
            $walletId = session('stripe_payment_wallet_id');
            $feeAmount = session('stripe_payment_fee');
            $netAmount = session('stripe_payment_net');

            // If we don't have the reference ID from the session, try to find it from the pending payment
            if (!$referenceId) {
                $pendingPayment = PendingPayment::where('metadata->payment_intent_id', $paymentIntentId)
                    ->where('user_id', Auth::id())
                    ->first();

                if ($pendingPayment) {
                    $referenceId = $pendingPayment->reference_id;
                } else {
                    // Generate a new reference ID if we can't find one
                    $referenceId = 'STRIPE-' . Str::upper(Str::random(10));
                }
            }

            // Check if we already processed this transaction
            $existingTransaction = Transaction::where('reference_id', $referenceId)
                ->where(function($query) {
                    $query->where('metadata->provider', 'stripe');
                })
                ->first();

            if ($existingTransaction) {
                Log::info('Stripe payment: Transaction already processed', [
                    'reference_id' => $referenceId,
                    'transaction_id' => $existingTransaction->id
                ]);

                // Update the pending payment status if it exists
                $pendingPayment = PendingPayment::where('reference_id', $referenceId)->first();
                if ($pendingPayment) {
                    $pendingPayment->update([
                        'status' => 'completed',
                        'last_checked_at' => now(),
                        'metadata' => array_merge($pendingPayment->metadata ?? [], [
                            'transaction_id' => $existingTransaction->id,
                            'completed_at' => now()->toIso8601String(),
                        ])
                    ]);
                }

                // Clear the session data
                session()->forget([
                    'stripe_payment_intent_id',
                    'stripe_payment_amount',
                    'stripe_payment_wallet_id',
                    'stripe_payment_fee',
                    'stripe_payment_net',
                    'stripe_payment_reference_id'
                ]);

                return redirect()->route('payment.status', ['reference' => $referenceId]);
            }

            // Get the wallet
            $wallet = Wallet::findOrFail($walletId);

            // Process the deposit using WalletService
            try {
                $walletService = new WalletService();
                $result = $walletService->deposit(
                    $wallet,
                    (float)$amount,
                    "Deposit via Stripe",
                    'stripe',
                    $referenceId
                );

                // Update the pending payment if it exists
                $pendingPayment = PendingPayment::where('reference_id', $referenceId)->first();
                if ($pendingPayment) {
                    $pendingPayment->update([
                        'status' => 'completed',
                        'last_checked_at' => now(),
                        'metadata' => array_merge($pendingPayment->metadata ?? [], [
                            'transaction_id' => $result['deposit']->id,
                            'completed_at' => now()->toIso8601String(),
                        ])
                    ]);
                }

                Log::info('Stripe payment processed successfully', [
                    'payment_intent_id' => $paymentIntentId,
                    'deposit_transaction_id' => $result['deposit']->id,
                    'fee_transaction_id' => $result['fee']->id,
                    'amount' => $amount,
                    'wallet_id' => $walletId,
                    'reference_id' => $referenceId
                ]);

                // Clear the session data
                session()->forget([
                    'stripe_payment_intent_id',
                    'stripe_payment_amount',
                    'stripe_payment_wallet_id',
                    'stripe_payment_fee',
                    'stripe_payment_net',
                    'stripe_payment_reference_id'
                ]);

                return redirect()->route('payment.status', ['reference' => $referenceId]);

            } catch (\Exception $e) {
                Log::error('Error processing Stripe payment deposit', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                    'payment_intent_id' => $paymentIntentId,
                    'reference_id' => $referenceId
                ]);

                // Update the pending payment with the error if it exists
                $pendingPayment = PendingPayment::where('reference_id', $referenceId)->first();
                if ($pendingPayment) {
                    $pendingPayment->update([
                        'status' => 'failed',
                        'last_checked_at' => now(),
                        'metadata' => array_merge($pendingPayment->metadata ?? [], [
                            'error' => $e->getMessage(),
                            'failed_at' => now()->toIso8601String(),
                        ])
                    ]);
                }

                return redirect()->route('dashboard')->with([
                    'toast' => [
                        'type' => 'error',
                        'message' => 'An error occurred while processing your payment: ' . $e->getMessage()
                    ]
                ]);
            }

        } catch (\Exception $e) {
            Log::error('Error processing Stripe payment', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'payment_intent_id' => $paymentIntentId
            ]);

            return redirect()->route('dashboard')->with([
                'toast' => [
                    'type' => 'error',
                    'message' => 'An error occurred while processing your payment: ' . $e->getMessage()
                ]
            ]);
        }
    }

    /**
     * Handle canceled payment
     */
    public function cancel(Request $request)
    {
        $referenceId = session('stripe_payment_reference_id');

        // Update the pending payment status if it exists
        if ($referenceId) {
            $pendingPayment = PendingPayment::where('reference_id', $referenceId)
                ->where('user_id', Auth::id())
                ->first();

            if ($pendingPayment) {
                $pendingPayment->update([
                    'status' => 'failed',
                    'last_checked_at' => now(),
                    'metadata' => array_merge($pendingPayment->metadata ?? [], [
                        'canceled_at' => now()->toIso8601String(),
                        'reason' => 'User canceled the payment'
                    ])
                ]);
            }
        }

        // Clear the session data
        session()->forget([
            'stripe_payment_intent_id',
            'stripe_payment_amount',
            'stripe_payment_wallet_id',
            'stripe_payment_fee',
            'stripe_payment_net',
            'stripe_payment_reference_id'
        ]);

        return redirect()->route('dashboard')->with([
            'toast' => [
                'type' => 'error',
                'message' => 'Payment was canceled'
            ]
        ]);
    }
}

