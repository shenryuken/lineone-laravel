<div class="py-12">
    <!-- Period Selector -->
    <div class="card mb-5 p-3">
        <div class="flex flex-wrap items-center justify-between">
            <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                {{ __('Dashboard Overview') }}
            </h2>
            <div class="flex">
                <select wire:model="period"
                    class="form-select rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">
                    <option value="week">{{ __('Last 7 Days') }}</option>
                    <option value="month">{{ __('Last 30 Days') }}</option>
                    <option value="quarter">{{ __('Last Quarter') }}</option>
                    <option value="year">{{ __('Last Year') }}</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Key Metrics -->
    {{-- <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-5 lg:grid-cols-4 lg:gap-6 mb-5">
        <!-- Total Users -->
        <div class="card p-4 sm:p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-lg font-semibold text-slate-700 dark:text-navy-100">
                        {{ number_format($totalUsers) }}
                    </p>
                    <p class="text-xs+ text-slate-400 dark:text-navy-300">
                        {{ __('Total Users') }}
                    </p>
                </div>
                <div class="mask is-squircle bg-primary/10 p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center justify-between">
                <p class="text-xs+ text-slate-400 dark:text-navy-300">
                    {{ __('Growth') }}
                </p>
                <p class="text-xs+ @if($userGrowth >= 0) text-success @else text-error @endif">
                    {{ number_format($userGrowth, 1) }}%
                </p>
            </div>
        </div>

        <!-- Total Transactions -->
        <div class="card p-4 sm:p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-lg font-semibold text-slate-700 dark:text-navy-100">
                        {{ number_format($totalTransactions) }}
                    </p>
                    <p class="text-xs+ text-slate-400 dark:text-navy-300">
                        {{ __('Total Transactions') }}
                    </p>
                </div>
                <div class="mask is-squircle bg-warning/10 p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-warning" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center justify-between">
                <p class="text-xs+ text-slate-400 dark:text-navy-300">
                    {{ __('Growth') }}
                </p>
                <p class="text-xs+ @if($transactionGrowth >= 0) text-success @else text-error @endif">
                    {{ number_format($transactionGrowth, 1) }}%
                </p>
            </div>
        </div>

        <!-- Transaction Volume -->
        <div class="card p-4 sm:p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-lg font-semibold text-slate-700 dark:text-navy-100">
                        {{ number_format($totalVolume, 2) }}
                    </p>
                    <p class="text-xs+ text-slate-400 dark:text-navy-300">
                        {{ __('Transaction Volume') }}
                    </p>
                </div>
                <div class="mask is-squircle bg-success/10 p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-success" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center justify-between">
                <p class="text-xs+ text-slate-400 dark:text-navy-300">
                    {{ __('Average Transaction') }}
                </p>
                <p class="text-xs+ text-info">
                    {{ number_format($totalTransactions > 0 ? $totalVolume / $totalTransactions : 0, 2) }}
                </p>
            </div>
        </div>

        <!-- Wallets -->
        <div class="card p-4 sm:p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-lg font-semibold text-slate-700 dark:text-navy-100">
                        {{ number_format($totalWallets) }}
                    </p>
                    <p class="text-xs+ text-slate-400 dark:text-navy-300">
                        {{ __('Active Wallets') }}
                    </p>
                </div>
                <div class="mask is-squircle bg-info/10 p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-info" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center justify-between">
                <p class="text-xs+ text-slate-400 dark:text-navy-300">
                    {{ __('Average Balance') }}
                </p>
                <p class="text-xs+ text-info">
                    {{ number_format($averageBalance, 2) }}
                </p>
            </div>
        </div>
    </div> --}}
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-8">
    <!-- Total Users Card -->
    <div class="card bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-900/10 border border-blue-100 dark:border-blue-900/20 p-5 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-blue-600 dark:text-blue-300 mb-1">
                    {{ __('Total Users') }}
                </p>
                <p class="text-2xl font-bold text-slate-800 dark:text-navy-100">
                    {{ number_format($totalUsers) }}
                </p>
            </div>
            <div class="p-3 rounded-xl bg-blue-100/50 dark:bg-blue-900/20">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
        </div>
        <div class="mt-4 flex items-center justify-between pt-3 border-t border-blue-100 dark:border-blue-900/20">
            <div class="flex items-center space-x-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 @if($userGrowth >= 0) text-green-500 @else text-red-500 @endif" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="@if($userGrowth >= 0) M5 10l7-7m0 0l7 7m-7-7v18 @else M19 14l-7 7m0 0l-7-7m7 7V3 @endif" />
                </svg>
                <span class="text-xs font-medium @if($userGrowth >= 0) text-green-600 dark:text-green-400 @else text-red-600 dark:text-red-400 @endif">
                    {{ number_format($userGrowth, 1) }}%
                </span>
            </div>
            <p class="text-xs text-blue-500 dark:text-blue-400">
                {{ __('vs last month') }}
            </p>
        </div>
    </div>

    <!-- Total Transactions Card -->
    <div class="card bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-900/10 border border-purple-100 dark:border-purple-900/20 p-5 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-purple-600 dark:text-purple-300 mb-1">
                    {{ __('Total Transactions') }}
                </p>
                <p class="text-2xl font-bold text-slate-800 dark:text-navy-100">
                    {{ number_format($totalTransactions) }}
                </p>
            </div>
            <div class="p-3 rounded-xl bg-purple-100/50 dark:bg-purple-900/20">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-purple-600 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
            </div>
        </div>
        <div class="mt-4 flex items-center justify-between pt-3 border-t border-purple-100 dark:border-purple-900/20">
            <div class="flex items-center space-x-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 @if($transactionGrowth >= 0) text-green-500 @else text-red-500 @endif" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="@if($transactionGrowth >= 0) M5 10l7-7m0 0l7 7m-7-7v18 @else M19 14l-7 7m0 0l-7-7m7 7V3 @endif" />
                </svg>
                <span class="text-xs font-medium @if($transactionGrowth >= 0) text-green-600 dark:text-green-400 @else text-red-600 dark:text-red-400 @endif">
                    {{ number_format($transactionGrowth, 1) }}%
                </span>
            </div>
            <p class="text-xs text-purple-500 dark:text-purple-400">
                {{ __('vs last month') }}
            </p>
        </div>
    </div>

    <!-- Transaction Volume Card -->
    <div class="card bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-900/10 border border-green-100 dark:border-green-900/20 p-5 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-green-600 dark:text-green-300 mb-1">
                    {{ __('Transaction Volume') }}
                </p>
                <p class="text-2xl font-bold text-slate-800 dark:text-navy-100">
                    ${{ number_format($totalVolume, 2) }}
                </p>
            </div>
            <div class="p-3 rounded-xl bg-green-100/50 dark:bg-green-900/20">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
        <div class="mt-4 flex items-center justify-between pt-3 border-t border-green-100 dark:border-green-900/20">
            <p class="text-xs text-green-600 dark:text-green-400">
                {{ __('Avg. Transaction') }}
            </p>
            <p class="text-xs font-medium text-slate-700 dark:text-navy-100">
                ${{ number_format($totalTransactions > 0 ? $totalVolume / $totalTransactions : 0, 2) }}
            </p>
        </div>
    </div>

    <!-- Active Wallets Card -->
    <div class="card bg-gradient-to-br from-amber-50 to-amber-100 dark:from-amber-900/20 dark:to-amber-900/10 border border-amber-100 dark:border-amber-900/20 p-5 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-amber-600 dark:text-amber-300 mb-1">
                    {{ __('Active Wallets') }}
                </p>
                <p class="text-2xl font-bold text-slate-800 dark:text-navy-100">
                    {{ number_format($totalWallets) }}
                </p>
            </div>
            <div class="p-3 rounded-xl bg-amber-100/50 dark:bg-amber-900/20">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                </svg>
            </div>
        </div>
        <div class="mt-4 flex items-center justify-between pt-3 border-t border-amber-100 dark:border-amber-900/20">
            <p class="text-xs text-amber-600 dark:text-amber-400">
                {{ __('Avg. Balance') }}
            </p>
            <p class="text-xs font-medium text-slate-700 dark:text-navy-100">
                ${{ number_format($averageBalance, 2) }}
            </p>
        </div>
    </div>
</div>
    <!-- Charts -->
    <div class="grid grid-cols-1 gap-4 sm:gap-5 lg:grid-cols-2 lg:gap-6 mb-5">
        <!-- Transaction Chart -->
        <div class="card p-4 sm:p-5">
            <div class="flex items-center justify-between">
                <h2 class="font-medium tracking-wide text-slate-700 dark:text-navy-100">
                    {{ __('Transaction Activity') }}
                </h2>
            </div>
            <div class="mt-3 h-80">
                <div id="transactionChart" class="h-full w-full"></div>
            </div>
        </div>

        <!-- User Growth Chart -->
        <div class="card p-4 sm:p-5">
            <div class="flex items-center justify-between">
                <h2 class="font-medium tracking-wide text-slate-700 dark:text-navy-100">
                    {{ __('User Growth') }}
                </h2>
            </div>
            <div class="mt-3 h-80">
                <div id="userGrowthChart" class="h-full w-full"></div>
            </div>
        </div>
    </div>

    <!-- KYC & KYB Status -->
    <div class="grid grid-cols-1 gap-4 sm:gap-5 lg:grid-cols-2 lg:gap-6 mb-5">
        <!-- KYC Status -->
        <div class="card p-4 sm:p-5">
            <div class="flex items-center justify-between">
                <h2 class="font-medium tracking-wide text-slate-700 dark:text-navy-100">
                    {{ __('KYC Status') }}
                </h2>
                <a href="{{ route('admin.kyc.index') }}"
                    class="border-b border-dashed border-current pb-0.5 font-medium text-primary outline-none transition-colors duration-300 hover:text-primary/70 focus:text-primary/70 dark:text-accent-light dark:hover:text-accent-light/70 dark:focus:text-accent-light/70">
                    {{ __('View All') }}
                </a>
            </div>
            <div class="mt-5">
                <div class="flex justify-between pb-2">
                    <p class="text-slate-700 dark:text-navy-100">{{ __('Pending') }}</p>
                    <p class="font-medium text-warning">{{ $kycStatusData['pending'] }}</p>
                </div>
                <div class="mt-2 h-2 w-full rounded-full bg-slate-150 dark:bg-navy-500">
                    @php
                    $totalKyc = array_sum($kycStatusData);
                    $pendingPercentage = $totalKyc > 0 ? ($kycStatusData['pending'] / $totalKyc) * 100 : 0;
                    @endphp
                    <div class="h-full rounded-full bg-warning" style="width: {{ $pendingPercentage }}%"></div>
                </div>

                <div class="flex justify-between pt-4 pb-2">
                    <p class="text-slate-700 dark:text-navy-100">{{ __('Approved') }}</p>
                    <p class="font-medium text-success">{{ $kycStatusData['approved'] }}</p>
                </div>
                <div class="mt-2 h-2 w-full rounded-full bg-slate-150 dark:bg-navy-500">
                    @php
                    $approvedPercentage = $totalKyc > 0 ? ($kycStatusData['approved'] / $totalKyc) * 100 : 0;
                    @endphp
                    <div class="h-full rounded-full bg-success" style="width: {{ $approvedPercentage }}%"></div>
                </div>

                <div class="flex justify-between pt-4 pb-2">
                    <p class="text-slate-700 dark:text-navy-100">{{ __('Rejected') }}</p>
                    <p class="font-medium text-error">{{ $kycStatusData['rejected'] }}</p>
                </div>
                <div class="mt-2 h-2 w-full rounded-full bg-slate-150 dark:bg-navy-500">
                    @php
                    $rejectedPercentage = $totalKyc > 0 ? ($kycStatusData['rejected'] / $totalKyc) * 100 : 0;
                    @endphp
                    <div class="h-full rounded-full bg-error" style="width: {{ $rejectedPercentage }}%"></div>
                </div>

                <div class="flex justify-between pt-4 pb-2">
                    <p class="text-slate-700 dark:text-navy-100">{{ __('Additional Info') }}</p>
                    <p class="font-medium text-info">{{ $kycStatusData['additional_info'] }}</p>
                </div>
                <div class="mt-2 h-2 w-full rounded-full bg-slate-150 dark:bg-navy-500">
                    @php
                    $additionalInfoPercentage = $totalKyc > 0 ? ($kycStatusData['additional_info'] / $totalKyc) * 100 :
                    0;
                    @endphp
                    <div class="h-full rounded-full bg-info" style="width: {{ $additionalInfoPercentage }}%"></div>
                </div>
                <div class="flex justify-between pt-4 pb-2">
                    <p class="text-slate-700 dark:text-navy-100">{{ __('KIV') }}</p>
                    <p class="font-medium text-purple-500">{{ $kycStatusData['kiv'] }}</p>
                </div>
                <div class="mt-2 h-2 w-full rounded-full bg-slate-150 dark:bg-navy-500">
                    @php
                    $kivPercentage = $totalKyc > 0 ? ($kycStatusData['kiv'] / $totalKyc) * 100 : 0;
                    @endphp
                    <div class="h-full rounded-full bg-purple-500" style="width: {{ $kivPercentage }}%"></div>
                </div>
            </div>
        </div>

        <!-- KYB Status -->
        <div class="card p-4 sm:p-5">
            <div class="flex items-center justify-between">
                <h2 class="font-medium tracking-wide text-slate-700 dark:text-navy-100">
                    {{ __('KYB Status') }}
                </h2>
                <a href="{{ route('admin.kyb.index') }}"
                    class="border-b border-dashed border-current pb-0.5 font-medium text-primary outline-none transition-colors duration-300 hover:text-primary/70 focus:text-primary/70 dark:text-accent-light dark:hover:text-accent-light/70 dark:focus:text-accent-light/70">
                    {{ __('View All') }}
                </a>
            </div>
            <div class="mt-5">
                <div class="flex justify-between pb-2">
                    <p class="text-slate-700 dark:text-navy-100">{{ __('Pending') }}</p>
                    <p class="font-medium text-warning">{{ $kybStatusData['pending'] }}</p>
                </div>
                <div class="mt-2 h-2 w-full rounded-full bg-slate-150 dark:bg-navy-500">
                    @php
                    $totalKyb = array_sum($kybStatusData);
                    $pendingPercentage = $totalKyb > 0 ? ($kybStatusData['pending'] / $totalKyb) * 100 : 0;
                    @endphp
                    <div class="h-full rounded-full bg-warning" style="width: {{ $pendingPercentage }}%"></div>
                </div>

                <div class="flex justify-between pt-4 pb-2">
                    <p class="text-slate-700 dark:text-navy-100">{{ __('Approved') }}</p>
                    <p class="font-medium text-success">{{ $kybStatusData['approved'] }}</p>
                </div>
                <div class="mt-2 h-2 w-full rounded-full bg-slate-150 dark:bg-navy-500">
                    @php
                    $approvedPercentage = $totalKyb > 0 ? ($kybStatusData['approved'] / $totalKyb) * 100 : 0;
                    @endphp
                    <div class="h-full rounded-full bg-success" style="width: {{ $approvedPercentage }}%"></div>
                </div>

                <div class="flex justify-between pt-4 pb-2">
                    <p class="text-slate-700 dark:text-navy-100">{{ __('Rejected') }}</p>
                    <p class="font-medium text-error">{{ $kybStatusData['rejected'] }}</p>
                </div>
                <div class="mt-2 h-2 w-full rounded-full bg-slate-150 dark:bg-navy-500">
                    @php
                    $rejectedPercentage = $totalKyb > 0 ? ($kybStatusData['rejected'] / $totalKyb) * 100 : 0;
                    @endphp
                    <div class="h-full rounded-full bg-error" style="width: {{ $rejectedPercentage }}%"></div>
                </div>

                <div class="flex justify-between pt-4 pb-2">
                    <p class="text-slate-700 dark:text-navy-100">{{ __('Additional Info') }}</p>
                    <p class="font-medium text-info">{{ $kybStatusData['additional_info'] }}</p>
                </div>
                <div class="mt-2 h-2 w-full rounded-full bg-slate-150 dark:bg-navy-500">
                    @php
                    $additionalInfoPercentage = $totalKyb > 0 ? ($kybStatusData['additional_info'] / $totalKyb) * 100 :
                    0;
                    @endphp
                    <div class="h-full rounded-full bg-info" style="width: {{ $additionalInfoPercentage }}%"></div>
                </div>

                <div class="flex justify-between pt-4 pb-2">
                    <p class="text-slate-700 dark:text-navy-100">{{ __('KIV') }}</p>
                    <p class="font-medium text-purple-500">{{ $kybStatusData['kiv'] }}</p>
                </div>
                <div class="mt-2 h-2 w-full rounded-full bg-slate-150 dark:bg-navy-500">
                    @php
                    $kivPercentage = $totalKyb > 0 ? ($kybStatusData['kiv'] / $totalKyb) * 100 : 0;
                    @endphp
                    <div class="h-full rounded-full bg-purple-500" style="width: {{ $kivPercentage }}%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="grid grid-cols-1 gap-4 sm:gap-5 lg:grid-cols-3 lg:gap-6 mb-5">
        <!-- Recent Transactions -->
        <div class="card p-4 sm:p-5">
            <div class="flex items-center justify-between">
                <h2 class="font-medium tracking-wide text-slate-700 dark:text-navy-100">
                    {{ __('Recent Transactions') }}
                </h2>
                <a href="{{ route('admin.transactions.index') }}"
                    class="border-b border-dashed border-current pb-0.5 font-medium text-primary outline-none transition-colors duration-300 hover:text-primary/70 focus:text-primary/70 dark:text-accent-light dark:hover:text-accent-light/70 dark:focus:text-accent-light/70">
                    {{ __('View All') }}
                </a>
            </div>
            <div class="mt-5 space-y-4">
                @forelse($recentTransactions as $transaction)
                <div class="flex items-center justify-between space-x-2">
                    <div class="flex items-center space-x-3">
                        <div class="avatar h-10 w-10">
                            <div
                                class="is-initial rounded-full bg-{{ $transaction->color }}/10 text-{{ $transaction->color }} dark:bg-{{ $transaction->color }}/10 dark:text-{{ $transaction->color }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M{{ $transaction->icon }}" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <p class="font-medium text-slate-700 dark:text-navy-100">
                                {{ ucfirst($transaction->type) }}
                            </p>
                            <p class="text-xs text-slate-400 dark:text-navy-300">
                                {{ $transaction->created_at->format('M d, Y H:i') }}
                            </p>
                        </div>
                    </div>
                    <p class="font-medium @if($transaction->amount < 0) text-error @else text-success @endif">
                        {{ $transaction->formatted_amount }}
                    </p>
                </div>
                @empty
                <div class="flex flex-col items-center justify-center py-5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-slate-300 dark:text-navy-300"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <p class="mt-2 text-slate-500 dark:text-navy-200">{{ __('No transactions found') }}</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Recent Users -->
        <div class="card p-4 sm:p-5">
            <div class="flex items-center justify-between">
                <h2 class="font-medium tracking-wide text-slate-700 dark:text-navy-100">
                    {{ __('Recent Users') }}
                </h2>
                <a href="{{ route('admin.users.index') }}"
                    class="border-b border-dashed border-current pb-0.5 font-medium text-primary outline-none transition-colors duration-300 hover:text-primary/70 focus:text-primary/70 dark:text-accent-light dark:hover:text-accent-light/70 dark:focus:text-accent-light/70">
                    {{ __('View All') }}
                </a>
            </div>
            <div class="mt-5 space-y-4">
                @forelse($recentUsers as $user)
                <div class="flex items-center justify-between space-x-2">
                    <div class="flex items-center space-x-3">
                        <div class="avatar h-10 w-10">
                            <div
                                class="is-initial rounded-full bg-primary/10 text-primary dark:bg-accent/10 dark:text-accent">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                        </div>
                        <div>
                            <p class="font-medium text-slate-700 dark:text-navy-100">
                                {{ $user->name }}
                            </p>
                            <p class="text-xs text-slate-400 dark:text-navy-300">
                                {{ $user->email }}
                            </p>
                        </div>
                    </div>
                    <p class="text-xs text-slate-400 dark:text-navy-300">
                        {{ $user->created_at->format('M d, Y') }}
                    </p>
                </div>
                @empty
                <div class="flex flex-col items-center justify-center py-5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-slate-300 dark:text-navy-300"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <p class="mt-2 text-slate-500 dark:text-navy-200">{{ __('No users found') }}</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Recent KYB Applications -->
        <div class="card p-4 sm:p-5">
            <div class="flex items-center justify-between">
                <h2 class="font-medium tracking-wide text-slate-700 dark:text-navy-100">
                    {{ __('Recent KYB Applications') }}
                </h2>
                <a href="{{ route('admin.kyb.index') }}"
                    class="border-b border-dashed border-current pb-0.5 font-medium text-primary outline-none transition-colors duration-300 hover:text-primary/70 focus:text-primary/70 dark:text-accent-light dark:hover:text-accent-light/70 dark:focus:text-accent-light/70">
                    {{ __('View All') }}
                </a>
            </div>
            <div class="mt-5 space-y-4">
                @forelse($recentKybApplications as $kyb)
                <div class="flex items-center justify-between space-x-2">
                    <div class="flex items-center space-x-3">
                        <div class="avatar h-10 w-10">
                            <div
                                class="is-initial rounded-full bg-primary/10 text-primary dark:bg-accent/10 dark:text-accent">
                                {{ substr($kyb->legal_name, 0, 1) }}
                            </div>
                        </div>
                        <div>
                            <p class="font-medium text-slate-700 dark:text-navy-100">
                                {{ $kyb->legal_name }}
                            </p>
                            <p class="text-xs text-slate-400 dark:text-navy-300">
                                {{ $kyb->user->email }}
                            </p>
                        </div>
                    </div>
                    <div>
                        @if($kyb->status === 'pending')
                        <div class="badge rounded-full bg-warning/10 text-warning dark:bg-warning/15">
                            {{ __('Pending') }}
                        </div>
                        @elseif($kyb->status === 'approved')
                        <div class="badge rounded-full bg-success/10 text-success dark:bg-success/15">
                            {{ __('Approved') }}
                        </div>
                        @elseif($kyb->status === 'rejected')
                        <div class="badge rounded-full bg-error/10 text-error dark:bg-error/15">
                            {{ __('Rejected') }}
                        </div>
                        @elseif($kyb->status === 'additional_info')
                        <div class="badge rounded-full bg-info/10 text-info dark:bg-info/15">
                            {{ __('Additional Info') }}
                        </div>
                        @endif
                    </div>
                </div>
                @empty
                <div class="flex flex-col items-center justify-center py-5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-slate-300 dark:text-navy-300"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <p class="mt-2 text-slate-500 dark:text-navy-200">{{ __('No KYB applications found') }}</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- JavaScript for Charts -->
    <script>
        document.addEventListener('livewire:load', function() {
            initializeCharts();
            Livewire.on('refreshDashboard', function() {
                initializeCharts();
            });
        });

        function initializeCharts() {
            // Transaction Chart
            const transactionData = @json($transactionData);

            if (document.getElementById('transactionChart')) {
                const options = {
                    series: [
                        {
                            name: 'Amount',
                            type: 'column',
                            data: transactionData.map(item => item.amount)
                        },
                        {
                            name: 'Count',
                            type: 'line',
                            data: transactionData.map(item => item.count)
                        }
                    ],
                    chart: {
                        height: 290,
                        type: 'line',
                        toolbar: {
                            show: false
                        }
                    },
                    colors: ['#1e40af', '#10b981'],
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: 'smooth',
                        width: [0, 3]
                    },
                    plotOptions: {
                        bar: {
                            columnWidth: '60%'
                        }
                    },
                    grid: {
                        borderColor: '#e0e0e0',
                        row: {
                            colors: ['transparent', 'transparent'],
                            opacity: 0.2
                        }
                    },
                    markers: {
                        size: 4
                    },
                    xaxis: {
                        categories: transactionData.map(item => item.date),
                        labels: {
                            style: {
                                colors: '#64748b'
                            }
                        }
                    },
                    yaxis: [
                        {
                            title: {
                                text: 'Amount',
                                style: {
                                    color: '#1e40af'
                                }
                            },
                            labels: {
                                style: {
                                    colors: '#64748b'
                                }
                            }
                        },
                        {
                            opposite: true,
                            title: {
                                text: 'Count',
                                style: {
                                    color: '#10b981'
                                }
                            },
                            labels: {
                                style: {
                                    colors: '#64748b'
                                }
                            }
                        }
                    ],
                    legend: {
                        position: 'top',
                        horizontalAlign: 'right',
                        floating: true,
                        offsetY: -25,
                        offsetX: -5
                    },
                    tooltip: {
                        theme: 'dark'
                    }
                };

                // Clear any existing charts
                document.getElementById('transactionChart').innerHTML = '';

                const chart = new ApexCharts(document.getElementById('transactionChart'), options);
                chart.render();
            }

            // User Growth Chart
            const userGrowthData = @json($userGrowthData);

            if (document.getElementById('userGrowthChart')) {
                const options = {
                    series: [
                        {
                            name: 'Daily Registrations',
                            type: 'column',
                            data: userGrowthData.map(item => item.daily)
                        },
                        {
                            name: 'Total Users',
                            type: 'line',
                            data: userGrowthData.map(item => item.cumulative)
                        }
                    ],
                    chart: {
                        height: 290,
                        type: 'line',
                        toolbar: {
                            show: false
                        }
                    },
                    colors: ['#f59e0b', '#3b82f6'],
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: 'smooth',
                        width: [0, 3]
                    },
                    plotOptions: {
                        bar: {
                            columnWidth: '60%'
                        }
                    },
                    grid: {
                        borderColor: '#e0e0e0',
                        row: {
                            colors: ['transparent', 'transparent'],
                            opacity: 0.2
                        }
                    },
                    markers: {
                        size: 4
                    },
                    xaxis: {
                        categories: userGrowthData.map(item => item.date),
                        labels: {
                            style: {
                                colors: '#64748b'
                            }
                        }
                    },
                    yaxis: [
                        {
                            title: {
                                text: 'Daily',
                                style: {
                                    color: '#f59e0b'
                                }
                            },
                            labels: {
                                style: {
                                    colors: '#64748b'
                                }
                            }
                        },
                        {
                            opposite: true,
                            title: {
                                text: 'Total',
                                style: {
                                    color: '#3b82f6'
                                }
                            },
                            labels: {
                                style: {
                                    colors: '#64748b'
                                }
                            }
                        }
                    ],
                    legend: {
                        position: 'top',
                        horizontalAlign: 'right',
                        floating: true,
                        offsetY: -25,
                        offsetX: -5
                    },
                    tooltip: {
                        theme: 'dark'
                    }
                };

                // Clear any existing charts
                document.getElementById('userGrowthChart').innerHTML = '';

                const chart = new ApexCharts(document.getElementById('userGrowthChart'), options);
                chart.render();
            }
        }
    </script>
</div>
