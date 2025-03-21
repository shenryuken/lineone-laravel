<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class RediPayService
{
    protected $baseUrl;
    protected $clientId;
    protected $clientSecret;
    protected $secretKey;
    protected $accessToken;

    public function __construct()
    {
        $this->baseUrl = config('redipay.base_url', 'https://sandbox.redipay.app');
        $this->clientId = config('redipay.client_id');
        $this->clientSecret = config('redipay.client_secret');
        $this->secretKey = config('redipay.secret_key');

        if (empty($this->baseUrl) || empty($this->clientId) || empty($this->clientSecret) || empty($this->secretKey)) {
            throw new \Exception('RediPay configuration is incomplete');
        }
    }

    /**
     * Get access token for debugging
     */
    public function getAccessToken()
    {
        return $this->fetchAccessToken();
    }

    /**
     * Fetch access token from API
     */
    protected function fetchAccessToken()
    {
        // Check if we have a cached token
        if (Cache::has('redipay_access_token')) {
            return Cache::get('redipay_access_token');
        }

        Log::info('Requesting new RediPay access token');

        try {
            $response = Http::post("{$this->baseUrl}/oauth/token", [
                'grant_type' => 'client_credentials',
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'scope' => '*',
            ]);

            if ($response->successful()) {
                $data = $response->json();
                Log::info('RediPay token obtained successfully', ['expires_in' => $data['expires_in'] ?? 'unknown']);

                // Cache the token (for slightly less than the expiry time)
                $expiresIn = ($data['expires_in'] ?? 1296000) - 60;
                $token = $data['access_token'];

                Cache::put('redipay_access_token', $token, $expiresIn);

                return $token;
            }

            Log::error('Failed to get RediPay access token', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            throw new \Exception('Failed to authenticate with RediPay: ' . $response->body());
        } catch (\Exception $e) {
            Log::error('Exception while getting RediPay token', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    /**
     * Create a payment
     */
    public function createPayment(array $paymentData)
    {
        Log::info('Creating RediPay payment', ['data' => $paymentData]);

        try {
            // Get access token
            $token = $this->fetchAccessToken();

            // Make sure we have the required fields
            if (!isset($paymentData['callback_url'])) {
                throw new \Exception('callback_url is required for RediPay payments');
            }

            // Add redirect_url if not provided
            if (!isset($paymentData['redirect_url'])) {
                $paymentData['redirect_url'] = route('dashboard');
            }

            $data = array_merge($paymentData, [
                'client_id' => $this->clientId,
            ]);

            // Use the correct endpoint from the documentation
            $endpoint = "{$this->baseUrl}/api/payments/payment";

            Log::info('Attempting RediPay payment with endpoint', [
                'endpoint' => $endpoint,
                'data' => $data
            ]);

            // Make the API request with the token
            $response = Http::withToken($token)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ])
                ->post($endpoint, $data);

            if ($response->successful()) {
                Log::info('RediPay payment created successfully', ['response' => $response->json()]);
                return $response->json();
            }

            Log::error('RediPay createPayment failed', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            throw new \Exception('Failed to create payment: ' . $response->body());
        } catch (\Exception $e) {
            Log::error('RediPay payment creation exception', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    // Update the getPaymentStatus method to use a consistent endpoint pattern
    public function getPaymentStatus($paymentId)
    {
        Log::info('Getting RediPay payment status', ['paymentId' => $paymentId]);

        try {
            // Get access token
            $token = $this->fetchAccessToken();

            // Use a consistent endpoint pattern
            $endpoint = "{$this->baseUrl}/api/payments/{$paymentId}";

            $response = Http::withToken($token)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ])
                ->get($endpoint);

            if ($response->successful()) {
                Log::info('RediPay payment status retrieved', ['status' => $response->json()]);
                return $response->json();
            }

            Log::error('RediPay getPaymentStatus failed', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            throw new \Exception('Failed to get payment status: ' . $response->body());
        } catch (\Exception $e) {
            Log::error('RediPay payment status exception', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

     /**
     * Check payment status by reference ID
     */
    public function checkPaymentStatusByReference($referenceId)
    {
        Log::info('Checking RediPay payment status by reference', ['referenceId' => $referenceId]);

        try {
            // Get access token
            $token = $this->fetchAccessToken();

            // Use the payments search endpoint
            $endpoint = "{$this->baseUrl}/api/payments/search";

            $response = Http::withToken($token)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ])
                ->post($endpoint, [
                    'reference_no' => $referenceId
                ]);

            if ($response->successful()) {
                $data = $response->json();
                Log::info('RediPay payment status retrieved by reference', ['data' => $data]);
                return $data;
            }

            Log::error('RediPay checkPaymentStatusByReference failed', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            throw new \Exception('Failed to get payment status: ' . $response->body());
        } catch (\Exception $e) {
            Log::error('RediPay payment status by reference exception', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }
}

