<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RedicashService
{
    protected $baseUrl;
    protected $publicKey;
    protected $secretKey;
    protected $webhookSecret;
    protected $mode;

    public function __construct()
    {
        $this->mode = config('redicash.mode', 'development');
        
        // Get configuration based on mode
        $config = config("redicash.{$this->mode}");
        $this->baseUrl = $config['base_url'];
        $this->publicKey = $config['public_key'];
        $this->secretKey = $config['secret_key'];
        $this->webhookSecret = config('redicash.webhook.secret');

        // For testing purposes, provide more detailed error information
        if (empty($this->publicKey) || empty($this->secretKey)) {
            throw new \Exception('Redicash configuration is incomplete. Missing API keys. Please add REDICASH_DEV_PUBLIC_KEY and REDICASH_DEV_SECRET_KEY to your .env file.');
        }
    }

    /**
     * Create a new payment according to official Redicash API guide
     */
    public function createPayment(array $paymentData)
    {
        Log::info('Creating Redicash payment', ['data' => $paymentData]);

        try {
            // Format payload according to official Redicash API documentation
            $payload = [
                'amount' => $paymentData['amount'], // Should be in cents
                'currency' => $paymentData['currency'] ?? 'MYR',
                'customer' => [
                    'name' => $paymentData['customer']['name'] ?? $paymentData['name'] ?? null,
                    'email' => $paymentData['customer']['email'] ?? $paymentData['email'] ?? null,
                    'phone' => $paymentData['customer']['phone'] ?? $paymentData['phone'] ?? null,
                ],
                'return_url' => $paymentData['return_url'] ?? route('dashboard'),
                'cancel_url' => $paymentData['cancel_url'] ?? route('dashboard'),
                'metadata' => $paymentData['metadata'] ?? [],
            ];

            // Add optional fields if provided
            if (isset($paymentData['reference_id'])) {
                $payload['reference_id'] = $paymentData['reference_id'];
            }
            if (isset($paymentData['description'])) {
                $payload['description'] = $paymentData['description'];
            }

            Log::info('Redicash payload prepared', ['payload' => $payload]);

            // Send request according to official API documentation with proper headers
            $response = Http::withOptions([
                'verify' => false, // Disable SSL verification for development
                'timeout' => 30,
            ])->withHeaders([
                'Authorization' => 'Bearer ' . $this->publicKey,
                'X-Secret-Key' => $this->secretKey,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->post($this->baseUrl . '/payments', $payload);

            Log::info('Redicash API response', [
                'status' => $response->status(),
                'headers' => $response->headers(),
                'body' => $response->body()
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            // Enhanced error handling according to official guide
            $errorBody = $response->body();
            $errorData = json_decode($errorBody, true);
            
            if (isset($errorData['error']['message'])) {
                throw new \Exception('Redicash API Error: ' . $errorData['error']['message']);
            }

            throw new \Exception('Failed to create Redicash payment: ' . $errorBody);
        } catch (\Exception $e) {
            Log::error('Redicash payment creation failed', [
                'error' => $e->getMessage(),
                'data' => $paymentData,
                'trace' => $e->getTraceAsString()
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
            $response = Http::withOptions([
                'verify' => false, // Disable SSL verification for development
                'timeout' => 30,
            ])->withHeaders([
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
            $response = Http::withOptions([
                'verify' => false, // Disable SSL verification for development
                'timeout' => 30,
            ])->withHeaders([
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
            $response = Http::withOptions([
                'verify' => false, // Disable SSL verification for development
                'timeout' => 30,
            ])->withHeaders([
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
     * Verify webhook signature according to official guide
     */
    public function verifyWebhookSignature(string $payload, string $signature, string $secret = null)
    {
        $webhookSecret = $secret ?? $this->webhookSecret;
        $expectedSignature = 'sha256=' . hash_hmac('sha256', $payload, $webhookSecret);
        return hash_equals($expectedSignature, $signature);
    }
}
