<?php

/**
 * Simple PHP script to test the Payment Gateway API
 * Run this from command line: php test-api.php
 */

// Configuration
$baseUrl = 'https://lineone-laravel/api/merchant/v1';
$apiKey = 'test_pk_r6qOYS7a2OjSKEAqbu6r7yo82NdKTV4d'; // Replace with your actual API key
$secretKey = 'test_sk_X0z1qp1PiDX0HeX44P9X0azmvtLidHGl'; // Replace with your actual secret key

function generateSignature($timestamp, $payload, $secretKey) {
    $message = $timestamp . $payload;
    return hash_hmac('sha256', $message, $secretKey);
}

function makeApiRequest($url, $method = 'POST', $data = null, $apiKey, $secretKey) {
    $timestamp = time();
    $payload = $data ? json_encode($data) : '';
    $signature = generateSignature($timestamp, $payload, $secretKey);
    
    $headers = [
        'Content-Type: application/json',
        'X-API-Key: ' . $apiKey,
        'X-Signature: ' . $signature,
        'X-Timestamp: ' . $timestamp
    ];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    
    if ($data && $method !== 'GET') {
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    }
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    return [
        'status_code' => $httpCode,
        'response' => json_decode($response, true) ?: $response
    ];
}

echo "🚀 Payment Gateway API Test Script\n";
echo "==================================\n\n";

// Test 1: Create Payment Order
echo "Test 1: Creating Payment Order...\n";
$orderData = [
    'amount' => 100.00,
    'currency' => 'MYR',
    'description' => 'Test payment order from PHP script',
    'customer_email' => 'test@example.com',
    'customer_name' => 'Test Customer',
    'merchant_order_id' => 'ORDER_' . time(),
    'return_url' => 'https://lineone-laravel/payment/success',
    'cancel_url' => 'https://lineone-laravel/payment/cancel'
];

$result = makeApiRequest($baseUrl . '/orders', 'POST', $orderData, $apiKey, $secretKey);
echo "Status: " . $result['status_code'] . "\n";
echo "Response: " . json_encode($result['response'], JSON_PRETTY_PRINT) . "\n\n";

if ($result['status_code'] === 201 && isset($result['response']['data']['order_id'])) {
    $orderId = $result['response']['data']['order_id'];
    echo "✅ Order created successfully! Order ID: $orderId\n\n";
    
    // Test 2: Get Order Status
    echo "Test 2: Getting Order Status...\n";
    $result = makeApiRequest($baseUrl . '/orders/' . $orderId, 'GET', null, $apiKey, $secretKey);
    echo "Status: " . $result['status_code'] . "\n";
    echo "Response: " . json_encode($result['response'], JSON_PRETTY_PRINT) . "\n\n";
    
    if ($result['status_code'] === 200) {
        echo "✅ Order status retrieved successfully!\n\n";
    } else {
        echo "❌ Failed to get order status\n\n";
    }
} else {
    echo "❌ Failed to create order\n\n";
}

// Test 3: List Orders
echo "Test 3: Listing Orders...\n";
$result = makeApiRequest($baseUrl . '/orders?per_page=5', 'GET', null, $apiKey, $secretKey);
echo "Status: " . $result['status_code'] . "\n";
echo "Response: " . json_encode($result['response'], JSON_PRETTY_PRINT) . "\n\n";

if ($result['status_code'] === 200) {
    echo "✅ Orders listed successfully!\n\n";
} else {
    echo "❌ Failed to list orders\n\n";
}

// Test 4: Test Webhook
echo "Test 4: Testing Webhook Endpoint...\n";
$webhookUrl = str_replace('/merchant/v1', '/gateway/v1/webhooks/test', $baseUrl);
$webhookData = [
    'test' => true,
    'timestamp' => date('c'),
    'message' => 'Test webhook from PHP script'
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $webhookUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($webhookData));

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "Status: " . $httpCode . "\n";
echo "Response: " . $response . "\n\n";

if ($httpCode === 200) {
    echo "✅ Webhook test successful!\n\n";
} else {
    echo "❌ Webhook test failed\n\n";
}

echo "🏁 Testing completed!\n";
echo "\nNext steps:\n";
echo "1. Update the API key and secret key in this script\n";
echo "2. Make sure your Laravel app is running (php artisan serve)\n";
echo "3. Check the web interface at: http://localhost:8000/merchant/api-keys/test\n";
?>
