<?php

// return [
//     'base_url' => env('APP_ENV') === 'production' ? 'https://dev.toyyibpay.com/' : 'https://dev.toyyibpay.com/',
//     'key' => env('APP_ENV') === 'production' ? env('TOYYIBPAY_KEY_LIVE') : env('TOYYIBPAY_KEY_SANDBOX'),
//     'category' => env('APP_ENV') === 'production' ? env('TOYYIBPAY_CATEGORY_LIVE') : env('TOYYIBPAY_CATEGORY_SANDBOX'),
// ];

// return [
//     'base_url' => env('APP_ENV') === 'production'
//         ? 'https://toyyibpay.com'
//         : 'https://dev.toyyibpay.com',
//     'key' => env('APP_ENV') === 'production'
//         ? env('TOYYIBPAY_KEY_LIVE')
//         : env('TOYYIBPAY_KEY_SANDBOX'),
//     'category' => env('APP_ENV') === 'production'
//         ? env('TOYYIBPAY_CATEGORY_LIVE')
//         : env('TOYYIBPAY_CATEGORY_SANDBOX'),
// ];

return [
    'base_url' => env('APP_ENV') === 'production'
        ? 'https://dev.toyyibpay.com'
        : 'https://dev.toyyibpay.com',
    'key' => env('APP_ENV') === 'production'
        ? env('TOYYIBPAY_KEY_SANDBOX')
        : env('TOYYIBPAY_KEY_SANDBOX'),
    'category' => env('APP_ENV') === 'production'
        ? env('TOYYIBPAY_CATEGORY_SANDBOX')
        : env('TOYYIBPAY_CATEGORY_SANDBOX'),
];
