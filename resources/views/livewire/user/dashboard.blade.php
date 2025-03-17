@php
/*
<div class="mt-4">
    @if(session('toast'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
        class="fixed top-4 right-4 z-50 rounded-lg px-4 py-3 shadow-lg transition-all duration-300 ease-in-out {{ session('toast.type') === 'success' ? 'bg-emerald-500' : 'bg-red-500' }} text-white">
        {{ session('toast.message') }}
    </div>
    @endif

    <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
        <!-- User Welcome & Quick Stats -->
        <div class="col-span-12 lg:col-span-4">
            <div class="card p-4 sm:p-5">
                <div class="flex items-center space-x-4">
                    <div class="avatar h-14 w-14">
                        <div
                            class="is-initial rounded-full bg-primary/10 text-primary dark:bg-accent-light/10 dark:text-accent-light">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    </div>
                    <div>
                        <h3 class="text-base font-medium text-slate-700 dark:text-navy-100">
                            Welcome, {{ Auth::user()->name }}
                        </h3>
                        <p class="text-xs+ text-slate-400 dark:text-navy-300">
                            Account Type: <span
                                class="font-medium {{ Auth::user()->role === 'merchant' ? 'text-amber-500' : 'text-emerald-500' }}">
                                {{ Auth::user()->role === 'merchant' ? 'Business' : 'Personal' }}
                            </span>
                        </p>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="mt-5 grid grid-cols-2 gap-3">
                    <div class="rounded-lg bg-slate-100 p-3 dark:bg-navy-600">
                        <div class="flex justify-between space-x-1">
                            <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">
                                {{ $walletCurrency }} {{ number_format($walletBalance/100, 2) }}
                            </p>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary dark:text-accent"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                            </svg>
                        </div>
                        <p class="mt-1 text-xs+ text-slate-500 dark:text-navy-300">
                            Balance
                        </p>
                    </div>
                    <div class="rounded-lg bg-slate-100 p-3 dark:bg-navy-600">
                        <div class="flex justify-between">
                            <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">
                                {{ Auth::user()->wallets->count() }}
                            </p>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-success" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <p class="mt-1 text-xs+ text-slate-500 dark:text-navy-300">
                            Wallets
                        </p>
                    </div>
                </div>

                <!-- Wallet Account Info -->
                <div class="mt-5">
                    <div
                        class="rounded-lg bg-gradient-to-r from-primary to-primary-focus p-4 text-white dark:from-accent dark:to-accent-focus">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium">Primary Wallet</p>
                            <div class="avatar h-8 w-8">
                                <div class="is-initial rounded-full bg-white/20 text-white">
                                    {{ $walletCurrency }}
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <p class="text-lg font-semibold">{{ $walletCurrency }} {{ number_format($walletBalance/100,
                                2) }}</p>
                            <div class="flex items-center space-x-1 text-xs">
                                <p id="clipboardContent1" class="line-clamp-1">{{ $walletAccountNumber }}</p>
                                <button
                                    class="btn h-5 w-5 rounded-full p-0 text-white hover:bg-white/20 focus:bg-white/20"
                                    @click="$clipboard({
                                        content:document.querySelector('#clipboardContent1').innerText,
                                        success:()=>$notification({text:'Account Number Copied',variant:'success'}),
                                        error:()=>$notification({text:'Error',variant:'error'})
                                    })">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path d="M7 9a2 2 0 012-2h6a2 2 0 012 2v6a2 2 0 01-2 2H9a2 2 0 01-2-2V9z" />
                                        <path d="M5 3a2 2 0 00-2 2v6a2 2 0 002 2V5h8a2 2 0 00-2-2H5z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-5 grid grid-cols-3 gap-3">
                    <button wire:click="deposit({{ Auth::user()->wallet()->id }})"
                        class="btn h-10 w-full bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>Deposit</span>
                    </button>
                    <button wire:click="transfer"
                        class="btn h-10 w-full bg-slate-150 font-medium text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                        </svg>
                        <span>Transfer</span>
                    </button>
                    <button wire:click="withdraw({{ Auth::user()->wallet()->id }})"
                        class="btn h-10 w-full bg-slate-150 font-medium text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"
                                transform="rotate(45 12 12)" />
                        </svg>
                        <span>Withdraw</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Transaction History -->
        <div class="col-span-12 lg:col-span-8">
            <div class="card p-4 sm:p-5">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                        Transaction History
                    </h2>
                    <div class="flex space-x-2">
                        <div class="flex items-center space-x-2">
                            <div class="h-3 w-3 rounded-full bg-success"></div>
                            <p class="text-xs text-slate-400 dark:text-navy-300">Income</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <div class="h-3 w-3 rounded-full bg-error"></div>
                            <p class="text-xs text-slate-400 dark:text-navy-300">Expense</p>
                        </div>
                    </div>
                </div>

                <div class="mt-5">
                    <livewire:transactions.latest-transactions wire:key="latest-transactions-{{ now() }}" />
                </div>
            </div>
        </div>
    </div>

    <!-- Transfer Modal -->
    @if($showTransferModal)
    <div
        class="fixed inset-0 z-[100] flex items-center justify-center overflow-y-auto bg-slate-900/60 dark:bg-navy-900/60">
        <div class="w-full max-w-lg p-3 sm:p-5">
            <div class="card bg-white dark:bg-navy-700">
                <div class="flex justify-between p-4 sm:p-5">
                    <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100">
                        Transfer Funds
                    </h3>
                    <button wire:click="closeTransferModal"
                        class="btn -mr-1.5 h-7 w-7 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="p-4 sm:p-5">
                    @if($selectedWalletId)
                    <livewire:wallets.transfer :wallet="App\Models\Wallet::find($selectedWalletId)"
                        :key="'transfer-form-'.$selectedWalletId" />
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Withdraw Modal -->
    @if($showWithdrawModal)
    <div
        class="fixed inset-0 z-[100] flex items-center justify-center overflow-y-auto bg-slate-900/60 dark:bg-navy-900/60">
        <div class="w-full max-w-lg p-3 sm:p-5">
            <div class="card bg-white dark:bg-navy-700">
                <div class="flex justify-between p-4 sm:p-5">
                    <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100">
                        Withdraw Funds
                    </h3>
                    <button wire:click="closeWithdrawModal"
                        class="btn -mr-1.5 h-7 w-7 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="p-4 sm:p-5">
                    @if($selectedWalletId)
                    <livewire:wallets.withdraw :wallet="App\Models\Wallet::find($selectedWalletId)"
                        :key="'withdraw-form-'.$selectedWalletId" />
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Deposit Modal -->
    @if($showDepositModal)
    <div
        class="fixed inset-0 z-[100] flex items-center justify-center overflow-y-auto bg-slate-900/60 dark:bg-navy-900/60">
        <div class="w-full max-w-lg p-3 sm:p-5">
            <div class="card bg-white dark:bg-navy-700">
                <div class="flex justify-between p-4 sm:p-5">
                    <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100">
                        Deposit Funds
                    </h3>
                    <button wire:click="closeDepositModal"
                        class="btn -mr-1.5 h-7 w-7 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="p-4 sm:p-5">
                    @if($selectedWalletId)
                    <livewire:wallets.deposit :wallet="App\Models\Wallet::find($selectedWalletId)"
                        :key="'deposit-form-'.$selectedWalletId" />
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
*/
@endphp
<div class="mt-4">
    @if(session('toast'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
        class="fixed top-4 right-4 z-50 rounded-lg px-4 py-3 shadow-lg transition-all duration-300 ease-in-out {{ session('toast.type') === 'success' ? 'bg-emerald-500' : 'bg-red-500' }} text-white">
        {{ session('toast.message') }}
    </div>
    @endif

    <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
        <!-- User Welcome & Quick Stats -->
        <div class="col-span-12 lg:col-span-4">
            <div class="card p-4 sm:p-5">
                {{-- <div class="flex items-center space-x-4">
                    <div class="avatar h-14 w-14">
                        <div
                            class="is-initial rounded-full bg-primary/10 text-primary dark:bg-accent-light/10 dark:text-accent-light">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    </div>
                    <div>
                        <h3 class="text-base font-medium text-slate-700 dark:text-navy-100">
                            Welcome, {{ Auth::user()->name }}
                        </h3>
                        <p class="text-xs+ text-slate-400 dark:text-navy-300">
                            Account Type: <span
                                class="font-medium {{ Auth::user()->role === 'merchant' ? 'text-amber-500' : 'text-emerald-500' }}">
                                {{ Auth::user()->hasRole('merchant') ? 'Business' : 'Personal' }}
                            </span>
                        </p>
                    </div>
                </div> --}}
                <div class="flex items-center space-x-4">
                    <div class="avatar h-14 w-14">
                        <div class="is-initial rounded-full bg-primary/10 text-primary dark:bg-accent-light/10 dark:text-accent-light">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center gap-2">
                            <h3 class="text-base font-medium text-slate-700 dark:text-navy-100">
                                Welcome, {{ Auth::user()->name }}
                            </h3>
                            @if(Auth::user()->kyc_status === 'approved')
                            <div class="flex h-6 w-6 items-center justify-center rounded-full bg-success/10">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-success" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            @endif
                        </div>
                        <p class="text-xs+ text-slate-400 dark:text-navy-300">
                            Account Type: <span
                                class="font-medium {{ Auth::user()->role === 'merchant' ? 'text-amber-500' : 'text-emerald-500' }}">
                                {{ Auth::user()->hasRole('merchant') ? 'Business' : 'Personal' }}
                            </span>
                        </p>
                    </div>
                </div>

                <!-- KYC Status -->
                {{-- <div class="mt-5">
                    <div class="rounded-lg border border-slate-300 p-3 dark:border-navy-450">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-full
                                    @if(Auth::user()->kyc_status === 'approved') bg-success/10 text-success
                                    @elseif(Auth::user()->kyc_status === 'pending') bg-warning/10 text-warning
                                    @elseif(Auth::user()->kyc_status === 'rejected') bg-error/10 text-error
                                    @else bg-slate-100 text-slate-600 dark:bg-navy-500 dark:text-navy-100 @endif">
                                    @if(Auth::user()->kyc_status === 'approved')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                    @elseif(Auth::user()->kyc_status === 'pending')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    @elseif(Auth::user()->kyc_status === 'rejected')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                    @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                    </svg>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-sm+ font-medium text-slate-700 dark:text-navy-100">
                                        KYC Verification
                                    </p>
                                    <p class="text-xs text-slate-400 dark:text-navy-300">
                                        @if(Auth::user()->kyc_status === 'approved')
                                        Verified
                                        @elseif(Auth::user()->kyc_status === 'pending')
                                        Pending Verification
                                        @elseif(Auth::user()->kyc_status === 'rejected')
                                        Verification Failed
                                        @else
                                        Not Verified
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div>
                                @if(Auth::user()->kyc_status === 'approved')
                                <a href="{{ route('kyc.status') }}"
                                    class="btn h-8 rounded bg-slate-150 px-3 text-xs+ font-medium text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">
                                    View
                                </a>
                                @elseif(Auth::user()->kyc_status === 'pending')
                                <a href="{{ route('kyc.status') }}"
                                    class="btn h-8 rounded bg-slate-150 px-3 text-xs+ font-medium text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">
                                    Check Status
                                </a>
                                @elseif(Auth::user()->kyc_status === 'rejected')
                                <a href="{{ route('kyc.apply') }}"
                                    class="btn h-8 rounded bg-primary px-3 text-xs+ font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                                    Reapply
                                </a>
                                @else
                                <a href="{{ route('kyc.apply') }}"
                                    class="btn h-8 rounded bg-primary px-3 text-xs+ font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                                    Verify Now
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div> --}}
                <!-- KYC Status - Only show if not approved -->
                @if(Auth::user()->kyc_status !== 'approved')
                <div class="mt-5">
                    <div class="rounded-lg border border-slate-300 p-3 dark:border-navy-450">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-full
                                            @if(Auth::user()->kyc_status === 'pending') bg-warning/10 text-warning
                                            @elseif(Auth::user()->kyc_status === 'rejected') bg-error/10 text-error
                                            @else bg-slate-100 text-slate-600 dark:bg-navy-500 dark:text-navy-100 @endif">
                                    @if(Auth::user()->kyc_status === 'pending')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    @elseif(Auth::user()->kyc_status === 'rejected')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                    @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                    </svg>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-sm+ font-medium text-slate-700 dark:text-navy-100">
                                        KYC Verification
                                    </p>
                                    <p class="text-xs text-slate-400 dark:text-navy-300">
                                        @if(Auth::user()->kyc_status === 'pending')
                                        Pending Verification
                                        @elseif(Auth::user()->kyc_status === 'rejected')
                                        Verification Failed
                                        @else
                                        Not Verified
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div>
                                @if(Auth::user()->kyc_status === 'pending')
                                <a href="{{ route('kyc.status') }}"
                                    class="btn h-8 rounded bg-slate-150 px-3 text-xs+ font-medium text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">
                                    Check Status
                                </a>
                                @elseif(Auth::user()->kyc_status === 'rejected')
                                <a href="{{ route('kyc.apply') }}"
                                    class="btn h-8 rounded bg-primary px-3 text-xs+ font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                                    Reapply
                                </a>
                                @else
                                <a href="{{ route('kyc.apply') }}"
                                    class="btn h-8 rounded bg-primary px-3 text-xs+ font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                                    Verify Now
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Quick Stats -->
                <div class="mt-5 grid grid-cols-2 gap-3">
                    <div class="rounded-lg bg-slate-100 p-3 dark:bg-navy-600">
                        <div class="flex justify-between space-x-1">
                            <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">
                                {{ $walletCurrency }} {{ number_format($walletBalance/100, 2) }}
                            </p>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary dark:text-accent"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                            </svg>
                        </div>
                        <p class="mt-1 text-xs+ text-slate-500 dark:text-navy-300">
                            Balance
                        </p>
                    </div>
                    <div class="rounded-lg bg-slate-100 p-3 dark:bg-navy-600">
                        <div class="flex justify-between">
                            <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">
                                {{ Auth::user()->wallets->count() }}
                            </p>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-success" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <p class="mt-1 text-xs+ text-slate-500 dark:text-navy-300">
                            Wallets
                        </p>
                    </div>
                </div>

                <!-- Wallet Account Info -->
                <div class="mt-5">
                    <div
                        class="rounded-lg bg-gradient-to-r from-primary to-primary-focus p-4 text-white dark:from-accent dark:to-accent-focus">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium">Primary Wallet</p>
                            <div class="avatar h-8 w-8">
                                <div class="is-initial rounded-full bg-white/20 text-white">
                                    {{ $walletCurrency }}
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <p class="text-lg font-semibold">{{ $walletCurrency }} {{ number_format($walletBalance/100,
                                2) }}</p>
                            <div class="flex items-center space-x-1 text-xs">
                                <p id="clipboardContent1" class="line-clamp-1">{{ $walletAccountNumber }}</p>
                                <button
                                    class="btn h-5 w-5 rounded-full p-0 text-white hover:bg-white/20 focus:bg-white/20"
                                    @click="$clipboard({
                                        content:document.querySelector('#clipboardContent1').innerText,
                                        success:()=>$notification({text:'Account Number Copied',variant:'success'}),
                                        error:()=>$notification({text:'Error',variant:'error'})
                                    })">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path d="M7 9a2 2 0 012-2h6a2 2 0 012 2v6a2 2 0 01-2 2H9a2 2 0 01-2-2V9z" />
                                        <path d="M5 3a2 2 0 00-2 2v6a2 2 0 002 2V5h8a2 2 0 00-2-2H5z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-5 grid grid-cols-3 gap-3">
                    <button wire:click="deposit({{ Auth::user()->wallet()->id }})"
                        class="btn h-10 w-full bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>Deposit</span>
                    </button>
                    <button wire:click="transfer"
                        class="btn h-10 w-full bg-slate-150 font-medium text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                        </svg>
                        <span>Transfer</span>
                    </button>
                @if(auth()->user()->kyc_status === 'approved')
                    <button wire:click="withdraw({{ Auth::user()->wallet()->id }})"
                        class="btn h-10 w-full bg-slate-150 font-medium text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"
                                transform="rotate(45 12 12)" />
                        </svg>
                        <span>Withdraw</span>
                    </button>
                @else
                    <div class="btn h-20 rounded-lg bg-slate-200 font-medium text-slate-500 cursor-not-allowed dark:bg-navy-500 dark:text-navy-300">
                        <div class="flex flex-col items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            <span class="mt-1 text-xs">Withdraw</span>
                        </div>
                    </div>
                @endif
                </div>
                @if(auth()->user()->kyc_status !== 'approved')
                <div class="mt-3 p-2 rounded-lg bg-amber-50 border border-amber-200 dark:bg-amber-900/20 dark:border-amber-700/30">
                    <p class="text-xs text-amber-600 dark:text-amber-400">
                        <span class="font-medium">Withdrawals restricted:</span> Your account needs to be approved before you can withdraw funds. Please complete your verification process.
                    </p>
                </div>
            @endif
            </div>
        </div>

        <!-- Transaction History -->
        <div class="col-span-12 lg:col-span-8">
            <div class="card p-4 sm:p-5">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                        Recent Transactions
                    </h2>
                    <div class="flex space-x-2">
                        <div class="flex items-center space-x-2">
                            <div class="h-3 w-3 rounded-full bg-success"></div>
                            <p class="text-xs text-slate-400 dark:text-navy-300">Income</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <div class="h-3 w-3 rounded-full bg-error"></div>
                            <p class="text-xs text-slate-400 dark:text-navy-300">Expense</p>
                        </div>
                    </div>
                </div>

                <div class="mt-5">
                    <livewire:transactions.latest-transactions wire:key="latest-transactions-{{ now() }}" />
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        @if(session('toast'))
        <div class="fixed top-4 right-4 z-50 max-w-md">
            <x-payment-notification type="{{ session('toast.type') }}" message="{{ session('toast.message') }}"
                timeout="5000" />
        </div>
        @endif

        <!-- Rest of your dashboard content -->
    </div>

    <!-- Transfer Modal -->
    @if($showTransferModal)
    <div
        class="fixed inset-0 z-[100] flex items-center justify-center overflow-y-auto bg-slate-900/60 dark:bg-navy-900/60">
        <div class="w-full max-w-lg p-3 sm:p-5">
            <div class="card bg-white dark:bg-navy-700">
                <div class="flex justify-between p-4 sm:p-5">
                    <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100">
                        Transfer Funds
                    </h3>
                    <button wire:click="closeTransferModal"
                        class="btn -mr-1.5 h-7 w-7 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="p-4 sm:p-5">
                    @if($selectedWalletId)
                    <livewire:wallets.transfer :wallet="App\Models\Wallet::find($selectedWalletId)"
                        :key="'transfer-form-'.$selectedWalletId" />
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Withdraw Modal -->
    @if($showWithdrawModal)
    <div
        class="fixed inset-0 z-[100] flex items-center justify-center overflow-y-auto bg-slate-900/60 dark:bg-navy-900/60">
        <div class="w-full max-w-lg p-3 sm:p-5">
            <div class="card bg-white dark:bg-navy-700">
                <div class="flex justify-between p-4 sm:p-5">
                    <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100">
                        Withdraw Funds
                    </h3>
                    <button wire:click="closeWithdrawModal"
                        class="btn -mr-1.5 h-7 w-7 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="p-4 sm:p-5">
                    @if($selectedWalletId)
                    <livewire:wallets.withdraw :wallet="App\Models\Wallet::find($selectedWalletId)"
                        :key="'withdraw-form-'.$selectedWalletId" />
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Deposit Modal -->
    @if($showDepositModal)
    <div
        class="fixed inset-0 z-[100] flex items-center justify-center overflow-y-auto bg-slate-900/60 dark:bg-navy-900/60">
        <div class="w-full max-w-lg p-3 sm:p-5">
            <div class="card bg-white dark:bg-navy-700">
                <div class="flex justify-between p-4 sm:p-5">
                    <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100">
                        Deposit Funds
                    </h3>
                    <button wire:click="closeDepositModal"
                        class="btn -mr-1.5 h-7 w-7 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="p-4 sm:p-5">
                    @if($selectedWalletId)
                    <livewire:wallets.deposit :wallet="App\Models\Wallet::find($selectedWalletId)"
                        :key="'deposit-form-'.$selectedWalletId" />
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
