<?php

namespace App\Http\Controllers\Gateway;

use App\Http\Controllers\Controller;
use App\Models\MerchantApiKey;
use App\Models\PaymentOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MerchantGatewayController extends Controller
{
    /**
     * Display the merchant payment gateway dashboard
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        // Get API keys count
        $activeApiKeys = $user->merchantApiKeys()->where('is_active', true)->count();
        
        // Get today's transactions
        $todayOrders = $user->paymentOrders()
            ->whereDate('created_at', today())
            ->count();
            
        // Get successful payments
        $successfulPayments = $user->paymentOrders()
            ->where('status', 'paid')
            ->count();
            
        // Get recent transactions
        $recentOrders = $user->paymentOrders()
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
            
        // Get total revenue
        $totalRevenue = $user->paymentOrders()
            ->where('status', 'paid')
            ->sum('amount');
            
        return view('gateway.merchant.dashboard', compact(
            'activeApiKeys',
            'todayOrders',
            'successfulPayments',
            'recentOrders',
            'totalRevenue'
        ));
    }

    /**
     * Display transactions
     */
    public function transactions(Request $request)
    {
        $user = Auth::user();
        
        $query = $user->paymentOrders();
        
        // Apply filters
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }
        
        if ($request->has('from_date') && $request->from_date) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        
        if ($request->has('to_date') && $request->to_date) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }
        
        $orders = $query->orderBy('created_at', 'desc')->paginate(20);
        
        return view('gateway.merchant.transactions', compact('orders'));
    }

    /**
     * Show specific transaction
     */
    public function showTransaction($id)
    {
        $user = Auth::user();
        
        $order = $user->paymentOrders()
            ->where('id', $id)
            ->firstOrFail();
            
        return view('gateway.merchant.transaction-detail', compact('order'));
    }

    /**
     * Refund transaction
     */
    public function refundTransaction(Request $request, $id)
    {
        $user = Auth::user();
        
        $order = $user->paymentOrders()
            ->where('id', $id)
            ->where('status', 'paid')
            ->firstOrFail();
            
        $request->validate([
            'refund_amount' => 'required|numeric|min:0.01|max:' . $order->amount,
            'refund_reason' => 'required|string|max:255'
        ]);
        
        try {
            DB::beginTransaction();
            
            $order->update([
                'status' => 'refunded',
                'refund_amount' => $request->refund_amount,
                'refunded_at' => now(),
                'metadata' => array_merge($order->metadata ?? [], [
                    'refund_reason' => $request->refund_reason,
                    'refunded_by' => $user->id,
                    'refund_processed_at' => now()->toISOString()
                ])
            ]);
            
            DB::commit();
            
            return back()->with('success', 'Refund processed successfully.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to process refund: ' . $e->getMessage());
        }
    }

    /**
     * Show settings
     */
    public function settings()
    {
        $user = Auth::user();
        $apiKeys = $user->merchantApiKeys()->latest()->get();
        
        return view('gateway.merchant.settings', compact('apiKeys'));
    }

    /**
     * Update settings
     */
    public function updateSettings(Request $request)
    {
        $request->validate([
            'webhook_url' => 'nullable|url',
            'notification_email' => 'nullable|email',
        ]);
        
        $user = Auth::user();
        
        // Update user profile or settings
        // This depends on your user profile structure
        
        return back()->with('success', 'Settings updated successfully.');
    }
}
