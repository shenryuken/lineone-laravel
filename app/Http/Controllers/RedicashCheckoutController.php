<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use App\Models\PendingPayment;
use App\Services\RedicashService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class RedicashCheckoutController extends Controller
{
    protected $redicashService;

    public function __construct(RedicashService $redicashService)
    {
        $this->redicashService = $redicashService;
    }

    /**
     * Show checkout confirmation page before redirecting to Redicash
     */
    public function showCheckout(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:10',
            'wallet_id' => 'required|exists:wallets,id'
        ]);

        $wallet = Wallet::findOrFail($validated['wallet_id']);
        $user = auth()->user();
        $amount = $validated['amount'];

        // Calculate fee (5%)
        $feeAmount = round($amount * 0.05, 2);
        $netAmount = $amount - $feeAmount;

        // Store checkout data in session
        session([
            'redicash_checkout' => [
                'wallet_id' => $wallet->id,
                'amount' => $amount,
                'fee_amount' => $feeAmount,
                'net_amount' => $netAmount,
                'user_id' => $user->id
            ]
        ]);

        Log::info('Redicash checkout page displayed', [
            'wallet_id' => $wallet->id,
            'amount' => $amount,
            'fee_amount' => $feeAmount,
            'user_id' => $user->id
        ]);

        return view('redicash.checkout', [
            'wallet' => $wallet,
            'amount' => $amount,
            'feeAmount' => $feeAmount,
            'netAmount' => $netAmount,
            'user' => $user
        ]);
    }

    /**
     * Process checkout and redirect to Redicash payment page
     */
    public function processCheckout(Request $request)
    {
        // Get checkout data from session
        $checkoutData = session('redicash_checkout');
        
        if (!$checkoutData) {
            return redirect()->route('dashboard')->with('toast', [
                'type' => 'error',
                'message' => 'Checkout session expired. Please try again.'
            ]);
        }

        $user = auth()->user();
        $wallet = Wallet::findOrFail($checkoutData['wallet_id']);
        $amount = $checkoutData['amount'];
        $referenceNo = 'DEP-' . Str::random(10);

        try {
            // Create a pending payment record
            $pendingPayment = PendingPayment::create([
                'user_id' => $user->id,
                'wallet_id' => $wallet->id,
                'reference_id' => $referenceNo,
                'provider' => 'redicash',
                'amount' => $amount,
                'status' => 'pending',
                'metadata' => [
                    'email' => $user->email,
                    'name' => $user->name,
                    'callback_url' => route('deposit.callback', ['wallet' => $wallet->id, 'method' => 'redicash']),
                    'return_url' => route('deposit.callback', ['wallet' => $wallet->id, 'method' => 'redicash']),
                    'created_at' => now()->toIso8601String(),
                ]
            ]);

            // Prepare payment data for Redicash
            $amountInCents = (int)($amount * 100);
            
            $paymentData = [
                'amount' => $amountInCents,
                'currency' => $wallet->currency ?? 'MYR',
                'reference_id' => $referenceNo,
                'description' => "Wallet Deposit - {$referenceNo}",
                'customer' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone ?? null,
                ],
                'return_url' => route('deposit.callback', ['wallet' => $wallet->id, 'method' => 'redicash']),
                'cancel_url' => route('dashboard'),
                'metadata' => [
                    'wallet_id' => (string) $wallet->id,
                    'user_id' => (string) $user->id,
                    'reference_no' => $referenceNo,
                    'description' => 'Wallet Deposit'
                ],
            ];

            Log::info('Processing Redicash checkout', [
                'reference_no' => $referenceNo,
                'amount' => $amount,
                'wallet_id' => $wallet->id
            ]);

            // Create payment with Redicash
            $response = $this->redicashService->createPayment($paymentData);

            // Clear checkout session
            session()->forget('redicash_checkout');

            // Check response structure - Redicash returns checkout_url in data object
            if (!isset($response['data']['checkout_url'])) {
                Log::error('Redicash: Missing checkout_url in response data', ['response' => $response]);
                return redirect()->route('dashboard')->with('toast', [
                    'type' => 'error',
                    'message' => 'Payment gateway error: Missing checkout URL'
                ]);
            }

            $checkoutUrl = $response['data']['checkout_url'];
            $paymentId = $response['data']['id'] ?? 'unknown';

            Log::info('Redirecting to Redicash checkout', [
                'checkout_url' => $checkoutUrl,
                'reference_no' => $referenceNo
            ]);

            return redirect()->to($checkoutUrl);

        } catch (\Exception $e) {
            Log::error('Redicash checkout processing failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'reference_no' => $referenceNo ?? 'unknown'
            ]);

            // Clear checkout session on error
            session()->forget('redicash_checkout');

            return redirect()->route('dashboard')->with('toast', [
                'type' => 'error',
                'message' => 'Payment processing failed: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Cancel checkout
     */
    public function cancelCheckout()
    {
        session()->forget('redicash_checkout');
        
        return redirect()->route('dashboard')->with('toast', [
            'type' => 'info',
            'message' => 'Checkout cancelled'
        ]);
    }
}
