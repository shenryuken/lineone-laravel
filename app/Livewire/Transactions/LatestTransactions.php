<?php

namespace App\Livewire\Transactions;

use Livewire\Component;
use App\Models\Transaction;

class LatestTransactions extends Component
{
    public $limit = 5;
    public $wallet = null;

    // Add listener for wallet updates
    protected $listeners = ['walletUpdated' => '$refresh'];

    public function mount($wallet = null)
    {
        $this->wallet = $wallet ?? auth()->user()->wallet();
    }

    public function render()
    {
        $transactions = $this->wallet->transactions()
            ->orderBy('created_at', 'desc')
            ->limit($this->limit)
            ->get();

        return view('livewire.transactions.latest-transactions', [
            'transactions' => $transactions
        ]);
    }
}

