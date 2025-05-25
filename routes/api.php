<?php

use App\Http\Controllers\Gateway\PaymentGatewayApiController;
use App\Http\Controllers\Gateway\WebhookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MerchantPaymentController;

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

// Rate limiting for API routes
Route::middleware(['throttle:api'])->group(function () {
    // Additional rate-limited routes can go here
});

// Merchant Payment Gateway API
Route::prefix('merchant/v1')->middleware('merchant.api.auth')->group(function () {
    Route::post('orders', [MerchantPaymentController::class, 'createOrder']);
    Route::get('orders/{orderId}', [MerchantPaymentController::class, 'getOrderStatus']);
    Route::get('orders', [MerchantPaymentController::class, 'listOrders']);
    Route::post('orders/{orderId}/cancel', [MerchantPaymentController::class, 'cancelOrder']);
});
