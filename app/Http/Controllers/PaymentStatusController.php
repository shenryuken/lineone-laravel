<?php

namespace App\Http\Controllers;

use App\Models\PendingPayment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PaymentStatusController extends Controller
{
    /**
     * Show payment status
     */
    public function show(Request $request, $reference = null)
    {
        // If reference is provided in the URL, use it
        $referenceId = $reference ?? $request->input('reference');

        if (!$referenceId) {
            return redirect()->route('dashboard')->with('toast', [
                'type' => 'error',
                'message' => 'No payment reference provided'
            ]);
        }

        try {
            // Check if the transaction exists
            // First, get the user's wallet IDs
            $walletIds = Auth::user()->wallets()->pluck('id')->toArray();

            // Then query transactions using wallet_id instead of user_id
            $transaction = Transaction::where('reference_id', $referenceId)
                ->whereIn('wallet_id', $walletIds)
                ->first();

            if ($transaction) {
                return view('payments.status', [
                    'status' => 'completed',
                    'reference' => $referenceId,
                    'transaction' => $transaction,
                    'message' => 'Your payment has been processed successfully!'
                ]);
            }

            // Check if there's a pending payment
            $pendingPayment = PendingPayment::where('reference_id', $referenceId)
                ->where('user_id', Auth::id())
                ->first();

            if (!$pendingPayment) {
                return view('payments.status', [
                    'status' => 'not_found',
                    'reference' => $referenceId,
                    'message' => 'No payment found with this reference ID'
                ]);
            }

            // If the payment is completed but transaction not found, something is wrong
            if ($pendingPayment->status === 'completed') {
                return view('payments.status', [
                    'status' => 'error',
                    'reference' => $referenceId,
                    'pendingPayment' => $pendingPayment,
                    'message' => 'Payment marked as completed but no transaction found. Please contact support.'
                ]);
            }

            // If the payment failed
            if ($pendingPayment->status === 'failed') {
                return view('payments.status', [
                    'status' => 'failed',
                    'reference' => $referenceId,
                    'pendingPayment' => $pendingPayment,
                    'message' => 'Your payment has failed. Please try again or contact support.'
                ]);
            }

            // If the payment is still pending
            return view('payments.status', [
                'status' => 'pending',
                'reference' => $referenceId,
                'pendingPayment' => $pendingPayment,
                'message' => 'Your payment is being processed. Please wait a moment.'
            ]);
        } catch (\Exception $e) {
            Log::error('Error in payment status page', [
                'reference_id' => $referenceId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return view('payments.status', [
                'status' => 'error',
                'reference' => $referenceId,
                'message' => 'An error occurred while checking your payment status. Please try again later or contact support.'
            ]);
        }
    }

    /**
     * Check payment status via AJAX
     */
    public function check(Request $request)
    {
        $referenceId = $request->input('reference');

        if (!$referenceId) {
            return response()->json([
                'success' => false,
                'message' => 'No payment reference provided'
            ]);
        }

        try {
            // Check if the transaction exists
            // First, get the user's wallet IDs
            $walletIds = Auth::user()->wallets()->pluck('id')->toArray();

            // Then query transactions using wallet_id instead of user_id
            $transaction = Transaction::where('reference_id', $referenceId)
                ->whereIn('wallet_id', $walletIds)
                ->first();

            if ($transaction) {
                return response()->json([
                    'success' => true,
                    'status' => 'completed',
                    'message' => 'Your payment has been processed successfully!',
                    'transaction' => [
                        'id' => $transaction->id,
                        'amount' => $transaction->amount / 100, // Convert from cents
                        'created_at' => $transaction->created_at->format('M d, Y h:i A')
                    ]
                ]);
            }

            // Check if there's a pending payment
            $pendingPayment = PendingPayment::where('reference_id', $referenceId)
                ->where('user_id', Auth::id())
                ->first();

            if (!$pendingPayment) {
                return response()->json([
                    'success' => false,
                    'status' => 'not_found',
                    'message' => 'No payment found with this reference ID'
                ]);
            }

            // Return the appropriate status
            return response()->json([
                'success' => true,
                'status' => $pendingPayment->status,
                'message' => $this->getStatusMessage($pendingPayment->status),
                'last_checked' => $pendingPayment->last_checked_at ? $pendingPayment->last_checked_at->diffForHumans() : null,
                'created_at' => $pendingPayment->created_at->format('M d, Y h:i A')
            ]);
        } catch (\Exception $e) {
            Log::error('Error in payment status check', [
                'reference_id' => $referenceId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => 'An error occurred while checking your payment status. Please try again later.'
            ]);
        }
    }

    /**
     * Get status message based on status
     */
    private function getStatusMessage($status)
    {
        switch ($status) {
            case 'completed':
                return 'Your payment has been processed successfully!';
            case 'failed':
                return 'Your payment has failed. Please try again or contact support.';
            case 'pending':
                return 'Your payment is being processed. Please wait a moment.';
            default:
                return 'Unknown payment status.';
        }
    }
}

