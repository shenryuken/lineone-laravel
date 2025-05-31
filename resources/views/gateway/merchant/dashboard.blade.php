<x-app-layout-sideblock title="Payment Gateway Dashboard" is-header-blur="true">
    <!-- Main Content Wrapper -->
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        <div class="mt-4 sm:mt-5 md:mt-6">
            <!-- Page Header -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between space-y-2 sm:space-y-0 pb-5 border-b border-slate-200 dark:border-navy-500">
                <div>
                    <h2 class="text-xl font-medium text-slate-700 dark:text-navy-50">
                        Payment Gateway Dashboard
                    </h2>
                    <p class="mt-1 text-sm text-slate-500 dark:text-navy-300">
                        Monitor your payment gateway performance and transactions
                    </p>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4 mt-5">
                <!-- Active API Keys -->
                <div class="card p-4 sm:p-5 lg:p-6">
                    <div class="flex justify-between">
                        <div>
                            <p class="text-sm+ text-slate-600 dark:text-navy-100">Active API Keys</p>
                            <div class="mt-3 flex items-baseline space-x-1">
                                <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">{{ $activeApiKeys }}</p>
                                <p class="text-xs text-info">Keys</p>
                            </div>
                        </div>
                        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-primary/10 dark:bg-accent-light/10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary dark:text-accent-light" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1721 9z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Today's Orders -->
                <div class="card p-4 sm:p-5 lg:p-6">
                    <div class="flex justify-between">
                        <div>
                            <p class="text-sm+ text-slate-600 dark:text-navy-100">Today's Orders</p>
                            <div class="mt-3 flex items-baseline space-x-1">
                                <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">{{ $todayOrders }}</p>
                                <p class="text-xs text-warning">Orders</p>
                            </div>
                        </div>
                        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-warning/10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-warning" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Successful Payments -->
                <div class="card p-4 sm:p-5 lg:p-6">
                    <div class="flex justify-between">
                        <div>
                            <p class="text-sm+ text-slate-600 dark:text-navy-100">Successful Payments</p>
                            <div class="mt-3 flex items-baseline space-x-1">
                                <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">{{ $successfulPayments }}</p>
                                <p class="text-xs text-success">Paid</p>
                            </div>
                        </div>
                        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-success/10 dark:bg-success/15">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-success" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Revenue -->
                <div class="card p-4 sm:p-5 lg:p-6">
                    <div class="flex justify-between">
                        <div>
                            <p class="text-sm+ text-slate-600 dark:text-navy-100">Total Revenue</p>
                            <div class="mt-3 flex items-baseline space-x-1">
                                <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">MYR {{ number_format($totalRevenue, 2) }}</p>
                                <p class="text-xs text-info">Revenue</p>
                            </div>
                        </div>
                        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-info/10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-info" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="card p-4 sm:p-5 lg:p-6 mt-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100">Recent Orders</h3>
                    <a href="{{ route('merchant.payment.gateway.transactions.index') }}" 
                       class="text-primary hover:text-primary-focus dark:text-accent-light dark:hover:text-accent text-sm">
                        View All
                    </a>
                </div>
                
                @if($recentOrders->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="border-b border-slate-200 dark:border-navy-500">
                                    <th class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">Order ID</th>
                                    <th class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">Amount</th>
                                    <th class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">Status</th>
                                    <th class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">Customer</th>
                                    <th class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentOrders as $order)
                                    <tr class="border-b border-slate-200 dark:border-navy-500">
                                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                            <span class="font-medium text-slate-700 dark:text-navy-100">{{ $order->order_id }}</span>
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                            <span class="text-slate-700 dark:text-navy-100">{{ $order->currency }} {{ number_format($order->amount, 2) }}</span>
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                            <div class="badge {{ $order->status === 'paid' ? 'bg-success/10 text-success dark:bg-success/15' : 
                                                   ($order->status === 'pending' ? 'bg-warning/10 text-warning dark:bg-warning/15' : 'bg-error/10 text-error dark:bg-error/15') }}">
                                                {{ ucfirst($order->status) }}
                                            </div>
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                            <span class="text-slate-700 dark:text-navy-100">{{ $order->customer_email }}</span>
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                            <span class="text-slate-500 dark:text-navy-300">{{ $order->created_at->format('M j, Y H:i') }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="text-slate-400 dark:text-navy-300 mb-4">
                            <svg class="mx-auto h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <p class="text-slate-500 dark:text-navy-300">No orders yet</p>
                        <p class="text-slate-400 dark:text-navy-400 text-sm mt-1">Orders will appear here once customers start making payments</p>
                    </div>
                @endif
            </div>
        </div>
    </main>
</x-app-layout-sideblock>
