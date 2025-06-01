#!/bin/bash

echo "🔧 Fixing SSL and Route Issues"
echo "=============================="

echo "1. Clearing Laravel caches..."
php artisan route:clear
php artisan config:clear
php artisan cache:clear
php artisan view:clear

echo "2. Checking if routes are registered..."
echo "Merchant API routes:"
php artisan route:list | grep merchant || echo "No merchant routes found!"

echo "3. Checking middleware registration..."
php artisan route:list | grep "merchant.api.auth" || echo "Middleware not found!"

echo "4. Testing basic Laravel functionality..."
php artisan --version

echo "5. Checking if API routes file is loaded..."
if [ -f "routes/api.php" ]; then
    echo "✅ routes/api.php exists"
    grep -n "merchant/v1" routes/api.php || echo "❌ No merchant/v1 routes found in api.php"
else
    echo "❌ routes/api.php not found!"
fi

echo "6. Checking web server configuration..."
echo "Make sure your web server (Apache/Nginx) is configured to handle both HTTP and HTTPS"
echo "For local development, use HTTP: http://lineone-laravel.test"

echo "7. Testing with curl (no SSL)..."
curl -I http://lineone-laravel.test 2>/dev/null | head -1 || echo "❌ Cannot connect to http://lineone-laravel.test"

echo "Done! Now run: php test-api-no-ssl.php"
