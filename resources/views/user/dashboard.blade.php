@php
/*

<x-app-layout-sideblock title="Crypto Dashboard v1" is-header-blur="true">
    <!-- Main Content Wrapper -->
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        <livewire:user.dashboard />
    </main>
</x-app-layout-sideblock>
*/
@endphp
<x-app-layout-sideblock title="Crypto Dashboard" is-header-blur="true">
    <!-- Main Content Wrapper -->
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        <!-- Payment Status Notifications -->
        @if(session('toast'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
            class="fixed top-4 right-4 z-50 max-w-sm rounded-lg px-4 py-3 shadow-lg transition-all duration-300 ease-in-out
                    {{ session('toast.type') === 'success' ? 'bg-emerald-500' : (session('toast.type') === 'warning' ? 'bg-amber-500' : 'bg-red-500') }} text-white">
            <div class="flex items-center space-x-3">
                @if(session('toast.type') === 'success')
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-white/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                @elseif(session('toast.type') === 'warning')
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-white/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                @else
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-white/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
                @endif
                <div>
                    <p class="font-medium">
                        {{ session('toast.type') === 'success' ? 'Success' : (session('toast.type') === 'warning' ? 'Warning' :
                        'Error') }}
                    </p>
                    <p class="text-sm">{{ session('toast.message') }}</p>
                </div>
            </div>
            <button @click="show = false" class="absolute top-2 right-2 rounded-full p-1 hover:bg-white/20">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        @endif
        <div class="mt-4 sm:mt-5 md:mt-6">
            <!-- Dashboard Header -->
            <div
                class="flex flex-col sm:flex-row sm:items-center justify-between space-y-2 sm:space-y-0 pb-5 border-b border-slate-200 dark:border-navy-500">
                <div>
                    <h2 class="text-xl font-medium text-slate-700 dark:text-navy-50">
                        Welcome back, {{ auth()->user()->name }}
                    </h2>
                    <p class="mt-1 text-sm text-slate-500 dark:text-navy-300">
                        Here's what's happening with your wallet today
                    </p>
                </div>
                {{-- <div class="flex space-x-2">
                    <button
                        class="btn h-9 rounded-full bg-primary/10 px-4 text-primary hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/30 dark:bg-accent-light/10 dark:text-accent-light dark:hover:bg-accent-light/20 dark:focus:bg-accent-light/20 dark:active:bg-accent-light/30">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                        <span>Add Funds</span>
                    </button>
                    <div x-data="{ isOpen: false }" class="inline-flex">
                        <button @click="isOpen = !isOpen"
                            class="btn h-9 w-9 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                            </svg>
                        </button>
                        <div x-show="isOpen" @click.outside="isOpen = false"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                            class="absolute right-0 mt-12 w-48 origin-top-right rounded-lg bg-white py-2 shadow-lg dark:bg-navy-700"
                            style="display: none;">
                            <a href="#"
                                class="flex h-8 items-center px-3 pr-8 font-medium tracking-wide outline-none transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mt-px h-4.5 w-4.5 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                <span>Export Data</span>
                            </a>
                            <a href="#"
                                class="flex h-8 items-center px-3 pr-8 font-medium tracking-wide outline-none transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mt-px h-4.5 w-4.5 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>Settings</span>
                            </a>
                        </div>
                    </div>
                </div> --}}
            </div>

            <!-- Dashboard Stats Cards -->
            {{-- <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4 mt-5">
                <!-- Total Balance Card -->
                <div
                    class="card p-4 sm:p-5 lg:p-6 bg-gradient-to-br from-purple-500 to-indigo-600 dark:from-purple-600 dark:to-indigo-700">
                    <div class="flex justify-between">
                        <div>
                            <p class="text-sm+ text-white/80">Total Balance</p>
                            <div class="mt-3 flex items-baseline text-white">
                                <p class="text-2xl font-semibold tracking-wide">$24,680.00</p>
                                <span class="ml-1 text-xs">USD</span>
                            </div>
                        </div>
                        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-white/10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center justify-between">
                        <p class="text-xs+ text-white/80">+2.5% from last month</p>
                        <a href="#" class="text-xs+ text-white hover:text-white/80">View Details</a>
                    </div>
                </div>

                <!-- Available Balance Card -->
                <div class="card p-4 sm:p-5 lg:p-6">
                    <div class="flex justify-between">
                        <div>
                            <p class="text-sm+ text-slate-600 dark:text-navy-100">Available Balance</p>
                            <div class="mt-3 flex items-baseline space-x-1">
                                <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">$16,489.25</p>
                                <p class="text-xs text-success">+4.3%</p>
                            </div>
                        </div>
                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-lg bg-primary/10 dark:bg-accent-light/10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary dark:text-accent-light"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center justify-between">
                        <p class="text-xs+ text-slate-400 dark:text-navy-300">Last updated 2 hours ago</p>
                        <a href="#"
                            class="text-xs+ text-primary hover:text-primary-focus dark:text-accent-light dark:hover:text-accent">Details</a>
                    </div>
                </div>

                <!-- Pending Transactions Card -->
                <div class="card p-4 sm:p-5 lg:p-6">
                    <div class="flex justify-between">
                        <div>
                            <p class="text-sm+ text-slate-600 dark:text-navy-100">Pending Transactions</p>
                            <div class="mt-3 flex items-baseline space-x-1">
                                <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">3</p>
                                <p class="text-xs text-warning">$1,240.50</p>
                            </div>
                        </div>
                        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-warning/10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-warning" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center justify-between">
                        <p class="text-xs+ text-slate-400 dark:text-navy-300">Awaiting confirmation</p>
                        <a href="#"
                            class="text-xs+ text-primary hover:text-primary-focus dark:text-accent-light dark:hover:text-accent">View
                            All</a>
                    </div>
                </div>

                <!-- Total Transactions Card -->
                <div class="card p-4 sm:p-5 lg:p-6">
                    <div class="flex justify-between">
                        <div>
                            <p class="text-sm+ text-slate-600 dark:text-navy-100">Total Transactions</p>
                            <div class="mt-3 flex items-baseline space-x-1">
                                <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">142</p>
                                <p class="text-xs text-info">This Month</p>
                            </div>
                        </div>
                        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-info/10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-info" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center justify-between">
                        <p class="text-xs+ text-slate-400 dark:text-navy-300">+12.5% from last month</p>
                        <a href="#"
                            class="text-xs+ text-primary hover:text-primary-focus dark:text-accent-light dark:hover:text-accent">History</a>
                    </div>
                </div>
            </div> --}}

            <!-- Main Dashboard Content -->
            {{-- <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6 mt-5">
                <!-- Left Column - Wallet & Activity -->
                <div class="col-span-12 lg:col-span-8">
                    <!-- Wallet Cards -->
                    <div class="card p-4 sm:p-5">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                                Your Wallets
                            </h2>
                            <div x-data="{ showModal: false }">
                                <button @click="showModal = true"
                                    class="btn h-8 w-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-5">
                            <!-- Main Wallet Card -->
                            <div
                                class="rounded-lg bg-gradient-to-br from-purple-500 to-indigo-600 p-4 dark:from-purple-600 dark:to-indigo-700">
                                <div class="flex justify-between text-white">
                                    <div>
                                        <p class="text-xs+ opacity-80">Main Wallet</p>
                                        <p class="text-xl font-semibold">$16,489.25</p>
                                    </div>
                                    <div class="flex items-center justify-center rounded-lg bg-white/20 p-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="mt-2 text-white">
                                    <p class="text-xs opacity-80">**** **** **** 8945</p>
                                </div>
                                <div class="mt-3 flex justify-between text-white">
                                    <button
                                        class="btn h-8 rounded-full bg-white/20 px-3 text-xs+ font-medium text-white hover:bg-white/30 focus:bg-white/30 active:bg-white/35">
                                        Transfer
                                    </button>
                                    <button
                                        class="btn h-8 rounded-full bg-white/20 px-3 text-xs+ font-medium text-white hover:bg-white/30 focus:bg-white/30 active:bg-white/35">
                                        Withdraw
                                    </button>
                                </div>
                            </div>

                            <!-- Savings Wallet Card -->
                            <div
                                class="rounded-lg bg-gradient-to-br from-amber-400 to-orange-600 p-4 dark:from-amber-500 dark:to-orange-700">
                                <div class="flex justify-between text-white">
                                    <div>
                                        <p class="text-xs+ opacity-80">Savings Wallet</p>
                                        <p class="text-xl font-semibold">$8,942.00</p>
                                    </div>
                                    <div class="flex items-center justify-center rounded-lg bg-white/20 p-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="mt-2 text-white">
                                    <p class="text-xs opacity-80">**** **** **** 5214</p>
                                </div>
                                <div class="mt-3 flex justify-between text-white">
                                    <button
                                        class="btn h-8 rounded-full bg-white/20 px-3 text-xs+ font-medium text-white hover:bg-white/30 focus:bg-white/30 active:bg-white/35">
                                        Transfer
                                    </button>
                                    <button
                                        class="btn h-8 rounded-full bg-white/20 px-3 text-xs+ font-medium text-white hover:bg-white/30 focus:bg-white/30 active:bg-white/35">
                                        Withdraw
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Transactions -->
                    <div class="card mt-5 p-4 sm:p-5">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                                Recent Transactions
                            </h2>
                            <a href="#"
                                class="border-b border-dotted border-current pb-0.5 text-xs+ font-medium text-primary outline-none transition-colors duration-300 hover:text-primary/70 focus:text-primary/70 dark:text-accent-light dark:hover:text-accent-light/70 dark:focus:text-accent-light/70">View
                                All</a>
                        </div>

                        <div class="mt-5 space-y-4">
                            <!-- Transaction Item 1 -->
                            <div class="flex items-center justify-between space-x-2">
                                <div class="flex items-center space-x-3">
                                    <div
                                        class="flex h-10 w-10 items-center justify-center rounded-lg bg-success/10 dark:bg-success/15">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-success" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium text-slate-700 dark:text-navy-100">
                                            Deposit from Bank
                                        </p>
                                        <p class="text-xs text-slate-400 dark:text-navy-300">
                                            Today, 12:25 PM
                                        </p>
                                    </div>
                                </div>
                                <p class="font-medium text-success">+$1,200.00</p>
                            </div>

                            <!-- Transaction Item 2 -->
                            <div class="flex items-center justify-between space-x-2">
                                <div class="flex items-center space-x-3">
                                    <div
                                        class="flex h-10 w-10 items-center justify-center rounded-lg bg-error/10 dark:bg-error/15">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-error" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium text-slate-700 dark:text-navy-100">
                                            Withdrawal to Bank
                                        </p>
                                        <p class="text-xs text-slate-400 dark:text-navy-300">
                                            Yesterday, 4:48 PM
                                        </p>
                                    </div>
                                </div>
                                <p class="font-medium text-error">-$550.00</p>
                            </div>

                            <!-- Transaction Item 3 -->
                            <div class="flex items-center justify-between space-x-2">
                                <div class="flex items-center space-x-3">
                                    <div
                                        class="flex h-10 w-10 items-center justify-center rounded-lg bg-warning/10 dark:bg-warning/15">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-warning" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium text-slate-700 dark:text-navy-100">
                                            Transfer to John Doe
                                        </p>
                                        <p class="text-xs text-slate-400 dark:text-navy-300">
                                            Mar 08, 2:30 PM
                                        </p>
                                    </div>
                                </div>
                                <p class="font-medium text-error">-$250.00</p>
                            </div>

                            <!-- Transaction Item 4 -->
                            <div class="flex items-center justify-between space-x-2">
                                <div class="flex items-center space-x-3">
                                    <div
                                        class="flex h-10 w-10 items-center justify-center rounded-lg bg-success/10 dark:bg-success/15">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-success" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium text-slate-700 dark:text-navy-100">
                                            Received from Sarah
                                        </p>
                                        <p class="text-xs text-slate-400 dark:text-navy-300">
                                            Mar 07, 10:42 AM
                                        </p>
                                    </div>
                                </div>
                                <p class="font-medium text-success">+$840.00</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Market & Activity -->
                <div class="col-span-12 lg:col-span-4">
                    <!-- Quick Actions Card -->
                    <div class="card p-4 sm:p-5">
                        <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                            Quick Actions
                        </h2>
                        <div class="mt-5 grid grid-cols-3 gap-4">
                            <button
                                class="btn h-20 w-full flex-col rounded-lg bg-primary/10 font-medium text-primary hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:bg-accent-light/10 dark:text-accent-light dark:hover:bg-accent-light/20 dark:focus:bg-accent-light/20 dark:active:bg-accent-light/25">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                </svg>
                                <span class="mt-1 text-xs">Deposit</span>
                            </button>
                            <button
                                class="btn h-20 w-full flex-col rounded-lg bg-primary/10 font-medium text-primary hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:bg-accent-light/10 dark:text-accent-light dark:hover:bg-accent-light/20 dark:focus:bg-accent-light/20 dark:active:bg-accent-light/25">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                </svg>
                                <span class="mt-1 text-xs">Transfer</span>
                            </button>
                            <button
                                class="btn h-20 w-full flex-col rounded-lg bg-primary/10 font-medium text-primary hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:bg-accent-light/10 dark:text-accent-light dark:hover:bg-accent-light/20 dark:focus:bg-accent-light/20 dark:active:bg-accent-light/25">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                                </svg>
                                <span class="mt-1 text-xs">Withdraw</span>
                            </button>
                        </div>
                    </div>

                    <!-- Market Trends Card -->
                    <div class="card mt-5 p-4 sm:p-5">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                                Market Trends
                            </h2>
                            <div x-data="{ activeTab: 'day' }" class="flex rounded-lg bg-slate-150 dark:bg-navy-500">
                                <button @click="activeTab = 'day'"
                                    :class="activeTab === 'day' ? 'bg-white shadow dark:bg-navy-700' : ''"
                                    class="btn h-8 rounded-lg px-3 text-xs+ font-medium">
                                    Day
                                </button>
                                <button @click="activeTab = 'week'"
                                    :class="activeTab === 'week' ? 'bg-white shadow dark:bg-navy-700' : ''"
                                    class="btn h-8 rounded-lg px-3 text-xs+ font-medium">
                                    Week
                                </button>
                                <button @click="activeTab = 'month'"
                                    :class="activeTab === 'month' ? 'bg-white shadow dark:bg-navy-700' : ''"
                                    class="btn h-8 rounded-lg px-3 text-xs+ font-medium">
                                    Month
                                </button>
                            </div>
                        </div>

                        <div class="mt-5 space-y-4">
                            <!-- Bitcoin -->
                            <div class="flex items-center justify-between space-x-2">
                                <div class="flex items-center space-x-3">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-warning/10">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-warning"
                                            viewBox="0 0 24 24" fill="currentColor">
                                            <path
                                                d="M11.944 17.97L4.58 13.62 11.943 24l7.37-10.38-7.372 4.35h.003zM12.056 0L4.69 12.223l7.365 4.354 7.365-4.35L12.056 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium text-slate-700 dark:text-navy-100">
                                            Bitcoin
                                        </p>
                                        <p class="text-xs text-slate-400 dark:text-navy-300">
                                            BTC
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <p class="font-medium text-slate-700 dark:text-navy-100">
                                        $42,856.90
                                    </p>
                                    <div class="flex items-center text-success">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 11l5-5m0 0l5 5m-5-5v12" />
                                        </svg>
                                        <span class="text-xs font-medium">2.5%</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Ethereum -->
                            <div class="flex items-center justify-between space-x-2">
                                <div class="flex items-center space-x-3">
                                    <div
                                        class="flex h-10 w-10 items-center justify-center rounded-lg bg-primary/10 dark:bg-accent-light/10">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-6 w-6 text-primary dark:text-accent-light" viewBox="0 0 24 24"
                                            fill="currentColor">
                                            <path
                                                d="M11.944 17.97L4.58 13.62 11.943 24l7.37-10.38-7.372 4.35h.003zM12.056 0L4.69 12.223l7.365 4.354 7.365-4.35L12.056 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium text-slate-700 dark:text-navy-100">
                                            Ethereum
                                        </p>
                                        <p class="text-xs text-slate-400 dark:text-navy-300">
                                            ETH
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <p class="font-medium text-slate-700 dark:text-navy-100">
                                        $3,284.50
                                    </p>
                                    <div class="flex items-center text-success">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 11l5-5m0 0l5 5m-5-5v12" />
                                        </svg>
                                        <span class="text-xs font-medium">3.2%</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Litecoin -->
                            <div class="flex items-center justify-between space-x-2">
                                <div class="flex items-center space-x-3">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-info/10">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-info"
                                            viewBox="0 0 24 24" fill="currentColor">
                                            <path
                                                d="M11.944 17.97L4.58 13.62 11.943 24l7.37-10.38-7.372 4.35h.003zM12.056 0L4.69 12.223l7.365 4.354 7.365-4.35L12.056 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium text-slate-700 dark:text-navy-100">
                                            Litecoin
                                        </p>
                                        <p class="text-xs text-slate-400 dark:text-navy-300">
                                            LTC
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <p class="font-medium text-slate-700 dark:text-navy-100">
                                        $186.25
                                    </p>
                                    <div class="flex items-center text-error">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 13l-5 5m0 0l-5-5m5 5V6" />
                                        </svg>
                                        <span class="text-xs font-medium">1.8%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Activity Card -->
                    <div class="card mt-5 p-4 sm:p-5">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                                Recent Activity
                            </h2>
                            <a href="#"
                                class="border-b border-dotted border-current pb-0.5 text-xs+ font-medium text-primary outline-none transition-colors duration-300 hover:text-primary/70 focus:text-primary/70 dark:text-accent-light dark:hover:text-accent-light/70 dark:focus:text-accent-light/70">View
                                All</a>
                        </div>

                        <div class="mt-5 space-y-4">
                            <div class="flex items-center space-x-3">
                                <div
                                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-success/10 dark:bg-success/15">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-success" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-slate-700 dark:text-navy-100">
                                        KYC Verification Approved
                                    </p>
                                    <p class="text-xs text-slate-400 dark:text-navy-300">
                                        Today, 10:45 AM
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div
                                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-info/10 dark:bg-info/15">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-info" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-slate-700 dark:text-navy-100">
                                        New Support Message
                                    </p>
                                    <p class="text-xs text-slate-400 dark:text-navy-300">
                                        Yesterday, 3:22 PM
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div
                                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-warning/10 dark:bg-warning/15">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-warning" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-slate-700 dark:text-navy-100">
                                        Pending Withdrawal
                                    </p>
                                    <p class="text-xs text-slate-400 dark:text-navy-300">
                                        Mar 08, 2:30 PM
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}

            <!-- Livewire Component Integration -->
            <div class="mt-5">
                <livewire:user.dashboard />
            </div>
        </div>
    </main>
</x-app-layout-sideblock>
{{-- <x-app-layout-sideblock title="Crypto Dashboard" is-header-blur="true">
    <!-- Main Content Wrapper -->
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        <div class="mt-4 sm:mt-5 md:mt-6">
            <!-- Dashboard Header -->
            <div
                class="flex flex-col sm:flex-row sm:items-center justify-between space-y-2 sm:space-y-0 pb-5 border-b border-slate-200 dark:border-navy-500">
                <div>
                    <h2 class="text-xl font-medium text-slate-700 dark:text-navy-50">
                        Welcome back, {{ auth()->user()->name }}
                    </h2>
                    <p class="mt-1 text-sm text-slate-500 dark:text-navy-300">
                        Here's what's happening with your wallet today
                    </p>
                </div>
                <div class="flex space-x-2">
                    <button
                        class="btn h-9 rounded-full bg-primary/10 px-4 text-primary hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/30 dark:bg-accent-light/10 dark:text-accent-light dark:hover:bg-accent-light/20 dark:focus:bg-accent-light/20 dark:active:bg-accent-light/30">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                        <span>Add Funds</span>
                    </button>
                    <div x-data="{ isOpen: false }" class="inline-flex">
                        <button @click="isOpen = !isOpen"
                            class="btn h-9 w-9 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                            </svg>
                        </button>
                        <div x-show="isOpen" @click.outside="isOpen = false"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                            class="absolute right-0 mt-12 w-48 origin-top-right rounded-lg bg-white py-2 shadow-lg dark:bg-navy-700"
                            style="display: none;">
                            <a href="#"
                                class="flex h-8 items-center px-3 pr-8 font-medium tracking-wide outline-none transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mt-px h-4.5 w-4.5 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                <span>Export Data</span>
                            </a>
                            <a href="#"
                                class="flex h-8 items-center px-3 pr-8 font-medium tracking-wide outline-none transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mt-px h-4.5 w-4.5 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>Settings</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dashboard Stats Cards -->
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4 mt-5">
                <!-- Total Balance Card -->
                <div
                    class="card p-4 sm:p-5 lg:p-6 bg-gradient-to-br from-purple-500 to-indigo-600 dark:from-purple-600 dark:to-indigo-700">
                    <div class="flex justify-between">
                        <div>
                            <p class="text-sm+ text-white/80">Total Balance</p>
                            <div class="mt-3 flex items-baseline text-white">
                                <p class="text-2xl font-semibold tracking-wide">$24,680.00</p>
                                <span class="ml-1 text-xs">USD</span>
                            </div>
                        </div>
                        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-white/10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center justify-between">
                        <p class="text-xs+ text-white/80">+2.5% from last month</p>
                        <a href="#" class="text-xs+ text-white hover:text-white/80">View Details</a>
                    </div>
                </div>

                <!-- Available Balance Card -->
                <div class="card p-4 sm:p-5 lg:p-6">
                    <div class="flex justify-between">
                        <div>
                            <p class="text-sm+ text-slate-600 dark:text-navy-100">Available Balance</p>
                            <div class="mt-3 flex items-baseline space-x-1">
                                <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">$16,489.25</p>
                                <p class="text-xs text-success">+4.3%</p>
                            </div>
                        </div>
                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-lg bg-primary/10 dark:bg-accent-light/10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary dark:text-accent-light"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center justify-between">
                        <p class="text-xs+ text-slate-400 dark:text-navy-300">Last updated 2 hours ago</p>
                        <a href="#"
                            class="text-xs+ text-primary hover:text-primary-focus dark:text-accent-light dark:hover:text-accent">Details</a>
                    </div>
                </div>

                <!-- Pending Transactions Card -->
                <div class="card p-4 sm:p-5 lg:p-6">
                    <div class="flex justify-between">
                        <div>
                            <p class="text-sm+ text-slate-600 dark:text-navy-100">Pending Transactions</p>
                            <div class="mt-3 flex items-baseline space-x-1">
                                <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">3</p>
                                <p class="text-xs text-warning">$1,240.50</p>
                            </div>
                        </div>
                        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-warning/10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-warning" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center justify-between">
                        <p class="text-xs+ text-slate-400 dark:text-navy-300">Awaiting confirmation</p>
                        <a href="#"
                            class="text-xs+ text-primary hover:text-primary-focus dark:text-accent-light dark:hover:text-accent">View
                            All</a>
                    </div>
                </div>

                <!-- Total Transactions Card -->
                <div class="card p-4 sm:p-5 lg:p-6">
                    <div class="flex justify-between">
                        <div>
                            <p class="text-sm+ text-slate-600 dark:text-navy-100">Total Transactions</p>
                            <div class="mt-3 flex items-baseline space-x-1">
                                <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">142</p>
                                <p class="text-xs text-info">This Month</p>
                            </div>
                        </div>
                        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-info/10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-info" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center justify-between">
                        <p class="text-xs+ text-slate-400 dark:text-navy-300">+12.5% from last month</p>
                        <a href="#"
                            class="text-xs+ text-primary hover:text-primary-focus dark:text-accent-light dark:hover:text-accent">History</a>
                    </div>
                </div>
            </div>

            <!-- Main Dashboard Content -->
            <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6 mt-5">
                <!-- Left Column - Wallet & Activity -->
                <div class="col-span-12 lg:col-span-8">
                    <!-- Wallet Cards -->
                    <div class="card p-4 sm:p-5">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                                Your Wallets
                            </h2>
                            <div x-data="{ showModal: false }">
                                <button @click="showModal = true"
                                    class="btn h-8 w-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-5">
                            <!-- Main Wallet Card -->
                            <div
                                class="rounded-lg bg-gradient-to-br from-purple-500 to-indigo-600 p-4 dark:from-purple-600 dark:to-indigo-700">
                                <div class="flex justify-between text-white">
                                    <div>
                                        <p class="text-xs+ opacity-80">Main Wallet</p>
                                        <p class="text-xl font-semibold">$16,489.25</p>
                                    </div>
                                    <div class="flex items-center justify-center rounded-lg bg-white/20 p-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="mt-2 text-white">
                                    <p class="text-xs opacity-80">**** **** **** 8945</p>
                                </div>
                                <div class="mt-3 flex justify-between text-white">
                                    <button
                                        class="btn h-8 rounded-full bg-white/20 px-3 text-xs+ font-medium text-white hover:bg-white/30 focus:bg-white/30 active:bg-white/35">
                                        Transfer
                                    </button>
                                    <button
                                        class="btn h-8 rounded-full bg-white/20 px-3 text-xs+ font-medium text-white hover:bg-white/30 focus:bg-white/30 active:bg-white/35">
                                        Withdraw
                                    </button>
                                </div>
                            </div>

                            <!-- Savings Wallet Card -->
                            <div
                                class="rounded-lg bg-gradient-to-br from-amber-400 to-orange-600 p-4 dark:from-amber-500 dark:to-orange-700">
                                <div class="flex justify-between text-white">
                                    <div>
                                        <p class="text-xs+ opacity-80">Savings Wallet</p>
                                        <p class="text-xl font-semibold">$8,942.00</p>
                                    </div>
                                    <div class="flex items-center justify-center rounded-lg bg-white/20 p-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="mt-2 text-white">
                                    <p class="text-xs opacity-80">**** **** **** 5214</p>
                                </div>
                                <div class="mt-3 flex justify-between text-white">
                                    <button
                                        class="btn h-8 rounded-full bg-white/20 px-3 text-xs+ font-medium text-white hover:bg-white/30 focus:bg-white/30 active:bg-white/35">
                                        Transfer
                                    </button>
                                    <button
                                        class="btn h-8 rounded-full bg-white/20 px-3 text-xs+ font-medium text-white hover:bg-white/30 focus:bg-white/30 active:bg-white/35">
                                        Withdraw
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Transactions -->
                    <div class="card mt-5 p-4 sm:p-5">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                                Recent Transactions
                            </h2>
                            <a href="#"
                                class="border-b border-dotted border-current pb-0.5 text-xs+ font-medium text-primary outline-none transition-colors duration-300 hover:text-primary/70 focus:text-primary/70 dark:text-accent-light dark:hover:text-accent-light/70 dark:focus:text-accent-light/70">View
                                All</a>
                        </div>

                        <div class="mt-5 space-y-4">
                            <!-- Transaction Item 1 -->
                            <div class="flex items-center justify-between space-x-2">
                                <div class="flex items-center space-x-3">
                                    <div
                                        class="flex h-10 w-10 items-center justify-center rounded-lg bg-success/10 dark:bg-success/15">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-success" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium text-slate-700 dark:text-navy-100">
                                            Deposit from Bank
                                        </p>
                                        <p class="text-xs text-slate-400 dark:text-navy-300">
                                            Today, 12:25 PM
                                        </p>
                                    </div>
                                </div>
                                <p class="font-medium text-success">+$1,200.00</p>
                            </div>

                            <!-- Transaction Item 2 -->
                            <div class="flex items-center justify-between space-x-2">
                                <div class="flex items-center space-x-3">
                                    <div
                                        class="flex h-10 w-10 items-center justify-center rounded-lg bg-error/10 dark:bg-error/15">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-error" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium text-slate-700 dark:text-navy-100">
                                            Withdrawal to Bank
                                        </p>
                                        <p class="text-xs text-slate-400 dark:text-navy-300">
                                            Yesterday, 4:48 PM
                                        </p>
                                    </div>
                                </div>
                                <p class="font-medium text-error">-$550.00</p>
                            </div>

                            <!-- Transaction Item 3 -->
                            <div class="flex items-center justify-between space-x-2">
                                <div class="flex items-center space-x-3">
                                    <div
                                        class="flex h-10 w-10 items-center justify-center rounded-lg bg-warning/10 dark:bg-warning/15">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-warning" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium text-slate-700 dark:text-navy-100">
                                            Transfer to John Doe
                                        </p>
                                        <p class="text-xs text-slate-400 dark:text-navy-300">
                                            Mar 08, 2:30 PM
                                        </p>
                                    </div>
                                </div>
                                <p class="font-medium text-error">-$250.00</p>
                            </div>

                            <!-- Transaction Item 4 -->
                            <div class="flex items-center justify-between space-x-2">
                                <div class="flex items-center space-x-3">
                                    <div
                                        class="flex h-10 w-10 items-center justify-center rounded-lg bg-success/10 dark:bg-success/15">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-success" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium text-slate-700 dark:text-navy-100">
                                            Received from Sarah
                                        </p>
                                        <p class="text-xs text-slate-400 dark:text-navy-300">
                                            Mar 07, 10:42 AM
                                        </p>
                                    </div>
                                </div>
                                <p class="font-medium text-success">+$840.00</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Market & Activity -->
                <div class="col-span-12 lg:col-span-4">
                    <!-- Quick Actions Card -->
                    <div class="card p-4 sm:p-5">
                        <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                            Quick Actions
                        </h2>
                        <div class="mt-5 grid grid-cols-3 gap-4">
                            <button
                                class="btn h-20 w-full flex-col rounded-lg bg-primary/10 font-medium text-primary hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:bg-accent-light/10 dark:text-accent-light dark:hover:bg-accent-light/20 dark:focus:bg-accent-light/20 dark:active:bg-accent-light/25">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                </svg>
                                <span class="mt-1 text-xs">Deposit</span>
                            </button>
                            <button
                                class="btn h-20 w-full flex-col rounded-lg bg-primary/10 font-medium text-primary hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:bg-accent-light/10 dark:text-accent-light dark:hover:bg-accent-light/20 dark:focus:bg-accent-light/20 dark:active:bg-accent-light/25">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                </svg>
                                <span class="mt-1 text-xs">Transfer</span>
                            </button>
                            <button
                                class="btn h-20 w-full flex-col rounded-lg bg-primary/10 font-medium text-primary hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:bg-accent-light/10 dark:text-accent-light dark:hover:bg-accent-light/20 dark:focus:bg-accent-light/20 dark:active:bg-accent-light/25">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                                </svg>
                                <span class="mt-1 text-xs">Withdraw</span>
                            </button>
                        </div>
                    </div>

                    <!-- Market Trends Card -->
                    <div class="card mt-5 p-4 sm:p-5">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                                Market Trends
                            </h2>
                            <div x-data="{ activeTab: 'day' }" class="flex rounded-lg bg-slate-150 dark:bg-navy-500">
                                <button @click="activeTab = 'day'"
                                    :class="activeTab === 'day' ? 'bg-white shadow dark:bg-navy-700' : ''"
                                    class="btn h-8 rounded-lg px-3 text-xs+ font-medium">
                                    Day
                                </button>
                                <button @click="activeTab = 'week'"
                                    :class="activeTab === 'week' ? 'bg-white shadow dark:bg-navy-700' : ''"
                                    class="btn h-8 rounded-lg px-3 text-xs+ font-medium">
                                    Week
                                </button>
                                <button @click="activeTab = 'month'"
                                    :class="activeTab === 'month' ? 'bg-white shadow dark:bg-navy-700' : ''"
                                    class="btn h-8 rounded-lg px-3 text-xs+ font-medium">
                                    Month
                                </button>
                            </div>
                        </div>

                        <div class="mt-5 space-y-4">
                            <!-- Bitcoin -->
                            <div class="flex items-center justify-between space-x-2">
                                <div class="flex items-center space-x-3">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-warning/10">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-warning"
                                            viewBox="0 0 24 24" fill="currentColor">
                                            <path
                                                d="M11.944 17.97L4.58 13.62 11.943 24l7.37-10.38-7.372 4.35h.003zM12.056 0L4.69 12.223l7.365 4.354 7.365-4.35L12.056 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium text-slate-700 dark:text-navy-100">
                                            Bitcoin
                                        </p>
                                        <p class="text-xs text-slate-400 dark:text-navy-300">
                                            BTC
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <p class="font-medium text-slate-700 dark:text-navy-100">
                                        $42,856.90
                                    </p>
                                    <div class="flex items-center text-success">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 11l5-5m0 0l5 5m-5-5v12" />
                                        </svg>
                                        <span class="text-xs font-medium">2.5%</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Ethereum -->
                            <div class="flex items-center justify-between space-x-2">
                                <div class="flex items-center space-x-3">
                                    <div
                                        class="flex h-10 w-10 items-center justify-center rounded-lg bg-primary/10 dark:bg-accent-light/10">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-6 w-6 text-primary dark:text-accent-light" viewBox="0 0 24 24"
                                            fill="currentColor">
                                            <path
                                                d="M11.944 17.97L4.58 13.62 11.943 24l7.37-10.38-7.372 4.35h.003zM12.056 0L4.69 12.223l7.365 4.354 7.365-4.35L12.056 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium text-slate-700 dark:text-navy-100">
                                            Ethereum
                                        </p>
                                        <p class="text-xs text-slate-400 dark:text-navy-300">
                                            ETH
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <p class="font-medium text-slate-700 dark:text-navy-100">
                                        $3,284.50
                                    </p>
                                    <div class="flex items-center text-success">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 11l5-5m0 0l5 5m-5-5v12" />
                                        </svg>
                                        <span class="text-xs font-medium">3.2%</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Litecoin -->
                            <div class="flex items-center justify-between space-x-2">
                                <div class="flex items-center space-x-3">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-info/10">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-info"
                                            viewBox="0 0 24 24" fill="currentColor">
                                            <path
                                                d="M11.944 17.97L4.58 13.62 11.943 24l7.37-10.38-7.372 4.35h.003zM12.056 0L4.69 12.223l7.365 4.354 7.365-4.35L12.056 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium text-slate-700 dark:text-navy-100">
                                            Litecoin
                                        </p>
                                        <p class="text-xs text-slate-400 dark:text-navy-300">
                                            LTC
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <p class="font-medium text-slate-700 dark:text-navy-100">
                                        $186.25
                                    </p>
                                    <div class="flex items-center text-error">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 13l-5 5m0 0l-5-5m5 5V6" />
                                        </svg>
                                        <span class="text-xs font-medium">1.8%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Activity Card -->
                    <div class="card mt-5 p-4 sm:p-5">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                                Recent Activity
                            </h2>
                            <a href="#"
                                class="border-b border-dotted border-current pb-0.5 text-xs+ font-medium text-primary outline-none transition-colors duration-300 hover:text-primary/70 focus:text-primary/70 dark:text-accent-light dark:hover:text-accent-light/70 dark:focus:text-accent-light/70">View
                                All</a>
                        </div>

                        <div class="mt-5 space-y-4">
                            <div class="flex items-center space-x-3">
                                <div
                                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-success/10 dark:bg-success/15">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-success" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-slate-700 dark:text-navy-100">
                                        KYC Verification Approved
                                    </p>
                                    <p class="text-xs text-slate-400 dark:text-navy-300">
                                        Today, 10:45 AM
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div
                                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-info/10 dark:bg-info/15">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-info" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-slate-700 dark:text-navy-100">
                                        New Support Message
                                    </p>
                                    <p class="text-xs text-slate-400 dark:text-navy-300">
                                        Yesterday, 3:22 PM
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div
                                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-warning/10 dark:bg-warning/15">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-warning" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-slate-700 dark:text-navy-100">
                                        Pending Withdrawal
                                    </p>
                                    <p class="text-xs text-slate-400 dark:text-navy-300">
                                        Mar 08, 2:30 PM
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Livewire Component Integration -->
            <div class="mt-5">
                <livewire:user.dashboard />
            </div>
        </div>
    </main>
</x-app-layout-sideblock> --}}
