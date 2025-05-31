<x-app-layout-sideblock title="API Keys Management" is-header-blur="true">
    <!-- Main Content Wrapper -->
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        <div class="mt-4 sm:mt-5 md:mt-6">
            <!-- Page Header -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between space-y-2 sm:space-y-0 pb-5 border-b border-slate-200 dark:border-navy-500">
                <div>
                    <h2 class="text-xl font-medium text-slate-700 dark:text-navy-50">
                        API Keys Management
                    </h2>
                    <p class="mt-1 text-sm text-slate-500 dark:text-navy-300">
                        Manage your payment gateway API keys for integration
                    </p>
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('merchant.api-keys.create') }}" 
                       class="btn h-9 rounded-full bg-primary/10 px-4 text-primary hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/30 dark:bg-accent-light/10 dark:text-accent-light dark:hover:bg-accent-light/20 dark:focus:bg-accent-light/20 dark:active:bg-accent-light/30">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>Create New API Key</span>
                    </a>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4 mt-5">
                <!-- Total API Keys -->
                <div class="card p-4 sm:p-5 lg:p-6">
                    <div class="flex justify-between">
                        <div>
                            <p class="text-sm+ text-slate-600 dark:text-navy-100">Total API Keys</p>
                            <div class="mt-3 flex items-baseline space-x-1">
                                <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">{{ $testKeys->count() + $liveKeys->count() }}</p>
                                <p class="text-xs text-info">Active</p>
                            </div>
                        </div>
                        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-primary/10 dark:bg-accent-light/10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary dark:text-accent-light" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Test Keys -->
                <div class="card p-4 sm:p-5 lg:p-6">
                    <div class="flex justify-between">
                        <div>
                            <p class="text-sm+ text-slate-600 dark:text-navy-100">Test Keys</p>
                            <div class="mt-3 flex items-baseline space-x-1">
                                <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">{{ $testKeys->count() }}</p>
                                <p class="text-xs text-warning">Development</p>
                            </div>
                        </div>
                        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-warning/10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-warning" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Live Keys -->
                <div class="card p-4 sm:p-5 lg:p-6">
                    <div class="flex justify-between">
                        <div>
                            <p class="text-sm+ text-slate-600 dark:text-navy-100">Live Keys</p>
                            <div class="mt-3 flex items-baseline space-x-1">
                                <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">{{ $liveKeys->count() }}</p>
                                <p class="text-xs text-success">Production</p>
                            </div>
                        </div>
                        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-success/10 dark:bg-success/15">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-success" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Active Keys -->
                <div class="card p-4 sm:p-5 lg:p-6">
                    <div class="flex justify-between">
                        <div>
                            <p class="text-sm+ text-slate-600 dark:text-navy-100">Active Keys</p>
                            <div class="mt-3 flex items-baseline space-x-1">
                                <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">{{ $testKeys->where('is_active', true)->count() + $liveKeys->where('is_active', true)->count() }}</p>
                                <p class="text-xs text-info">Running</p>
                            </div>
                        </div>
                        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-info/10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-info" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6 mt-5">
                <!-- Test Environment -->
                <div class="col-span-12 lg:col-span-6">
                    <div class="card p-4 sm:p-5">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                <div class="bg-warning/10 text-warning px-3 py-1 rounded-full text-sm font-medium mr-3 dark:bg-warning/15">
                                    TEST
                                </div>
                                <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">Test Environment</h2>
                            </div>
                            <a href="{{ route('merchant.api-keys.create') }}?mode=test" 
                               class="btn h-8 w-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                </svg>
                            </a>
                        </div>
                        <p class="text-slate-600 dark:text-navy-300 text-sm mb-4">Use these keys for testing. No real money will be processed.</p>
                        
                        @if($testKeys->count() > 0)
                            <div class="space-y-3">
                                @foreach($testKeys as $key)
                                    <div class="border border-slate-200 dark:border-navy-500 rounded-lg p-4 hover:bg-slate-50 dark:hover:bg-navy-600/50 transition-colors">
                                        <div class="flex justify-between items-start">
                                            <div class="flex-1">
                                                <div class="flex items-center">
                                                    <h3 class="font-medium text-slate-700 dark:text-navy-100">{{ $key->name }}</h3>
                                                    @if(!$key->is_active)
                                                        <span class="ml-2 bg-error/10 text-error px-2 py-1 rounded text-xs dark:bg-error/15">Inactive</span>
                                                    @endif
                                                    @if($key->isExpired())
                                                        <span class="ml-2 bg-slate-200 text-slate-600 px-2 py-1 rounded text-xs dark:bg-navy-500 dark:text-navy-200">Expired</span>
                                                    @endif
                                                </div>
                                                @if($key->description)
                                                    <p class="text-slate-500 dark:text-navy-300 text-sm mt-1">{{ $key->description }}</p>
                                                @endif
                                                <div class="mt-2 space-y-1">
                                                    <div class="text-sm">
                                                        <span class="text-slate-500 dark:text-navy-300">API Key:</span>
                                                        <code class="bg-slate-100 dark:bg-navy-700 px-2 py-1 rounded text-xs ml-2 text-slate-700 dark:text-navy-100">{{ $key->api_key }}</code>
                                                    </div>
                                                    <div class="text-sm">
                                                        <span class="text-slate-500 dark:text-navy-300">Last used:</span>
                                                        <span class="ml-2 text-slate-600 dark:text-navy-200">{{ $key->last_used_at ? $key->last_used_at->diffForHumans() : 'Never' }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex space-x-2">
                                                <a href="{{ route('merchant.api-keys.show', $key) }}" 
                                                   class="text-primary hover:text-primary-focus dark:text-accent-light dark:hover:text-accent text-sm">View</a>
                                                <a href="{{ route('merchant.api-keys.edit', $key) }}" 
                                                   class="text-slate-600 hover:text-slate-800 dark:text-navy-300 dark:hover:text-navy-100 text-sm">Edit</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <div class="text-slate-400 dark:text-navy-300 mb-4">
                                    <svg class="mx-auto h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100 mb-2">No test API keys</h3>
                                <p class="text-slate-500 dark:text-navy-300 mb-4">Create your first test API key to start integrating with our payment gateway.</p>
                                <a href="{{ route('merchant.api-keys.create') }}?mode=test" 
                                   class="btn bg-warning text-white hover:bg-warning-focus focus:bg-warning-focus active:bg-warning-focus/90">
                                    Create Test API Key
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Live Environment -->
                <div class="col-span-12 lg:col-span-6">
                    <div class="card p-4 sm:p-5">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                <div class="bg-success/10 text-success px-3 py-1 rounded-full text-sm font-medium mr-3 dark:bg-success/15">
                                    LIVE
                                </div>
                                <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">Live Environment</h2>
                            </div>
                            <a href="{{ route('merchant.api-keys.create') }}?mode=live" 
                               class="btn h-8 w-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                </svg>
                            </a>
                        </div>
                        <p class="text-slate-600 dark:text-navy-300 text-sm mb-4">Use these keys for production. Real money will be processed.</p>
                        
                        @if($liveKeys->count() > 0)
                            <div class="space-y-3">
                                @foreach($liveKeys as $key)
                                    <div class="border border-slate-200 dark:border-navy-500 rounded-lg p-4 hover:bg-slate-50 dark:hover:bg-navy-600/50 transition-colors">
                                        <div class="flex justify-between items-start">
                                            <div class="flex-1">
                                                <div class="flex items-center">
                                                    <h3 class="font-medium text-slate-700 dark:text-navy-100">{{ $key->name }}</h3>
                                                    @if(!$key->is_active)
                                                        <span class="ml-2 bg-error/10 text-error px-2 py-1 rounded text-xs dark:bg-error/15">Inactive</span>
                                                    @endif
                                                    @if($key->isExpired())
                                                        <span class="ml-2 bg-slate-200 text-slate-600 px-2 py-1 rounded text-xs dark:bg-navy-500 dark:text-navy-200">Expired</span>
                                                    @endif
                                                </div>
                                                @if($key->description)
                                                    <p class="text-slate-500 dark:text-navy-300 text-sm mt-1">{{ $key->description }}</p>
                                                @endif
                                                <div class="mt-2 space-y-1">
                                                    <div class="text-sm">
                                                        <span class="text-slate-500 dark:text-navy-300">API Key:</span>
                                                        <code class="bg-slate-100 dark:bg-navy-700 px-2 py-1 rounded text-xs ml-2 text-slate-700 dark:text-navy-100">{{ $key->api_key }}</code>
                                                    </div>
                                                    <div class="text-sm">
                                                        <span class="text-slate-500 dark:text-navy-300">Last used:</span>
                                                        <span class="ml-2 text-slate-600 dark:text-navy-200">{{ $key->last_used_at ? $key->last_used_at->diffForHumans() : 'Never' }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex space-x-2">
                                                <a href="{{ route('merchant.api-keys.show', $key) }}" 
                                                   class="text-primary hover:text-primary-focus dark:text-accent-light dark:hover:text-accent text-sm">View</a>
                                                <a href="{{ route('merchant.api-keys.edit', $key) }}" 
                                                   class="text-slate-600 hover:text-slate-800 dark:text-navy-300 dark:hover:text-navy-100 text-sm">Edit</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <div class="text-slate-400 dark:text-navy-300 mb-4">
                                    <svg class="mx-auto h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100 mb-2">No live API keys</h3>
                                <p class="text-slate-500 dark:text-navy-300 mb-4">Create live API keys when you're ready to accept real payments.</p>
                                <a href="{{ route('merchant.api-keys.create') }}?mode=live" 
                                   class="btn bg-success text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
                                    Create Live API Key
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-app-layout-sideblock>
