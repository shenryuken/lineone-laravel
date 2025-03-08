<?php
/*
namespace App\Livewire\Wallets;

use Livewire\Component;
use App\Models\User;
use App\Models\Wallet;
use App\Services\WalletService;
use Illuminate\Support\Facades\DB;

class Transfer extends Component
{
    // Step 1 Form Fields
    public $account_number = '';
    public $amount = '';
    public $description = '';
    public $source_wallet_id = null;

    // Preview and Confirmation Fields
    public $recipient = null;
    public $recipient_wallet = null;
    public $source_wallet = null;
    public $transfer_preview = false;
    public $transfer_confirmed = false;

    // Step tracking
    public $currentStep = 1;

    // Validation Rules
    protected function rules()
    {
        return [
            'account_number' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    // Find wallet by account number
                    $recipientWallet = Wallet::where('account_number', $value)->first();

                    if (!$recipientWallet) {
                        $fail('No wallet found with this account number.');
                        return;
                    }

                    // Check if user is trying to transfer to their own wallet
                    if ($recipientWallet->user_id === auth()->id()) {
                        $fail('You cannot transfer to your own wallet.');
                    }
                }
            ],
            'amount' => [
                'required',
                'numeric',
                'min:1',
                function ($attribute, $value, $fail) {
                    $sourceWallet = Wallet::find($this->source_wallet_id);
                    if (!$sourceWallet || $sourceWallet->balance < ($value * 100)) {
                        $fail('Insufficient funds for transfer.');
                    }
                }
            ],
            'description' => 'nullable|string|max:255',
            'source_wallet_id' => 'required|exists:wallets,id'
        ];
    }

    // Messages for validation
    protected $messages = [
        'account_number.required' => 'The recipient account number is required.',
        'amount.min' => 'Transfer amount must be at least 1.',
    ];

    // Add this line to define the events this component emits
    protected $listeners = ['walletUpdated' => '$refresh'];

    public function mount($wallet = null)
    {
        // Load user's default wallet or the provided wallet
        if ($wallet) {
            $this->source_wallet = $wallet;
        } else {
            $this->source_wallet = auth()->user()->wallet();
        }

        $this->source_wallet_id = $this->source_wallet->id;
    }

    public function nextStep()
    {
        if ($this->currentStep == 1) {
            $this->validate([
                'account_number' => $this->rules()['account_number'],
                'amount' => $this->rules()['amount'],
                'source_wallet_id' => $this->rules()['source_wallet_id'],
            ]);

            // Find recipient wallet and user
            $this->recipient_wallet = Wallet::where('account_number', $this->account_number)->first();
            $this->recipient = $this->recipient_wallet->user;
            $this->currentStep = 2;
        }
    }

    public function previousStep()
    {
        $this->currentStep = 1;
        $this->transfer_preview = false;
    }

    public function previewTransfer()
    {
        $this->validate();

        // Find recipient wallet and user
        $this->recipient_wallet = Wallet::where('account_number', $this->account_number)->first();
        $this->recipient = $this->recipient_wallet->user;

        // Set preview flag
        $this->transfer_preview = true;
        $this->currentStep = 2;
    }

    public function confirmTransfer()
    {
        $this->validate();

        try {
            DB::beginTransaction();

            // Perform transfer using wallet service
            $walletService = new WalletService();

            $sourceWallet = Wallet::findOrFail($this->source_wallet_id);
            $recipientWallet = Wallet::where('account_number', $this->account_number)->firstOrFail();

            $transfer = $walletService->transfer(
                $sourceWallet,
                $recipientWallet,
                $this->amount,
                $this->description
            );

            DB::commit();

            // Reset form and show success
            $this->reset(['account_number', 'amount', 'description']);
            $this->transfer_preview = false;
            $this->transfer_confirmed = true;
            $this->currentStep = 3;

            session()->flash('success', 'Transfer completed successfully!');

            // Emit an event to notify other components that a wallet has been updated
            $this->dispatch('walletUpdated');
            $this->dispatch('transactionCompleted');
        } catch (\Exception $e) {
            DB::rollBack();

            session()->flash('error', 'Transfer failed: ' . $e->getMessage());
        }
    }

    public function resetForm()
    {
        $this->reset([
            'account_number',
            'amount',
            'description',
            'recipient',
            'recipient_wallet',
            'transfer_preview',
            'transfer_confirmed',
            'currentStep'
        ]);

        $this->currentStep = 1;
    }

    public function render()
    {
        // Get user's wallets for selection
        $userWallets = auth()->user()->wallets;

        return view('livewire.wallets.transfer', [
            'userWallets' => $userWallets
        ]);
    }
}
*/

namespace App\Livewire\Wallets;

use Livewire\Component;
use App\Models\User;
use App\Models\Wallet;
use App\Services\WalletService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Transfer extends Component
{
    // Step 1 Form Fields
    public $account_number = '';
    public $amount = '';
    public $description = '';
    public $source_wallet_id = null;

    // Preview and Confirmation Fields
    public $recipient = null;
    public $recipient_wallet = null;
    public $source_wallet = null;
    public $transfer_preview = false;
    public $transfer_confirmed = false;

    // Result information
    public $showResult = false;
    public $isSuccess = false;
    public $resultMessage = '';
    public $resultDetails = [];
    public $messageTimeout = 10000; // 10 seconds for message display

    // Step tracking
    public $currentStep = 1;

    // Validation Rules
    protected function rules()
    {
        return [
            'account_number' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    // Find wallet by account number
                    $recipientWallet = Wallet::where('account_number', $value)->first();

                    if (!$recipientWallet) {
                        $fail('No wallet found with this account number.');
                        return;
                    }

                    // Check if user is trying to transfer to their own wallet
                    if ($recipientWallet->user_id === auth()->id()) {
                        $fail('You cannot transfer to your own wallet.');
                    }
                }
            ],
            'amount' => [
                'required',
                'numeric',
                'min:1',
                function ($attribute, $value, $fail) {
                    $sourceWallet = Wallet::find($this->source_wallet_id);
                    if (!$sourceWallet || $sourceWallet->balance < ($value * 100)) {
                        $fail('Insufficient funds for transfer.');
                    }
                }
            ],
            'description' => 'nullable|string|max:255',
            'source_wallet_id' => 'required|exists:wallets,id'
        ];
    }

    // Messages for validation
    protected $messages = [
        'account_number.required' => 'The recipient account number is required.',
        'amount.min' => 'Transfer amount must be at least 1.',
    ];

    // Add this line to define the events this component emits
    protected $listeners = ['walletUpdated' => '$refresh'];

    public function mount($wallet = null)
    {
        // Load user's default wallet or the provided wallet
        if ($wallet) {
            $this->source_wallet = $wallet;
        } else {
            $this->source_wallet = auth()->user()->wallet();
        }

        $this->source_wallet_id = $this->source_wallet->id;

        Log::info('Transfer component mounted', [
            'wallet_id' => $this->source_wallet_id,
            'user_id' => auth()->id()
        ]);
    }

    public function nextStep()
    {
        if ($this->currentStep == 1) {
            $this->validate([
                'account_number' => $this->rules()['account_number'],
                'amount' => $this->rules()['amount'],
                'source_wallet_id' => $this->rules()['source_wallet_id'],
            ]);

            // Find recipient wallet and user
            $this->recipient_wallet = Wallet::where('account_number', $this->account_number)->first();
            $this->recipient = $this->recipient_wallet->user;
            $this->currentStep = 2;

            Log::info('Moved to step 2', [
                'wallet_id' => $this->source_wallet_id,
                'recipient_wallet_id' => $this->recipient_wallet->id,
                'amount' => $this->amount
            ]);
        }
    }

    public function previousStep()
    {
        $this->currentStep = 1;
        $this->transfer_preview = false;

        Log::info('Returned to step 1', [
            'wallet_id' => $this->source_wallet_id
        ]);
    }

    public function previewTransfer()
    {
        $this->validate();

        // Find recipient wallet and user
        $this->recipient_wallet = Wallet::where('account_number', $this->account_number)->first();
        $this->recipient = $this->recipient_wallet->user;

        // Set preview flag
        $this->transfer_preview = true;
        $this->currentStep = 2;

        Log::info('Transfer preview shown', [
            'wallet_id' => $this->source_wallet_id,
            'recipient_wallet_id' => $this->recipient_wallet->id,
            'amount' => $this->amount
        ]);
    }

    public function confirmTransfer()
    {
        $this->validate();

        try {
            Log::info('Processing transfer confirmation', [
                'wallet_id' => $this->source_wallet_id,
                'recipient_account' => $this->account_number,
                'amount' => $this->amount
            ]);

            DB::beginTransaction();

            // Perform transfer using wallet service
            $walletService = new WalletService();

            $sourceWallet = Wallet::findOrFail($this->source_wallet_id);
            $recipientWallet = Wallet::where('account_number', $this->account_number)->firstOrFail();

            $transfer = $walletService->transfer(
                $sourceWallet,
                $recipientWallet,
                $this->amount,
                $this->description
            );

            DB::commit();

            // Set success result
            $this->isSuccess = true;
            $this->resultMessage = "Transfer of {$this->amount} {$sourceWallet->currency} to {$this->recipient->name} has been completed successfully.";
            $this->resultDetails = [
                'Amount' => number_format($this->amount, 2) . ' ' . $sourceWallet->currency,
                'Recipient' => $this->recipient->name,
                'Account Number' => $this->account_number,
                'Description' => $this->description ?: 'N/A',
                'Date' => now()->format('Y-m-d H:i:s'),
                'Reference' => $transfer['withdraw']->reference_id ?? 'TR' . time(),
            ];

            // Reset form and show success
            $this->reset(['account_number', 'amount', 'description']);
            $this->transfer_preview = false;
            $this->transfer_confirmed = true;
            $this->showResult = true;
            $this->currentStep = 3;

            session()->flash('success', 'Transfer completed successfully!');

            // Emit an event to notify other components that a wallet has been updated
            $this->dispatch('walletUpdated');
            $this->dispatch('transactionCompleted');

            Log::info('Transfer completed successfully', [
                'wallet_id' => $this->source_wallet_id,
                'recipient_wallet_id' => $recipientWallet->id,
                'amount' => $this->amount,
                'transaction_id' => $transfer['withdraw']->id ?? 'unknown'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Transfer failed', [
                'wallet_id' => $this->source_wallet_id,
                'recipient_account' => $this->account_number,
                'amount' => $this->amount,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Set failure result
            $this->isSuccess = false;
            $this->resultMessage = 'Transfer failed. Please try again or contact support if the problem persists.';
            $this->resultDetails = [
                'Error' => $e->getMessage(),
            ];

            $this->showResult = true;
            $this->transfer_preview = false;
            $this->currentStep = 3;

            session()->flash('error', 'Transfer failed: ' . $e->getMessage());
        }
    }

    public function resetForm()
    {
        $this->reset([
            'account_number',
            'amount',
            'description',
            'recipient',
            'recipient_wallet',
            'transfer_preview',
            'transfer_confirmed',
            'showResult',
            'isSuccess',
            'resultMessage',
            'resultDetails',
            'currentStep'
        ]);

        $this->currentStep = 1;

        Log::info('Form reset', [
            'wallet_id' => $this->source_wallet_id,
            'user_id' => auth()->id()
        ]);
    }

    public function render()
    {
        // Get user's wallets for selection
        $userWallets = auth()->user()->wallets;

        return view('livewire.wallets.transfer', [
            'userWallets' => $userWallets
        ]);
    }
}

