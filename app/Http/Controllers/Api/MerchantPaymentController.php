<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PaymentOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class MerchantPaymentController extends Controller
{
    /**
     * Create a new payment order
     */
    public function createOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:0.01',
            'currency' => 'required|string|in:MYR,USD,SGD',
            'description' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'customer_name' => 'nullable|string|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'merchant_order_id' => 'nullable|string|max:255',
            'return_url' => 'nullable|url',
            'cancel_url' => 'nullable|url',
            'expires_in' => 'nullable|integer|min:300|max:86400', // 5 minutes to 24 hours
            'metadata' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validation failed',
                'details' => $validator->errors()
            ], 422);
        }

        $merchantApiKey = $request->attributes->get('merchant_api_key');

        // Check daily limit
        $todayTotal = $merchantApiKey->getTodayTransactionTotal();
        if (($todayTotal + $request->amount) > $merchantApiKey->daily_limit) {
            return response()->json([
                'error' => 'Daily transaction limit exceeded'
            ], 429);
        }

        // Check per-transaction limit
        if ($request->amount > $merchantApiKey->per_transaction_limit) {
            return response()->json([
                'error' => 'Transaction amount exceeds limit'
            ], 422);
        }

        $orderId = 'ORD_' . Str::upper(Str::random(20));
        $expiresAt = now()->addSeconds($request->expires_in ?? 3600); // Default 1 hour

        $paymentOrder = PaymentOrder::create([
            'order_id' => $orderId,
            'merchant_api_key_id' => $merchantApiKey->id,
            'amount' => $request->amount,
            'currency' => $request->currency,
            'description' => $request->description,
            'customer_email' => $request->customer_email,
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'merchant_order_id' => $request->merchant_order_id,
            'return_url' => $request->return_url,
            'cancel_url' => $request->cancel_url,
            'expires_at' => $expiresAt,
            'metadata' => $request->metadata,
        ]);

        return response()->json([
            'success' => true,
            'data' => [
                'order_id' => $orderId,
                'payment_url' => $paymentOrder->payment_url,
                'amount' => $paymentOrder->amount,
                'currency' => $paymentOrder->currency,
                'status' => $paymentOrder->status,
                'expires_at' => $paymentOrder->expires_at->toISOString(),
            ]
        ], 201);
    }

    /**
     * Get order status
     */
    public function getOrderStatus(Request $request, $orderId)
    {
        $merchantApiKey = $request->attributes->get('merchant_api_key');

        $paymentOrder = PaymentOrder::where('order_id', $orderId)
            ->where('merchant_api_key_id', $merchantApiKey->id)
            ->first();

        if (!$paymentOrder) {
            return response()->json([
                'error' => 'Order not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'order_id' => $paymentOrder->order_id,
                'merchant_order_id' => $paymentOrder->merchant_order_id,
                'amount' => $paymentOrder->amount,
                'currency' => $paymentOrder->currency,
                'status' => $paymentOrder->status,
                'description' => $paymentOrder->description,
                'customer_email' => $paymentOrder->customer_email,
                'created_at' => $paymentOrder->created_at->toISOString(),
                'expires_at' => $paymentOrder->expires_at->toISOString(),
                'paid_at' => $paymentOrder->paid_at?->toISOString(),
                'metadata' => $paymentOrder->metadata,
            ]
        ]);
    }

    /**
     * List orders with pagination and filters
     */
    public function listOrders(Request $request)
    {
        $merchantApiKey = $request->attributes->get('merchant_api_key');

        $query = PaymentOrder::where('merchant_api_key_id', $merchantApiKey->id);

        // Apply filters
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->has('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        if ($request->has('customer_email')) {
            $query->where('customer_email', 'like', '%' . $request->customer_email . '%');
        }

        $perPage = min($request->get('per_page', 20), 100);
        $orders = $query->orderBy('created_at', 'desc')->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $orders->items(),
            'pagination' => [
                'current_page' => $orders->currentPage(),
                'last_page' => $orders->lastPage(),
                'per_page' => $orders->perPage(),
                'total' => $orders->total(),
            ]
        ]);
    }

    /**
     * Cancel an order
     */
    public function cancelOrder(Request $request, $orderId)
    {
        $merchantApiKey = $request->attributes->get('merchant_api_key');

        $paymentOrder = PaymentOrder::where('order_id', $orderId)
            ->where('merchant_api_key_id', $merchantApiKey->id)
            ->where('status', 'pending')
            ->first();

        if (!$paymentOrder) {
            return response()->json([
                'error' => 'Order not found or cannot be cancelled'
            ], 404);
        }

        $paymentOrder->update(['status' => 'cancelled']);

        return response()->json([
            'success' => true,
            'message' => 'Order cancelled successfully'
        ]);
    }
}
