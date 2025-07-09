<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Redicash Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration for the Redicash payment gateway.
    | Set your API keys and other settings here.
    |
    */

    'mode' => env('REDICASH_MODE', 'development'), // development or production
    
    // Development environment
    'development' => [
        'base_url' => env('REDICASH_DEV_BASE_URL', 'https://redicashv2.test/api/v1'),
        'public_key' => env('REDICASH_DEV_PUBLIC_KEY', ''),
        'secret_key' => env('REDICASH_DEV_SECRET_KEY', ''),
    ],
    
    // Production environment
    'production' => [
        'base_url' => env('REDICASH_PROD_BASE_URL', 'https://redicash.ai/api/v1'),
        'public_key' => env('REDICASH_PROD_PUBLIC_KEY', ''),
        'secret_key' => env('REDICASH_PROD_SECRET_KEY', ''),
    ],
    
    // Webhook configuration
    'webhook' => [
        'secret' => env('REDICASH_WEBHOOK_SECRET', ''),
        'url' => env('REDICASH_WEBHOOK_URL', '/webhooks/redicash'),
    ],
    
    // Default settings
    'defaults' => [
        'currency' => env('REDICASH_DEFAULT_CURRENCY', 'MYR'),
        'payment_method' => env('REDICASH_DEFAULT_PAYMENT_METHOD', 'card'),
        'timeout' => env('REDICASH_TIMEOUT', 30),
    ],
];
