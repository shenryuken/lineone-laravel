<div>
    <div class="card">
        <div class="border-b border-slate-200 p-4 dark:border-navy-500 sm:px-5">
            <div class="flex items-center space-x-2">
                <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                    Transfer Limits & Security
                </h2>
            </div>
        </div>

        <div class="p-4 sm:p-5">
            @if(session('success'))
            <div class="mb-4 rounded-lg bg-success px-4 py-3 text-white">
                {{ session('success') }}
            </div>
            @endif

            <!-- Current Usage -->
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3 mb-6">
                <div class="rounded-lg bg-slate-100 p-4 dark:bg-navy-600">
                    <h3 class="text-sm font-medium text-slate-700 dark:text-navy-100">Daily Usage</h3>
                    <div class="mt-2">
                        <div class="text-lg font-semibold">
                            {{ number_format($transferLimit->remaining_daily_limit / 100, 2) }} MYR
                        </div>
                        <div class="text-xs text-slate-500">
                            of {{ number_format($transferLimit->daily_limit / 100, 2) }} MYR remaining
                        </div>
                    </div>
                </div>

                <div class="rounded-lg bg-slate-100 p-4 dark:bg-navy-600">
                    <h3 class="text-sm font-medium text-slate-700 dark:text-navy-100">Monthly Usage</h3>
                    <div class="mt-2">
                        <div class="text-lg font-semibold">
                            {{ number_format($transferLimit->remaining_monthly_limit / 100, 2) }} MYR
                        </div>
                        <div class="text-xs text-slate-500">
                            of {{ number_format($transferLimit->monthly_limit / 100, 2) }} MYR remaining
                        </div>
                    </div>
                </div>

                <div class="rounded-lg bg-slate-100 p-4 dark:bg-navy-600">
                    <h3 class="text-sm font-medium text-slate-700 dark:text-navy-100">Single Transfer Limit</h3>
                    <div class="mt-2">
                        <div class="text-lg font-semibold">
                            {{ number_format($transferLimit->single_transfer_limit / 100, 2) }} MYR
                        </div>
                        <div class="text-xs text-slate-500">
                            Maximum per transaction
                        </div>
                    </div>
                </div>
            </div>

            <!-- Limit Settings -->
            <form wire:submit.prevent="updateLimits">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-navy-100">
                            Daily Limit (MYR)
                        </label>
                        <input type="number" wire:model="daily_limit" step="0.01" min="1" max="50000"
                            class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2">
                        @error('daily_limit') <span class="text-error text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-navy-100">
                            Monthly Limit (MYR)
                        </label>
                        <input type="number" wire:model="monthly_limit" step="0.01" min="1" max="500000"
                            class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2">
                        @error('monthly_limit') <span class="text-error text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-navy-100">
                            Single Transfer Limit (MYR)
                        </label>
                        <input type="number" wire:model="single_transfer_limit" step="0.01" min="1" max="10000"
                            class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2">
                        @error('single_transfer_limit') <span class="text-error text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit"
                        class="btn bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90">
                        Update Limits
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
