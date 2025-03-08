<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Models\Kyb;
use App\Models\Kyc;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Dashboard extends Component
{
    public $period = 'week';
    public $transactionData = [];
    public $userGrowthData = [];
    public $kycStatusData = [];
    public $kybStatusData = [];
    public $recentTransactions = [];
    public $recentUsers = [];
    public $recentKybApplications = [];

    protected $listeners = ['refreshDashboard' => '$refresh'];

    public function mount()
    {
        $this->loadDashboardData();
    }

    public function updatedPeriod()
    {
        $this->loadDashboardData();
    }

    private function loadDashboardData()
    {
        $this->loadTransactionData();
        $this->loadUserGrowthData();
        $this->loadKycStatusData();
        $this->loadKybStatusData();
        $this->loadRecentTransactions();
        $this->loadRecentUsers();
        $this->loadRecentKybApplications();
    }

    private function loadTransactionData()
    {
        // Determine date range based on selected period
        $startDate = $this->getStartDate();
        $endDate = Carbon::now();

        // Get transaction data grouped by date
        $transactions = Transaction::whereBetween('created_at', [$startDate, $endDate])
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(amount) as total_amount'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $formattedData = [];
        $currentDate = clone $startDate;

        while ($currentDate <= $endDate) {
            $dateString = $currentDate->format('Y-m-d');
            $transaction = $transactions->firstWhere('date', $dateString);

            $formattedData[] = [
                'date' => $currentDate->format($this->getDateFormat()),
                'amount' => $transaction ? round($transaction->total_amount / 100, 2) : 0, // Convert cents to dollars
                'count' => $transaction ? $transaction->count : 0
            ];

            $currentDate->addDay();
        }

        $this->transactionData = $formattedData;
    }

    private function loadUserGrowthData()
    {
        // Determine date range based on selected period
        $startDate = $this->getStartDate();
        $endDate = Carbon::now();

        // Get user registration data grouped by date
        $users = User::whereBetween('created_at', [$startDate, $endDate])
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $formattedData = [];
        $currentDate = clone $startDate;
        $cumulativeCount = User::where('created_at', '<', $startDate)->count();

        while ($currentDate <= $endDate) {
            $dateString = $currentDate->format('Y-m-d');
            $user = $users->firstWhere('date', $dateString);

            $dailyCount = $user ? $user->count : 0;
            $cumulativeCount += $dailyCount;

            $formattedData[] = [
                'date' => $currentDate->format($this->getDateFormat()),
                'daily' => $dailyCount,
                'cumulative' => $cumulativeCount
            ];

            $currentDate->addDay();
        }

        $this->userGrowthData = $formattedData;
    }

    private function loadKycStatusData()
    {
        $this->kycStatusData = [
            'pending' => Kyc::where('status', 'pending')->count(),
            'approved' => Kyc::where('status', 'approved')->count(),
            'rejected' => Kyc::where('status', 'rejected')->count(),
            'additional_info' => Kyc::where('status', 'additional_info')->count(),
        ];
    }

    private function loadKybStatusData()
    {
        $this->kybStatusData = [
            'pending' => Kyb::where('status', 'pending')->count(),
            'approved' => Kyb::where('status', 'approved')->count(),
            'rejected' => Kyb::where('status', 'rejected')->count(),
            'additional_info' => Kyb::where('status', 'additional_info')->count(),
        ];
    }

    private function loadRecentTransactions()
    {
        $this->recentTransactions = Transaction::with(['wallet.user'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
    }

    private function loadRecentUsers()
    {
        $this->recentUsers = User::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
    }

    private function loadRecentKybApplications()
    {
        $this->recentKybApplications = Kyb::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
    }

    private function getStartDate()
    {
        switch ($this->period) {
            case 'week':
                return Carbon::now()->subWeek();
            case 'month':
                return Carbon::now()->subMonth();
            case 'quarter':
                return Carbon::now()->subQuarter();
            case 'year':
                return Carbon::now()->subYear();
            default:
                return Carbon::now()->subWeek();
        }
    }

    private function getDateFormat()
    {
        switch ($this->period) {
            case 'week':
                return 'D';
            case 'month':
                return 'd M';
            case 'quarter':
                return 'd M';
            case 'year':
                return 'M Y';
            default:
                return 'd M';
        }
    }

    public function render()
    {
        // Calculate summary metrics
        $totalUsers = User::count();
        $totalTransactions = Transaction::count();
        $totalVolume = Transaction::sum('amount') / 100; // Convert cents to dollars
        $totalWallets = Wallet::count();
        $averageBalance = Wallet::avg('balance') / 100; // Convert cents to dollars

        // Calculate growth metrics
        $previousPeriodStart = $this->getStartDate()->copy()->subDays($this->getPeriodDays());
        $currentPeriodStart = $this->getStartDate();

        $currentPeriodTransactions = Transaction::whereBetween('created_at', [$currentPeriodStart, Carbon::now()])->count();
        $previousPeriodTransactions = Transaction::whereBetween('created_at', [$previousPeriodStart, $currentPeriodStart])->count();

        $transactionGrowth = $previousPeriodTransactions > 0
            ? (($currentPeriodTransactions - $previousPeriodTransactions) / $previousPeriodTransactions) * 100
            : 100;

        $currentPeriodUsers = User::whereBetween('created_at', [$currentPeriodStart, Carbon::now()])->count();
        $previousPeriodUsers = User::whereBetween('created_at', [$previousPeriodStart, $currentPeriodStart])->count();

        $userGrowth = $previousPeriodUsers > 0
            ? (($currentPeriodUsers - $previousPeriodUsers) / $previousPeriodUsers) * 100
            : 100;

        return view('livewire.admin.dashboard', [
            'totalUsers' => $totalUsers,
            'totalTransactions' => $totalTransactions,
            'totalVolume' => $totalVolume,
            'totalWallets' => $totalWallets,
            'averageBalance' => $averageBalance,
            'transactionGrowth' => $transactionGrowth,
            'userGrowth' => $userGrowth,
        ]);
    }

    private function getPeriodDays()
    {
        switch ($this->period) {
            case 'week':
                return 7;
            case 'month':
                return 30;
            case 'quarter':
                return 90;
            case 'year':
                return 365;
            default:
                return 7;
        }
    }
}

