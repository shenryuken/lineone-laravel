<div class="card p-4 sm:p-5">
    <div class="flex items-center justify-between">
        <h2 class="text-base font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100">
            Latest Transactions
        </h2>
        <a href="{{ route('transactions.history') }}"
            class="border-b border-dashed border-current pb-0.5 text-xs-plus font-medium text-primary outline-none transition-colors duration-300 hover:text-primary/70 focus:text-primary/70 dark:text-accent-light dark:hover:text-accent-light/70 dark:focus:text-accent-light/70">
            View All
        </a>
    </div>

    <div class="mt-3 space-y-4">
        @forelse($transactions as $transaction)
        <div class="flex items-center justify-between space-x-2">
            <div class="flex items-center space-x-3">
                <div
                    class="flex size-10 items-center justify-center rounded-full bg-{{ $transaction->color }}/10 text-{{ $transaction->color }} dark:bg-{{ $transaction->color }}/15">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.5">
                        @if($transaction->icon === 'arrow-down')
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                        @elseif($transaction->icon === 'arrow-up')
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                        @elseif($transaction->icon === 'credit-card')
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        @elseif($transaction->icon === 'refresh-cw')
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        @else
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        @endif
                    </svg>
                </div>
                <div>
                    <p class="font-medium text-slate-700 dark:text-navy-100">
                        {{ ucfirst($transaction->type) }}
                    </p>
                    <p class="text-xs text-slate-400 line-clamp-1 dark:text-navy-300">
                        {{ $transaction->description }}
                    </p>
                </div>
            </div>
            <div class="flex items-center space-x-2">
                <p class="font-medium {{ $transaction->isNegative() ? 'text-error' : 'text-success' }}">
                    {{ $transaction->isNegative() ? '-' : '+' }}{{ $transaction->formatted_amount }}
                </p>
                <p class="text-xs text-slate-400 dark:text-navy-300">
                    {{ $transaction->created_at->format('M d') }}
                </p>
            </div>
        </div>
        @empty
        <div class="flex justify-center py-8">
            <p class="text-slate-400 dark:text-navy-300">No transactions found</p>
        </div>
        @endforelse
    </div>
</div>
