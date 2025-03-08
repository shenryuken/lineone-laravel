<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center space-x-2">
                <a href="{{ route('admin.transactions.index') }}"
                    class="btn h-8 w-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
                <h2 class="text-xl font-medium text-slate-800 dark:text-navy-50">
                    {{ __('Transaction Details') }}
                </h2>
            </div>
            <div class="mt-3 sm:mt-0 flex items-center space-x-2">
                <span class="text-xs+ text-slate-400 dark:text-navy-300">
                    {{ __('Transaction ID') }}: {{ $transaction->reference_id }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 gap-4 sm:gap-5 lg:gap-6">
        <div class="card p-4 sm:p-5">
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
    </div>
</x-app-layout>
