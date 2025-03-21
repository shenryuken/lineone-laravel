<x-app-layout-sideblock title="Pending Payment Details" is-header-blur="true">
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        <div class="flex items-center space-x-4 py-5 lg:py-6">
            <h2 class="text-xl font-medium text-slate-800 dark:text-navy-50 lg:text-2xl">
                Pending Payment Details
            </h2>
            <div class="hidden h-full py-1 sm:flex">
                <div class="h-full w-px bg-slate-300 dark:bg-navy-600"></div>
            </div>
            <ul class="hidden flex-wrap items-center space-x-2 sm:flex">
                <li class="flex items-center space-x-2">
                    <a class="text-primary transition-colors hover:text-primary-focus dark:text-accent-light dark:hover:text-accent"
                        href="{{ route('admin.pending-payments.index') }}">Pending Payments</a>
                    <svg x-ignore xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </li>
                <li>{{ $pendingPayment->reference_id }}</li>
            </ul>
        </div>

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

        <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
            <div class="col-span-12 lg:col-span-8">
                <div class="card p-4 sm:p-5">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                            Payment Information
                        </h2>
                        <div class="flex space-x-2">
                            @if($pendingPayment->status === 'pending')
                            <div class="badge rounded-full bg-warning/10 text-warning dark:bg-warning/15">
                                Pending
                            </div>
                            @elseif($pendingPayment->status === 'completed')
                            <div class="badge rounded-full bg-success/10 text-success dark:bg-success/15">
                                Completed
                            </div>
                            @elseif($pendingPayment->status === 'failed')
                            <div class="badge rounded-full bg-error/10 text-error dark:bg-error/15">
                                Failed
                            </div>
                            @else
                            <div
                                class="badge rounded-full bg-slate-100 text-slate-600 dark:bg-navy-500 dark:text-navy-100">
                                {{ ucfirst($pendingPayment->status) }}
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="mt-5 space-y-4">
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div class="card border border-slate-150 px-4 py-4 dark:border-navy-600 sm:px-5">
                                <div class="flex justify-between space-x-1">
                                    <p class="text-slate-700 dark:text-navy-100">Reference ID</p>
                                </div>
                                <p class="mt-1 text-base font-medium text-slate-700 dark:text-navy-100">
                                    {{ $pendingPayment->reference_id }}
                                </p>
                            </div>
                            <div class="card border border-slate-150 px-4 py-4 dark:border-navy-600 sm:px-5">
                                <div class="flex justify-between">
                                    <p class="text-slate-700 dark:text-navy-100">Amount</p>
                                </div>
                                <p class="mt-1 text-base font-medium text-slate-700 dark:text-navy-100">
                                    MYR {{ number_format($pendingPayment->amount, 2) }}
                                </p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                            <div class="card border border-slate-150 px-4 py-4 dark:border-navy-600 sm:px-5">
                                <div class="flex justify-between space-x-1">
                                    <p class="text-slate-700 dark:text-navy-100">Provider</p>
                                </div>
                                <p class="mt-1 text-base font-medium text-slate-700 dark:text-navy-100">
                                    {{ ucfirst($pendingPayment->provider) }}
                                </p>
                            </div>
                            <div class="card border border-slate-150 px-4 py-4 dark:border-navy-600 sm:px-5">
                                <div class="flex justify-between">
                                    <p class="text-slate-700 dark:text-navy-100">Created At</p>
                                </div>
                                <p class="mt-1 text-base font-medium text-slate-700 dark:text-navy-100">
                                    {{ $pendingPayment->created_at->format('M d, Y h:i A') }}
                                </p>
                            </div>
                            <div class="card border border-slate-150 px-4 py-4 dark:border-navy-600 sm:px-5">
                                <div class="flex justify-between">
                                    <p class="text-slate-700 dark:text-navy-100">Last Checked</p>
                                </div>
                                <p class="mt-1 text-base font-medium text-slate-700 dark:text-navy-100">
                                    {{ $pendingPayment->last_checked_at ? $pendingPayment->last_checked_at->format('M d,
                                    Y h:i A') : 'Never' }}
                                </p>
                            </div>
                        </div>

                        @if($transaction)
                        <div class="card border border-slate-150 px-4 py-4 dark:border-navy-600 sm:px-5">
                            <div class="flex justify-between space-x-1">
                                <p class="text-slate-700 dark:text-navy-100">Associated Transaction</p>
                            </div>
                            <div class="mt-3">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div
                                            class="flex h-10 w-10 items-center justify-center rounded-lg bg-success/10 dark:bg-success/15">
                                            <i class="fa-solid fa-check text-success"></i>
                                        </div>
                                        <div>
                                            <p class="font-medium text-slate-700 dark:text-navy-100">
                                                Transaction #{{ $transaction->id }}
                                            </p>
                                            <p class="text-xs text-slate-400 dark:text-navy-300">
                                                {{ $transaction->created_at->format('M d, Y h:i A') }}
                                            </p>
                                        </div>
                                    </div>
                                    <p class="font-medium text-slate-700 dark:text-navy-100">
                                        MYR {{ number_format($transaction->amount/100, 2) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="card border border-slate-150 px-4 py-4 dark:border-navy-600 sm:px-5">
                            <div class="flex justify-between space-x-1">
                                <p class="text-slate-700 dark:text-navy-100">User Information</p>
                            </div>
                            @if($pendingPayment->user)
                            <div class="mt-3">
                                <div class="flex items-center space-x-3">
                                    <div class="avatar h-12 w-12">
                                        <img class="rounded-full" src="{{ $pendingPayment->user->avatar_url }}"
                                            alt="User avatar" />
                                    </div>
                                    <div>
                                        <p class="font-medium text-slate-700 dark:text-navy-100">
                                            {{ $pendingPayment->user->name }}
                                        </p>
                                        <p class="text-xs+ text-slate-400 dark:text-navy-300">
                                            {{ $pendingPayment->user->email }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @else
                            <p class="mt-2 text-error">User not found</p>
                            @endif
                        </div>

                        <div class="card border border-slate-150 px-4 py-4 dark:border-navy-600 sm:px-5">
                            <div class="flex justify-between space-x-1">
                                <p class="text-slate-700 dark:text-navy-100">Wallet Information</p>
                            </div>
                            @if($pendingPayment->wallet)
                            <div class="mt-3">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-medium text-slate-700 dark:text-navy-100">
                                            {{ $pendingPayment->wallet->account_number }}
                                        </p>
                                        <p class="text-xs+ text-slate-400 dark:text-navy-300">
                                            {{ $pendingPayment->wallet->currency }} Wallet
                                        </p>
                                    </div>
                                    <p class="font-medium text-slate-700 dark:text-navy-100">
                                        Balance: MYR {{ number_format($pendingPayment->wallet->balance/100, 2) }}
                                    </p>
                                </div>
                            </div>
                            @else
                            <p class="mt-2 text-error">Wallet not found</p>
                            @endif
                        </div>

                        @if(!empty($pendingPayment->metadata))
                        <div class="card border border-slate-150 px-4 py-4 dark:border-navy-600 sm:px-5">
                            <div class="flex justify-between space-x-1">
                                <p class="text-slate-700 dark:text-navy-100">Metadata</p>
                            </div>
                            <div class="mt-3 overflow-x-auto">
                                <pre
                                    class="text-xs text-slate-600 dark:text-navy-100 bg-slate-100 dark:bg-navy-800 p-3 rounded-lg">{{ json_encode($pendingPayment->metadata, JSON_PRETTY_PRINT) }}</pre>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-span-12 lg:col-span-4">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-5 lg:grid-cols-1 lg:gap-6">
                    <!-- Actions Card -->
                    <div class="card p-4 sm:p-5">
                        <h2 class="text-lg font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100">
                            Actions
                        </h2>
                        <div class="mt-5 space-y-3">
                            <form action="{{ route('admin.pending-payments.check-status', $pendingPayment) }}"
                                method="POST">
                                @csrf
                                <button type="submit"
                                    class="btn w-full bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                                    <i class="fa-solid fa-sync mr-1"></i>
                                    Check Status with Provider
                                </button>
                            </form>

                            @if($pendingPayment->status === 'pending')
                            <form action="{{ route('admin.pending-payments.process-payment', $pendingPayment) }}"
                                method="POST" id="process-payment-form">
                                @csrf
                                <input type="hidden" name="confirm" value="1">
                                <input type="hidden" name="notes" id="process-notes" value="">
                                <button type="button" onclick="confirmProcessPayment()"
                                    class="btn w-full bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
                                    <i class="fa-solid fa-check mr-1"></i>
                                    Process Payment Manually
                                </button>
                            </form>
                            @endif

                            <button type="button" onclick="openStatusModal()"
                                class="btn w-full border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                                <i class="fa-solid fa-edit mr-1"></i>
                                Update Status
                            </button>

                            <a href="{{ route('admin.pending-payments.index') }}"
                                class="btn w-full border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                                <i class="fa-solid fa-arrow-left mr-1"></i>
                                Back to List
                            </a>
                        </div>
                    </div>

                    <!-- Status History Card -->
                    <div class="card p-4 sm:p-5">
                        <h2 class="text-lg font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100">
                            Status History
                        </h2>
                        <div class="mt-5">
                            <ol class="timeline max-w-sm [--size:1.5rem]">
                                <li class="timeline-item">
                                    <div class="timeline-item-point rounded-full bg-slate-300 dark:bg-navy-400"></div>
                                    <div class="timeline-item-content flex-1 pl-4 sm:pl-8">
                                        <div class="flex flex-col justify-between sm:flex-row sm:items-center">
                                            <p
                                                class="text-xs+ font-medium leading-none text-slate-600 dark:text-navy-100">
                                                Created
                                            </p>
                                            <span class="text-xs text-slate-400 dark:text-navy-300">{{
                                                $pendingPayment->created_at->format('M d, Y h:i A') }}</span>
                                        </div>
                                        <p class="mt-1 text-xs+ text-slate-500 dark:text-navy-200">
                                            Payment record created with status: <span class="font-medium">Pending</span>
                                        </p>
                                    </div>
                                </li>

                                @if($pendingPayment->last_checked_at)
                                <li class="timeline-item">
                                    <div class="timeline-item-point rounded-full bg-primary dark:bg-accent"></div>
                                    <div class="timeline-item-content flex-1 pl-4 sm:pl-8">
                                        <div class="flex flex-col justify-between sm:flex-row sm:items-center">
                                            <p
                                                class="text-xs+ font-medium leading-none text-slate-600 dark:text-navy-100">
                                                Last Checked
                                            </p>
                                            <span class="text-xs text-slate-400 dark:text-navy-300">{{
                                                $pendingPayment->last_checked_at->format('M d, Y h:i A') }}</span>
                                        </div>
                                        <p class="mt-1 text-xs+ text-slate-500 dark:text-navy-200">
                                            Payment status checked
                                        </p>
                                    </div>
                                </li>
                                @endif

                                @if($pendingPayment->status === 'completed')
                                <li class="timeline-item">
                                    <div class="timeline-item-point rounded-full bg-success"></div>
                                    <div class="timeline-item-content flex-1 pl-4 sm:pl-8">
                                        <div class="flex flex-col justify-between sm:flex-row sm:items-center">
                                            <p
                                                class="text-xs+ font-medium leading-none text-slate-600 dark:text-navy-100">
                                                Completed
                                            </p>
                                            <span class="text-xs text-slate-400 dark:text-navy-300">
                                                {{ isset($pendingPayment->metadata['completed_at']) ?
                                                \Carbon\Carbon::parse($pendingPayment->metadata['completed_at'])->format('M
                                                d, Y h:i A') : 'Unknown' }}
                                            </span>
                                        </div>
                                        <p class="mt-1 text-xs+ text-slate-500 dark:text-navy-200">
                                            Payment was successfully processed
                                        </p>
                                    </div>
                                </li>
                                @elseif($pendingPayment->status === 'failed')
                                <li class="timeline-item">
                                    <div class="timeline-item-point rounded-full bg-error"></div>
                                    <div class="timeline-item-content flex-1 pl-4 sm:pl-8">
                                        <div class="flex flex-col justify-between sm:flex-row sm:items-center">
                                            <p
                                                class="text-xs+ font-medium leading-none text-slate-600 dark:text-navy-100">
                                                Failed
                                            </p>
                                            <span class="text-xs text-slate-400 dark:text-navy-300">
                                                {{ isset($pendingPayment->metadata['failed_at']) ?
                                                \Carbon\Carbon::parse($pendingPayment->metadata['failed_at'])->format('M
                                                d, Y h:i A') : 'Unknown' }}
                                            </span>
                                        </div>
                                        <p class="mt-1 text-xs+ text-slate-500 dark:text-navy-200">
                                            Payment processing failed
                                            @if(isset($pendingPayment->metadata['error']))
                                            <br><span class="text-error">{{ $pendingPayment->metadata['error'] }}</span>
                                            @endif
                                        </p>
                                    </div>
                                </li>
                                @endif

                                @if(isset($pendingPayment->metadata['admin_notes']))
                                <li class="timeline-item">
                                    <div class="timeline-item-point rounded-full bg-info"></div>
                                    <div class="timeline-item-content flex-1 pl-4 sm:pl-8">
                                        <div class="flex flex-col justify-between sm:flex-row sm:items-center">
                                            <p
                                                class="text-xs+ font-medium leading-none text-slate-600 dark:text-navy-100">
                                                Admin Notes
                                            </p>
                                            <span class="text-xs text-slate-400 dark:text-navy-300">
                                                {{ isset($pendingPayment->metadata['updated_at']) ?
                                                \Carbon\Carbon::parse($pendingPayment->metadata['updated_at'])->format('M
                                                d, Y h:i A') : 'Unknown' }}
                                            </span>
                                        </div>
                                        <p class="mt-1 text-xs+ text-slate-500 dark:text-navy-200">
                                            {{ $pendingPayment->metadata['admin_notes'] }}
                                            @if(isset($pendingPayment->metadata['updated_by_admin']))
                                            <br><span class="text-xs italic">Updated by: {{
                                                $pendingPayment->metadata['updated_by_admin'] }}</span>
                                            @endif
                                        </p>
                                    </div>
                                </li>
                                @endif
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Update Status Modal -->
        <div id="update-status-modal"
            class="fixed inset-0 z-[100] flex items-center justify-center overflow-y-auto hidden"
            style="background-color: rgba(0,0,0,0.5);">
            <div class="card w-full max-w-lg p-5">
                <div class="flex justify-between">
                    <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100">
                        Update Payment Status
                    </h3>
                    <button onclick="closeStatusModal()"
                        class="btn -mr-1.5 h-7 w-7 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <form action="{{ route('admin.pending-payments.update-status', $pendingPayment) }}" method="POST"
                    class="mt-4">
                    @csrf
                    <div class="space-y-4">
                        <label class="block">
                            <span class="font-medium text-slate-600 dark:text-navy-100">Status</span>
                            <select name="status"
                                class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">
                                <option value="pending" {{ $pendingPayment->status === 'pending' ? 'selected' : ''
                                    }}>Pending</option>
                                <option value="completed" {{ $pendingPayment->status === 'completed' ? 'selected' : ''
                                    }}>Completed</option>
                                <option value="failed" {{ $pendingPayment->status === 'failed' ? 'selected' : ''
                                    }}>Failed</option>
                            </select>
                        </label>

                        <label class="block">
                            <span class="font-medium text-slate-600 dark:text-navy-100">Notes</span>
                            <textarea name="notes" rows="3"
                                class="form-textarea mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent p-2.5 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"></textarea>
                        </label>

                        <div class="flex justify-end space-x-2">
                            <button type="button" onclick="closeStatusModal()"
                                class="btn min-w-[7rem] border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                                Cancel
                            </button>
                            <button type="submit"
                                class="btn min-w-[7rem] bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                                Update
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Process Payment Confirmation Modal -->
        <div id="process-payment-modal"
            class="fixed inset-0 z-[100] flex items-center justify-center overflow-y-auto hidden"
            style="background-color: rgba(0,0,0,0.5);">
            <div class="card w-full max-w-lg p-5">
                <div class="flex justify-between">
                    <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100">
                        Confirm Manual Processing
                    </h3>
                    <button onclick="closeProcessModal()"
                        class="btn -mr-1.5 h-7 w-7 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="mt-4">
                    <div class="alert flex rounded-lg bg-warning/15 py-4 px-4 text-warning dark:bg-warning/20">
                        <div class="flex flex-1 items-center space-x-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <div class="flex-1">
                                <p class="font-medium">Warning!</p>
                                <p class="mt-1 text-sm">
                                    You are about to manually process this payment. This will create a transaction and
                                    credit the user's wallet with MYR {{ number_format($pendingPayment->amount, 2) }}.
                                    This action cannot be undone.
                                </p>
                            </div>
                        </div>
                    </div>

                    <label class="mt-4 block">
                        <span class="font-medium text-slate-600 dark:text-navy-100">Notes (Optional)</span>
                        <textarea id="confirm-notes" rows="3"
                            class="form-textarea mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent p-2.5 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"></textarea>
                    </label>

                    <div class="mt-4 flex justify-end space-x-2">
                        <button type="button" onclick="closeProcessModal()"
                            class="btn min-w-[7rem] border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                            Cancel
                        </button>
                        <button type="button" onclick="submitProcessPayment()"
                            class="btn min-w-[7rem] bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
                            Confirm Processing
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function openStatusModal() {
                document.getElementById('update-status-modal').classList.remove('hidden');
            }

            function closeStatusModal() {
                document.getElementById('update-status-modal').classList.add('hidden');
            }

            function confirmProcessPayment() {
                document.getElementById('process-payment-modal').classList.remove('hidden');
            }

            function closeProcessModal() {
                document.getElementById('process-payment-modal').classList.add('hidden');
            }

            function submitProcessPayment() {
                const notes = document.getElementById('confirm-notes').value;
                document.getElementById('process-notes').value = notes;
                document.getElementById('process-payment-form').submit();
            }
        </script>
    </main>
</x-app-layout-sideblock>