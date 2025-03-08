<?php

namespace App\Livewire\Merchant;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Dashboard extends Component
{
    use WithPagination;

    public $period = 'week';
    public $dateRange = [];
    public $chartData = [];
    public $metrics = [];
    public $paymentMethods = [];
    public $kybStatus = [];

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        // Load KYB verification status
        $this->loadKybStatus();

        // Load metrics
        $this->loadMetrics();

        // Load chart data
        $this->loadChartData();

        // Load payment methods
        $this->loadPaymentMethods();
    }

    public function setDateRange()
    {
        $now = Carbon::now();

        switch ($this->period) {
            case 'today':
                $this->dateRange = [
                    'start' => $now->startOfDay(),
                    'end' => $now->copy()->endOfDay(),
                    'format' => 'H:i',
                    'unit' => 'hour'
                ];
                break;
            case 'week':
                $this->dateRange = [
                    'start' => $now->copy()->startOfWeek(),
                    'end' => $now->copy()->endOfWeek(),
                    'format' => 'D',
                    'unit' => 'day'
                ];
                break;
            case 'month':
                $this->dateRange = [
                    'start' => $now->copy()->startOfMonth(),
                    'end' => $now->copy()->endOfMonth(),
                    'format' => 'd',
                    'unit' => 'day'
                ];
                break;
            case 'year':
                $this->dateRange = [
                    'start' => $now->copy()->startOfYear(),
                    'end' => $now->copy()->endOfYear(),
                    'format' => 'M',
                    'unit' => 'month'
                ];
                break;
        }
    }

    public function loadMetrics()
    {
        // In a real application, these would be fetched from the database
        // For now, we'll use sample data

        $this->metrics = [
            'total_sales' => [
                'value' => 15842.50,
                'change' => 12.5,
                'trend' => 'up'
            ],
            'transactions' => [
                'value' => 324,
                'change' => 8.2,
                'trend' => 'up'
            ],
            'average_order' => [
                'value' => 48.90,
                'change' => 3.1,
                'trend' => 'up'
            ],
            'conversion_rate' => [
                'value' => 3.24,
                'change' => -0.5,
                'trend' => 'down'
            ]
        ];
    }

    public function loadChartData()
    {
        // In a real application, this would be fetched from the database
        // For now, we'll use sample data

        // Sample data for sales chart
        $this->chartData = [
            'sales' => [
                'labels' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                'data' => [1250, 1580, 1320, 1740, 1530, 1680, 1750]
            ],
            'transactions' => [
                'labels' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                'data' => [42, 56, 38, 65, 48, 52, 53]
            ]
        ];
    }

    public function loadPaymentMethods()
    {
        // In a real application, this would be fetched from the database
        // For now, we'll use sample data

        $this->paymentMethods = [
            [
                'name' => 'Credit Card',
                'percentage' => 45,
                'amount' => 7129.13
            ],
            [
                'name' => 'Bank Transfer',
                'percentage' => 30,
                'amount' => 4752.75
            ],
            [
                'name' => 'Digital Wallet',
                'percentage' => 20,
                'amount' => 3168.50
            ],
            [
                'name' => 'Cryptocurrency',
                'percentage' => 5,
                'amount' => 792.12
            ]
        ];
    }

    public function loadKybStatus()
    {
        // In a real application, you would fetch the actual KYB status from the database
        // For now, we'll use sample data

        // You could fetch this from Auth::user()->kyb or a similar relationship
        $this->kybStatus = [
            'status' => 'pending', // Options: pending, approved, rejected, kiv (keep in view)
            'submitted_at' => now()->subDays(3)->format('M d, Y'),
            'last_updated' => now()->subDay()->format('M d, Y'),
            'missing_documents' => [
                'Business registration certificate',
                'Proof of address',
            ],
            'verification_progress' => 25, // Percentage of completion
        ];
    }

    public function changePeriod($period)
    {
        $this->period = $period;
        $this->loadData();
    }

    public function getRecentTransactions()
    {
        // In a real application, this would be fetched from the database
        // For now, we'll return sample data

        return [
            [
                'id' => 'TRX-'.rand(10000, 99999),
                'customer' => 'John Doe',
                'amount' => 125.50,
                'status' => 'completed',
                'date' => Carbon::now()->subHours(2)->format('M d, Y h:i A'),
                'payment_method' => 'Credit Card'
            ],
            [
                'id' => 'TRX-'.rand(10000, 99999),
                'customer' => 'Jane Smith',
                'amount' => 78.25,
                'status' => 'completed',
                'date' => Carbon::now()->subHours(5)->format('M d, Y h:i A'),
                'payment_method' => 'Digital Wallet'
            ],
            [
                'id' => 'TRX-'.rand(10000, 99999),
                'customer' => 'Robert Johnson',
                'amount' => 245.00,
                'status' => 'pending',
                'date' => Carbon::now()->subHours(8)->format('M d, Y h:i A'),
                'payment_method' => 'Bank Transfer'
            ],
            [
                'id' => 'TRX-'.rand(10000, 99999),
                'customer' => 'Emily Wilson',
                'amount' => 56.75,
                'status' => 'completed',
                'date' => Carbon::now()->subHours(12)->format('M d, Y h:i A'),
                'payment_method' => 'Credit Card'
            ],
            [
                'id' => 'TRX-'.rand(10000, 99999),
                'customer' => 'Michael Brown',
                'amount' => 189.99,
                'status' => 'failed',
                'date' => Carbon::now()->subHours(24)->format('M d, Y h:i A'),
                'payment_method' => 'Cryptocurrency'
            ]
        ];
    }

    public function render()
    {
        $recentTransactions = $this->getRecentTransactions();

        return view('livewire.merchant.dashboard', [
            'recentTransactions' => $recentTransactions
        ]);
    }
}

