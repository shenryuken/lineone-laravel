<?php

namespace App\Livewire\Admin\Kyc;

use App\Models\Kyc;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class KycDashboard extends Component
{
    use AuthorizesRequests;

    public $totalApplications = 0;
    public $pendingApplications = 0;
    public $approvedApplications = 0;
    public $rejectedApplications = 0;
    public $kivApplications = 0;
    public $recentApplications = [];
    public $monthlyStats = [];

    public function mount()
    {
        $this->authorize('viewAny', Kyc::class);
        $this->loadStats();
    }

    public function loadStats()
    {
        // Get counts by status
        $this->totalApplications = Kyc::count();
        $this->pendingApplications = Kyc::where('status', 'pending')->count();
        $this->approvedApplications = Kyc::where('status', 'approved')->count();
        $this->rejectedApplications = Kyc::where('status', 'rejected')->count();
        $this->kivApplications = Kyc::where('status', 'kiv')->count();

        // Get recent applications
        $this->recentApplications = Kyc::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Get monthly stats for the last 6 months
        $this->monthlyStats = Kyc::select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN status = "approved" THEN 1 ELSE 0 END) as approved'),
                DB::raw('SUM(CASE WHEN status = "rejected" THEN 1 ELSE 0 END) as rejected'),
                DB::raw('SUM(CASE WHEN status = "pending" THEN 1 ELSE 0 END) as pending'),
                DB::raw('SUM(CASE WHEN status = "kiv" THEN 1 ELSE 0 END) as kiv')
            )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get()
            ->map(function ($item) {
                $monthName = date('M', mktime(0, 0, 0, $item->month, 1));
                return [
                    'month' => $monthName . ' ' . $item->year,
                    'total' => $item->total,
                    'approved' => $item->approved,
                    'rejected' => $item->rejected,
                    'pending' => $item->pending,
                    'kiv' => $item->kiv,
                ];
            });
    }

    public function render()
    {
        return view('livewire.admin.kyc.kyc-dashboard');
    }
}

