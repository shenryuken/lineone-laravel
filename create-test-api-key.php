<?php

// Create a test API key in the database
// Run this from your project root: php create-test-api-key.php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\MerchantApiKey;

echo "🔑 Creating Test API Key\n";
echo "========================\n\n";

try {
    // Find or create a merchant user
    $merchant = User::where('email', 'merchant@test.com')->first();
    
    if (!$merchant) {
        echo "Creating test merchant user...\n";
        $merchant = User::create([
            'name' => 'Test Merchant',
            'email' => 'merchant@test.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);
        
        // Assign merchant role (assuming you have Spatie roles)
        if (method_exists($merchant, 'assignRole')) {
            $merchant->assignRole('merchant');
        }
    }
    
    echo "Merchant User ID: {$merchant->id}\n";
    echo "Merchant Email: {$merchant->email}\n\n";
    
    // Create API key
    $keys = MerchantApiKey::generateKeys('test');
    
    $apiKey = MerchantApiKey::create([
        'user_id' => $merchant->id,
        'name' => 'Test API Key',
        'description' => 'Generated for testing',
        'api_key' => $keys['api_key'],
        'secret_key' => $keys['secret_key'],
        'mode' => 'test',
        'daily_limit' => 10000,
        'per_transaction_limit' => 1000,
        'is_active' => true,
    ]);
    
    echo "✅ API Key created successfully!\n\n";
    echo "API Key: {$apiKey->api_key}\n";
    echo "Secret Key: {$apiKey->secret_key}\n";
    echo "Mode: {$apiKey->mode}\n";
    echo "Status: " . ($apiKey->is_active ? 'Active' : 'Inactive') . "\n\n";
    
    echo "🧪 Test this API key with:\n";
    echo "php test-api-no-ssl.php\n\n";
    
    echo "📝 Update the test script with these values:\n";
    echo "\$testApiKey = '{$apiKey->api_key}';\n";
    echo "\$testSecretKey = '{$apiKey->secret_key}';\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Make sure you've run: php artisan migrate\n";
}
