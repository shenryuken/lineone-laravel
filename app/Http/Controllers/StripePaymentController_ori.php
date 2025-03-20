<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Wallet;
use App\Services\StripeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

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
        ]);

        $amount = $request->input('amount');
        $walletId = $request->input('wallet_id');

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
                'stripe_payment_net' => $netAmount
            ]);

            Log::info('Stripe payment intent created', [
                'payment_intent_id' => $paymentIntent->id,
                'amount' => $amount,
                'wallet_id' => $walletId
            ]);

            return view('payments.stripe-checkout', [
                'clientSecret' => $paymentIntent->client_secret,
                'amount' => $amount,
                'wallet' => $wallet,
                'feeAmount' => $feeAmount,
                'netAmount' => $netAmount
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

            // Get the wallet
            $wallet = Wallet::findOrFail($walletId);

            // Convert amounts to cents for storage
            $amountCents = (int)($amount * 100);
            $feeCents = (int)($feeAmount * 100);
            $netAmountCents = (int)($netAmount * 100);

            // Generate a reference ID
            $referenceId = 'STRIPE-' . Str::upper(Str::random(10));

            // Begin transaction
            \DB::beginTransaction();

            try {
                $balanceBefore = $wallet->balance;

                // First, create the deposit transaction (gross amount)
                $depositTransaction = $wallet->transactions()->create([
                    'type' => Transaction::TYPE_DEPOSIT,
                    'amount' => $amountCents,
                    'currency' => $wallet->currency,
                    'balance_before' => $balanceBefore,
                    'balance_after' => $balanceBefore + $amountCents, // Full amount before fee
                    'description' => 'Deposit via Stripe',
                    'status' => Transaction::STATUS_COMPLETED,
                    'metadata' => [
                        'provider' => 'stripe',
                        'gross_amount' => $amountCents,
                        'fee_amount' => $feeCents,
                        'net_amount' => $netAmountCents,
                        'payment_intent_id' => $paymentIntentId
                    ],
                    'reference_id' => $referenceId,
                    'provider' => 'stripe'
                ]);

                // Then, create the fee transaction
                $feeTransaction = $wallet->transactions()->create([
                    'type' => Transaction::TYPE_DEPOSIT_FEE,
                    'amount' => -$feeCents, // Negative amount for fee
                    'currency' => $wallet->currency,
                    'balance_before' => $balanceBefore + $amountCents, // Balance after deposit
                    'balance_after' => $balanceBefore + $netAmountCents, // Final balance after fee
                    'description' => "Processing fee for deposit {$referenceId}",
                    'status' => Transaction::STATUS_COMPLETED,
                    'metadata' => [
                        'deposit_id' => $depositTransaction->id,
                        'fee_percentage' => 5,
                        'payment_intent_id' => $paymentIntentId
                    ],
                    'reference_id' => $referenceId,
                    'provider' => 'stripe'
                ]);

                // Finally, update the wallet balance with the net amount
                $wallet->balance = $balanceBefore + $netAmountCents;
                $wallet->save();

                \DB::commit();

                Log::info('Stripe payment processed successfully', [
                    'payment_intent_id' => $paymentIntentId,
                    'deposit_transaction_id' => $depositTransaction->id,
                    'fee_transaction_id' => $feeTransaction->id,
                    'amount' => $amountCents,
                    'wallet_id' => $walletId
                ]);
            } catch (\Exception $e) {
                \DB::rollBack();
                throw $e;
            }

            // Clear the session data
            session()->forget([
                'stripe_payment_intent_id',
                'stripe_payment_amount',
                'stripe_payment_wallet_id',
                'stripe_payment_fee',
                'stripe_payment_net'
            ]);

            return redirect()->route('dashboard')->with([
                'toast' => [
                    'type' => 'success',
                    'message' => 'Payment successful! ' . $wallet->currency . ' ' . number_format($amount, 2) . ' has been added to your wallet.'
                ]
            ]);

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
    public function cancel()
    {
        // Clear the session data
        session()->forget([
            'stripe_payment_intent_id',
            'stripe_payment_amount',
            'stripe_payment_wallet_id',
            'stripe_payment_fee',
            'stripe_payment_net'
        ]);

        return redirect()->route('dashboard')->with([
            'toast' => [
                'type' => 'error',
                'message' => 'Payment was canceled'
            ]
        ]);
    }
}

