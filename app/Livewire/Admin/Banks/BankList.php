<?php

namespace App\Livewire\Admin\Banks;

use App\Models\Bank;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;

class BankList extends Component
{
    use WithPagination;

    public $search = '';
    public $type = '';
    public $country = '';
    public $perPage = 10;
    public $sortField = 'name';
    public $sortDirection = 'asc';

    public $confirmingBankDeletion = false;
    public $bankToDelete = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'type' => ['except' => ''],
        'country' => ['except' => ''],
        'perPage' => ['except' => 10],
        'sortField' => ['except' => 'name'],
        'sortDirection' => ['except' => 'asc'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingType()
    {
        $this->resetPage();
    }

    public function updatingCountry()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;
    }

    public function confirmBankDeletion($bankId)
    {
        $this->confirmingBankDeletion = true;
        $this->bankToDelete = $bankId;
    }

    public function deleteBank()
    {
        try {
            $bank = Bank::findOrFail($this->bankToDelete);
            $bank->delete();

            session()->flash('toast', [
                'type' => 'success',
                'message' => 'Bank deleted successfully!'
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting bank', [
                'bank_id' => $this->bankToDelete,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            session()->flash('toast', [
                'type' => 'error',
                'message' => 'Failed to delete bank: ' . $e->getMessage()
            ]);
        }

        $this->confirmingBankDeletion = false;
        $this->bankToDelete = null;
    }

    public function toggleBankStatus($bankId)
    {
        try {
            $bank = Bank::findOrFail($bankId);
            $bank->is_active = !$bank->is_active;
            $bank->save();

            session()->flash('toast', [
                'type' => 'success',
                'message' => 'Bank status updated successfully!'
            ]);
        } catch (\Exception $e) {
            Log::error('Error toggling bank status', [
                'bank_id' => $bankId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            session()->flash('toast', [
                'type' => 'error',
                'message' => 'Failed to update bank status: ' . $e->getMessage()
            ]);
        }
    }

    public function render()
    {
        $banks = Bank::query()
            ->when($this->search, function ($query) {
                return $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('code', 'like', '%' . $this->search . '%')
                      ->orWhere('swift_code', 'like', '%' . $this->search . '%')
                      ->orWhere('country_name', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->type, function ($query) {
                return $query->where('type', $this->type);
            })
            ->when($this->country, function ($query) {
                return $query->where('country_code', $this->country);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        // Get unique countries for filter
        $countries = Bank::select('country_code', 'country_name')
            ->distinct()
            ->orderBy('country_name')
            ->get();

        return view('livewire.admin.banks.bank-list', [
            'banks' => $banks,
            'countries' => $countries
        ]);
    }
}

