<?php

namespace App\Livewire\Admin\Transactions;

use App\Models\Transaction;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $type = '';
    public $status = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 10;

    protected $queryString = [
        'search' => ['except' => ''],
        'type' => ['except' => ''],
        'status' => ['except' => ''],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
        'perPage' => ['except' => 10],
    ];

    public function updatingSearch()
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

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;
    }

    public function render()
    {
        $transactions = Transaction::query()
            ->when($this->search, function ($query) {
                $query->where('description', 'like', '%' . $this->search . '%')
                    ->orWhere('reference_id', 'like', '%' . $this->search . '%');
            })
            ->when($this->type, function ($query) {
                $query->where('type', $this->type);
            })
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        $typeCounts = [
            'deposit' => Transaction::where('type', Transaction::TYPE_DEPOSIT)->count(),
            'withdrawal' => Transaction::where('type', Transaction::TYPE_WITHDRAWAL)->count(),
            'transfer' => Transaction::where('type', Transaction::TYPE_TRANSFER)->count(),
            'payment' => Transaction::where('type', Transaction::TYPE_PAYMENT)->count(),
        ];

        return view('livewire.admin.transactions.index', [
            'transactions' => $transactions,
            'typeCounts' => $typeCounts,
        ]);
    }
}

