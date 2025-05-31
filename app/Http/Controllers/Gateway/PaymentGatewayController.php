<?php

namespace App\Http\Controllers\Gateway;

use App\Http\Controllers\Controller;
use App\Models\PaymentOrder;
use App\Models\MerchantApiKey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PaymentGatewayController extends Controller
{
    /**
     * Show payment checkout page
     */
    public function showCheckout($requestId)
    {
        $paymentOrder = PaymentOrder::where('order_id', $requestId)
            ->where('status', 'pending')
            ->with('merchantApiKey.user')
            ->first();

        if (!$paymentOrder) {
            return view('gateway.error', [
                'title' => 'Payment Not Found',
                'message' => 'The payment request was not found or has expired.',
                'requestId' => $requestId
            ]);
        }

        // Check if payment has expired
        if ($paymentOrder->expires_at && $paymentOrder->expires_at->isPast()) {
            $paymentOrder->update(['status' => 'expired']);
            
            return view('gateway.error', [
                'title' => 'Payment Expired',
                'message' => 'This payment request has expired.',
                'requestId' => $requestId
            ]);
        }

        $merchant = $paymentOrder->merchantApiKey->user;
        
        return view('gateway.checkout', [
            'paymentRequest' => $paymentOrder,
            'merchant' => $merchant,
            'amount' => $paymentOrder->amount,
            'currency' => $paymentOrder->currency,
            'requestId' => $requestId
        ]);
    }

    /**
     * Process payment
     */
    public function processPayment(Request $request, $requestId)
    {
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'customer_phone' => 'nullable|string|max:20',
            'payment_method' => 'required|in:wallet,bank_transfer,card',
            'wallet_id' => 'required_if:payment_method,wallet',
            'bank_account' => 'required_if:payment_method,bank_transfer|string',
            'card_token' => 'required_if:payment_method,card|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $paymentOrder = PaymentOrder::where('order_id', $requestId)
                ->where('status', 'pending')
                ->with('merchantApiKey.user')
                ->first();

            if (!$paymentOrder) {
                return redirect()->route('payment.gateway.error', $requestId)
                    ->with('error', 'Payment request not found or has expired.');
            }

            // Check if payment has expired
            if ($paymentOrder->expires_at && $paymentOrder->expires_at->isPast()) {
                $paymentOrder->update(['status' => 'expired']);
                return redirect()->route('payment.gateway.error', $requestId)
                    ->with('error', 'Payment request has expired.');
            }

            DB::beginTransaction();

            // For demo purposes, we'll simulate successful payment
            $paymentOrder->update([
                'status' => 'paid',
                'payment_method' => $request->payment_method,
                'paid_at' => now(),
                'metadata' => array_merge($paymentOrder->metadata ?? [], [
                    'customer_name' => $request->customer_name,
                    'customer_phone' => $request->customer_phone,
                    'payment_method' => $request->payment_method,
                    'processed_ip' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                ])
            ]);

            DB::commit();

            Log::info('Payment processed successfully', [
                'order_id' => $requestId,
                'amount' => $paymentOrder->amount,
                'payment_method' => $request->payment_method
            ]);

            return redirect()->route('payment.gateway.success', $requestId);

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Payment processing failed', [
                'order_id' => $requestId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->with('error', 'Payment processing failed: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Show payment success page
     */
    public function showSuccess($requestId)
    {
        $paymentOrder = PaymentOrder::where('order_id', $requestId)
            ->where('status', 'paid')
            ->with('merchantApiKey.user')
            ->first();

        if (!$paymentOrder) {
            return view('gateway.error', [
                'title' => 'Payment Not Found',
                'message' => 'The payment request was not found.',
                'requestId' => $requestId
            ]);
        }

        return view('gateway.success', [
            'paymentRequest' => $paymentOrder,
            'transaction' => null, // You can add transaction relationship later
            'amount' => $paymentOrder->amount,
            'currency' => $paymentOrder->currency,
            'requestId' => $requestId
        ]);
    }

    /**
     * Show payment error page
     */
    public function showError($requestId)
    {
        $paymentOrder = PaymentOrder::where('order_id', $requestId)->first();
        
        return view('gateway.error', [
            'title' => 'Payment Error',
            'message' => session('error', 'An error occurred while processing your payment.'),
            'requestId' => $requestId,
            'paymentRequest' => $paymentOrder
        ]);
    }
}
