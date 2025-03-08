<?php

namespace App\Livewire\Admin\Kyb;

use App\Models\Kyb;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class KybIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $status = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 10;

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
        'perPage' => ['except' => 10],
    ];

    protected $listeners = ['refreshKybList' => '$refresh'];

    public function updatingSearch()
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
        $kybs = Kyb::query()
            ->when($this->search, function ($query) {
                $query->whereHas('user', function ($subQuery) {
                    $subQuery->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                })
                ->orWhere('legal_name', 'like', '%' . $this->search . '%')
                ->orWhere('registration_number', 'like', '%' . $this->search . '%');
            })
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        $statusCounts = [
            'pending' => Kyb::where('status', 'pending')->count(),
            'approved' => Kyb::where('status', 'approved')->count(),
            'rejected' => Kyb::where('status', 'rejected')->count(),
            'additional_info' => Kyb::where('status', 'additional_info')->count(),
        ];

        return view('livewire.admin.kyb.kyb-index', [
            'kybs' => $kybs,
            'statusCounts' => $statusCounts,
        ]);
    }
}

