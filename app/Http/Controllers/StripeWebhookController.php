<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Webhook;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Models\User;
use Illuminate\Support\Str;

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
        // Check if we already have a transaction for this payment intent
        $existingTransaction = Transaction::where('metadata->payment_intent_id', $paymentIntent->id)
            ->where('type', Transaction::TYPE_DEPOSIT)
            ->first();

        if ($existingTransaction) {
            Log::info('Stripe webhook: Transaction already exists for payment intent', [
                'payment_intent_id' => $paymentIntent->id,
                'transaction_id' => $existingTransaction->id
            ]);
            return;
        }

        // If transaction not found, we need to create one
        try {
            // Get the amount from the payment intent (already in cents)
            $amountCents = $paymentIntent->amount;
            $userId = $paymentIntent->metadata->user_id ?? null;

            if (!$userId) {
                Log::error('Stripe webhook: No user ID in payment intent metadata', [
                    'payment_intent_id' => $paymentIntent->id
                ]);
                return;
            }

            $user = User::find($userId);
            if (!$user) {
                Log::error('Stripe webhook: User not found', [
                    'payment_intent_id' => $paymentIntent->id,
                    'user_id' => $userId
                ]);
                return;
            }

            $wallet = $user->wallet();

            // Calculate fee (5%)
            $feeCents = (int)($amountCents * 0.05);
            $netAmountCents = $amountCents - $feeCents;

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
                    'description' => 'Deposit via Stripe (webhook)',
                    'status' => Transaction::STATUS_COMPLETED,
                    'metadata' => [
                        'provider' => 'stripe',
                        'gross_amount' => $amountCents,
                        'fee_amount' => $feeCents,
                        'net_amount' => $netAmountCents,
                        'payment_intent_id' => $paymentIntent->id,
                        'webhook_processed' => true
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
                        'payment_intent_id' => $paymentIntent->id,
                        'webhook_processed' => true
                    ],
                    'reference_id' => $referenceId,
                    'provider' => 'stripe'
                ]);

                // Finally, update the wallet balance with the net amount
                $wallet->balance = $balanceBefore + $netAmountCents;
                $wallet->save();

                // Store a notification for the user to see on their next page load
                session()->flash('toast', [
                    'type' => 'success',
                    'message' => 'Payment of ' . $wallet->currency . ' ' . number_format($amountCents/100, 2) . ' was processed successfully via webhook!'
                ]);

                \DB::commit();

                Log::info('Stripe webhook: Created transactions from webhook', [
                    'deposit_transaction_id' => $depositTransaction->id,
                    'fee_transaction_id' => $feeTransaction->id,
                    'payment_intent_id' => $paymentIntent->id,
                    'amount' => $amountCents
                ]);
            } catch (\Exception $e) {
                \DB::rollBack();
                throw $e;
            }
        } catch (\Exception $e) {
            Log::error('Stripe webhook: Failed to create transaction', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'payment_intent_id' => $paymentIntent->id
            ]);
        }
    }

    private function handleFailedPayment($paymentIntent)
    {
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

            // Get the user to show them a notification
            $user = User::find($existingTransaction->user_id);
            if ($user) {
                // Store a notification for the user to see on their next page load
                session()->flash('toast', [
                    'type' => 'error',
                    'message' => 'Your payment has failed: ' . ($paymentIntent->last_payment_error->message ?? 'Unknown error')
                ]);
            }

            Log::info('Stripe webhook: Transaction marked as failed', [
                'transaction_id' => $existingTransaction->id,
                'payment_intent_id' => $paymentIntent->id
            ]);
        } else {
            Log::warning('Stripe webhook: No transaction found for failed payment intent', [
                'payment_intent_id' => $paymentIntent->id
            ]);
        }
    }
}

