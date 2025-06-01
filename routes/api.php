<?php

use App\Http\Controllers\Gateway\PaymentGatewayApiController;
use App\Http\Controllers\Gateway\WebhookController;
use App\Http\Controllers\Api\MerchantPaymentController;
use App\Http\Controllers\Api\PaymentWidgetController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Payment Gateway API Routes
Route::prefix('gateway/v1')->name('api.gateway.')->group(function () {
    
    // Public webhook test endpoint
    Route::post('webhooks/test', [WebhookController::class, 'test'])->name('webhook.test');
    
    // Protected API routes (require API key authentication)
    Route::middleware('api.key.auth')->group(function () {
        // Payment management
        Route::post('payments', [PaymentGatewayApiController::class, 'createPaymentRequest'])->name('payments.create');
        Route::get('payments/{requestId}', [PaymentGatewayApiController::class, 'getPaymentRequestStatus'])->name('payments.status');
        Route::post('payments/{requestId}/refund', [PaymentGatewayApiController::class, 'refundPayment'])->name('payments.refund');
        
        // Additional endpoints for comprehensive API
        Route::get('payments', [PaymentGatewayApiController::class, 'listPayments'])->name('payments.list');
        Route::post('payments/{requestId}/cancel', [PaymentGatewayApiController::class, 'cancelPayment'])->name('payments.cancel');
        
        // Webhook management
        Route::post('webhooks/verify', [WebhookController::class, 'verify'])->name('webhook.verify');
    });
});

// Merchant Payment Gateway API - FIXED MIDDLEWARE NAME
Route::prefix('merchant/v1')->name('api.merchant.')->middleware('merchant.api.auth')->group(function () {
    Route::post('orders', [MerchantPaymentController::class, 'createOrder'])->name('orders.create');
    Route::get('orders/{orderId}', [MerchantPaymentController::class, 'getOrderStatus'])->name('orders.status');
    Route::get('orders', [MerchantPaymentController::class, 'listOrders'])->name('orders.list');
    Route::post('orders/{orderId}/cancel', [MerchantPaymentController::class, 'cancelOrder'])->name('orders.cancel');
});

// E-Wallet Payment Widget API (for external integration)
Route::prefix('widget')->name('api.widget.')->group(function () {
    // Public endpoints
    Route::post('wallets', [PaymentWidgetController::class, 'getUserWallets'])->name('wallets');
    Route::get('payments/{paymentId}/status', [PaymentWidgetController::class, 'checkPaymentStatus'])->name('payments.status');
    
    // Protected endpoints (require API key)
    Route::middleware('merchant.api.auth')->group(function () {
        Route::post('payments/initialize', [PaymentWidgetController::class, 'initializePayment'])->name('payments.initialize');
    });
    
    // Payment processing (no auth required for widget)
    Route::post('payments/{paymentId}/process', [PaymentWidgetController::class, 'processWalletPayment'])->name('payments.process');
});

// Rate limiting for API routes
Route::middleware(['throttle:api'])->group(function () {
    // Additional rate-limited routes can go here
});
