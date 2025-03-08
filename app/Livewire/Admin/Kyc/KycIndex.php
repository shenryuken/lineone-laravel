<?php

namespace App\Livewire\Admin\Kyc;

use App\Models\Kyc;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class KycIndex extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public $search = '';
    public $status = '';
    public $verificationStatus = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 10;

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
        'verificationStatus' => ['except' => ''],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
        'perPage' => ['except' => 10],
    ];

    public function mount()
    {
        $this->authorize('viewAny', Kyc::class);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function updatingVerificationStatus()
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
        $query = Kyc::query()
            ->with(['user', 'verifier', 'approver', 'rejector'])
            ->when($this->search, function ($query) {
                return $query->whereHas('user', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
                })
                ->orWhere('full_name', 'like', '%' . $this->search . '%')
                ->orWhere('id_number', 'like', '%' . $this->search . '%');
            })
            ->when($this->status, function ($query) {
                return $query->where('status', $this->status);
            })
            ->when($this->verificationStatus, function ($query) {
                return $query->where('verification_status', $this->verificationStatus);
            })
            ->orderBy($this->sortField, $this->sortDirection);

        $kycs = $query->paginate($this->perPage);

        return view('livewire.admin.kyc.kyc-index', [
            'kycs' => $kycs,
            'statusOptions' => [
                'pending' => 'Pending',
                'approved' => 'Approved',
                'rejected' => 'Rejected',
                'kiv' => 'Keep In View',
            ],
            'verificationStatusOptions' => [
                'pending' => 'Pending',
                'pass' => 'Pass',
                'fail' => 'Fail',
            ],
        ]);
    }
}

