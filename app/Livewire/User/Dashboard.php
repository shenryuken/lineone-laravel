<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\Wallet;

class Dashboard extends Component
{
    public $showTransferModal = false;
    public $showWithdrawModal = false;
    public $showDepositModal = false;
    public $selectedWalletId = null;
    public $walletBalance = 0;
    public $walletCurrency = '';
    public $walletAccountNumber = '';

    // Add listeners for the events
    protected $listeners = [
        'transactionCompleted' => 'handleTransactionCompleted',
        'walletUpdated' => 'refreshWalletData'
    ];

    public function mount()
    {
        $this->refreshWalletData();
    }

    public function refreshWalletData()
    {
        $wallet = auth()->user()->wallet();
        if ($wallet) {
            $this->walletBalance = $wallet->balance;
            $this->walletCurrency = $wallet->currency;
            $this->walletAccountNumber = $wallet->account_number;
        }
    }

    public function handleTransactionCompleted()
    {
        $this->showTransferModal = false;
        $this->showWithdrawModal = false;
        $this->refreshWalletData();
    }

    public function transfer($walletId = null)
    {
        $this->selectedWalletId = $walletId ?? auth()->user()->wallet()->id;
        $this->showTransferModal = true;
    }

    public function withdraw($walletId = null)
    {
        $this->selectedWalletId = $walletId ?? auth()->user()->wallet()->id;
        $this->showWithdrawModal = true;
    }

    public function closeTransferModal()
    {
        $this->showTransferModal = false;
    }

    public function closeWithdrawModal()
    {
        $this->showWithdrawModal = false;
        $this->selectedWalletId = null;
    }

    public function deposit($walletId = null)
    {
        $this->selectedWalletId = $walletId ?? Auth::user()->wallet()->id;
        $this->showDepositModal = true;
    }

    public function closeDepositModal()
    {
        $this->showDepositModal = false;
    }

    public function render()
    {
        return view('livewire.user.dashboard');
    }
}

