<?php

namespace App\Livewire\Admin\Kyb;

use App\Models\Kyb;
use App\Models\KybStatusHistory;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class KybDashboard extends Component
{
    public $period = 'month';
    public $statusDistribution = [];
    public $timeframeData = [];
    public $processingTimeAvg = 0;
    public $pendingApplicationsCount = 0;
    public $approvalRate = 0;
    public $rejectionRate = 0;
    public $additionalInfoRate = 0;
    public $businessTypeDistribution = [];
    public $topReviewers = [];
    public $recentActivities = [];

    protected $listeners = ['refreshDashboard' => '$refresh'];

    public function mount()
    {
        $this->loadDashboardData();
    }

    public function updatedPeriod()
    {
        $this->loadDashboardData();
    }

    public function loadDashboardData()
    {
        $this->loadStatusDistribution();
        $this->loadTimeframeData();
        $this->loadKeyMetrics();
        $this->loadBusinessTypeDistribution();
        $this->loadTopReviewers();
        $this->loadRecentActivities();
    }

    private function loadStatusDistribution()
    {
        $statuses = ['pending', 'approved', 'rejected', 'additional_info'];
        $counts = [];

        foreach ($statuses as $status) {
            $counts[$status] = Kyb::where('status', $status)->count();
        }

        $this->statusDistribution = $counts;
    }

    private function loadTimeframeData()
    {
        // Determine date range based on selected period
        switch ($this->period) {
            case 'week':
                $startDate = Carbon::now()->subWeek();
                $interval = '1 day';
                $format = 'D';
                break;
            case 'month':
                $startDate = Carbon::now()->subMonth();
                $interval = '1 day';
                $format = 'd M';
                break;
            case 'quarter':
                $startDate = Carbon::now()->subQuarter();
                $interval = '1 week';
                $format = 'W/M';
                break;
            case 'year':
                $startDate = Carbon::now()->subYear();
                $interval = '1 month';
                $format = 'M';
                break;
            default:
                $startDate = Carbon::now()->subMonth();
                $interval = '1 day';
                $format = 'd M';
        }

        $endDate = Carbon::now();

        // Get applications created over time
        $createdApplications = Kyb::where('created_at', '>=', $startDate)
            ->groupBy('date')
            ->get([
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count')
            ])
            ->keyBy('date')
            ->map(function ($item) {
                return $item->count;
            })
            ->toArray();

        // Get applications approved over time
        $approvedApplications = Kyb::where('status', 'approved')
            ->where('updated_at', '>=', $startDate)
            ->groupBy('date')
            ->get([
                DB::raw('DATE(updated_at) as date'),
                DB::raw('COUNT(*) as count')
            ])
            ->keyBy('date')
            ->map(function ($item) {
                return $item->count;
            })
            ->toArray();

        // Create a complete date range
        $period = CarbonPeriod::create($startDate, $interval, $endDate);

        $data = [];
        foreach ($period as $date) {
            $dateString = $date->format('Y-m-d');
            $data[] = [
                'date' => $date->format($format),
                'submitted' => $createdApplications[$dateString] ?? 0,
                'approved' => $approvedApplications[$dateString] ?? 0
            ];
        }

        $this->timeframeData = $data;
    }

    private function loadKeyMetrics()
    {
        // Average processing time (for approved applications)
        $processingTimes = Kyb::where('status', 'approved')
            ->whereNotNull('approved_at')
            ->get()
            ->map(function ($kyb) {
                $createdAt = Carbon::parse($kyb->created_at);
                $approvedAt = Carbon::parse($kyb->approved_at);
                return $createdAt->diffInHours($approvedAt);
            });

        $this->processingTimeAvg = $processingTimes->count() > 0
            ? round($processingTimes->avg())
            : 0;

        // Pending applications count
        $this->pendingApplicationsCount = Kyb::where('status', 'pending')->count();

        // Total completed applications (approved or rejected)
        $totalCompleted = Kyb::whereIn('status', ['approved', 'rejected'])->count();

        // Only calculate rates if there are completed applications
        if ($totalCompleted > 0) {
            // Approval rate
            $approvedCount = Kyb::where('status', 'approved')->count();
            $this->approvalRate = round(($approvedCount / $totalCompleted) * 100);

            // Rejection rate
            $rejectedCount = Kyb::where('status', 'rejected')->count();
            $this->rejectionRate = round(($rejectedCount / $totalCompleted) * 100);
        }

        // Additional info rate (out of total applications)
        $totalApplications = Kyb::count();
        if ($totalApplications > 0) {
            $additionalInfoCount = Kyb::where('status', 'additional_info')->count();
            $this->additionalInfoRate = round(($additionalInfoCount / $totalApplications) * 100);
        }
    }

    private function loadBusinessTypeDistribution()
    {
        $businessTypes = Kyb::select('business_type', DB::raw('count(*) as count'))
            ->groupBy('business_type')
            ->orderBy('count', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'type' => ucfirst(str_replace('_', ' ', $item->business_type)),
                    'count' => $item->count
                ];
            })
            ->toArray();

        $this->businessTypeDistribution = $businessTypes;
    }

    private function loadTopReviewers()
    {
        $reviewers = KybStatusHistory::select('user_id', DB::raw('count(*) as actions'))
            ->where('is_note', false)
            ->whereIn('status', ['approved', 'rejected', 'additional_info'])
            ->groupBy('user_id')
            ->orderBy('actions', 'desc')
            ->limit(5)
            ->with('user:id,name,email')
            ->get()
            ->map(function ($item) {
                return [
                    'name' => $item->user->name,
                    'email' => $item->user->email,
                    'actions' => $item->actions
                ];
            })
            ->toArray();

        $this->topReviewers = $reviewers;
    }

    private function loadRecentActivities()
    {
        $this->recentActivities = KybStatusHistory::with(['kyb', 'user'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
    }

    public function render()
    {
        return view('livewire.admin.kyb.kyb-dashboard');
    }
}

