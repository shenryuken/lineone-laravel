<?php

namespace App\Http\Controllers\Webhook;

use App\Http\Controllers\Controller;
use App\Services\RedicashService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RedicashWebhookController extends Controller
{
    protected $redicashService;

    public function __construct(RedicashService $redicashService)
    {
        $this->redicashService = $redicashService;
    }

    /**
     * Handle Redicash webhook events
     */
    public function handle(Request $request)
    {
        Log::info('Redicash webhook received', [
            'headers' => $request->headers->all(),
            'payload' => $request->all()
        ]);

        try {
            // Verify webhook signature
            $signature = $request->header('X-Redicash-Signature');
            $payload = $request->getContent();
            $secret = config('redicash.webhook.secret');

            if (!$this->redicashService->verifyWebhookSignature($payload, $signature, $secret)) {
                Log::warning('Invalid Redicash webhook signature');
                return response()->json(['error' => 'Invalid signature'], 400);
            }

            $event = $request->all();
            
            // Handle different event types
            switch ($event['event'] ?? '') {
                case 'payment.completed':
                    $this->handlePaymentCompleted($event['data']);
                    break;
                    
                case 'payment.failed':
                    $this->handlePaymentFailed($event['data']);
                    break;
                    
                case 'payment.cancelled':
                    $this->handlePaymentCancelled($event['data']);
                    break;
                    
                case 'payment.refunded':
                    $this->handlePaymentRefunded($event['data']);
                    break;
                    
                default:
                    Log::info('Unhandled Redicash event type', ['event' => $event['event'] ?? 'unknown']);
            }

            return response()->json(['status' => 'ok'], 200);
        } catch (\Exception $e) {
            Log::error('Redicash webhook processing failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json(['error' => 'Processing failed'], 500);
        }
    }

    /**
     * Handle payment completed event
     */
    protected function handlePaymentCompleted(array $paymentData)
    {
        Log::info('Redicash payment completed', ['payment' => $paymentData]);
        
        // Update payment status in your database
        // Example: Update PaymentOrder model
        // PaymentOrder::where('gateway_payment_id', $paymentData['id'])
        //     ->update(['status' => 'completed', 'completed_at' => now()]);
    }

    /**
     * Handle payment failed event
     */
    protected function handlePaymentFailed(array $paymentData)
    {
        Log::info('Redicash payment failed', ['payment' => $paymentData]);
        
        // Update payment status in your database
        // Example: Update PaymentOrder model
        // PaymentOrder::where('gateway_payment_id', $paymentData['id'])
        //     ->update(['status' => 'failed', 'failure_reason' => $paymentData['failure_reason'] ?? null]);
    }

    /**
     * Handle payment cancelled event
     */
    protected function handlePaymentCancelled(array $paymentData)
    {
        Log::info('Redicash payment cancelled', ['payment' => $paymentData]);
        
        // Update payment status in your database
        // Example: Update PaymentOrder model
        // PaymentOrder::where('gateway_payment_id', $paymentData['id'])
        //     ->update(['status' => 'cancelled']);
    }

    /**
     * Handle payment refunded event
     */
    protected function handlePaymentRefunded(array $paymentData)
    {
        Log::info('Redicash payment refunded', ['payment' => $paymentData]);
        
        // Update payment status in your database
        // Example: Update PaymentOrder model
        // PaymentOrder::where('gateway_payment_id', $paymentData['id'])
        //     ->update(['status' => 'refunded']);
    }
}
