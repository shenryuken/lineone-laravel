<?php

// Simple script to debug your routes and API
// Run this from your project root: php debug-routes.php

$baseUrl = 'http://lineone-laravel.test';

echo "🔍 Debugging API Routes\n";
echo "=======================\n\n";

// Test 1: Check if the API endpoint exists
echo "1. Testing API endpoint availability...\n";

$testUrls = [
    $baseUrl . '/api/merchant/v1/orders',
    $baseUrl . '/api/merchant/v1',
    $baseUrl . '/api',
    $baseUrl
];

foreach ($testUrls as $url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_NOBODY, true); // HEAD request
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    echo "   $url -> HTTP $httpCode\n";
}

echo "\n2. Testing with minimal request...\n";

// Test 2: Try a simple request without authentication
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $baseUrl . '/api/merchant/v1/orders');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, '{}');
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

echo "   HTTP Code: $httpCode\n";
echo "   Response: $response\n";
if ($error) {
    echo "   cURL Error: $error\n";
}

echo "\n3. Laravel Route Commands to Run:\n";
echo "   php artisan route:list | grep merchant\n";
echo "   php artisan route:clear\n";
echo "   php artisan config:clear\n";
echo "   php artisan cache:clear\n";
