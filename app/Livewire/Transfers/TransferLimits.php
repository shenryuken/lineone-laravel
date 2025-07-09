<?php

namespace App\Livewire\Transfers;

use Livewire\Component;
use App\Models\TransferLimit;

class TransferLimits extends Component
{
    public $transferLimit;
    public $daily_limit;
    public $monthly_limit;
    public $single_transfer_limit;

    public function mount()
    {
        $this->transferLimit = auth()->user()->transferLimit ?? auth()->user()->transferLimit()->create([]);
        $this->daily_limit = $this->transferLimit->daily_limit / 100;
        $this->monthly_limit = $this->transferLimit->monthly_limit / 100;
        $this->single_transfer_limit = $this->transferLimit->single_transfer_limit / 100;
    }

    public function updateLimits()
    {
        $this->validate([
            'daily_limit' => 'required|numeric|min:1|max:50000',
            'monthly_limit' => 'required|numeric|min:1|max:500000',
            'single_transfer_limit' => 'required|numeric|min:1|max:10000',
        ]);

        $this->transferLimit->update([
            'daily_limit' => (int)($this->daily_limit * 100),
            'monthly_limit' => (int)($this->monthly_limit * 100),
            'single_transfer_limit' => (int)($this->single_transfer_limit * 100),
        ]);

        session()->flash('success', 'Transfer limits updated successfully!');
    }

    public function render()
    {
        return view('livewire.transfers.transfer-limits');
    }
}
