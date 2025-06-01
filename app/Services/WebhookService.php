<?php

namespace App\Services;

use App\Models\PaymentOrder;
use App\Models\WebhookDelivery;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WebhookService
{
    /**
     * Send payment notification webhook
     */
    public function sendPaymentNotification($webhookUrl, PaymentOrder $paymentOrder, $eventType)
    {
        $payload = [
            'event' => $eventType,
            'timestamp' => now()->toISOString(),
            'data' => [
                'payment_id' => $paymentOrder->order_id,
                'merchant_order_id' => $paymentOrder->merchant_order_id,
                'status' => $paymentOrder->status,
                'amount' => $paymentOrder->amount,
                'currency' => $paymentOrder->currency,
                'customer_email' => $paymentOrder->customer_email,
                'customer_name' => $paymentOrder->customer_name,
                'description' => $paymentOrder->description,
                'payment_method' => $paymentOrder->payment_method,
                'paid_at' => $paymentOrder->paid_at?->toISOString(),
                'metadata' => $paymentOrder->metadata,
            ]
        ];

        $signature = $this->generateWebhookSignature($payload, $paymentOrder->merchantApiKey->secret_key);

        try {
            $response = Http::timeout(30)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'X-Webhook-Signature' => $signature,
                    'X-Webhook-Event' => $eventType,
                    'User-Agent' => 'EWallet-Webhook/1.0',
                ])
                ->post($webhookUrl, $payload);

            $this->logWebhookDelivery($paymentOrder, $webhookUrl, $payload, $response->status(), $response->body());

            Log::info('Webhook delivered successfully', [
                'payment_id' => $paymentOrder->order_id,
                'webhook_url' => $webhookUrl,
                'status_code' => $response->status()
            ]);

            return $response->successful();

        } catch (\Exception $e) {
            $this->logWebhookDelivery($paymentOrder, $webhookUrl, $payload, 0, $e->getMessage());

            Log::error('Webhook delivery failed', [
                'payment_id' => $paymentOrder->order_id,
                'webhook_url' => $webhookUrl,
                'error' => $e->getMessage()
            ]);

            return false;
        }
    }

    /**
     * Generate webhook signature
     */
    private function generateWebhookSignature($payload, $secretKey)
    {
        return hash_hmac('sha256', json_encode($payload), $secretKey);
    }

    /**
     * Log webhook delivery attempt
     */
    private function logWebhookDelivery($paymentOrder, $webhookUrl, $payload, $statusCode, $response)
    {
        // You can create a webhook_deliveries table to track this
        Log::info('Webhook delivery logged', [
            'payment_id' => $paymentOrder->order_id,
            'webhook_url' => $webhookUrl,
            'status_code' => $statusCode,
            'payload_size' => strlen(json_encode($payload)),
            'response_preview' => substr($response, 0, 200)
        ]);
    }
}
