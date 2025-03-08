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
        $rediPay = new RediPayService();
        $paymentId = $request->input('payment_id');
        $status = $request->input('status');
        $referenceId = $request->input('reference_no') ?? $paymentId;

        Log::info('RediPay callback details', [
            'payment_id' => $paymentId,
            'status' => $status,
            'reference_id' => $referenceId,
            'all_data' => $request->all()
        ]);

        try {
            // If status is already provided in the callback
            if ($status === 'paid') {
                $amount = (int)($request->input('amount') * 100);
                return $this->processDeposit($wallet, $amount, 'redipay', $referenceId);
            }

            // Otherwise, check the status from the API
            $paymentStatus = $rediPay->getPaymentStatus($paymentId);

            Log::info('RediPay payment status', ['status' => $paymentStatus]);

            if ($paymentStatus['status'] === 'paid') {
                $amount = (int)($paymentStatus['amount'] * 100);
                return $this->processDeposit($wallet, $amount, 'redipay', $referenceId);
            }

            Log::warning('RediPay deposit failed', ['wallet' => $wallet->id, 'status' => $paymentStatus]);
            return $this->handleFailedPayment('Payment was not completed');
        } catch (\Exception $e) {
            Log::error('RediPay error processing callback', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return $this->handleFailedPayment('Error processing payment: ' . $e->getMessage());
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
                return $this->handleSuccessfulPayment($amount, $amount * 0.05);
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
            $feeAmount = $amountInCents * 0.05;
            $netAmount = $amountInCents - $feeAmount;

            Log::info("{$provider} deposit successful", [
                'wallet' => $wallet->id,
                'gross_amount' => $amount,
                'fee_amount' => $feeAmount,
                'net_amount' => $netAmount,
                'reference_id' => $referenceId
            ]);

            return $this->handleSuccessfulPayment($amount, $feeAmount);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error processing deposit', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return $this->handleFailedPayment('Error processing deposit: ' . $e->getMessage());
        }
    }

    private function handleSuccessfulPayment($grossAmount, $feeAmount)
    {
        $netAmount = $grossAmount - $feeAmount;
        return redirect()->route('dashboard')->with('toast', [
            'type' => 'success',
            'message' => "Deposit of MYR $grossAmount was successful! (Fee: MYR $feeAmount, Net amount: MYR $netAmount)"
        ]);
    }

    private function handleFailedPayment($message)
    {
        return redirect()->route('dashboard')->with('toast', [
            'type' => 'error',
            'message' => $message
        ]);
    }
}

