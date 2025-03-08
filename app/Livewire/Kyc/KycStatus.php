<?php

namespace App\Livewire\Kyc;

use Livewire\Component;
use App\Models\Kyc;
use Illuminate\Support\Facades\Auth;

class KycStatus extends Component
{
    public $kyc;

    public function mount()
    {
        $this->kyc = Kyc::where('user_id', Auth::id())->latest()->first();

        if (!$this->kyc) {
            return redirect()->route('kyc.apply');
        }
    }

    public function render()
    {
        return view('livewire.kyc.kyc-status');
    }
}

