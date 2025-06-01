<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PaymentOrder;
use App\Models\MerchantApiKey;
use App\Models\User;
use App\Models\Wallet;
use App\Services\WebhookService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PaymentWidgetController extends Controller
{
    protected $webhookService;

    public function __construct(WebhookService $webhookService)
    {
        $this->webhookService = $webhookService;
    }

    /**
     * Initialize payment widget - called by merchant's website
     */
    public function initializePayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:0.01',
            'currency' => 'required|string|in:MYR,USD,SGD',
            'description' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'customer_name' => 'nullable|string|max:255',
            'merchant_order_id' => 'nullable|string|max:255',
            'return_url' => 'required|url',
            'cancel_url' => 'nullable|url',
            'webhook_url' => 'nullable|url',
            'metadata' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => 'Validation failed',
                'details' => $validator->errors()
            ], 422);
        }

        $merchantApiKey = $request->attributes->get('merchant_api_key');

        // Create payment order
        $paymentOrder = PaymentOrder::create([
            'order_id' => 'WLT_' . strtoupper(uniqid()),
            'merchant_api_key_id' => $merchantApiKey->id,
            'amount' => $request->amount,
            'currency' => $request->currency,
            'description' => $request->description,
            'customer_email' => $request->customer_email,
            'customer_name' => $request->customer_name,
            'merchant_order_id' => $request->merchant_order_id,
            'return_url' => $request->return_url,
            'cancel_url' => $request->cancel_url ?? $request->return_url,
            'expires_at' => now()->addHours(1),
            'metadata' => array_merge($request->metadata ?? [], [
                'webhook_url' => $request->webhook_url,
                'initiated_from' => 'widget',
                'user_agent' => $request->userAgent(),
                'ip_address' => $request->ip(),
            ]),
        ]);

        return response()->json([
            'success' => true,
            'data' => [
                'payment_id' => $paymentOrder->order_id,
                'checkout_url' => route('widget.checkout', $paymentOrder->order_id),
                'widget_url' => route('widget.embed', $paymentOrder->order_id),
                'amount' => $paymentOrder->amount,
                'currency' => $paymentOrder->currency,
                'expires_at' => $paymentOrder->expires_at->toISOString(),
            ]
        ], 201);
    }

    /**
     * Show embedded payment widget
     */
    public function showWidget($paymentId)
    {
        $paymentOrder = PaymentOrder::where('order_id', $paymentId)
            ->where('status', 'pending')
            ->with('merchantApiKey.user')
            ->first();

        if (!$paymentOrder) {
            return response()->json([
                'error' => 'Payment not found or expired'
            ], 404);
        }

        if ($paymentOrder->isExpired()) {
            $paymentOrder->update(['status' => 'expired']);
            return response()->json([
                'error' => 'Payment has expired'
            ], 410);
        }

        return view('widget.payment', [
            'paymentOrder' => $paymentOrder,
            'merchant' => $paymentOrder->merchantApiKey->user,
        ]);
    }

    /**
     * Process wallet payment
     */
    public function processWalletPayment(Request $request, $paymentId)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
            'wallet_id' => 'required|exists:wallets,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => 'Validation failed',
                'details' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            // Find payment order
            $paymentOrder = PaymentOrder::where('order_id', $paymentId)
                ->where('status', 'pending')
                ->lockForUpdate()
                ->first();

            if (!$paymentOrder) {
                return response()->json([
                    'success' => false,
                    'error' => 'Payment not found or already processed'
                ], 404);
            }

            if ($paymentOrder->isExpired()) {
                $paymentOrder->update(['status' => 'expired']);
                return response()->json([
                    'success' => false,
                    'error' => 'Payment has expired'
                ], 410);
            }

            // Authenticate user
            $user = User::where('email', $request->email)->first();
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'error' => 'Invalid credentials'
                ], 401);
            }

            // Get wallet
            $wallet = Wallet::where('id', $request->wallet_id)
                ->where('user_id', $user->id)
                ->where('is_active', true)
                ->first();

            if (!$wallet) {
                return response()->json([
                    'success' => false,
                    'error' => 'Wallet not found or inactive'
                ], 404);
            }

            // Check balance
            if ($wallet->balance < $paymentOrder->amount) {
                return response()->json([
                    'success' => false,
                    'error' => 'Insufficient wallet balance',
                    'details' => [
                        'required' => $paymentOrder->amount,
                        'available' => $wallet->balance
                    ]
                ], 400);
            }

            // Process payment
            $wallet->decrement('balance', $paymentOrder->amount);

            // Update payment order
            $paymentOrder->update([
                'status' => 'paid',
                'paid_at' => now(),
                'payment_method' => 'wallet',
                'metadata' => array_merge($paymentOrder->metadata ?? [], [
                    'wallet_id' => $wallet->id,
                    'payer_user_id' => $user->id,
                    'payer_email' => $user->email,
                    'processed_at' => now()->toISOString(),
                ])
            ]);

            // Create transaction record (if you have a transactions table)
            // Transaction::create([...]);

            DB::commit();

            // Send webhook notification
            if (!empty($paymentOrder->metadata['webhook_url'])) {
                $this->webhookService->sendPaymentNotification(
                    $paymentOrder->metadata['webhook_url'],
                    $paymentOrder,
                    'payment.completed'
                );
            }

            Log::info('Wallet payment processed', [
                'payment_id' => $paymentId,
                'amount' => $paymentOrder->amount,
                'wallet_id' => $wallet->id,
                'user_id' => $user->id
            ]);

            return response()->json([
                'success' => true,
                'data' => [
                    'payment_id' => $paymentOrder->order_id,
                    'status' => 'paid',
                    'amount' => $paymentOrder->amount,
                    'currency' => $paymentOrder->currency,
                    'paid_at' => $paymentOrder->paid_at->toISOString(),
                    'return_url' => $paymentOrder->return_url,
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Wallet payment failed', [
                'payment_id' => $paymentId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Payment processing failed'
            ], 500);
        }
    }

    /**
     * Get user's wallets for payment
     */
    public function getUserWallets(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => 'Validation failed',
                'details' => $validator->errors()
            ], 422);
        }

        // Authenticate user
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'error' => 'Invalid credentials'
            ], 401);
        }

        $wallets = Wallet::where('user_id', $user->id)
            ->where('is_active', true)
            ->select('id', 'name', 'currency', 'balance')
            ->get()
            ->map(function ($wallet) {
                return [
                    'id' => $wallet->id,
                    'name' => $wallet->name,
                    'currency' => $wallet->currency,
                    'balance' => $wallet->balance,
                    'formatted_balance' => $wallet->currency . ' ' . number_format($wallet->balance, 2),
                ];
            });

        return response()->json([
            'success' => true,
            'data' => [
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                ],
                'wallets' => $wallets
            ]
        ]);
    }

    /**
     * Check payment status
     */
    public function checkPaymentStatus($paymentId)
    {
        $paymentOrder = PaymentOrder::where('order_id', $paymentId)->first();

        if (!$paymentOrder) {
            return response()->json([
                'success' => false,
                'error' => 'Payment not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'payment_id' => $paymentOrder->order_id,
                'status' => $paymentOrder->status,
                'amount' => $paymentOrder->amount,
                'currency' => $paymentOrder->currency,
                'created_at' => $paymentOrder->created_at->toISOString(),
                'paid_at' => $paymentOrder->paid_at?->toISOString(),
                'expires_at' => $paymentOrder->expires_at->toISOString(),
            ]
        ]);
    }
}
