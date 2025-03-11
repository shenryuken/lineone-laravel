<?php

namespace App\Livewire\Wallets;

use Livewire\Component;
use App\Models\Wallet;
use App\Services\WalletService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Withdraw extends Component
{
    // Step 1 Form Fields
    public $amount = '';
    public $bank_name = '';
    public $account_number = '';
    public $account_holder_name = '';
    public $description = '';
    public $source_wallet_id = null;

    // Fee and total calculation
    public $fee = 0;
    public $totalDeduction = 0;

    // Preview and Confirmation Fields
    public $source_wallet = null;
    public $withdraw_preview = false;
    public $withdraw_confirmed = false;

    // Result information
    public $showResult = false;
    public $isSuccess = false;
    public $resultMessage = '';
    public $resultDetails = [];

    // Step tracking
    public $currentStep = 1;

    // Validation Rules
    protected function rules()
    {
        return [
            'amount' => [
                'required',
                'numeric',
                'min:10',
                function ($attribute, $value, $fail) {
                    $sourceWallet = Wallet::find($this->source_wallet_id);
                    if (!$sourceWallet) {
                        $fail('Wallet not found.');
                        return;
                    }

                    // Calculate total with fee
                    $fee = (new WalletService())->calculateWithdrawalFee($value);
                    $total = $value + $fee;

                    if ($sourceWallet->balance < ($total * 100)) {
                        $fail('Insufficient funds for withdrawal including fee.');
                    }
                }
            ],
            'bank_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:50',
            'account_holder_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'source_wallet_id' => 'required|exists:wallets,id'
        ];
    }

    // Messages for validation
    protected $messages = [
        'amount.min' => 'Withdrawal amount must be at least 10.',
        'bank_name.required' => 'Bank name is required.',
        'account_number.required' => 'Account number is required.',
        'account_holder_name.required' => 'Account holder name is required.',
    ];

    // Add this line to define the events this component listens for
    protected $listeners = ['walletUpdated' => '$refresh'];

    public function mount($wallet = null)
    {
        // Check if user is approved for withdrawals
        if (auth()->user()->status !== 'approved') {
            // Log the attempt
            Log::warning('Unapproved user attempted withdrawal', [
                'user_id' => Auth::id(),
                'status' => auth()->user()->status
            ]);

            // Redirect with message
            session()->flash('error', 'Withdrawals are only available for approved accounts. Please complete your verification process to enable withdrawals.');
            return redirect()->route('user.dashboard');
        }

        // Load user's default wallet or the provided wallet
        if ($wallet) {
            $this->source_wallet = $wallet;
        } else {
            $this->source_wallet = auth()->user()->wallet();
        }

        $this->source_wallet_id = $this->source_wallet->id;

        Log::info('Withdraw component mounted', [
            'wallet_id' => $this->source_wallet_id,
            'user_id' => Auth::id()
        ]);
    }

    public function updatedAmount()
    {
        Log::info('Amount updated', [
            'wallet_id' => $this->source_wallet_id,
            'new_amount' => $this->amount
        ]);
        $this->calculateFee();
    }

    private function calculateFee()
    {
        if (is_numeric($this->amount) && $this->amount > 0) {
            $walletService = new WalletService();
            $this->fee = $walletService->calculateWithdrawalFee($this->amount);
            $this->totalDeduction = $this->amount + $this->fee;

            Log::info('Fee calculated', [
                'wallet_id' => $this->source_wallet_id,
                'amount' => $this->amount,
                'fee' => $this->fee,
                'totalDeduction' => $this->totalDeduction
            ]);
        } else {
            $this->fee = 0;
            $this->totalDeduction = 0;
        }
    }

    public function nextStep()
    {
        if ($this->currentStep == 1) {
            $this->validate();
            $this->calculateFee();

            // Check if total deduction exceeds balance
            if ($this->totalDeduction > $this->source_wallet->balance / 100) {
                $this->addError('amount', 'Insufficient funds for withdrawal including fee');
                return;
            }

            $this->currentStep = 2;
            Log::info('Moved to step 2', [
                'wallet_id' => $this->source_wallet_id,
                'amount' => $this->amount,
                'fee' => $this->fee
            ]);
        }
    }

    public function previousStep()
    {
        $this->currentStep = 1;
        $this->withdraw_preview = false;
        Log::info('Returned to step 1', [
            'wallet_id' => $this->source_wallet_id
        ]);
    }

    public function previewWithdraw()
    {
        $this->validate();
        $this->calculateFee();

        // Check if total deduction exceeds balance
        if ($this->totalDeduction > $this->source_wallet->balance / 100) {
            $this->addError('amount', 'Insufficient funds for withdrawal including fee');
            return;
        }

        // Set preview flag
        $this->withdraw_preview = true;
        $this->currentStep = 2;

        Log::info('Withdrawal preview shown', [
            'wallet_id' => $this->source_wallet_id,
            'amount' => $this->amount,
            'fee' => $this->fee,
            'totalDeduction' => $this->totalDeduction
        ]);
    }

    public function confirmWithdraw()
    {
        // Double-check user approval status
        if (auth()->user()->kyc_status !== 'approved') {
            Log::warning('Unapproved user attempted to confirm withdrawal', [
                'user_id' => Auth::id(),
                'status' => auth()->user()->status
            ]);

            $this->isSuccess = false;
            $this->resultMessage = 'Withdrawal failed. Your account is not approved for withdrawals.';
            $this->resultDetails = [
                'Error' => 'Account verification required',
                'Status' => auth()->user()->status,
                'Required Status' => 'approved'
            ];

            $this->showResult = true;
            $this->withdraw_preview = false;
            $this->currentStep = 3;

            return;
        }

        $this->validate();
        $this->calculateFee();

        // Check if total deduction exceeds balance
        if ($this->totalDeduction > $this->source_wallet->balance / 100) {
            $this->addError('amount', 'Insufficient funds for withdrawal including fee');
            return;
        }

        try {
            Log::info('Processing withdrawal confirmation', [
                'wallet_id' => $this->source_wallet_id,
                'amount' => $this->amount,
                'fee' => $this->fee,
                'bank_name' => $this->bank_name,
                'account_number' => '****' . substr($this->account_number, -4)
            ]);

            // Perform withdrawal using wallet service
            $walletService = new WalletService();
            $sourceWallet = Wallet::findOrFail($this->source_wallet_id);

            $result = $walletService->withdraw(
                $sourceWallet,
                $this->amount,
                $this->fee,
                [
                    'bank_name' => $this->bank_name,
                    'account_number' => $this->account_number,
                    'account_holder_name' => $this->account_holder_name,
                ],
                $this->description ?: 'Withdrawal to bank account'
            );

            // Set success result
            $this->isSuccess = true;
            $this->resultMessage = "Withdrawal of {$this->amount} {$sourceWallet->currency} has been initiated.";
            $this->resultDetails = [
                'Amount' => number_format($this->amount, 2) . ' ' . $sourceWallet->currency,
                'Fee' => number_format($this->fee, 2) . ' ' . $sourceWallet->currency,
                'Total Deduction' => number_format($this->totalDeduction, 2) . ' ' . $sourceWallet->currency,
                'Bank Name' => $this->bank_name,
                'Account Number' => $this->account_number,
                'Account Holder' => $this->account_holder_name,
                'Status' => 'Pending',
                'Date' => now()->format('Y-m-d H:i:s'),
                'Reference' => $result['transaction']->reference_id,
            ];

            // Reset form and show success
            $this->reset(['amount', 'bank_name', 'account_number', 'account_holder_name', 'description']);
            $this->withdraw_preview = false;
            $this->withdraw_confirmed = true;
            $this->showResult = true;
            $this->currentStep = 3;

            session()->flash('success', 'Withdrawal request submitted successfully!');

            // Emit events to notify other components
            $this->dispatch('walletUpdated');
            $this->dispatch('transactionCompleted');

            Log::info('Withdrawal completed successfully', [
                'wallet_id' => $this->source_wallet_id,
                'transaction_id' => $result['transaction']->id,
                'withdrawal_id' => $result['withdrawal']->id
            ]);
        } catch (\Exception $e) {
            Log::error('Withdrawal failed', [
                'wallet_id' => $this->source_wallet_id,
                'amount' => $this->amount,
                'fee' => $this->fee,
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            // Set failure result
            $this->isSuccess = false;
            $this->resultMessage = 'Withdrawal failed. Please try again or contact support if the problem persists.';
            $this->resultDetails = [
                'Error' => $e->getMessage(),
            ];

            $this->showResult = true;
            $this->withdraw_preview = false;
            $this->currentStep = 3;

            session()->flash('error', 'Withdrawal failed: ' . $e->getMessage());
        }
    }

    public function resetForm()
    {
        $this->reset([
            'amount',
            'bank_name',
            'account_number',
            'account_holder_name',
            'description',
            'fee',
            'totalDeduction',
            'withdraw_preview',
            'withdraw_confirmed',
            'showResult',
            'isSuccess',
            'resultMessage',
            'resultDetails',
            'currentStep'
        ]);

        $this->currentStep = 1;

        Log::info('Form reset', [
            'wallet_id' => $this->source_wallet_id,
            'user_id' => Auth::id()
        ]);
    }

    public function render()
    {
        // Get user's wallets for selection
        $userWallets = auth()->user()->wallets;

        return view('livewire.wallets.withdraw', [
            'userWallets' => $userWallets
        ]);
    }
}
