<?php

// Test API without SSL verification
// Run this from your project root: php test-api-no-ssl.php

require_once 'vendor/autoload.php';

echo "🔧 Testing API without SSL verification\n";
echo "=======================================\n\n";

// Use HTTP instead of HTTPS for local testing
$baseUrl = 'http://lineone-laravel.test/api/merchant/v1';

echo "1. Testing basic connectivity...\n";

// Test basic connectivity first
$urls = [
    'http://lineone-laravel.test',
    'http://lineone-laravel.test/api',
    'http://lineone-laravel.test/api/merchant',
    'http://lineone-laravel.test/api/merchant/v1',
    'http://lineone-laravel.test/api/merchant/v1/orders'
];

foreach ($urls as $url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Disable SSL verification
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // Disable SSL verification
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);
    
    echo "   {$url} -> HTTP {$httpCode}";
    if ($error) {
        echo " (Error: {$error})";
    }
    echo "\n";
}

echo "\n2. Testing with API authentication...\n";

// Replace with your actual API key from the database
$testApiKey = 'test_pk_r6qOYS7a2OjSKEAqbu6r7yo82NdKTV4d';
$testSecretKey = 'test_sk_X0z1qp1PiDX0HeX44P9X0azmvtLidHGl';

$orderData = [
    'amount' => 50.00,
    'currency' => 'MYR',
    'customer_email' => 'test@example.com',
    'customer_name' => 'Test Customer',
    'description' => 'Test payment'
];

$payload = json_encode($orderData);
$timestamp = time();
$signature = hash_hmac('sha256', $timestamp . $payload, $testSecretKey);

$headers = [
    'Content-Type: application/json',
    'X-API-Key: ' . $testApiKey,
    'X-Timestamp: ' . $timestamp,
    'X-Signature: ' . $signature
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $baseUrl . '/orders');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Disable SSL verification
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // Disable SSL verification
curl_setopt($ch, CURLOPT_TIMEOUT, 30);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

echo "POST {$baseUrl}/orders -> HTTP {$httpCode}\n";
echo "Response: {$response}\n";
if ($error) {
    echo "Error: {$error}\n";
}

echo "\n3. Laravel route debugging...\n";
echo "Run these commands to debug:\n";
echo "   php artisan route:list | grep merchant\n";
echo "   php artisan route:clear\n";
echo "   php artisan config:clear\n";
echo "   php artisan cache:clear\n";
