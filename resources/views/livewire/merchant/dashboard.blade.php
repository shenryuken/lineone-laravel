<div class="mt-6">
    <!-- Merchant Dashboard Header -->
    <div class="flex items-center justify-between py-5 lg:py-6">
        <div class="flex items-center space-x-1">
            <h2 class="text-xl font-medium text-slate-700 line-clamp-1 dark:text-navy-50 lg:text-2xl">
                Merchant Dashboard
            </h2>
            <div class="inline-flex ml-3">
                <span class="badge bg-success/10 text-success dark:bg-success/15">Active</span>
            </div>
        </div>

        <div class="flex items-center space-x-2">
            <label class="relative hidden sm:flex">
                <input
                    class="form-input peer h-9 w-full rounded-full border border-slate-300 bg-transparent px-3 py-2 pl-9 text-xs+ placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                    placeholder="Search transactions..." type="text" />
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
                    class="btn h-8 w-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25 sm:h-9 sm:w-9">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" stroke="currentColor" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M15.375 17.556h-6.75m6.75 0H21l-1.58-1.562a2.254 2.254 0 01-.67-1.596v-3.51a6.612 6.612 0 00-1.238-3.85 6.744 6.744 0 00-3.262-2.437v-.379c0-.59-.237-1.154-.659-1.571A2.265 2.265 0 0012 2c-.597 0-1.169.234-1.591.65a2.208 2.208 0 00-.659 1.572v.38c-2.621.915-4.5 3.385-4.5 6.287v3.51c0 .598-.24 1.172-.67 1.595L3 17.556h12.375zm0 0v1.11c0 .885-.356 1.733-.989 2.358A3.397 3.397 0 0112 22a3.397 3.397 0 01-2.386-.976 3.313 3.313 0 01-.989-2.357v-1.111h6.75z" />
                    </svg>
                </button>
                <button
                    class="btn h-8 w-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25 sm:h-9 sm:w-9">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- KYB Verification Status -->
    <div class="mb-5">
        <div class="card p-4 sm:p-5">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between space-y-3 sm:space-y-0">
                <div>
                    <h2 class="text-lg font-medium text-slate-700 dark:text-navy-100">
                        Business Verification (KYB)
                    </h2>
                    <p class="mt-1 text-xs+ text-slate-500 dark:text-navy-200">
                        Complete your KYB verification to access all merchant features
                    </p>
                </div>

                <!-- This would be dynamic based on actual KYB status -->
                <div class="flex flex-col sm:items-end space-y-3">
                    <div class="badge rounded-full px-3 py-1.5 bg-warning/10 text-warning dark:bg-warning/15">
                        Pending Verification
                    </div>

                    <a href="{{ route('merchant.kyb.dashboard') }}"
                        class="btn bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                        View KYB Status
                    </a>
                </div>
            </div>

            <div class="mt-5">
                <div class="rounded-lg bg-slate-50 p-4 dark:bg-navy-600">
                    <div class="flex items-center space-x-4">
                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-lg bg-slate-200 dark:bg-navy-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-slate-600 dark:text-navy-100"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-base font-medium text-slate-700 dark:text-navy-100">
                                KYB Documentation Required
                            </p>
                            <p class="text-xs+ text-slate-500 dark:text-navy-200">
                                Please submit business registration documents, ownership proof, and identity documents
                                for verification.
                            </p>
                        </div>
                        <a href="{{ route('merchant.kyb.apply') }}"
                            class="btn h-8 rounded-full bg-primary px-3 text-xs+ font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                            Submit Documents
                        </a>
                    </div>
                </div>
            </div>

            <!-- KYB Verification Steps -->
            <div class="mt-5">
                <div class="flex items-center justify-between py-3">
                    <h3 class="text-sm+ font-medium text-slate-700 dark:text-navy-100">
                        Verification Steps
                    </h3>
                </div>

                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <div
                            class="flex h-8 w-8 items-center justify-center rounded-full bg-primary/10 text-primary dark:bg-accent/10 dark:text-accent-light">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-slate-700 dark:text-navy-100">
                                Create Account
                            </p>
                            <p class="text-xs text-slate-500 dark:text-navy-200">
                                Merchant account created successfully
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3">
                        <div
                            class="flex h-8 w-8 items-center justify-center rounded-full bg-warning/10 text-warning dark:bg-warning/15">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-slate-700 dark:text-navy-100">
                                Submit KYB Documents
                            </p>
                            <p class="text-xs text-slate-500 dark:text-navy-200">
                                Business registration & proof of address pending
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3">
                        <div
                            class="flex h-8 w-8 items-center justify-center rounded-full bg-slate-200 text-slate-600 dark:bg-navy-500 dark:text-navy-100">
                            <span class="text-xs font-bold">3</span>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-slate-700 dark:text-navy-100">
                                Verification Review
                            </p>
                            <p class="text-xs text-slate-500 dark:text-navy-200">
                                Awaiting document review by our team
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3">
                        <div
                            class="flex h-8 w-8 items-center justify-center rounded-full bg-slate-200 text-slate-600 dark:bg-navy-500 dark:text-navy-100">
                            <span class="text-xs font-bold">4</span>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-slate-700 dark:text-navy-100">
                                KYB Approved
                            </p>
                            <p class="text-xs text-slate-500 dark:text-navy-200">
                                Full merchant features unlocked
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Time Period Selector -->
    <div class="mb-5 flex items-center justify-between">
        <h3 class="text-sm+ font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100">
            Overview
        </h3>
        <div class="flex items-center space-x-2">
            <button @click="$wire.changePeriod('today')"
                class="btn h-8 rounded-full px-3 text-xs+ font-medium {{ $period === 'today' ? 'bg-primary text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90' : 'bg-slate-150 text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90' }}">
                Today
            </button>
            <button @click="$wire.changePeriod('week')"
                class="btn h-8 rounded-full px-3 text-xs+ font-medium {{ $period === 'week' ? 'bg-primary text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90' : 'bg-slate-150 text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90' }}">
                Week
            </button>
            <button @click="$wire.changePeriod('month')"
                class="btn h-8 rounded-full px-3 text-xs+ font-medium {{ $period === 'month' ? 'bg-primary text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90' : 'bg-slate-150 text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90' }}">
                Month
            </button>
            <button @click="$wire.changePeriod('year')"
                class="btn h-8 rounded-full px-3 text-xs+ font-medium {{ $period === 'year' ? 'bg-primary text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90' : 'bg-slate-150 text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90' }}">
                Year
            </button>
        </div>
    </div>

    <!-- Metrics Cards -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-5 lg:grid-cols-4 lg:gap-6">
        <!-- Total Sales Card -->
        <div class="card p-4 sm:p-5">
            <div class="flex items-center justify-between space-x-2">
                <div class="flex items-center space-x-3">
                    <div
                        class="flex h-10 w-10 items-center justify-center rounded-lg bg-primary/10 dark:bg-accent-light/10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary dark:text-accent-light"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="font-medium text-slate-700 dark:text-navy-100">Total Sales</span>
                </div>
                <div class="flex items-center space-x-1">
                    <p class="text-xs text-success">+{{ $metrics['total_sales']['change'] }}%</p>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-success" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 11l5-5m0 0l5 5m-5-5v12" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 text-center">
                <p class="text-2xl font-semibold text-slate-700 dark:text-navy-100">${{
                    number_format($metrics['total_sales']['value'], 2) }}</p>
                <p class="text-xs+ text-slate-400 dark:text-navy-300">This {{ $period }}</p>
            </div>
        </div>

        <!-- Transactions Card -->
        <div class="card p-4 sm:p-5">
            <div class="flex items-center justify-between space-x-2">
                <div class="flex items-center space-x-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-success/10 dark:bg-success/15">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-success" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <span class="font-medium text-slate-700 dark:text-navy-100">Transactions</span>
                </div>
                <div class="flex items-center space-x-1">
                    <p class="text-xs text-success">+{{ $metrics['transactions']['change'] }}%</p>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-success" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 11l5-5m0 0l5 5m-5-5v12" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 text-center">
                <p class="text-2xl font-semibold text-slate-700 dark:text-navy-100">{{
                    number_format($metrics['transactions']['value']) }}</p>
                <p class="text-xs+ text-slate-400 dark:text-navy-300">This {{ $period }}</p>
            </div>
        </div>

        <!-- Average Order Card -->
        <div class="card p-4 sm:p-5">
            <div class="flex items-center justify-between space-x-2">
                <div class="flex items-center space-x-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-warning/10 dark:bg-warning/15">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-warning" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <span class="font-medium text-slate-700 dark:text-navy-100">Avg. Order</span>
                </div>
                <div class="flex items-center space-x-1">
                    <p class="text-xs text-success">+{{ $metrics['average_order']['change'] }}%</p>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-success" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 11l5-5m0 0l5 5m-5-5v12" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 text-center">
                <p class="text-2xl font-semibold text-slate-700 dark:text-navy-100">${{
                    number_format($metrics['average_order']['value'], 2) }}</p>
                <p class="text-xs+ text-slate-400 dark:text-navy-300">This {{ $period }}</p>
            </div>
        </div>

        <!-- Conversion Rate Card -->
        <div class="card p-4 sm:p-5">
            <div class="flex items-center justify-between space-x-2">
                <div class="flex items-center space-x-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-info/10 dark:bg-info/15">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-info" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>
                    <span class="font-medium text-slate-700 dark:text-navy-100">Conversion</span>
                </div>
                <div class="flex items-center space-x-1">
                    <p class="text-xs text-error">{{ $metrics['conversion_rate']['change'] }}%</p>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-error" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 13l-5 5m0 0l-5-5m5 5V6" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 text-center">
                <p class="text-2xl font-semibold text-slate-700 dark:text-navy-100">{{
                    $metrics['conversion_rate']['value'] }}%</p>
                <p class="text-xs+ text-slate-400 dark:text-navy-300">This {{ $period }}</p>
            </div>
        </div>
    </div>

    <!-- Charts and Payment Methods -->
    <div class="mt-4 grid grid-cols-12 gap-4 sm:mt-5 sm:gap-5 lg:mt-6 lg:gap-6">
        <!-- Sales Chart -->
        <div class="col-span-12 lg:col-span-8">
            <div class="card p-4 sm:p-5">
                <div class="flex items-center justify-between">
                    <h2 class="font-medium tracking-wide text-slate-700 dark:text-navy-100">
                        Sales Overview
                    </h2>
                    <div class="flex items-center space-x-2">
                        <div
                            class="flex h-5 w-5 items-center justify-center rounded-full bg-primary/10 dark:bg-accent-light/10">
                            <div class="h-2 w-2 rounded-full bg-primary dark:bg-accent-light"></div>
                        </div>
                        <p class="text-xs text-slate-600 dark:text-navy-200">Sales</p>
                    </div>
                </div>
                <div class="mt-3 h-80">
                    <canvas x-init="$nextTick(() => {
                        const ctx = $el.getContext('2d');

                        const salesData = {{ json_encode($chartData['sales']) }};

                        new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: salesData.labels,
                                datasets: [
                                    {
                                        label: 'Sales',
                                        data: salesData.data,
                                        fill: true,
                                        backgroundColor: 'rgba(107, 114, 128, 0.1)',
                                        borderColor: '#4f46e5',
                                        borderWidth: 2,
                                        tension: 0.3,
                                        pointRadius: 4,
                                        pointBackgroundColor: '#4f46e5',
                                    }
                                ]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        grid: {
                                            display: true,
                                            drawBorder: false,
                                        },
                                        ticks: {
                                            callback: function(value) {
                                                return '$' + value.toLocaleString();
                                            }
                                        }
                                    },
                                    x: {
                                        grid: {
                                            display: false,
                                        }
                                    }
                                },
                                plugins: {
                                    tooltip: {
                                        callbacks: {
                                            label: function(context) {
                                                return '$' + context.raw.toLocaleString();
                                            }
                                        }
                                    },
                                    legend: {
                                        display: false
                                    }
                                }
                            }
                        });
                    })"></canvas>
                </div>
            </div>
        </div>

        <!-- Payment Methods -->
        <div class="col-span-12 lg:col-span-4">
            <div class="card p-4 sm:p-5">
                <div class="flex items-center justify-between">
                    <h2 class="font-medium tracking-wide text-slate-700 dark:text-navy-100">
                        Payment Methods
                    </h2>
                </div>
                <div class="mt-4 space-y-4">
                    @foreach($paymentMethods as $method)
                    <div>
                        <div class="flex items-center justify-between">
                            <p class="text-sm+ font-medium text-slate-700 dark:text-navy-100">
                                {{ $method['name'] }}
                            </p>
                            <p class="text-sm font-medium text-slate-700 dark:text-navy-100">
                                {{ $method['percentage'] }}%
                            </p>
                        </div>
                        <div class="mt-2 flex h-2 overflow-hidden rounded bg-slate-150 dark:bg-navy-500">
                            <div class="@if($method['name'] === 'Credit Card') bg-primary dark:bg-accent @elseif($method['name'] === 'Bank Transfer') bg-success @elseif($method['name'] === 'Digital Wallet') bg-warning @else bg-info @endif"
                                style="width: {{ $method['percentage'] }}%"></div>
                        </div>
                        <div class="mt-1 text-right text-xs text-slate-400 dark:text-navy-300">
                            ${{ number_format($method['amount'], 2) }}
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="mt-4 sm:mt-5 lg:mt-6">
        <div class="card p-4 sm:p-5">
            <div class="flex items-center justify-between">
                <h2 class="font-medium tracking-wide text-slate-700 dark:text-navy-100">
                    Recent Transactions
                </h2>
                <a href="#"
                    class="border-b border-dashed border-current pb-0.5 text-xs+ font-medium text-primary outline-none transition-colors duration-300 hover:text-primary/70 focus:text-primary/70 dark:text-accent-light dark:hover:text-accent-light/70 dark:focus:text-accent-light/70">
                    View All
                </a>
            </div>
            <div class="mt-4 overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-slate-200 dark:border-navy-500">
                            <th
                                class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100 text-left">
                                Transaction ID
                            </th>
                            <th
                                class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100 text-left">
                                Customer
                            </th>
                            <th
                                class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100 text-left">
                                Amount
                            </th>
                            <th
                                class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100 text-left">
                                Status
                            </th>
                            <th
                                class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100 text-left">
                                Date
                            </th>
                            <th
                                class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100 text-left">
                                Payment Method
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentTransactions as $transaction)
                        <tr
                            class="border-b border-slate-200 dark:border-navy-500 hover:bg-slate-50 dark:hover:bg-navy-600">
                            <td class="whitespace-nowrap px-3 py-3 font-medium text-slate-700 dark:text-navy-100">
                                {{ $transaction['id'] }}
                            </td>
                            <td class="whitespace-nowrap px-3 py-3 font-medium text-slate-700 dark:text-navy-100">
                                {{ $transaction['customer'] }}
                            </td>
                            <td class="whitespace-nowrap px-3 py-3 font-medium text-slate-700 dark:text-navy-100">
                                ${{ number_format($transaction['amount'], 2) }}
                            </td>
                            <td class="whitespace-nowrap px-3 py-3">
                                <div class="badge rounded-full px-2 py-1
                                    @if($transaction['status'] === 'completed') bg-success/10 text-success
                                    @elseif($transaction['status'] === 'pending') bg-warning/10 text-warning
                                    @else bg-error/10 text-error @endif">
                                    {{ ucfirst($transaction['status']) }}
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-3 py-3 font-medium text-slate-700 dark:text-navy-100">
                                {{ $transaction['date'] }}
                            </td>
                            <td class="whitespace-nowrap px-3 py-3 font-medium text-slate-700 dark:text-navy-100">
                                {{ $transaction['payment_method'] }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mt-4 sm:mt-5 lg:mt-6">
        <div class="card p-4 sm:p-5">
            <h2 class="font-medium tracking-wide text-slate-700 dark:text-navy-100">
                Quick Actions
            </h2>
            <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-4 sm:gap-5">
                <a href="#"
                    class="card flex flex-col items-center justify-center p-4 text-center hover:bg-slate-100 dark:hover:bg-navy-600">
                    <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-primary/10 dark:bg-accent/10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary dark:text-accent-light"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </div>
                    <h3 class="mt-3 text-base font-medium text-slate-700 dark:text-navy-100">
                        Create Invoice
                    </h3>
                    <p class="mt-1 text-xs+ text-slate-400 dark:text-navy-300">
                        Generate a new invoice
                    </p>
                </a>

                <a href="#"
                    class="card flex flex-col items-center justify-center p-4 text-center hover:bg-slate-100 dark:hover:bg-navy-600">
                    <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-success/10 dark:bg-success/15">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-success" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <h3 class="mt-3 text-base font-medium text-slate-700 dark:text-navy-100">
                        View Reports
                    </h3>
                    <p class="mt-1 text-xs+ text-slate-400 dark:text-navy-300">
                        Access detailed reports
                    </p>
                </a>

                <a href="#"
                    class="card flex flex-col items-center justify-center p-4 text-center hover:bg-slate-100 dark:hover:bg-navy-600">
                    <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-warning/10 dark:bg-warning/15">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-warning" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="mt-3 text-base font-medium text-slate-700 dark:text-navy-100">
                        Manage Payments
                    </h3>
                    <p class="mt-1 text-xs+ text-slate-400 dark:text-navy-300">
                        Configure payment methods
                    </p>
                </a>

                <a href="#"
                    class="card flex flex-col items-center justify-center p-4 text-center hover:bg-slate-100 dark:hover:bg-navy-600">
                    <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-info/10 dark:bg-info/15">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-info" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h3 class="mt-3 text-base font-medium text-slate-700 dark:text-navy-100">
                        Settings
                    </h3>
                    <p class="mt-1 text-xs+ text-slate-400 dark:text-navy-300">
                        Configure your account
                    </p>
                </a>
            </div>
        </div>
    </div>
</div>
