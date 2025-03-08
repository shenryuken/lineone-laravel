<div>
    <!-- Transaction Type Cards -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-5 lg:grid-cols-4 lg:gap-6 mb-5">
        <div class="card p-4 sm:p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-lg font-semibold text-slate-700 dark:text-navy-100">
                        {{ $typeCounts['deposit'] }}
                    </p>
                    <p class="text-xs+ text-slate-400 dark:text-navy-300">
                        {{ __('Deposits') }}
                    </p>
                </div>
                <div class="mask is-squircle bg-success/10 p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-success" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <a href="#" wire:click.prevent="$set('type', 'deposit')"
                    class="border-b border-dashed border-current pb-0.5 font-medium text-success outline-none transition-colors duration-300 hover:text-success/70 focus:text-success/70">
                    {{ __('View Transactions') }}
                </a>
            </div>
        </div>

        <div class="card p-4 sm:p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-lg font-semibold text-slate-700 dark:text-navy-100">
                        {{ $typeCounts['withdrawal'] }}
                    </p>
                    <p class="text-xs+ text-slate-400 dark:text-navy-300">
                        {{ __('Withdrawals') }}
                    </p>
                </div>
                <div class="mask is-squircle bg-error/10 p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-error" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 10l7-7m0 0l7 7m-7-7v18" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <a href="#" wire:click.prevent="$set('type', 'withdrawal')"
                    class="border-b border-dashed border-current pb-0.5 font-medium text-error outline-none transition-colors duration-300 hover:text-error/70 focus:text-error/70">
                    {{ __('View Transactions') }}
                </a>
            </div>
        </div>

        <div class="card p-4 sm:p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-lg font-semibold text-slate-700 dark:text-navy-100">
                        {{ $typeCounts['transfer'] }}
                    </p>
                    <p class="text-xs+ text-slate-400 dark:text-navy-300">
                        {{ __('Transfers') }}
                    </p>
                </div>
                <div class="mask is-squircle bg-warning/10 p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-warning" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <a href="#" wire:click.prevent="$set('type', 'transfer')"
                    class="border-b border-dashed border-current pb-0.5 font-medium text-warning outline-none transition-colors duration-300 hover:text-warning/70 focus:text-warning/70">
                    {{ __('View Transactions') }}
                </a>
            </div>
        </div>

        <div class="card p-4 sm:p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-lg font-semibold text-slate-700 dark:text-navy-100">
                        {{ $typeCounts['payment'] }}
                    </p>
                    <p class="text-xs+ text-slate-400 dark:text-navy-300">
                        {{ __('Payments') }}
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
            <div class="mt-4">
                <a href="#" wire:click.prevent="$set('type', 'payment')"
                    class="border-b border-dashed border-current pb-0.5 font-medium text-info outline-none transition-colors duration-300 hover:text-info/70 focus:text-info/70">
                    {{ __('View Transactions') }}
                </a>
            </div>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="card p-4 sm:p-5 mb-5">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between">
            <div class="mb-4 sm:mb-0">
                <div class="relative w-full sm:w-72">
                    <input wire:model.debounce.300ms="search"
                        class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                        placeholder="Search by description, reference..." type="text" />
                    <span
                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5 transition-colors duration-200"
                            fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M3.316 13.781l.73-.171-.73.171zm0-5.457l.73.171-.73-.171zm15.473 0l.73-.171-.73.171zm0 5.457l.73.171-.73-.171zm-5.008 5.008l-.171-.73.171.73zm-5.457 0l-.171.73.171-.73zm0-15.473l-.171-.73.171.73zm5.457 0l.171-.73-.171.73zM20.47 21.53a.75.75 0 101.06-1.06l-1.06 1.06zM4.046 13.61a11.198 11.198 0 010-5.115l-1.46-.342a12.698 12.698 0 000 5.8l1.46-.343zm14.013-5.115a11.196 11.196 0 010 5.115l1.46.342a12.698 12.698 0 000-5.8l-1.46.343zm-4.45 9.564a11.196 11.196 0 01-5.114 0l-.342 1.46c1.907.448 3.892.448 5.8 0l-.343-1.46zM8.496 4.046a11.198 11.198 0 015.115 0l.342-1.46a12.698 12.698 0 00-5.8 0l.343 1.46zm0 14.013a5.97 5.97 0 01-4.45-4.45l-1.46.343a7.47 7.47 0 005.568 5.568l.342-1.46zm5.457 1.46a7.47 7.47 0 005.568-5.567l-1.46-.342a5.97 5.97 0 01-4.45 4.45l.342 1.46zM13.61 4.046a5.97 5.97 0 014.45 4.45l1.46-.343a7.47 7.47 0 00-5.568-5.567l-.342 1.46zm-5.457-1.46a7.47 7.47 0 00-5.567 5.567l1.46.342a5.97 5.97 0 014.45-4.45l-.343-1.46zm8.652 15.28l3.665 3.664 1.06-1.06-3.665-3.665-1.06 1.06z" />
                        </svg>
                    </span>
                </div>
            </div>
            <div class="flex flex-wrap items-center space-x-2 space-y-2 sm:space-y-0">
                <div>
                    <select wire:model="type"
                        class="form-select w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">
                        <option value="">{{ __('All Types') }}</option>
                        <option value="deposit">{{ __('Deposit') }}</option>
                        <option value="withdrawal">{{ __('Withdrawal') }}</option>
                        <option value="transfer">{{ __('Transfer') }}</option>
                        <option value="payment">{{ __('Payment') }}</option>
                        <option value="refund">{{ __('Refund') }}</option>
                    </select>
                </div>
                <div>
                    <select wire:model="status"
                        class="form-select w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">
                        <option value="">{{ __('All Statuses') }}</option>
                        <option value="pending">{{ __('Pending') }}</option>
                        <option value="completed">{{ __('Completed') }}</option>
                        <option value="failed">{{ __('Failed') }}</option>
                        <option value="cancelled">{{ __('Cancelled') }}</option>
                    </select>
                </div>
                <div>
                    <select wire:model="perPage"
                        class="form-select w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">
                        <option>10</option>
                        <option>25</option>
                        <option>50</option>
                        <option>100</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Transactions Table -->
    <div class="card">
        <div class="is-scrollbar-hidden min-w-full overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                        <th class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100">
                            <a href="#" wire:click.prevent="sortBy('created_at')" class="flex items-center">
                                {{ __('Date') }}
                                @if ($sortField === 'created_at')
                                @if ($sortDirection === 'asc')
                                <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-3 w-3" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 15l7-7 7 7" />
                                </svg>
                                @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-3 w-3" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                                @endif
                                @endif
                            </a>
                        </th>
                        <th class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100">
                            {{ __('Type') }}
                        </th>
                        <th class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100">
                            {{ __('Description') }}
                        </th>
                        <th class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100">
                            <a href="#" wire:click.prevent="sortBy('amount')" class="flex items-center">
                                {{ __('Amount') }}
                                @if ($sortField === 'amount')
                                @if ($sortDirection === 'asc')
                                <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-3 w-3" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 15l7-7 7 7" />
                                </svg>
                                @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-3 w-3" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                                @endif
                                @endif
                            </a>
                        </th>
                        <th class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100">
                            {{ __('Status') }}
                        </th>
                        <th class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100">
                            {{ __('Actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transactions as $transaction)
                    <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                            {{ $transaction->created_at->format('M d, Y H:i') }}
                        </td>
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                            <div class="flex items-center space-x-2">
                                <div class="avatar h-8 w-8">
                                    <div
                                        class="is-initial rounded-full bg-{{ $transaction->color }}/10 text-{{ $transaction->color }} dark:bg-{{ $transaction->color }}/10 dark:text-{{ $transaction->color }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M{{ $transaction->icon }}" />
                                        </svg>
                                    </div>
                                </div>
                                <span>{{ ucfirst($transaction->type) }}</span>
                            </div>
                        </td>
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                            {{ $transaction->description }}
                        </td>
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                            <span class="@if($transaction->amount < 0) text-error @else text-success @endif">
                                {{ $transaction->formatted_amount }}
                            </span>
                        </td>
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                            @if($transaction->status === 'pending')
                            <div class="badge rounded-full bg-warning/10 text-warning dark:bg-warning/15">
                                {{ __('Pending') }}
                            </div>
                            @elseif($transaction->status === 'completed')
                            <div class="badge rounded-full bg-success/10 text-success dark:bg-success/15">
                                {{ __('Completed') }}
                            </div>
                            @elseif($transaction->status === 'failed')
                            <div class="badge rounded-full bg-error/10 text-error dark:bg-error/15">
                                {{ __('Failed') }}
                            </div>
                            @elseif($transaction->status === 'cancelled')
                            <div
                                class="badge rounded-full bg-slate-100 text-slate-600 dark:bg-navy-700 dark:text-navy-100">
                                {{ __('Cancelled') }}
                            </div>
                            @endif
                        </td>
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                            <a href="{{ route('admin.transactions.show', $transaction) }}"
                                class="btn h-8 w-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center sm:px-5">
                            <div class="flex flex-col items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-16 w-16 text-slate-300 dark:text-navy-300" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p class="mt-2 text-slate-500 dark:text-navy-200">{{ __('No transactions found') }}</p>
                                @if($search || $type || $status)
                                <button wire:click="$set('search', ''); $set('type', ''); $set('status', '');"
                                    class="btn mt-4 bg-slate-150 font-medium text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">
                                    {{ __('Clear Filters') }}
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 sm:p-5">
            {{ $transactions->links() }}
        </div>
    </div>
</div>
