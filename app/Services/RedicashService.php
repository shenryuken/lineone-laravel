<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class RedicashService
{
    protected $baseUrl;
    protected $publicKey;
    protected $secretKey;
    protected $mode;

    public function __construct()
    {
        $this->mode = config('app.env') === 'production' ? 'production' : 'development';
        $this->baseUrl = $this->mode === 'production' 
            ? 'https://redicash.ai/api/v1'
            : 'https://redicashv2.test/api/v1';
        
        $this->publicKey = config('services.redicash.public_key');
        $this->secretKey = config('services.redicash.secret_key');

        if (empty($this->publicKey) || empty($this->secretKey)) {
            throw new \Exception('Redicash configuration is incomplete');
        }
    }

    /**
     * Create a new payment
     */
    public function createPayment(array $paymentData)
    {
        Log::info('Creating Redicash payment', ['data' => $paymentData]);

        try {
            $payload = [
                'amount' => $paymentData['amount'],
                'currency' => $paymentData['currency'] ?? 'MYR',
                'payment_method' => $paymentData['payment_method'] ?? 'card',
                'customer' => [
                    'email' => $paymentData['email'] ?? null,
                    'name' => $paymentData['name'] ?? null,
                    'phone' => $paymentData['phone'] ?? null,
                ],
                'metadata' => $paymentData['metadata'] ?? [],
                'return_url' => $paymentData['return_url'] ?? route('dashboard'),
                'cancel_url' => $paymentData['cancel_url'] ?? route('dashboard'),
            ];

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->publicKey,
                'X-Secret-Key' => $this->secretKey,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->post($this->baseUrl . '/payments', $payload);

            if ($response->successful()) {
                return $response->json();
            }

            throw new \Exception('Failed to create Redicash payment: ' . $response->body());
        } catch (\Exception $e) {
            Log::error('Redicash payment creation failed', [
                'error' => $e->getMessage(),
                'data' => $paymentData
            ]);
            throw $e;
        }
    }

    /**
     * Get payment status
     */
    public function getPaymentStatus(string $paymentId)
    {
        Log::info('Getting Redicash payment status', ['paymentId' => $paymentId]);

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->publicKey,
                'X-Secret-Key' => $this->secretKey,
                'Accept' => 'application/json',
            ])->get($this->baseUrl . '/payments/' . $paymentId);

            if ($response->successful()) {
                return $response->json();
            }

            throw new \Exception('Failed to get Redicash payment status: ' . $response->body());
        } catch (\Exception $e) {
            Log::error('Redicash payment status check failed', [
                'error' => $e->getMessage(),
                'paymentId' => $paymentId
            ]);
            throw $e;
        }
    }

    /**
     * List all payments
     */
    public function listPayments(array $filters = [])
    {
        Log::info('Listing Redicash payments', ['filters' => $filters]);

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->publicKey,
                'X-Secret-Key' => $this->secretKey,
                'Accept' => 'application/json',
            ])->get($this->baseUrl . '/payments', $filters);

            if ($response->successful()) {
                return $response->json();
            }

            throw new \Exception('Failed to list Redicash payments: ' . $response->body());
        } catch (\Exception $e) {
            Log::error('Redicash payments listing failed', [
                'error' => $e->getMessage(),
                'filters' => $filters
            ]);
            throw $e;
        }
    }

    /**
     * Cancel a payment
     */
    public function cancelPayment(string $paymentId)
    {
        Log::info('Canceling Redicash payment', ['paymentId' => $paymentId]);

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->publicKey,
                'X-Secret-Key' => $this->secretKey,
                'Accept' => 'application/json',
            ])->post($this->baseUrl . '/payments/' . $paymentId . '/cancel');

            if ($response->successful()) {
                return $response->json();
            }

            throw new \Exception('Failed to cancel Redicash payment: ' . $response->body());
        } catch (\Exception $e) {
            Log::error('Redicash payment cancellation failed', [
                'error' => $e->getMessage(),
                'paymentId' => $paymentId
            ]);
            throw $e;
        }
    }

    /**
     * Verify webhook signature
     */
    public function verifyWebhookSignature(string $payload, string $signature, string $secret)
    {
        $expectedSignature = hash_hmac('sha256', $payload, $secret);
        return hash_equals($expectedSignature, $signature);
    }
}
