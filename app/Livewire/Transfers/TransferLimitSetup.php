<?php

namespace App\Livewire\Transfers;

use Livewire\Component;
use App\Models\TransferLimit;

class TransferLimitSetup extends Component
{
    public $transferLimit;
    public $daily_limit;
    public $monthly_limit;
    public $single_transfer_limit;
    public $showSetup = false;

    public function mount()
    {
        $this->transferLimit = auth()->user()->transferLimit;
        
        if (!$this->transferLimit) {
            $this->showSetup = true;
            // Set default values
            $this->daily_limit = 5000; // 5000 MYR
            $this->monthly_limit = 50000; // 50000 MYR
            $this->single_transfer_limit = 1000; // 1000 MYR
        } else {
            $this->daily_limit = $this->transferLimit->daily_limit / 100;
            $this->monthly_limit = $this->transferLimit->monthly_limit / 100;
            $this->single_transfer_limit = $this->transferLimit->single_transfer_limit / 100;
        }
    }

    public function setupLimits()
    {
        $this->validate([
            'daily_limit' => 'required|numeric|min:100|max:50000',
            'monthly_limit' => 'required|numeric|min:1000|max:500000',
            'single_transfer_limit' => 'required|numeric|min:10|max:10000',
        ], [
            'daily_limit.min' => 'Daily limit must be at least 100 MYR',
            'daily_limit.max' => 'Daily limit cannot exceed 50,000 MYR',
            'monthly_limit.min' => 'Monthly limit must be at least 1,000 MYR',
            'monthly_limit.max' => 'Monthly limit cannot exceed 500,000 MYR',
            'single_transfer_limit.min' => 'Single transfer limit must be at least 10 MYR',
            'single_transfer_limit.max' => 'Single transfer limit cannot exceed 10,000 MYR',
        ]);

        // Additional validation: daily limit should not exceed monthly limit
        if ($this->daily_limit > $this->monthly_limit) {
            $this->addError('daily_limit', 'Daily limit cannot exceed monthly limit.');
            return;
        }

        // Additional validation: single transfer limit should not exceed daily limit
        if ($this->single_transfer_limit > $this->daily_limit) {
            $this->addError('single_transfer_limit', 'Single transfer limit cannot exceed daily limit.');
            return;
        }

        if ($this->transferLimit) {
            // Update existing limits
            $this->transferLimit->update([
                'daily_limit' => (int)($this->daily_limit * 100),
                'monthly_limit' => (int)($this->monthly_limit * 100),
                'single_transfer_limit' => (int)($this->single_transfer_limit * 100),
            ]);
        } else {
            // Create new transfer limits
            $this->transferLimit = auth()->user()->transferLimit()->create([
                'daily_limit' => (int)($this->daily_limit * 100),
                'monthly_limit' => (int)($this->monthly_limit * 100),
                'single_transfer_limit' => (int)($this->single_transfer_limit * 100),
            ]);
        }

        $this->showSetup = false;
        session()->flash('success', 'Transfer limits have been set successfully!');
        
        // Emit event to refresh other components
        $this->dispatch('transferLimitsUpdated');
    }

    public function editLimits()
    {
        $this->showSetup = true;
    }

    public function cancelSetup()
    {
        $this->showSetup = false;
        $this->mount(); // Reset values
    }

    public function render()
    {
        return view('livewire.transfers.transfer-limit-setup');
    }
}
