<div>
    @if($showSetup)
    <!-- Setup/Edit Mode -->
    <div class="card">
        <div class="border-b border-slate-200 p-4 dark:border-navy-500 sm:px-5">
            <div class="flex items-center space-x-2">
                <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                    {{ $transferLimit ? 'Edit Transfer Limits' : 'Set Up Transfer Limits' }}
                </h2>
            </div>
            <p class="text-sm text-slate-500 dark:text-navy-300 mt-1">
                Configure your daily, monthly, and single transfer limits for security.
            </p>
        </div>

        <div class="p-4 sm:p-5">
            <form wire:submit.prevent="setupLimits">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-navy-100 mb-2">
                            Daily Limit (MYR)
                        </label>
                        <input type="number" wire:model="daily_limit" step="0.01" min="100" max="50000"
                            class="form-input w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                            placeholder="5000.00">
                        @error('daily_limit') 
                        <span class="text-error text-sm mt-1 block">{{ $message }}</span> 
                        @enderror
                        <p class="text-xs text-slate-500 dark:text-navy-300 mt-1">
                            Maximum amount you can transfer per day (100 - 50,000 MYR)
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-navy-100 mb-2">
                            Monthly Limit (MYR)
                        </label>
                        <input type="number" wire:model="monthly_limit" step="0.01" min="1000" max="500000"
                            class="form-input w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                            placeholder="50000.00">
                        @error('monthly_limit') 
                        <span class="text-error text-sm mt-1 block">{{ $message }}</span> 
                        @enderror
                        <p class="text-xs text-slate-500 dark:text-navy-300 mt-1">
                            Maximum amount you can transfer per month (1,000 - 500,000 MYR)
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-navy-100 mb-2">
                            Single Transfer Limit (MYR)
                        </label>
                        <input type="number" wire:model="single_transfer_limit" step="0.01" min="10" max="10000"
                            class="form-input w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                            placeholder="1000.00">
                        @error('single_transfer_limit') 
                        <span class="text-error text-sm mt-1 block">{{ $message }}</span> 
                        @enderror
                        <p class="text-xs text-slate-500 dark:text-navy-300 mt-1">
                            Maximum amount per single transfer (10 - 10,000 MYR)
                        </p>
                    </div>
                </div>

                <div class="mt-6 flex space-x-3">
                    <button type="submit"
                        class="btn bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                        {{ $transferLimit ? 'Update Limits' : 'Set Limits' }}
                    </button>
                    
                    @if($transferLimit)
                    <button type="button" wire:click="cancelSetup"
                        class="btn border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                        Cancel
                    </button>
                    @endif
                </div>
            </form>
        </div>
    </div>
    @else
    <!-- Display Mode -->
    <div class="card">
        <div class="border-b border-slate-200 p-4 dark:border-navy-500 sm:px-5">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                        Transfer Limits
                    </h2>
                    <p class="text-sm text-slate-500 dark:text-navy-300 mt-1">
                        Your current transfer limits and usage
                    </p>
                </div>
                <button wire:click="editLimits"
                    class="btn size-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="p-4 sm:p-5">
            @if(session('success'))
            <div class="mb-4 rounded-lg bg-success px-4 py-3 text-white">
                {{ session('success') }}
            </div>
            @endif

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <!-- Daily Limit -->
                <div class="rounded-lg bg-slate-100 p-4 dark:bg-navy-600">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-sm font-medium text-slate-700 dark:text-navy-100">Daily Limit</h3>
                        <span class="text-xs text-slate-500 dark:text-navy-300">
                            {{ number_format($transferLimit->remaining_daily_limit / 100, 2) }} MYR left
                        </span>
                    </div>
                    <div class="text-lg font-semibold text-slate-900 dark:text-navy-50">
                        {{ $transferLimit->formatted_daily_limit }} MYR
                    </div>
                    <div class="mt-2">
                        <div class="w-full bg-slate-200 rounded-full h-2 dark:bg-navy-500">
                            @php
                                $dailyUsedPercentage = $transferLimit->daily_limit > 0 ? 
                                    ($transferLimit->daily_used / $transferLimit->daily_limit) * 100 : 0;
                            @endphp
                            <div class="bg-primary h-2 rounded-full dark:bg-accent" 
                                 style="width: {{ min($dailyUsedPercentage, 100) }}%"></div>
                        </div>
                        <div class="text-xs text-slate-500 dark:text-navy-300 mt-1">
                            {{ number_format($transferLimit->daily_used / 100, 2) }} MYR used today
                        </div>
                    </div>
                </div>

                <!-- Monthly Limit -->
                <div class="rounded-lg bg-slate-100 p-4 dark:bg-navy-600">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-sm font-medium text-slate-700 dark:text-navy-100">Monthly Limit</h3>
                        <span class="text-xs text-slate-500 dark:text-navy-300">
                            {{ number_format($transferLimit->remaining_monthly_limit / 100, 2) }} MYR left
                        </span>
                    </div>
                    <div class="text-lg font-semibold text-slate-900 dark:text-navy-50">
                        {{ $transferLimit->formatted_monthly_limit }} MYR
                    </div>
                    <div class="mt-2">
                        <div class="w-full bg-slate-200 rounded-full h-2 dark:bg-navy-500">
                            @php
                                $monthlyUsedPercentage = $transferLimit->monthly_limit > 0 ? 
                                    ($transferLimit->monthly_used / $transferLimit->monthly_limit) * 100 : 0;
                            @endphp
                            <div class="bg-primary h-2 rounded-full dark:bg-accent" 
                                 style="width: {{ min($monthlyUsedPercentage, 100) }}%"></div>
                        </div>
                        <div class="text-xs text-slate-500 dark:text-navy-300 mt-1">
                            {{ number_format($transferLimit->monthly_used / 100, 2) }} MYR used this month
                        </div>
                    </div>
                </div>

                <!-- Single Transfer Limit -->
                <div class="rounded-lg bg-slate-100 p-4 dark:bg-navy-600">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-sm font-medium text-slate-700 dark:text-navy-100">Single Transfer</h3>
                        <span class="text-xs text-slate-500 dark:text-navy-300">
                            Per transaction
                        </span>
                    </div>
                    <div class="text-lg font-semibold text-slate-900 dark:text-navy-50">
                        {{ $transferLimit->formatted_single_transfer_limit }} MYR
                    </div>
                    <div class="text-xs text-slate-500 dark:text-navy-300 mt-3">
                        Maximum amount per single transfer
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
