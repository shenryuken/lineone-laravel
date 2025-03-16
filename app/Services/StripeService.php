<?php

namespace App\Services;

use App\Models\User;
use App\Models\PaymentMethod;
use App\Models\Transaction;
use Illuminate\Support\Facades\Log;
use Stripe\Exception\ApiErrorException;
use Stripe\StripeClient;

class StripeService
{
    protected $stripe;

    public function __construct()
    {
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

            $paymentIntent = $this->stripe->paymentIntents->create([
                'amount' => $amount * 100, // Convert to cents
                'currency' => $currency,
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
     * Create a setup intent for saving payment methods
     */
    public function createSetupIntent(User $user)
    {
        try {
            $customerId = $this->createCustomer($user);

            $setupIntent = $this->stripe->setupIntents->create([
                'customer' => $customerId,
                'payment_method_types' => ['card'],
                'metadata' => [
                    'user_id' => $user->id
                ]
            ]);

            return $setupIntent;
        } catch (ApiErrorException $e) {
            Log::error('Stripe setup intent creation failed', [
                'error' => $e->getMessage(),
                'user_id' => $user->id
            ]);
            throw $e;
        }
    }

    /**
     * Get customer payment methods
     */
    public function getPaymentMethods(User $user)
    {
        try {
            if (!$user->stripe_customer_id) {
                return [];
            }

            $paymentMethods = $this->stripe->paymentMethods->all([
                'customer' => $user->stripe_customer_id,
                'type' => 'card',
            ]);

            return $paymentMethods->data;
        } catch (ApiErrorException $e) {
            Log::error('Stripe get payment methods failed', [
                'error' => $e->getMessage(),
                'user_id' => $user->id
            ]);
            throw $e;
        }
    }

    /**
     * Detach a payment method from customer
     */
    public function detachPaymentMethod(string $paymentMethodId)
    {
        try {
            return $this->stripe->paymentMethods->detach($paymentMethodId);
        } catch (ApiErrorException $e) {
            Log::error('Stripe detach payment method failed', [
                'error' => $e->getMessage(),
                'payment_method_id' => $paymentMethodId
            ]);
            throw $e;
        }
    }

    /**
     * Process a payment
     */
    public function processPayment(User $user, float $amount, string $paymentMethodId, string $currency = 'myr')
    {
        try {
            $customerId = $this->createCustomer($user);

            $paymentIntent = $this->stripe->paymentIntents->create([
                'amount' => $amount * 100, // Convert to cents
                'currency' => $currency,
                'customer' => $customerId,
                'payment_method' => $paymentMethodId,
                'confirm' => true,
                'metadata' => [
                    'user_id' => $user->id
                ]
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

