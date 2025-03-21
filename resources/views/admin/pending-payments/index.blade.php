<x-app-layout-sideblock title="Pending Payments" is-header-blur="true">
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        <!-- Toast Messages -->
        @php $messageTimeout = 5000; @endphp

        @if(session('toast'))
        @php
        $type = session('toast')['type'];
        $message = session('toast')['message'];
        @endphp

        @if($type === 'success')
        <div class="mb-4 rounded-lg bg-success px-4 py-3 text-white" x-data="{show: true}"
            x-init="setTimeout(() => { show = false }, {{ $messageTimeout }})" x-show="show"
            x-transition:enter="transition ease-out duration-2000" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-2000"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            {{ $message }}
        </div>
        @elseif($type === 'error')
        <div class="mb-4 rounded-lg bg-error px-4 py-3 text-white" x-data="{show: true}"
            x-init="setTimeout(() => { show = false }, {{ $messageTimeout }})" x-show="show"
            x-transition:enter="transition ease-out duration-2000" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-2000"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            {{ $message }}
        </div>
        @elseif($type === 'info')
        <div class="mb-4 rounded-lg bg-info px-4 py-3 text-white" x-data="{show: true}"
            x-init="setTimeout(() => { show = false }, {{ $messageTimeout }})" x-show="show"
            x-transition:enter="transition ease-out duration-2000" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-2000"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            {{ $message }}
        </div>
        @elseif($type === 'warning')
        <div class="mb-4 rounded-lg bg-warning px-4 py-3 text-white" x-data="{show: true}"
            x-init="setTimeout(() => { show = false }, {{ $messageTimeout }})" x-show="show"
            x-transition:enter="transition ease-out duration-2000" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-2000"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            {{ $message }}
        </div>
        @endif
        @endif

        <div class="flex items-center justify-between py-5 lg:py-6">
            <div class="flex items-center space-x-1">
                <h2 class="text-xl font-medium text-slate-700 line-clamp-1 dark:text-navy-50 lg:text-2xl">
                    Pending Payments
                </h2>
                <div x-data="usePopper({ placement: 'bottom-start', offset: 4 })"
                    @click.outside="if(isShowPopper) isShowPopper = false" class="inline-flex">
                    <button x-ref="popperRef" @click="isShowPopper = !isShowPopper"
                        class="btn h-8 w-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                        <i class="fas fa-info-circle"></i>
                    </button>

                    <div x-ref="popperRoot" class="popper-root" :class="isShowPopper && 'show'">
                        <div
                            class="popper-box w-72 rounded-lg border border-slate-150 bg-white shadow-soft dark:border-navy-600 dark:bg-navy-700">
                            <div class="p-3 font-medium">
                                <p>This page shows all pending payments in the system. You can filter by status,
                                    provider, user, and date range.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center space-x-2">
                <form action="{{ route('admin.pending-payments.index') }}" method="GET"
                    class="flex items-center space-x-2">
                    <label class="relative flex">
                        <input
                            class="form-input peer h-9 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 text-xs+ placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                            placeholder="Search by reference..." type="text" name="reference_id"
                            value="{{ request('reference_id') }}" />
                        <span
                            class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-colors duration-200"
                                fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M3.316 13.781l.73-.171-.73.171zm0-5.457l.73.171-.73-.171zm15.473 0l.73-.171-.73.171zm0 5.457l.73.171-.73-.171zm-5.008 5.008l-.171-.73.171.73zm-5.457 0l-.171.73.171-.73zm0-15.473l-.171-.73.171.73zm5.457 0l.171-.73-.171.73zM20.47 21.53a.75.75 0 101.06-1.06l-1.06 1.06zM4.046 13.61a11.198 11.198 0 010-5.115l-1.46-.342a12.698 12.698 0 000 5.8l1.46-.343zm14.013-5.115a11.196 11.196 0 010 5.115l1.46.342a12.698 12.698 0 000-5.8l-1.46.343zm-4.45 9.564a11.196 11.196 0 01-5.114 0l-.342 1.46c1.907.448 3.892.448 5.8 0l-.343-1.46zM8.496 4.046a11.198 11.198 0 015.115 0l.342-1.46a12.698 12.698 0 00-5.8 0l.343 1.46zm0 14.013a5.97 5.97 0 01-4.45-4.45l-1.46.343a7.47 7.47 0 005.568 5.568l.342-1.46zm5.457 1.46a7.47 7.47 0 005.568-5.567l-1.46-.342a5.97 5.97 0 01-4.45 4.45l.342 1.46zM13.61 4.046a5.97 5.97 0 014.45 4.45l1.46-.343a7.47 7.47 0 00-5.568-5.567l-.342 1.46zm-5.457-1.46a7.47 7.47 0 00-5.567 5.567l1.46.342a5.97 5.97 0 014.45-4.45l-.343-1.46zm8.652 15.28l3.665 3.664 1.06-1.06-3.665-3.665-1.06 1.06z" />
                            </svg>
                        </span>
                    </label>

                    <div class="flex">
                        <button
                            class="btn h-9 w-9 shrink-0 rounded-l-lg bg-primary p-0 font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>

                        <a href="{{ route('admin.pending-payments.index') }}"
                            class="btn h-9 w-9 shrink-0 rounded-r-lg bg-info p-0 font-medium text-white hover:bg-info-focus focus:bg-info-focus active:bg-info-focus/90">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-5 lg:grid-cols-3 lg:gap-6">
            <!-- Filter Card -->
            <div class="card p-4">
                <h2 class="text-lg font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 mb-3">
                    Filters
                </h2>
                <form action="{{ route('admin.pending-payments.index') }}" method="GET">
                    <div class="space-y-4">
                        <label class="block">
                            <span class="text-sm font-medium text-slate-600 dark:text-navy-100">Status</span>
                            <select name="status"
                                class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">
                                <option value="">All Statuses</option>
                                @foreach($statuses as $status)
                                <option value="{{ $status }}" {{ request('status')==$status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                                @endforeach
                            </select>
                        </label>

                        <label class="block">
                            <span class="text-sm font-medium text-slate-600 dark:text-navy-100">Provider</span>
                            <select name="provider"
                                class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">
                                <option value="">All Providers</option>
                                @foreach($providers as $provider)
                                <option value="{{ $provider }}" {{ request('provider')==$provider ? 'selected' : '' }}>
                                    {{ ucfirst($provider) }}
                                </option>
                                @endforeach
                            </select>
                        </label>

                        <label class="block">
                            <span class="text-sm font-medium text-slate-600 dark:text-navy-100">User</span>
                            <select name="user_id"
                                class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">
                                <option value="">All Users</option>
                                @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ request('user_id')==$user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                                @endforeach
                            </select>
                        </label>

                        <div class="grid grid-cols-2 gap-4">
                            <label class="block">
                                <span class="text-sm font-medium text-slate-600 dark:text-navy-100">Date From</span>
                                <input name="date_from" type="date" value="{{ request('date_from') }}"
                                    class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent">
                            </label>

                            <label class="block">
                                <span class="text-sm font-medium text-slate-600 dark:text-navy-100">Date To</span>
                                <input name="date_to" type="date" value="{{ request('date_to') }}"
                                    class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent">
                            </label>
                        </div>

                        <div class="flex justify-between pt-4">
                            <a href="{{ route('admin.pending-payments.index') }}"
                                class="btn space-x-2 bg-slate-150 font-medium text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">
                                <span>Reset</span>
                            </a>
                            <button type="submit"
                                class="btn space-x-2 bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                                <span>Apply Filters</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 gap-4 sm:col-span-1 sm:grid-cols-2 lg:col-span-2">
                <!-- Pending Payments -->
                <div class="card flex-row justify-between p-4">
                    <div>
                        <p class="text-xs+ uppercase">Pending</p>
                        <div class="mt-1 flex items-center space-x-2">
                            <p class="text-2xl font-semibold text-slate-700 dark:text-navy-100">
                                {{ \App\Models\PendingPayment::where('status', 'pending')->count() }}
                            </p>
                        </div>
                    </div>
                    <div class="mask is-squircle flex h-10 w-10 items-center justify-center bg-warning/10">
                        <i class="fa-solid fa-clock text-xl text-warning"></i>
                    </div>
                </div>

                <!-- Completed Payments -->
                <div class="card flex-row justify-between p-4">
                    <div>
                        <p class="text-xs+ uppercase">Completed</p>
                        <div class="mt-1 flex items-center space-x-2">
                            <p class="text-2xl font-semibold text-slate-700 dark:text-navy-100">
                                {{ \App\Models\PendingPayment::where('status', 'completed')->count() }}
                            </p>
                        </div>
                    </div>
                    <div class="mask is-squircle flex h-10 w-10 items-center justify-center bg-success/10">
                        <i class="fa-solid fa-check text-xl text-success"></i>
                    </div>
                </div>

                <!-- Failed Payments -->
                <div class="card flex-row justify-between p-4">
                    <div>
                        <p class="text-xs+ uppercase">Failed</p>
                        <div class="mt-1 flex items-center space-x-2">
                            <p class="text-2xl font-semibold text-slate-700 dark:text-navy-100">
                                {{ \App\Models\PendingPayment::where('status', 'failed')->count() }}
                            </p>
                        </div>
                    </div>
                    <div class="mask is-squircle flex h-10 w-10 items-center justify-center bg-error/10">
                        <i class="fa-solid fa-xmark text-xl text-error"></i>
                    </div>
                </div>

                <!-- Total Amount -->
                <div class="card flex-row justify-between p-4">
                    <div>
                        <p class="text-xs+ uppercase">Total Amount (MYR)</p>
                        <div class="mt-1 flex items-center space-x-2">
                            <p class="text-2xl font-semibold text-slate-700 dark:text-navy-100">
                                {{ number_format(\App\Models\PendingPayment::sum('amount'), 2) }}
                            </p>
                        </div>
                    </div>
                    <div class="mask is-squircle flex h-10 w-10 items-center justify-center bg-info/10">
                        <i class="fa-solid fa-money-bill-wave text-xl text-info"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="is-scrollbar-hidden min-w-full overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                            <th
                                class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100 lg:px-5">
                                #
                            </th>
                            <th
                                class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100 lg:px-5">
                                Reference ID
                            </th>
                            <th
                                class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100 lg:px-5">
                                User
                            </th>
                            <th
                                class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100 lg:px-5">
                                Provider
                            </th>
                            <th
                                class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100 lg:px-5">
                                Amount
                            </th>
                            <th
                                class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100 lg:px-5">
                                Status
                            </th>
                            <th
                                class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100 lg:px-5">
                                Created
                            </th>
                            <th
                                class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100 lg:px-5">
                                Last Checked
                            </th>
                            <th
                                class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100 lg:px-5">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pendingPayments as $payment)
                        <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">{{ $payment->id }}</td>
                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                <a href="{{ route('admin.pending-payments.show', $payment) }}"
                                    class="text-primary hover:text-primary-focus dark:text-accent-light dark:hover:text-accent">
                                    {{ $payment->reference_id }}
                                </a>
                            </td>
                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                @if($payment->user)
                                <div class="flex items-center space-x-2">
                                    <div class="avatar h-8 w-8">
                                        <img class="rounded-full" src="{{ $payment->user->avatar_url }}"
                                            alt="User avatar" />
                                    </div>
                                    <div>
                                        <p class="font-medium text-slate-700 dark:text-navy-100">
                                            {{ $payment->user->name }}
                                        </p>
                                        <p class="text-xs text-slate-400 dark:text-navy-300">
                                            {{ $payment->user->email }}
                                        </p>
                                    </div>
                                </div>
                                @else
                                <span class="text-error">User not found</span>
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                <div
                                    class="badge rounded-full bg-primary/10 text-primary dark:bg-accent-light/15 dark:text-accent-light">
                                    {{ ucfirst($payment->provider) }}
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                <p class="font-medium">MYR {{ number_format($payment->amount, 2) }}</p>
                            </td>
                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                @if($payment->status === 'pending')
                                <div class="badge rounded-full bg-warning/10 text-warning dark:bg-warning/15">
                                    Pending
                                </div>
                                @elseif($payment->status === 'completed')
                                <div class="badge rounded-full bg-success/10 text-success dark:bg-success/15">
                                    Completed
                                </div>
                                @elseif($payment->status === 'failed')
                                <div class="badge rounded-full bg-error/10 text-error dark:bg-error/15">
                                    Failed
                                </div>
                                @else
                                <div
                                    class="badge rounded-full bg-slate-100 text-slate-600 dark:bg-navy-500 dark:text-navy-100">
                                    {{ ucfirst($payment->status) }}
                                </div>
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                <p class="text-xs">{{ $payment->created_at->format('M d, Y') }}</p>
                                <p class="text-xs text-slate-400 dark:text-navy-300">{{
                                    $payment->created_at->format('h:i A') }}</p>
                            </td>
                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                @if($payment->last_checked_at)
                                <p class="text-xs">{{ $payment->last_checked_at->format('M d, Y') }}</p>
                                <p class="text-xs text-slate-400 dark:text-navy-300">{{
                                    $payment->last_checked_at->format('h:i A') }}</p>
                                @else
                                <p class="text-xs text-slate-400 dark:text-navy-300">Never</p>
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                <div class="flex justify-center space-x-2">
                                    <a href="{{ route('admin.pending-payments.show', $payment) }}"
                                        class="btn h-8 w-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                                        <i class="fa-solid fa-eye text-primary dark:text-accent-light"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-8">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fa-solid fa-search text-3xl text-slate-400 dark:text-navy-300 mb-3"></i>
                                    <p class="text-slate-500 dark:text-navy-200">No pending payments found</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div
                class="flex flex-col justify-between space-y-4 px-4 py-4 sm:flex-row sm:items-center sm:space-y-0 sm:px-5">
                <div class="text-xs+">
                    Showing {{ $pendingPayments->firstItem() ?? 0 }} to {{ $pendingPayments->lastItem() ?? 0 }} of {{
                    $pendingPayments->total() }} entries
                </div>
                {{ $pendingPayments->links() }}
            </div>
        </div>
    </main>
</x-app-layout-sideblock>
