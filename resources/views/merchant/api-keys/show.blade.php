<x-app-layout-sideblock title="API Key Details" is-header-blur="true">
    <!-- Main Content Wrapper -->
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        <div class="mt-4 sm:mt-5 md:mt-6">
            <!-- Page Header -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between space-y-2 sm:space-y-0 pb-5 border-b border-slate-200 dark:border-navy-500">
                <div>
                    <div class="flex flex-col sm:flex-row sm:items-center">
                        <h2 class="text-xl font-medium text-slate-700 dark:text-navy-50">{{ $apiKey->name }}</h2>
                        <div class="mt-2 sm:mt-0 sm:ml-4 flex items-center space-x-2">
                            @if($apiKey->mode === 'test')
                                <span class="bg-warning/10 text-warning px-3 py-1 rounded-full text-sm font-medium dark:bg-warning/15">TEST</span>
                            @else
                                <span class="bg-success/10 text-success px-3 py-1 rounded-full text-sm font-medium dark:bg-success/15">LIVE</span>
                            @endif
                            @if(!$apiKey->is_active)
                                <span class="bg-error/10 text-error px-3 py-1 rounded-full text-sm font-medium dark:bg-error/15">INACTIVE</span>
                            @endif
                        </div>
                    </div>
                    @if($apiKey->description)
                        <p class="mt-1 text-sm text-slate-500 dark:text-navy-300">{{ $apiKey->description }}</p>
                    @endif
                </div>
                <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3">
                    <a href="{{ route('merchant.api-keys.edit', $apiKey) }}" 
                       class="btn bg-slate-150 font-medium text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90 justify-center">
                        Edit
                    </a>
                    <form action="{{ route('merchant.api-keys.toggle', $apiKey) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" 
                                class="btn font-medium text-white w-full sm:w-auto justify-center {{ $apiKey->is_active ? 'bg-error hover:bg-error-focus focus:bg-error-focus active:bg-error-focus/90' : 'bg-success hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90' }}">
                            {{ $apiKey->is_active ? 'Deactivate' : 'Activate' }}
                        </button>
                    </form>
                </div>
            </div>

            <!-- API Keys Display -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-5">
                <!-- API Key -->
                <div class="card p-4 sm:p-5 lg:p-6">
                    <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100 mb-4">API Key (Public)</h3>
                    <div class="bg-slate-100 dark:bg-navy-700 rounded-lg p-4">
                        <code class="text-sm break-all text-slate-700 dark:text-navy-100">{{ $apiKey->api_key }}</code>
                        <button onclick="copyToClipboard('{{ $apiKey->api_key }}')" 
                                class="ml-2 text-primary hover:text-primary-focus dark:text-accent-light dark:hover:text-accent text-sm">
                            Copy
                        </button>
                    </div>
                    <p class="text-slate-500 dark:text-navy-300 text-sm mt-2">Use this key in your API requests headers</p>
                </div>

                <!-- Secret Key -->
                <div class="card p-4 sm:p-5 lg:p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100">Secret Key (Private)</h3>
                        <form action="{{ route('merchant.api-keys.regenerate-secret', $apiKey) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" 
                                    onclick="return confirm('Are you sure? This will invalidate the current secret key.')"
                                    class="text-error hover:text-error-focus dark:text-error-light dark:hover:text-error text-sm">
                                Regenerate
                            </button>
                        </form>
                    </div>
                    
                    @if(session('new_secret_key'))
                        <div class="bg-success/10 border border-success/20 rounded-lg p-4 mb-4 dark:bg-success/15">
                            <p class="text-success text-sm font-medium mb-2">⚠️ Save this secret key now!</p>
                            <div class="bg-white dark:bg-navy-700 rounded p-3">
                                <code class="text-sm break-all text-slate-700 dark:text-navy-100">{{ session('new_secret_key') }}</code>
                                <button onclick="copyToClipboard('{{ session('new_secret_key') }}')" 
                                        class="ml-2 text-primary hover:text-primary-focus dark:text-accent-light dark:hover:text-accent text-sm">
                                    Copy
                                </button>
                            </div>
                            <p class="text-success text-xs mt-2">This is the only time we'll show you this key.</p>
                        </div>
                    @else
                        <div class="bg-slate-100 dark:bg-navy-700 rounded-lg p-4">
                            <code class="text-sm text-slate-700 dark:text-navy-100">{{ $apiKey->masked_secret_key }}</code>
                        </div>
                        <p class="text-slate-500 dark:text-navy-300 text-sm mt-2">Secret keys are hidden for security</p>
                    @endif
                </div>
            </div>

            <!-- Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                <div class="card p-4 sm:p-5 lg:p-6">
                    <div class="flex justify-between">
                        <div>
                            <p class="text-sm+ text-slate-600 dark:text-navy-100">Today's Revenue</p>
                            <div class="mt-3 flex items-baseline space-x-1">
                                <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">MYR {{ number_format($todayStats['total_amount'], 2) }}</p>
                                <p class="text-xs text-success">Revenue</p>
                            </div>
                        </div>
                        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-success/10 dark:bg-success/15">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-success" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="card p-4 sm:p-5 lg:p-6">
                    <div class="flex justify-between">
                        <div>
                            <p class="text-sm+ text-slate-600 dark:text-navy-100">Today's Orders</p>
                            <div class="mt-3 flex items-baseline space-x-1">
                                <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">{{ $todayStats['total_orders'] }}</p>
                                <p class="text-xs text-primary dark:text-accent-light">Orders</p>
                            </div>
                        </div>
                        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-primary/10 dark:bg-accent-light/10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary dark:text-accent-light" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="card p-4 sm:p-5 lg:p-6">
                    <div class="flex justify-between">
                        <div>
                            <p class="text-sm+ text-slate-600 dark:text-navy-100">Success Rate</p>
                            <div class="mt-3 flex items-baseline space-x-1">
                                <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">
                                    {{ $todayStats['total_orders'] > 0 ? number_format(($todayStats['successful_orders'] / $todayStats['total_orders']) * 100, 1) : 0 }}%
                                </p>
                                <p class="text-xs text-info">Success</p>
                            </div>
                        </div>
                        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-info/10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-info" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Configuration Details -->
            <div class="card p-4 sm:p-5 lg:p-6 mt-6">
                <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100 mb-4">Configuration</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-500 dark:text-navy-300">Daily Limit</label>
                        <p class="text-slate-700 dark:text-navy-100">MYR {{ number_format($apiKey->daily_limit, 2) }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-500 dark:text-navy-300">Per Transaction Limit</label>
                        <p class="text-slate-700 dark:text-navy-100">MYR {{ number_format($apiKey->per_transaction_limit, 2) }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-500 dark:text-navy-300">Webhook URL</label>
                        <p class="text-slate-700 dark:text-navy-100 break-all">{{ $apiKey->webhook_url ?: 'Not configured' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-500 dark:text-navy-300">Last Used</label>
                        <p class="text-slate-700 dark:text-navy-100">{{ $apiKey->last_used_at ? $apiKey->last_used_at->diffForHumans() : 'Never' }}</p>
                    </div>
                    @if($apiKey->allowed_domains)
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-500 dark:text-navy-300">Allowed Domains</label>
                            <p class="text-slate-700 dark:text-navy-100">{{ implode(', ', $apiKey->allowed_domains) }}</p>
                        </div>
                    @endif
                    @if($apiKey->expires_at)
                        <div>
                            <label class="block text-sm font-medium text-slate-500 dark:text-navy-300">Expires</label>
                            <p class="text-slate-700 dark:text-navy-100">{{ $apiKey->expires_at->format('M j, Y') }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="card p-4 sm:p-5 lg:p-6 mt-6">
                <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100 mb-4">Recent Orders</h3>
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
                    </div>
                @endif
            </div>
        </div>
    </main>

    <script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(function() {
            // You can add a toast notification here
            alert('Copied to clipboard!');
        });
    }
    </script>
</x-app-layout-sideblock>
