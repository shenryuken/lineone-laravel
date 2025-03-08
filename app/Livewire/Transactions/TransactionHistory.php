<?php

namespace App\Livewire\Transactions;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Transaction;
use App\Models\Wallet;

class TransactionHistory extends Component
{
    use WithPagination;

    public $period = 7; // Default to 7 days
    public $wallet_id = null;
    public $type = null;
    public $status = null;
    public $search = '';
    public $perPage = 10;

    protected $queryString = [
        'period' => ['except' => 7],
        'wallet_id' => ['except' => ''],
        'type' => ['except' => ''],
        'status' => ['except' => ''],
        'search' => ['except' => ''],
        'perPage' => ['except' => 10],
    ];

    public function mount()
    {
        // If user has only one wallet, select it by default
        $wallets = auth()->user()->wallets;
        if ($wallets->count() === 1) {
            $this->wallet_id = $wallets->first()->id;
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPeriod()
    {
        $this->resetPage();
    }

    public function updatingWalletId()
    {
        $this->resetPage();
    }

    public function updatingType()
    {
        $this->resetPage();
    }

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function render()
    {
        $wallets = auth()->user()->wallets;

        $query = Transaction::query()
            ->whereIn('wallet_id', $wallets->pluck('id'));

        // Apply period filter
        if ($this->period) {
            $query->fromPeriod($this->period);
        }

        // Apply wallet filter
        if ($this->wallet_id) {
            $query->where('wallet_id', $this->wallet_id);
        }

        // Apply type filter
        if ($this->type) {
            $query->where('type', $this->type);
        }

        // Apply status filter
        if ($this->status) {
            $query->where('status', $this->status);
        }

        // Apply search
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('description', 'like', '%' . $this->search . '%')
                  ->orWhere('reference_id', 'like', '%' . $this->search . '%');
            });
        }

        $transactions = $query->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.transactions.transaction-history', [
            'transactions' => $transactions,
            'wallets' => $wallets,
            'transactionTypes' => [
                Transaction::TYPE_DEPOSIT => 'Deposit',
                Transaction::TYPE_WITHDRAWAL => 'Withdrawal',
                Transaction::TYPE_TRANSFER => 'Transfer',
                Transaction::TYPE_PAYMENT => 'Payment',
                Transaction::TYPE_REFUND => 'Refund',
            ],
            'transactionStatuses' => [
                Transaction::STATUS_PENDING => 'Pending',
                Transaction::STATUS_COMPLETED => 'Completed',
                Transaction::STATUS_FAILED => 'Failed',
                Transaction::STATUS_CANCELLED => 'Cancelled',
            ],
        ]);
    }
}

