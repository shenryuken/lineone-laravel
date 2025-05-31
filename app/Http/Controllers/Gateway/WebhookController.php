<?php

namespace App\Http\Controllers\Gateway;

use App\Http\Controllers\Controller;
use App\Models\MerchantApiKey;
use App\Models\PaymentOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    /**
     * Test webhook endpoint
     */
    public function test(Request $request)
    {
        Log::info('Webhook test received', [
            'headers' => $request->headers->all(),
            'body' => $request->all(),
            'ip' => $request->ip()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Webhook test received successfully',
            'timestamp' => now()->toISOString(),
            'data' => $request->all()
        ]);
    }

    /**
     * Verify webhook signature
     */
    public function verify(Request $request)
    {
        $signature = $request->header('X-Webhook-Signature');
        $payload = $request->getContent();
        
        if (!$signature) {
            return response()->json([
                'success' => false,
                'message' => 'Missing webhook signature'
            ], 400);
        }

        $apiKey = $request->attributes->get('merchant_api_key');
        if (!$apiKey) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid API key'
            ], 401);
        }

        $expectedSignature = hash_hmac('sha256', $payload, $apiKey->secret_key);
        
        if (!hash_equals($signature, $expectedSignature)) {
            Log::warning('Invalid webhook signature', [
                'api_key_id' => $apiKey->id,
                'provided_signature' => $signature,
                'expected_signature' => $expectedSignature
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Invalid webhook signature'
            ], 401);
        }

        return response()->json([
            'success' => true,
            'message' => 'Webhook signature verified successfully'
        ]);
    }

    /**
     * Handle incoming webhook from external payment processors
     */
    public function handleExternalWebhook(Request $request, $provider)
    {
        try {
            switch ($provider) {
                case 'stripe':
                    return $this->handleStripeWebhook($request);
                case 'paypal':
                    return $this->handlePayPalWebhook($request);
                default:
                    Log::warning('Unknown webhook provider', ['provider' => $provider]);
                    return response()->json(['error' => 'Unknown provider'], 400);
            }
        } catch (\Exception $e) {
            Log::error('Webhook processing failed', [
                'provider' => $provider,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json(['error' => 'Webhook processing failed'], 500);
        }
    }

    /**
     * Handle Stripe webhook
     */
    protected function handleStripeWebhook(Request $request)
    {
        $payload = $request->getContent();
        $signature = $request->header('Stripe-Signature');
        
        // Verify Stripe signature (implement according to Stripe docs)
        // This is a simplified version
        
        $event = json_decode($payload, true);
        
        if ($event['type'] === 'payment_intent.succeeded') {
            $paymentIntent = $event['data']['object'];
            $orderId = $paymentIntent['metadata']['order_id'] ?? null;
            
            if ($orderId) {
                $this->updatePaymentOrderFromWebhook($orderId, 'paid', $event);
            }
        }
        
        return response()->json(['received' => true]);
    }

    /**
     * Handle PayPal webhook
     */
    protected function handlePayPalWebhook(Request $request)
    {
        // Implement PayPal webhook handling
        $payload = $request->all();
        
        Log::info('PayPal webhook received', $payload);
        
        return response()->json(['received' => true]);
    }

    /**
     * Update payment order from external webhook
     */
    protected function updatePaymentOrderFromWebhook($orderId, $status, $webhookData)
    {
        $paymentOrder = PaymentOrder::where('order_id', $orderId)->first();
        
        if (!$paymentOrder) {
            Log::warning('Payment order not found for webhook', ['order_id' => $orderId]);
            return;
        }
        
        $paymentOrder->update([
            'status' => $status,
            'paid_at' => now(),
            'metadata' => array_merge($paymentOrder->metadata ?? [], [
                'webhook_data' => $webhookData,
                'updated_via_webhook' => true
            ])
        ]);
        
        Log::info('Payment order updated from webhook', [
            'order_id' => $orderId,
            'new_status' => $status
        ]);
    }
}
