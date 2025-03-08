<?php

namespace App\Livewire\Kyc;

use Livewire\Component;
use App\Models\Kyc;
use Illuminate\Support\Facades\Auth;

class KycDashboard extends Component
{
    public $kyc;
    public $kycHistory;
    public $showReapplyButton = false;

    public function mount()
    {
        // Get the user's current KYC application
        $this->kyc = Kyc::where('user_id', Auth::id())->latest()->first();

        // Get the user's KYC history (all applications)
        $this->kycHistory = Kyc::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        // Show reapply button if the latest application was rejected or if there's no application
        $this->showReapplyButton = !$this->kyc || $this->kyc->status === 'rejected';
    }

    public function render()
    {
        return view('livewire.kyc.kyc-dashboard');
    }
}

