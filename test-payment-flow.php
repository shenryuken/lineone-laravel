<?php

// Test script to verify the complete payment gateway flow
// Run this from your project root: php test-payment-flow-fixed.php

require_once 'vendor/autoload.php';

// Your API base URL (FIXED - removed duplicate path)
$baseUrl = 'http://lineone-laravel.test';

// Test API credentials (replace with actual values from your merchant dashboard)
$apiKey = 'test_pk_r6qOYS7a2OjSKEAqbu6r7yo82NdKTV4d';
$secretKey = 'test_sk_X0z1qp1PiDX0HeX44P9X0azmvtLidHGl';

echo "🚀 Testing Payment Gateway Flow\n";
echo "================================\n\n";

// Step 1: Create a payment order
echo "1. Creating payment order...\n";

$orderData = [
    'amount' => 50.00,
    'currency' => 'MYR',
    'customer_email' => 'test@example.com',
    'customer_name' => 'Test Customer',
    'description' => 'Test payment for gateway',
    'return_url' => $baseUrl . '/success',
    'cancel_url' => $baseUrl . '/cancel',
    'callback_url' => $baseUrl . '/webhook/test'
];

$payload = json_encode($orderData);
$timestamp = time();

// FIXED: Signature should be timestamp + payload (not payload + timestamp)
$signature = hash_hmac('sha256', $timestamp . $payload, $secretKey);

$headers = [
    'Content-Type: application/json',
    'X-API-Key: ' . $apiKey,
    'X-Timestamp: ' . $timestamp,
    'X-Signature: ' . $signature
];

echo "Debug Info:\n";
echo "URL: " . $baseUrl . '/api/merchant/v1/orders' . "\n";
echo "API Key: " . $apiKey . "\n";
echo "Timestamp: " . $timestamp . "\n";
echo "Payload: " . $payload . "\n";
echo "Signature: " . $signature . "\n\n";

$ch = curl_init();
// FIXED: Use correct endpoint (/orders not /payments)
curl_setopt($ch, CURLOPT_URL, $baseUrl . '/api/merchant/v1/orders');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_VERBOSE, true); // Add verbose output for debugging

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

echo "HTTP Code: $httpCode\n";
echo "Response: $response\n";
if ($error) {
    echo "cURL Error: $error\n";
}
echo "\n";

if ($httpCode === 201) {
    $orderResponse = json_decode($response, true);
    echo "✅ Order created successfully!\n";
    echo "   Order ID: " . $orderResponse['data']['order_id'] . "\n";
    echo "   Payment URL: " . $orderResponse['data']['payment_url'] . "\n\n";
    
    // Step 2: Test the checkout page
    echo "2. Testing checkout page...\n";
    $checkoutUrl = $orderResponse['data']['payment_url'];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $checkoutUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    
    $checkoutResponse = curl_exec($ch);
    $checkoutHttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($checkoutHttpCode === 200) {
        echo "✅ Checkout page accessible!\n";
        echo "   You can visit: " . $checkoutUrl . "\n\n";
        
        // Step 3: Check order status
        echo "3. Checking order status...\n";
        
        $statusPayload = '';
        $statusTimestamp = time();
        $statusSignature = hash_hmac('sha256', $statusTimestamp . $statusPayload, $secretKey);
        
        $statusHeaders = [
            'X-API-Key: ' . $apiKey,
            'X-Timestamp: ' . $statusTimestamp,
            'X-Signature: ' . $statusSignature
        ];
        
        $ch = curl_init();
        // FIXED: Use correct endpoint
        curl_setopt($ch, CURLOPT_URL, $baseUrl . '/api/merchant/v1/orders/' . $orderResponse['data']['order_id']);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $statusHeaders);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $statusResponse = curl_exec($ch);
        $statusHttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($statusHttpCode === 200) {
            $status = json_decode($statusResponse, true);
            echo "✅ Order status retrieved!\n";
            echo "   Status: " . $status['data']['status'] . "\n";
            echo "   Amount: " . $status['data']['currency'] . " " . $status['data']['amount'] . "\n\n";
        } else {
            echo "❌ Failed to get order status (HTTP $statusHttpCode)\n";
            echo "   Response: " . $statusResponse . "\n\n";
        }
        
    } else {
        echo "❌ Checkout page not accessible (HTTP $checkoutHttpCode)\n\n";
    }
    
} else {
    echo "❌ Failed to create order (HTTP $httpCode)\n";
    echo "   Response: " . $response . "\n\n";
}

echo "🧪 Manual Testing Steps:\n";
echo "========================\n";
echo "1. Visit your merchant dashboard: $baseUrl/merchant/api-keys\n";
echo "2. Create an API key if you haven't already\n";
echo "3. Use the API testing console to create a payment\n";
echo "4. Visit the checkout URL to test the payment flow\n";
echo "5. Check the merchant dashboard for transaction history\n\n";
