<?php

namespace App\Services;

use App\Models\User;
use App\Models\Wallet;
use App\Models\Transaction;
use App\Models\Withdrawal;
use App\Models\Fee;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class WalletService
{
    /**
     * Create a new wallet for a user
     */
    public function createWallet(
        User $user,
        string $currency = 'MYR',
        float $initialBalance = 0.00,
        bool $isDefault = true
    ): Wallet {
        Log::info('Creating new wallet', [
            'user_id' => $user->id,
            'currency' => $currency,
            'initial_balance' => $initialBalance,
            'is_default' => $isDefault
        ]);

        return DB::transaction(function () use ($user, $currency, $initialBalance, $isDefault) {
            // Ensure no duplicate default wallet
            if ($isDefault) {
                $user->wallets()->where('is_default', true)->update(['is_default' => false]);
            }

            $wallet = $user->wallets()->create([
                'account_number' => Wallet::generateUniqueAccountNumber(),
                'currency' => $currency,
                'balance' => (int)($initialBalance * 100), // Convert to cents
                'is_default' => $isDefault,
                'is_verify' => false
            ]);

            Log::info('Wallet created successfully', [
                'wallet_id' => $wallet->id,
                'account_number' => $wallet->account_number
            ]);

            return $wallet;
        });
    }

    /**
     * Deposit funds to a wallet
     */
    // public function deposit(
    //     Wallet $wallet,
    //     float $amount,
    //     string $description = 'Deposit',
    //     ?string $referenceId = null
    // ): Transaction {
    //     Log::info('Processing deposit', [
    //         'wallet_id' => $wallet->id,
    //         'amount' => $amount,
    //         'description' => $description,
    //         'reference_id' => $referenceId
    //     ]);

    //     return DB::transaction(function () use ($wallet, $amount, $description, $referenceId) {
    //         // Validate amount
    //         if ($amount <= 0) {
    //             Log::warning('Invalid deposit amount', [
    //                 'wallet_id' => $wallet->id,
    //                 'amount' => $amount
    //             ]);
    //             throw ValidationException::withMessages([
    //                 'amount' => 'Deposit amount must be positive.'
    //             ]);
    //         }

    //         // Convert amount to cents
    //         $amountCents = (int)($amount * 100);

    //         // Calculate fee (5%)
    //         $feeAmountCents = (int)($amountCents * 0.05); // 5% fee

    //         // Create transaction record
    //         $depositTransaction = $wallet->transactions()->create([
    //             'type' => Transaction::TYPE_DEPOSIT,
    //             'amount' => $amountCents,
    //             'currency' => $wallet->currency,
    //             'balance_before' => $wallet->balance,
    //             'balance_after' => $wallet->balance + $amountCents,
    //             'description' => $description,
    //             'reference_id' => $referenceId,
    //             'status' => Transaction::STATUS_COMPLETED
    //         ]);

    //         // Update wallet balance
    //         $wallet->increment('balance', $amountCents);

    //         // Create fee transaction record
    //         $feeTransaction = $wallet->transactions()->create([
    //             'type' => Transaction::TYPE_DEPOSIT_FEE,
    //             'amount' => -$feeAmountCents, // Negative as it's a deduction
    //             'currency' => $wallet->currency,
    //             'balance_before' => $wallet->balance,
    //             'balance_after' => $wallet->balance - $feeAmountCents,
    //             'description' => 'Fee for ' . $description,
    //             'reference_id' => $referenceId,
    //             'status' => Transaction::STATUS_COMPLETED
    //         ]);

    //         // Update wallet balance after fee
    //         $wallet->decrement('balance', $feeAmountCents);

    //         // Create fee record
    //         Fee::create([
    //             'transaction_id' => $depositTransaction->id,
    //             'fee_transaction_id' => $feeTransaction->id,
    //             'amount' => $feeAmountCents,
    //             'currency' => $wallet->currency,
    //         ]);

    //         Log::info('Deposit completed successfully', [
    //             'wallet_id' => $wallet->id,
    //             'transaction_id' => $depositTransaction->id,
    //             'fee_transaction_id' => $feeTransaction->id,
    //             'amount' => $amount,
    //             'fee' => $feeAmountCents / 100
    //         ]);

    //         return $depositTransaction;
    //     });
    // }

    /**
     * Calculate withdrawal fee
     */
    public function calculateWithdrawalFee(float $amount): float
    {
        return round($amount * 0.03, 2); // 3% fee
    }

    /**
     * Withdraw funds from a wallet to a bank account
     */
    public function withdraw(
        Wallet $wallet,
        float $amount,
        float $fee,
        array $bankDetails,
        string $description = 'Withdrawal to Bank Account'
    ): array {
        Log::info('Processing withdrawal', [
            'wallet_id' => $wallet->id,
            'amount' => $amount,
            'fee' => $fee,
            'bank_details' => array_merge($bankDetails, ['account_number' => '****' . substr($bankDetails['account_number'] ?? '', -4)]),
            'description' => $description
        ]);

        return DB::transaction(function () use ($wallet, $amount, $fee, $bankDetails, $description) {
            // Convert amount to cents
            $amountCents = (int)($amount * 100);
            $feeCents = (int)($fee * 100);
            $totalDeductionCents = $amountCents + $feeCents;

            // Validate amount
            if ($amountCents <= 0) {
                Log::warning('Invalid withdrawal amount', [
                    'wallet_id' => $wallet->id,
                    'amount' => $amount
                ]);
                throw ValidationException::withMessages([
                    'amount' => 'Withdrawal amount must be positive.'
                ]);
            }

            // Check sufficient balance
            if ($wallet->balance < $totalDeductionCents) {
                Log::warning('Insufficient funds for withdrawal', [
                    'wallet_id' => $wallet->id,
                    'balance' => $wallet->balance / 100,
                    'amount' => $amount,
                    'fee' => $fee,
                    'total_deduction' => ($amountCents + $feeCents) / 100
                ]);
                throw ValidationException::withMessages([
                    'amount' => 'Insufficient funds for withdrawal including fee.'
                ]);
            }

            // Create withdrawal transaction
            $withdrawalTransaction = $wallet->transactions()->create([
                'type' => Transaction::TYPE_WITHDRAWAL,
                'amount' => -$amountCents,
                'currency' => $wallet->currency,
                'balance_before' => $wallet->balance,
                'balance_after' => $wallet->balance - $amountCents,
                'description' => $description ?: "Withdrawal to bank account",
                'status' => Transaction::STATUS_PENDING, // Initially pending until processed
                'metadata' => [
                    'bank_details' => $bankDetails,
                    'withdrawal_method' => 'bank_transfer'
                ],
                'reference_id' => 'WD' . time() . rand(1000, 9999)
            ]);

            // Create fee transaction
            $feeTransaction = $wallet->transactions()->create([
                'type' => Transaction::TYPE_WITHDRAWAL_FEE,
                'amount' => -$feeCents,
                'currency' => $wallet->currency,
                'balance_before' => $wallet->balance - $amountCents,
                'balance_after' => $wallet->balance - $amountCents - $feeCents,
                'description' => 'Fee for ' . $description,
                'status' => Transaction::STATUS_COMPLETED,
                'metadata' => [
                    'withdrawal_transaction_id' => $withdrawalTransaction->id
                ],
                'reference_id' => 'FEE' . time() . rand(1000, 9999)
            ]);

            // Update wallet balance
            $wallet->decrement('balance', $totalDeductionCents);

            // Create withdrawal record
            $withdrawal = Withdrawal::create([
                'wallet_id' => $wallet->id,
                'user_id' => Auth::id(),
                'amount' => $amountCents,
                'fee' => $feeCents,
                'bank_name' => $bankDetails['bank_name'],
                'account_number' => $bankDetails['account_number'],
                'account_holder_name' => $bankDetails['account_holder_name'],
                'status' => 'pending',
                'transaction_id' => $withdrawalTransaction->id,
            ]);

            Log::info('Withdrawal processed successfully', [
                'wallet_id' => $wallet->id,
                'withdrawal_id' => $withdrawal->id,
                'transaction_id' => $withdrawalTransaction->id,
                'fee_transaction_id' => $feeTransaction->id,
                'amount' => $amount,
                'fee' => $fee,
                'total_deduction' => $amount + $fee
            ]);

            return [
                'withdrawal' => $withdrawal,
                'transaction' => $withdrawalTransaction,
                'fee_transaction' => $feeTransaction
            ];
        });
    }

    /**
     * Transfer funds between wallets
     */
    public function transfer(
        Wallet $fromWallet,
        Wallet $toWallet,
        float $amount,
        string $description = 'Wallet Transfer'
    ): array {
        Log::info('Processing transfer', [
            'from_wallet_id' => $fromWallet->id,
            'to_wallet_id' => $toWallet->id,
            'amount' => $amount,
            'description' => $description
        ]);

        return DB::transaction(function () use ($fromWallet, $toWallet, $amount, $description) {
            // Convert amount to cents
            $amountCents = (int)($amount * 100);

            // Validate amount
            if ($amountCents <= 0) {
                Log::warning('Invalid transfer amount', [
                    'from_wallet_id' => $fromWallet->id,
                    'to_wallet_id' => $toWallet->id,
                    'amount' => $amount
                ]);
                throw ValidationException::withMessages([
                    'amount' => 'Transfer amount must be positive.'
                ]);
            }

            // Check sufficient balance
            if ($fromWallet->balance < $amountCents) {
                Log::warning('Insufficient funds for transfer', [
                    'from_wallet_id' => $fromWallet->id,
                    'balance' => $fromWallet->balance / 100,
                    'amount' => $amount
                ]);
                throw ValidationException::withMessages([
                    'amount' => 'Insufficient funds for transfer.'
                ]);
            }

            if ($fromWallet->currency !== $toWallet->currency) {
                Log::warning('Currency mismatch for transfer', [
                    'from_wallet_id' => $fromWallet->id,
                    'from_currency' => $fromWallet->currency,
                    'to_wallet_id' => $toWallet->id,
                    'to_currency' => $toWallet->currency
                ]);
                throw new \InvalidArgumentException('Wallets must have the same currency.');
            }

            // Create withdrawal transaction
            $withdrawTransaction = $fromWallet->transactions()->create([
                'type' => Transaction::TYPE_TRANSFER,
                'amount' => -$amountCents,
                'currency' => $fromWallet->currency,
                'balance_before' => $fromWallet->balance,
                'balance_after' => $fromWallet->balance - $amountCents,
                'description' => "Transfer to {$toWallet->user->name}",
                'status' => Transaction::STATUS_COMPLETED,
                'metadata' => ['to_wallet_id' => $toWallet->id]
            ]);

            // Create deposit transaction
            $depositTransaction = $toWallet->transactions()->create([
                'type' => Transaction::TYPE_TRANSFER,
                'amount' => $amountCents,
                'currency' => $toWallet->currency,
                'balance_before' => $toWallet->balance,
                'balance_after' => $toWallet->balance + $amountCents,
                'description' => "Transfer from {$fromWallet->user->name}",
                'status' => Transaction::STATUS_COMPLETED,
                'metadata' => ['from_wallet_id' => $fromWallet->id]
            ]);

            // Update wallet balances
            $fromWallet->decrement('balance', $amountCents);
            $toWallet->increment('balance', $amountCents);

            Log::info('Transfer completed successfully', [
                'from_wallet_id' => $fromWallet->id,
                'to_wallet_id' => $toWallet->id,
                'withdraw_transaction_id' => $withdrawTransaction->id,
                'deposit_transaction_id' => $depositTransaction->id,
                'amount' => $amount
            ]);

            return [
                'withdraw' => $withdrawTransaction,
                'deposit' => $depositTransaction
            ];
        });
    }

    /**
     * Process a deposit to a wallet with fee
     */
    public function deposit(
        Wallet $wallet,
        float $amount,
        string $description = 'Wallet Deposit',
        string $provider = 'manual',
        string $referenceId = null
    ): array {
        Log::info('Processing deposit', [
            'wallet_id' => $wallet->id,
            'amount' => $amount,
            'description' => $description,
            'provider' => $provider,
            'reference_id' => $referenceId
        ]);

        return DB::transaction(function () use ($wallet, $amount, $description, $provider, $referenceId) {
            // Convert amount to cents
            $amountCents = (int)($amount * 100);

            // Validate amount
            if ($amountCents <= 0) {
                Log::warning('Invalid deposit amount', [
                    'wallet_id' => $wallet->id,
                    'amount' => $amount
                ]);
                throw ValidationException::withMessages([
                    'amount' => 'Deposit amount must be positive.'
                ]);
            }

            // Generate reference ID if not provided
            if (!$referenceId) {
                $referenceId = 'DEP' . time() . rand(1000, 9999);
            }

            // Calculate fee (5%)
            $feeCents = (int)($amountCents * 0.05);
            $netAmountCents = $amountCents - $feeCents;

            // Create deposit transaction for gross amount
            $depositTransaction = $wallet->transactions()->create([
                'type' => Transaction::TYPE_DEPOSIT,
                'amount' => $amountCents,
                'currency' => $wallet->currency,
                'balance_before' => $wallet->balance,
                'balance_after' => $wallet->balance + $netAmountCents, // Net amount after fee
                'description' => $description,
                'status' => Transaction::STATUS_COMPLETED,
                'metadata' => [
                    'provider' => $provider,
                    'gross_amount' => $amountCents,
                    'fee_amount' => $feeCents,
                    'net_amount' => $netAmountCents
                ],
                'reference_id' => $referenceId,
                'provider' => $provider
            ]);

            // Create fee transaction
            $feeTransaction = $wallet->transactions()->create([
                'type' => Transaction::TYPE_DEPOSIT_FEE,
                'amount' => -$feeCents, // Negative amount for fee
                'currency' => $wallet->currency,
                'balance_before' => $wallet->balance + $amountCents,
                'balance_after' => $wallet->balance + $netAmountCents,
                'description' => "Processing fee for deposit {$referenceId}",
                'status' => Transaction::STATUS_COMPLETED,
                'metadata' => [
                    'deposit_id' => $depositTransaction->id,
                    'fee_percentage' => 5
                ],
                'reference_id' => $referenceId,
                'provider' => $provider
            ]);

            // Update wallet balance with net amount
            $wallet->increment('balance', $netAmountCents);

            Log::info('Deposit completed successfully', [
                'wallet_id' => $wallet->id,
                'deposit_transaction_id' => $depositTransaction->id,
                'fee_transaction_id' => $feeTransaction->id,
                'gross_amount' => $amount,
                'fee_amount' => $feeCents / 100,
                'net_amount' => $netAmountCents / 100,
                'reference_id' => $referenceId
            ]);

            return [
                'deposit' => $depositTransaction,
                'fee' => $feeTransaction,
                'reference_id' => $referenceId,
                'gross_amount' => $amount,
                'fee_amount' => $feeCents / 100,
                'net_amount' => $netAmountCents / 100
            ];
        });
    }
}
