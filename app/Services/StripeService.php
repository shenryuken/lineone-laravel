<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Stripe\Exception\ApiErrorException;
use Stripe\StripeClient;

class StripeService
{
    protected $stripe;

    public function __construct()
    {
        // This will use test keys when in sandbox mode
        $this->stripe = new StripeClient(config('services.stripe.secret'));
    }

    /**
     * Create a Stripe customer for the user
     */
    public function createCustomer(User $user)
    {
        try {
            if ($user->stripe_customer_id) {
                return $user->stripe_customer_id;
            }

            $customer = $this->stripe->customers->create([
                'email' => $user->email,
                'name' => $user->name,
                'metadata' => [
                    'user_id' => $user->id
                ]
            ]);

            $user->update(['stripe_customer_id' => $customer->id]);

            return $customer->id;
        } catch (ApiErrorException $e) {
            Log::error('Stripe customer creation failed', [
                'error' => $e->getMessage(),
                'user_id' => $user->id
            ]);
            throw $e;
        }
    }

    /**
     * Create a payment intent
     */
    public function createPaymentIntent(User $user, float $amount, string $currency = 'myr')
    {
        try {
            $customerId = $this->createCustomer($user);

            // Convert to cents for Stripe
            $amountInCents = (int)($amount * 100);

            $paymentIntent = $this->stripe->paymentIntents->create([
                'amount' => $amountInCents, // Already in cents
                'currency' => strtolower($currency),
                'customer' => $customerId,
                'metadata' => [
                    'user_id' => $user->id
                ],
                'automatic_payment_methods' => [
                    'enabled' => true,
                ],
            ]);

            return $paymentIntent;
        } catch (ApiErrorException $e) {
            Log::error('Stripe payment intent creation failed', [
                'error' => $e->getMessage(),
                'user_id' => $user->id,
                'amount' => $amount
            ]);
            throw $e;
        }
    }

    /**
     * Retrieve a payment intent by ID
     */
    public function retrievePaymentIntent(string $paymentIntentId)
    {
        try {
            return $this->stripe->paymentIntents->retrieve($paymentIntentId);
        } catch (ApiErrorException $e) {
            Log::error('Stripe retrieve payment intent failed', [
                'error' => $e->getMessage(),
                'payment_intent_id' => $paymentIntentId
            ]);
            throw $e;
        }
    }

    /**
     * Process a payment with an existing payment method
     */
    public function processPayment(User $user, float $amount, string $paymentMethodId, string $currency = 'myr')
    {
        try {
            $customerId = $this->createCustomer($user);

            // Convert to cents for Stripe
            $amountInCents = (int)($amount * 100);

            // Create a payment intent
            $paymentIntent = $this->stripe->paymentIntents->create([
                'amount' => $amountInCents, // Already in cents
                'currency' => strtolower($currency),
                'customer' => $customerId,
                'payment_method' => $paymentMethodId,
                'confirm' => true, // Confirm the payment immediately
                'metadata' => [
                    'user_id' => $user->id
                ],
                'return_url' => route('user.dashboard'), // Redirect URL after 3D Secure authentication
            ]);

            return $paymentIntent;
        } catch (ApiErrorException $e) {
            Log::error('Stripe payment processing failed', [
                'error' => $e->getMessage(),
                'user_id' => $user->id,
                'amount' => $amount,
                'payment_method_id' => $paymentMethodId
            ]);
            throw $e;
        }
    }
}

