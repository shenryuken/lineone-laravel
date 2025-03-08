<div>
    <div class="flex items-center justify-between">
        <h2 class="text-base font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100">
            Transaction History
        </h2>
    </div>

    <div class="card mt-3">
        <div
            class="flex flex-col items-center justify-between space-y-4 border-b border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:space-y-0 sm:px-5">
            <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                Transactions
            </h2>
            <div class="flex justify-center space-x-2">
                <div class="flex items-center" x-data="{isInputActive:false}">
                    <label class="block">
                        <input wire:model.live.debounce.300ms="search"
                            x-effect="isInputActive === true && $nextTick(() => { $el.focus()});"
                            :class="isInputActive ? 'w-32 lg:w-48' : 'w-0'"
                            class="form-input bg-transparent px-1 text-right transition-all duration-100 placeholder:text-slate-500 dark:placeholder:text-navy-200"
                            placeholder="Search..." type="text" />
                    </label>
                    <button @click="isInputActive = !isInputActive"
                        class="btn size-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4.5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div class="p-4 sm:p-5">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-4">
                <label class="block">
                    <span class="text-sm-plus font-medium text-slate-700 dark:text-navy-100">Period</span>
                    <select wire:model.live="period"
                        class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">
                        <option value="7">Last 7 Days</option>
                        <option value="30">Last 30 Days</option>
                        <option value="60">Last 60 Days</option>
                        <option value="90">Last 90 Days</option>
                        <option value="">All Time</option>
                    </select>
                </label>

                <label class="block">
                    <span class="text-sm-plus font-medium text-slate-700 dark:text-navy-100">Wallet</span>
                    <select wire:model.live="wallet_id"
                        class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">
                        <option value="">All Wallets</option>
                        @foreach($wallets as $wallet)
                        <option value="{{ $wallet->id }}">{{ $wallet->currency }} Wallet ({{ $wallet->account_number }})
                        </option>
                        @endforeach
                    </select>
                </label>

                <label class="block">
                    <span class="text-sm-plus font-medium text-slate-700 dark:text-navy-100">Type</span>
                    <select wire:model.live="type"
                        class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">
                        <option value="">All Types</option>
                        @foreach($transactionTypes as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </label>

                <label class="block">
                    <span class="text-sm-plus font-medium text-slate-700 dark:text-navy-100">Status</span>
                    <select wire:model.live="status"
                        class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">
                        <option value="">All Statuses</option>
                        @foreach($transactionStatuses as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </label>
            </div>

            <div class="mt-4">
                <div class="is-scrollbar-hidden min-w-full overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                <th
                                    class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100 lg:px-5">
                                    Date
                                </th>
                                <th
                                    class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100 lg:px-5">
                                    Description
                                </th>
                                <th
                                    class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100 lg:px-5">
                                    Type
                                </th>
                                <th
                                    class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100 lg:px-5">
                                    Amount
                                </th>
                                <th
                                    class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100 lg:px-5">
                                    Status
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $transaction)
                            <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                <td
                                    class="whitespace-nowrap px-3 py-3 font-medium text-slate-700 dark:text-navy-100 lg:px-5">
                                    {{ $transaction->created_at->format('M d, Y H:i') }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-3 lg:px-5">
                                    {{ $transaction->description }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-3 lg:px-5">
                                    <div
                                        class="badge rounded-full bg-primary/10 text-primary dark:bg-accent-light/15 dark:text-accent-light">
                                        {{ ucfirst($transaction->type) }}
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-3 py-3 lg:px-5">
                                    <span
                                        class="{{ $transaction->color === 'success' ? 'text-success' : 'text-error' }}">
                                        {{ $transaction->formatted_amount }} {{ $transaction->currency }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-3 py-3 lg:px-5">
                                    <div class="badge rounded-full
                                            @if($transaction->status === 'completed')
                                                bg-success/10 text-success dark:bg-success/15
                                            @elseif($transaction->status === 'pending')
                                                bg-warning/10 text-warning dark:bg-warning/15
                                            @elseif($transaction->status === 'failed')
                                                bg-error/10 text-error dark:bg-error/15
                                            @else
                                                bg-slate-100 text-slate-500 dark:bg-navy-500 dark:text-navy-200
                                            @endif
                                        ">
                                        {{ ucfirst($transaction->status) }}
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-3 py-8 text-center">
                                    <p class="text-slate-400 dark:text-navy-300">No transactions found</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $transactions->links('vendor.pagination.tailwind') }}
                </div>
            </div>
        </div>
    </div>
</div>
