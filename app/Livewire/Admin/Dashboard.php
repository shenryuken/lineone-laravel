<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class Dashboard extends Component
{
    public $showTransferModal = false;
    public $selectedWalletId = null;

    public function transfer($walletId = null)
    {
        $this->selectedWalletId = $walletId ?? auth()->user()->wallet()->id;
        $this->showTransferModal = true;
    }

    public function closeTransferModal()
    {
        $this->showTransferModal = false;
    }

    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}

