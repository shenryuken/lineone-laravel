<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RediPayService
{
    protected $baseUrl;
    protected $clientId;
    protected $clientSecret;
    protected $secretKey;

    public function __construct()
    {
        $this->baseUrl = config('redipay.base_url', 'https://sandbox.redipay.app');
        $this->clientId = config('redipay.client_id');
        $this->clientSecret = config('redipay.client_secret');
        $this->secretKey = config('redipay.secret_key');
    }

    public function createPayment(array $paymentData)
    {
        Log::info('Creating RediPay payment', ['data' => $paymentData]);

        $data = array_merge($paymentData, [
            'client_id' => $this->clientId,
        ]);

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$this->secretKey}",
            'Content-Type' => 'application/json',
        ])->post("{$this->baseUrl}/api/v1/payments", $data);

        if ($response->successful()) {
            return $response->json();
        }

        Log::error('RediPay createPayment failed', [
            'status' => $response->status(),
            'body' => $response->body()
        ]);

        throw new \Exception('Failed to create payment: ' . $response->body());
    }

    public function getPaymentStatus($paymentId)
    {
        Log::info('Getting RediPay payment status', ['paymentId' => $paymentId]);

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$this->secretKey}",
            'Content-Type' => 'application/json',
        ])->get("{$this->baseUrl}/api/v1/payments/{$paymentId}");

        if ($response->successful()) {
            return $response->json();
        }

        Log::error('RediPay getPaymentStatus failed', [
            'status' => $response->status(),
            'body' => $response->body()
        ]);

        throw new \Exception('Failed to get payment status');
    }
}

