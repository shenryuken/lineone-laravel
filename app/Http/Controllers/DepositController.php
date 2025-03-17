<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use App\Models\Transaction;
use App\Services\ToyyibPayService;
use App\Services\RediPayService;
use App\Services\WalletService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class DepositController extends Controller
{
    public function handleCallback(Request $request, Wallet $wallet, $method)
    {
        Log::info('Deposit callback received', [
            'method' => $method,
            'request_method' => $request->method(),
            'data' => $request->all()
        ]);

        if ($method === 'toyyibpay') {
            return $this->handleToyyibPayCallback($request, $wallet);
        } elseif ($method === 'redipay') {
            return $this->handleRediPayCallback($request, $wallet);
        }

        return $this->handleFailedPayment('Invalid payment method');
    }

    private function handleToyyibPayCallback(Request $request, Wallet $wallet)
    {
        $toyyibPay = new ToyyibPayService();
        $billCode = $request->input('billcode');
        $status = $request->input('status');
        $referenceId = $request->input('order_id') ?? $billCode;

        Log::info('ToyyibPay callback details', [
            'billcode' => $billCode,
            'status' => $status,
            'reference_id' => $referenceId,
            'all_data' => $request->all()
        ]);

        try {
            // If status is already provided in the callback
            if ($status == 1) {
                $amount = $request->input('amount');
                return $this->processDeposit($wallet, $amount, 'toyyibpay', $referenceId);
            }

            // Otherwise, check the status from the API
            $paymentStatus = $toyyibPay->getBillPaymentStatus($billCode);

            Log::info('ToyyibPay payment status', ['status' => $paymentStatus]);

            if (!empty($paymentStatus) && isset($paymentStatus[0]['billpaymentStatus']) && $paymentStatus[0]['billpaymentStatus'] == 1) {
                $amount = $paymentStatus[0]['billpaymentAmount'];
                return $this->processDeposit($wallet, $amount, 'toyyibpay', $referenceId);
            }

            Log::warning('ToyyibPay deposit failed', ['wallet' => $wallet->id, 'status' => $paymentStatus]);
            return $this->handleFailedPayment('Payment was not completed');
        } catch (\Exception $e) {
            Log::error('ToyyibPay error processing callback', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return $this->handleFailedPayment('Error processing payment: ' . $e->getMessage());
        }
    }

    private function handleRediPayCallback(Request $request, Wallet $wallet)
    {
        // According to RediPay docs, they send a POST request to the callback URL
        $trxNo = $request->input('trx_no');
        $billId = $request->input('bill_id');
        $amount = $request->input('amount');
        $referenceNo = $request->input('reference_no');

        Log::info('RediPay callback details', [
            'trx_no' => $trxNo,
            'bill_id' => $billId,
            'amount' => $amount,
            'reference_no' => $referenceNo,
            'all_data' => $request->all()
        ]);

        try {
            // Process the payment if we have the necessary information
            if ($amount) {
                // Use the transaction number as reference if reference_no is not provided
                $referenceId = $referenceNo ?: ($trxNo ?: $billId);

                // Process the deposit
                $this->processDeposit($wallet, (float)$amount, 'redipay', $referenceId);

                // Return a success response for the callback
                return response()->json(['status' => 'success']);
            }

            // If we don't have the amount, try to get payment details from the API
            if ($trxNo || $billId) {
                $rediPay = new RediPayService();
                $paymentId = $trxNo ?: $billId;

                try {
                    $paymentStatus = $rediPay->getPaymentStatus($paymentId);

                    Log::info('RediPay payment status', ['status' => $paymentStatus]);

                    if (isset($paymentStatus['status']) && $paymentStatus['status'] === 'paid') {
                        $amount = (float)$paymentStatus['amount'];
                        $referenceId = $referenceNo ?: $paymentId;

                        // Process the deposit
                        $this->processDeposit($wallet, $amount, 'redipay', $referenceId);

                        // Return a success response for the callback
                        return response()->json(['status' => 'success']);
                    }
                } catch (\Exception $e) {
                    Log::error('RediPay error checking payment status', [
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                }
            }

            Log::warning('RediPay deposit failed or insufficient data', [
                'wallet' => $wallet->id,
                'request_data' => $request->all()
            ]);

            // Return a response for the callback
            return response()->json(['status' => 'error', 'message' => 'Insufficient payment data']);

        } catch (\Exception $e) {
            Log::error('RediPay error processing callback', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Return an error response for the callback
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    private function processDeposit(Wallet $wallet, $amount, $provider, $referenceId)
    {
        try {
            DB::beginTransaction();

            // Check for duplicate transaction
            $existingTransaction = Transaction::where('wallet_id', $wallet->id)
                ->where('type', Transaction::TYPE_DEPOSIT)
                ->where('reference_id', $referenceId)
                ->first();

            if ($existingTransaction) {
                Log::info('Duplicate deposit attempt', [
                    'wallet' => $wallet->id,
                    'amount' => $amount,
                    'provider' => $provider,
                    'reference_id' => $referenceId
                ]);
                DB::commit();

                // For API callbacks, return JSON
                if (request()->expectsJson() || request()->ajax() || request()->wantsJson()) {
                    return response()->json(['status' => 'success', 'message' => 'Payment already processed']);
                }

                // For browser redirects, redirect to dashboard
                return redirect()->route('dashboard')->with('toast', [
                    'type' => 'success',
                    'message' => "Your payment has been processed successfully!"
                ]);
            }

            // Use wallet service to process the deposit
            $walletService = new WalletService();
            $result = $walletService->deposit(
                $wallet,
                $amount,
                "Deposit via " . ucfirst($provider),
                $provider,
                $referenceId
            );

            DB::commit();

            // Calculate fee amount (5%)
            $feeAmount = $amount * 0.05;
            $netAmount = $amount - $feeAmount;

            Log::info("{$provider} deposit successful", [
                'wallet' => $wallet->id,
                'gross_amount' => $amount,
                'fee_amount' => $feeAmount,
                'net_amount' => $netAmount,
                'reference_id' => $referenceId
            ]);

            // For API callbacks, return JSON
            if (request()->expectsJson() || request()->ajax() || request()->wantsJson()) {
                return response()->json(['status' => 'success', 'message' => 'Payment processed successfully']);
            }

            // For browser redirects, redirect to dashboard
            return redirect()->route('dashboard')->with('toast', [
                'type' => 'success',
                'message' => "Deposit of MYR " . number_format($amount, 2) . " was successful! (Fee: MYR " . number_format($feeAmount, 2) . ", Net amount: MYR " . number_format($netAmount, 2) . ")"
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error processing deposit', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // For API callbacks, return JSON
            if (request()->expectsJson() || request()->ajax() || request()->wantsJson()) {
                return response()->json(['status' => 'error', 'message' => 'Error processing deposit: ' . $e->getMessage()]);
            }

            // For browser redirects, redirect to dashboard
            return redirect()->route('dashboard')->with('toast', [
                'type' => 'error',
                'message' => 'Error processing deposit: ' . $e->getMessage()
            ]);
        }
    }

    private function handleSuccessfulPayment($grossAmount, $feeAmount)
    {
        $netAmount = $grossAmount - $feeAmount;

        // For API callbacks, return JSON
        if (request()->expectsJson() || request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Payment processed successfully',
                'data' => [
                    'gross_amount' => $grossAmount,
                    'fee_amount' => $feeAmount,
                    'net_amount' => $netAmount
                ]
            ]);
        }

        // For browser redirects, redirect to dashboard
        return redirect()->route('dashboard')->with('toast', [
            'type' => 'success',
            'message' => "Deposit of MYR " . number_format($grossAmount, 2) . " was successful! (Fee: MYR " . number_format($feeAmount, 2) . ", Net amount: MYR " . number_format($netAmount, 2) . ")"
        ]);
    }

    private function handleFailedPayment($message)
    {
        // For API callbacks, return JSON
        if (request()->expectsJson() || request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'status' => 'error',
                'message' => $message
            ]);
        }

        // For browser redirects, redirect to dashboard
        return redirect()->route('dashboard')->with('toast', [
            'type' => 'error',
            'message' => $message
        ]);
    }
}

