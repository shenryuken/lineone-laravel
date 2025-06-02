<x-app-layout-sideblock title="Transactions Details" is-header-blur="true">

    <main class="main-content w-full px-[var(--margin-x)] pb-8 py-12">
        <div class="card py-12 sm:p-5">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100">
                    {{ __('Transaction Information') }}
                </h3>
                <div
                    class="badge @if($transaction->status === 'completed') bg-success/10 text-success @elseif($transaction->status === 'pending') bg-warning/10 text-warning @elseif($transaction->status === 'failed') bg-error/10 text-error @else bg-slate-100 text-slate-600 @endif rounded-full px-3">
                    {{ ucfirst($transaction->status) }}
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div class="space-y-4">
                    <div>
                        <span class="text-xs+ text-slate-400 dark:text-navy-300">{{ __('Type') }}</span>
                        <p class="font-medium text-slate-700 dark:text-navy-100">{{ ucfirst($transaction->type) }}</p>
                    </div>
                    <div>
                        <span class="text-xs+ text-slate-400 dark:text-navy-300">{{ __('Amount') }}</span>
                        <p class="font-medium @if($transaction->amount < 0) text-error @else text-success @endif">
                            {{ $transaction->formatted_amount }}
                        </p>
                    </div>
                    <div>
                        <span class="text-xs+ text-slate-400 dark:text-navy-300">{{ __('Date') }}</span>
                        <p class="font-medium text-slate-700 dark:text-navy-100">{{ $transaction->created_at->format('M
                            d, Y H:i:s') }}</p>
                    </div>
                    <div>
                        <span class="text-xs+ text-slate-400 dark:text-navy-300">{{ __('Reference ID') }}</span>
                        <p class="font-medium text-slate-700 dark:text-navy-100">{{ $transaction->reference_id }}</p>
                    </div>
                </div>
                <div class="space-y-4">
                    <div>
                        <span class="text-xs+ text-slate-400 dark:text-navy-300">{{ __('Description') }}</span>
                        <p class="font-medium text-slate-700 dark:text-navy-100">{{ $transaction->description }}</p>
                    </div>
                    <div>
                        <span class="text-xs+ text-slate-400 dark:text-navy-300">{{ __('Wallet') }}</span>
                        <p class="font-medium text-slate-700 dark:text-navy-100">
                            {{ $transaction->wallet->account_number }} ({{ $transaction->wallet->currency }})
                        </p>
                    </div>
                    <div>
                        <span class="text-xs+ text-slate-400 dark:text-navy-300">{{ __('User') }}</span>
                        <p class="font-medium text-slate-700 dark:text-navy-100">
                            {{ $transaction->wallet->user->name }} ({{ $transaction->wallet->user->email }})
                        </p>
                    </div>
                    <div>
                        <span class="text-xs+ text-slate-400 dark:text-navy-300">{{ __('Balance Before') }}</span>
                        <p class="font-medium text-slate-700 dark:text-navy-100">
                            {{ number_format($transaction->balance_before / 100, 2) }}
                        </p>
                    </div>
                    <div>
                        <span class="text-xs+ text-slate-400 dark:text-navy-300">{{ __('Balance After') }}</span>
                        <p class="font-medium text-slate-700 dark:text-navy-100">
                            {{ number_format($transaction->balance_after / 100, 2) }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-app-layout-sideblock>
