<?php

namespace App\Livewire\Merchant;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\PaymentOrder;
use App\Models\MerchantApiKey;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    use WithPagination;

    public $period = 'week';
    public $dateRange = [];
    public $chartData = [];
    public $metrics = [];
    public $paymentMethods = [];
    public $kybStatus = 'pending submission';

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $this->setDateRange();
        $this->loadKybStatus();
        $this->loadMetrics();
        $this->loadChartData();
        $this->loadPaymentMethods();
    }

    public function setDateRange()
    {
        $now = Carbon::now();

        switch ($this->period) {
            case 'today':
                $this->dateRange = [
                    'start' => $now->copy()->startOfDay(),
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
        $user = Auth::user();
        $cacheKey = "merchant_metrics_{$user->id}_{$this->period}";
        
        $this->metrics = Cache::remember($cacheKey, 300, function () use ($user) {
            // Get payment orders for this merchant with correct column name
            $baseQuery = PaymentOrder::query()
                ->join('merchant_api_keys', 'payment_orders.merchant_api_key_id', '=', 'merchant_api_keys.id')
                ->where('merchant_api_keys.user_id', $user->id)
                ->whereBetween('payment_orders.created_at', [$this->dateRange['start'], $this->dateRange['end']]);

            // Calculate metrics
            $totalSales = $baseQuery->clone()
                ->where('payment_orders.status', 'paid')
                ->sum('payment_orders.amount');

            $transactionCount = $baseQuery->clone()->count();

            $averageOrder = $transactionCount > 0 
                ? $totalSales / $transactionCount 
                : 0;

            // Calculate conversion rate (successful vs total orders)
            $totalOrders = $baseQuery->clone()->count();
            $successfulOrders = $baseQuery->clone()
                ->where('payment_orders.status', 'paid')
                ->count();
            
            $conversionRate = $totalOrders > 0 
                ? ($successfulOrders / $totalOrders) * 100 
                : 0;

            // Calculate previous period for comparison
            $previousStart = $this->getPreviousPeriodStart();
            $previousEnd = $this->getPreviousPeriodEnd();

            $previousBaseQuery = PaymentOrder::query()
                ->join('merchant_api_keys', 'payment_orders.merchant_api_key_id', '=', 'merchant_api_keys.id')
                ->where('merchant_api_keys.user_id', $user->id)
                ->whereBetween('payment_orders.created_at', [$previousStart, $previousEnd]);

            $previousSales = $previousBaseQuery->clone()
                ->where('payment_orders.status', 'paid')
                ->sum('payment_orders.amount');

            $previousTransactions = $previousBaseQuery->clone()->count();

            $previousAverage = $previousTransactions > 0 
                ? $previousSales / $previousTransactions 
                : 0;

            $previousTotalOrders = $previousBaseQuery->clone()->count();
            
            $previousSuccessfulOrders = $previousBaseQuery->clone()
                ->where('payment_orders.status', 'paid')
                ->count();

            $previousConversionRate = $previousTotalOrders > 0 
                ? ($previousSuccessfulOrders / $previousTotalOrders) * 100 
                : 0;

            return [
                'total_sales' => [
                    'value' => $totalSales,
                    'change' => $this->calculatePercentageChange($totalSales, $previousSales),
                    'trend' => $totalSales >= $previousSales ? 'up' : 'down'
                ],
                'transactions' => [
                    'value' => $transactionCount,
                    'change' => $this->calculatePercentageChange($transactionCount, $previousTransactions),
                    'trend' => $transactionCount >= $previousTransactions ? 'up' : 'down'
                ],
                'average_order' => [
                    'value' => $averageOrder,
                    'change' => $this->calculatePercentageChange($averageOrder, $previousAverage),
                    'trend' => $averageOrder >= $previousAverage ? 'up' : 'down'
                ],
                'conversion_rate' => [
                    'value' => round($conversionRate, 2),
                    'change' => $this->calculatePercentageChange($conversionRate, $previousConversionRate),
                    'trend' => $conversionRate >= $previousConversionRate ? 'up' : 'down'
                ]
            ];
        });
    }

    public function loadChartData()
    {
        $user = Auth::user();
        $cacheKey = "merchant_chart_{$user->id}_{$this->period}";
        
        $this->chartData = Cache::remember($cacheKey, 300, function () use ($user) {
            $labels = [];
            $salesData = [];
            $transactionData = [];

            // Generate date range based on period
            $current = $this->dateRange['start']->copy();
            $end = $this->dateRange['end'];

            while ($current <= $end) {
                $nextPeriod = $this->getNextPeriod($current);
                
                $labels[] = $current->format($this->dateRange['format']);
                
                // Get sales for this period with correct column name
                $periodSales = PaymentOrder::query()
                    ->join('merchant_api_keys', 'payment_orders.merchant_api_key_id', '=', 'merchant_api_keys.id')
                    ->where('merchant_api_keys.user_id', $user->id)
                    ->whereBetween('payment_orders.created_at', [$current, $nextPeriod])
                    ->where('payment_orders.status', 'paid')
                    ->sum('payment_orders.amount');
                
                $periodTransactions = PaymentOrder::query()
                    ->join('merchant_api_keys', 'payment_orders.merchant_api_key_id', '=', 'merchant_api_keys.id')
                    ->where('merchant_api_keys.user_id', $user->id)
                    ->whereBetween('payment_orders.created_at', [$current, $nextPeriod])
                    ->count();

                $salesData[] = $periodSales;
                $transactionData[] = $periodTransactions;

                $current = $nextPeriod->copy()->addSecond();
            }

            return [
                'sales' => [
                    'labels' => $labels,
                    'data' => $salesData
                ],
                'transactions' => [
                    'labels' => $labels,
                    'data' => $transactionData
                ]
            ];
        });
    }

    public function loadPaymentMethods()
    {
        $user = Auth::user();
        $cacheKey = "merchant_payment_methods_{$user->id}_{$this->period}";
        
        $this->paymentMethods = Cache::remember($cacheKey, 300, function () use ($user) {
            // Check if payment_method column exists before querying
            $paymentMethodStats = PaymentOrder::query()
                ->join('merchant_api_keys', 'payment_orders.merchant_api_key_id', '=', 'merchant_api_keys.id')
                ->where('merchant_api_keys.user_id', $user->id)
                ->whereBetween('payment_orders.created_at', [$this->dateRange['start'], $this->dateRange['end']])
                ->where('payment_orders.status', 'paid')
                ->select(
                    DB::raw('COALESCE(payment_orders.payment_method, "Unknown") as payment_method'),
                    DB::raw('SUM(payment_orders.amount) as total_amount'),
                    DB::raw('COUNT(*) as count')
                )
                ->groupBy(DB::raw('COALESCE(payment_orders.payment_method, "Unknown")'))
                ->get();

            $totalAmount = $paymentMethodStats->sum('total_amount');
            
            return $paymentMethodStats->map(function ($stat) use ($totalAmount) {
                return [
                    'name' => $stat->payment_method ?: 'Unknown',
                    'percentage' => $totalAmount > 0 ? round(($stat->total_amount / $totalAmount) * 100, 1) : 0,
                    'amount' => $stat->total_amount,
                    'count' => $stat->count
                ];
            })->sortByDesc('percentage')->values()->take(4)->toArray();
        });
    }

    public function loadKybStatus()
    {
        $user = Auth::user();
        $this->kybStatus = $user->kybStatus();
    }

    public function changePeriod($period)
    {
        $this->period = $period;
        $this->loadData();
    }

    public function getRecentTransactions()
    {
        $user = Auth::user();
        
        return PaymentOrder::query()
            ->join('merchant_api_keys', 'payment_orders.merchant_api_key_id', '=', 'merchant_api_keys.id')
            ->where('merchant_api_keys.user_id', $user->id)
            ->select('payment_orders.*')
            ->latest('payment_orders.created_at')
            ->limit(5)
            ->get()
            ->map(function ($order) {
                return [
                    'id' => $order->order_id,
                    'customer' => $order->customer_email ?? 'Guest',
                    'amount' => $order->amount,
                    'status' => $order->status,
                    'date' => $order->created_at->format('M d, Y h:i A'),
                    'payment_method' => $order->payment_method ?? 'Unknown'
                ];
            })->toArray();
    }

    private function calculatePercentageChange($current, $previous)
    {
        if ($previous == 0) {
            return $current > 0 ? 100 : 0;
        }
        
        return round((($current - $previous) / $previous) * 100, 1);
    }

    private function getPreviousPeriodStart()
    {
        switch ($this->period) {
            case 'today':
                return $this->dateRange['start']->copy()->subDay();
            case 'week':
                return $this->dateRange['start']->copy()->subWeek();
            case 'month':
                return $this->dateRange['start']->copy()->subMonth();
            case 'year':
                return $this->dateRange['start']->copy()->subYear();
        }
    }

    private function getPreviousPeriodEnd()
    {
        switch ($this->period) {
            case 'today':
                return $this->dateRange['end']->copy()->subDay();
            case 'week':
                return $this->dateRange['end']->copy()->subWeek();
            case 'month':
                return $this->dateRange['end']->copy()->subMonth();
            case 'year':
                return $this->dateRange['end']->copy()->subYear();
        }
    }

    private function getNextPeriod($current)
    {
        switch ($this->dateRange['unit']) {
            case 'hour':
                return $current->copy()->endOfHour();
            case 'day':
                return $current->copy()->endOfDay();
            case 'month':
                return $current->copy()->endOfMonth();
            default:
                return $current->copy()->endOfDay();
        }
    }

    public function render()
    {
        $recentTransactions = $this->getRecentTransactions();

        return view('livewire.merchant.dashboard', [
            'recentTransactions' => $recentTransactions,
        ]);
    }
}
