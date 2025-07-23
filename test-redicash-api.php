<?php

/**
 * Test script to verify Redicash API configuration and functionality
 * Run this from command line: php test-redicash-api.php
 */

require_once 'vendor/autoload.php';

// Load Laravel environment
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

echo "🚀 Redicash API Test Script\n";
echo "===========================\n\n";

// Get Redicash configuration
$mode = config('redicash.mode', 'development');
$config = config("redicash.{$mode}");
$baseUrl = $config['base_url'];
$publicKey = $config['public_key'];
$secretKey = $config['secret_key'];
$webhookSecret = config('redicash.webhook.secret');

echo "Configuration:\n";
echo "- Mode: {$mode}\n";
echo "- Base URL: {$baseUrl}\n";
echo "- Public Key: " . (empty($publicKey) ? '❌ MISSING' : '✅ SET (' . substr($publicKey, 0, 10) . '...)') . "\n";
echo "- Secret Key: " . (empty($secretKey) ? '❌ MISSING' : '✅ SET (' . substr($secretKey, 0, 10) . '...)') . "\n";
echo "- Webhook Secret: " . (empty($webhookSecret) ? '❌ MISSING' : '✅ SET (' . substr($webhookSecret, 0, 10) . '...)') . "\n\n";

if (empty($publicKey) || empty($secretKey)) {
    echo "❌ Configuration incomplete. Please check your .env file.\n";
    exit(1);
}

// Test 1: Create Payment (Official RediCash API format)
echo "Test 1: Creating Payment (Official RediCash API format)...\n";

$referenceId = 'TEST-' . time();
$paymentData = [
    'amount' => 1000, // 10.00 MYR in cents
    'currency' => 'MYR',
    'customer' => [
        'email' => 'test@example.com',
        'name' => 'Test User'
    ],
    'return_url' => 'https://webhook.site/8dc7e775-ca43-4fff-92b3-cc2108a1c52d',
    'cancel_url' => 'https://webhook.site/8dc7e775-ca43-4fff-92b3-cc2108a1c52d',
    'metadata' => [
        'order_id' => $referenceId,
        'wallet_id' => '5',
        'user_id' => '4'
    ]
];

echo "Payload: " . json_encode($paymentData, JSON_PRETTY_PRINT) . "\n\n";

try {
    $response = Http::withOptions([
        'verify' => false,
        'timeout' => 30,
    ])->withHeaders([
        'Authorization' => 'Bearer ' . $publicKey,
        'X-Secret-Key' => $secretKey,
        'Content-Type' => 'application/json',
        'Accept' => 'application/json',
    ])->post($baseUrl . '/payments', $paymentData);

    echo "Response Status: " . $response->status() . "\n";
    echo "Response Headers: " . json_encode($response->headers(), JSON_PRETTY_PRINT) . "\n";
    echo "Response Body: " . $response->body() . "\n\n";

    if ($response->successful()) {
        $responseData = $response->json();
        echo "✅ Payment created successfully!\n";
        
        if (isset($responseData['data']['id'])) {
            $paymentId = $responseData['data']['id'];
            echo "Payment ID: {$paymentId}\n";
            
            if (isset($responseData['data']['checkout_url'])) {
                echo "Checkout URL: " . $responseData['data']['checkout_url'] . "\n";
            }
            
            // Test 2: Get Payment Status
            echo "\nTest 2: Getting Payment Status...\n";
            $statusResponse = Http::withOptions([
                'verify' => false,
                'timeout' => 30,
            ])->withHeaders([
                'Authorization' => 'Bearer ' . $publicKey,
                'X-Secret-Key' => $secretKey,
                'Accept' => 'application/json',
            ])->get($baseUrl . '/payments/' . $paymentId);
            
            echo "Status Response: " . $statusResponse->status() . "\n";
            echo "Status Body: " . $statusResponse->body() . "\n\n";
            
            if ($statusResponse->successful()) {
                echo "✅ Payment status retrieved successfully!\n";
            } else {
                echo "❌ Failed to get payment status\n";
            }
        }
    } else {
        echo "❌ Payment creation failed\n";
        echo "Error details: " . $response->body() . "\n";
    }
} catch (\Exception $e) {
    echo "❌ Exception occurred: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}

echo "\n🏁 Test completed!\n";
echo "\nNext steps if test fails:\n";
echo "1. Verify your .env file has correct REDICASH_DEV_* variables\n";
echo "2. Check if the base URL is accessible\n";
echo "3. Verify API keys are valid\n";
echo "4. Compare with working Postman request\n";
