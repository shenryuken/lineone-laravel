<x-app-layout-sideblock title="Create API Key" is-header-blur="true">
    <!-- Main Content Wrapper -->
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        <div class="mt-4 sm:mt-5 md:mt-6">
            <!-- Page Header -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between space-y-2 sm:space-y-0 pb-5 border-b border-slate-200 dark:border-navy-500">
                <div>
                    <h2 class="text-xl font-medium text-slate-700 dark:text-navy-50">
                        Create New API Key
                    </h2>
                    <p class="mt-1 text-sm text-slate-500 dark:text-navy-300">
                        Generate a new API key for your payment gateway integration
                    </p>
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('merchant.api-keys.index') }}" 
                       class="btn h-9 rounded-full bg-slate-150 px-4 text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        <span>Back to API Keys</span>
                    </a>
                </div>
            </div>

            <!-- Form Container -->
            <div class="mt-5 max-w-4xl">
                <div class="card p-4 sm:p-5 lg:p-6">
                    <form action="{{ route('merchant.api-keys.store') }}" method="POST">
                        @csrf
                        
                        <!-- Environment Selection -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-slate-700 dark:text-navy-100 mb-3">Environment</label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <label class="relative">
                                    <input type="radio" name="mode" value="test" 
                                           {{ old('mode', request('mode')) === 'test' ? 'checked' : '' }}
                                           class="sr-only peer">
                                    <div class="border-2 border-slate-200 dark:border-navy-500 rounded-lg p-4 cursor-pointer peer-checked:border-warning peer-checked:bg-warning/5 dark:peer-checked:bg-warning/10 hover:bg-slate-50 dark:hover:bg-navy-600/50 transition-all">
                                        <div class="flex items-center">
                                            <div class="bg-warning/10 text-warning px-3 py-1 rounded-full text-sm font-medium mr-3 dark:bg-warning/15">
                                                TEST
                                            </div>
                                        </div>
                                        <p class="text-sm text-slate-600 dark:text-navy-300 mt-2">For development and testing. No real money processed.</p>
                                    </div>
                                </label>
                                
                                <label class="relative">
                                    <input type="radio" name="mode" value="live" 
                                           {{ old('mode', request('mode')) === 'live' ? 'checked' : '' }}
                                           class="sr-only peer">
                                    <div class="border-2 border-slate-200 dark:border-navy-500 rounded-lg p-4 cursor-pointer peer-checked:border-success peer-checked:bg-success/5 dark:peer-checked:bg-success/10 hover:bg-slate-50 dark:hover:bg-navy-600/50 transition-all">
                                        <div class="flex items-center">
                                            <div class="bg-success/10 text-success px-3 py-1 rounded-full text-sm font-medium mr-3 dark:bg-success/15">
                                                LIVE
                                            </div>
                                        </div>
                                        <p class="text-sm text-slate-600 dark:text-navy-300 mt-2">For production use. Real money will be processed.</p>
                                    </div>
                                </label>
                            </div>
                            @error('mode')
                                <p class="text-error text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Basic Information -->
                        <div class="grid grid-cols-1 gap-6 mb-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-slate-700 dark:text-navy-100 mb-2">
                                    API Key Name <span class="text-error">*</span>
                                </label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}"
                                       class="form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                       placeholder="e.g., My Store API Key" required>
                                @error('name')
                                    <p class="text-error text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-medium text-slate-700 dark:text-navy-100 mb-2">
                                    Description
                                </label>
                                <textarea id="description" name="description" rows="3"
                                          class="form-textarea w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                          placeholder="Optional description for this API key">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="text-error text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Limits -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="daily_limit" class="block text-sm font-medium text-slate-700 dark:text-navy-100 mb-2">
                                    Daily Limit (MYR) <span class="text-error">*</span>
                                </label>
                                <input type="number" id="daily_limit" name="daily_limit" 
                                       value="{{ old('daily_limit', '10000') }}" step="0.01" min="1"
                                       class="form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                       required>
                                @error('daily_limit')
                                    <p class="text-error text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="per_transaction_limit" class="block text-sm font-medium text-slate-700 dark:text-navy-100 mb-2">
                                    Per Transaction Limit (MYR) <span class="text-error">*</span>
                                </label>
                                <input type="number" id="per_transaction_limit" name="per_transaction_limit" 
                                       value="{{ old('per_transaction_limit', '1000') }}" step="0.01" min="1"
                                       class="form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                       required>
                                @error('per_transaction_limit')
                                    <p class="text-error text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Webhook URL -->
                        <div class="mb-6">
                            <label for="webhook_url" class="block text-sm font-medium text-slate-700 dark:text-navy-100 mb-2">
                                Webhook URL
                            </label>
                            <input type="url" id="webhook_url" name="webhook_url" value="{{ old('webhook_url') }}"
                                   class="form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                   placeholder="https://yoursite.com/webhooks/payment">
                            <p class="text-slate-500 dark:text-navy-300 text-sm mt-1">We'll send payment notifications to this URL</p>
                            @error('webhook_url')
                                <p class="text-error text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Advanced Settings -->
                        <div class="border-t border-slate-200 dark:border-navy-500 pt-6 mb-6">
                            <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100 mb-4">Advanced Settings</h3>
                            
                            <div class="grid grid-cols-1 gap-6">
                                <div>
                                    <label for="allowed_domains" class="block text-sm font-medium text-slate-700 dark:text-navy-100 mb-2">
                                        Allowed Domains (CORS)
                                    </label>
                                    <input type="text" id="allowed_domains" name="allowed_domains" value="{{ old('allowed_domains') }}"
                                           class="form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                           placeholder="example.com, app.example.com">
                                    <p class="text-slate-500 dark:text-navy-300 text-sm mt-1">Comma-separated list of domains allowed to make API calls</p>
                                    @error('allowed_domains')
                                        <p class="text-error text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="expires_in_days" class="block text-sm font-medium text-slate-700 dark:text-navy-100 mb-2">
                                        Expires In (Days)
                                    </label>
                                    <select id="expires_in_days" name="expires_in_days"
                                            class="form-select w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">
                                        <option value="">Never expires</option>
                                        <option value="30" {{ old('expires_in_days') == '30' ? 'selected' : '' }}>30 days</option>
                                        <option value="90" {{ old('expires_in_days') == '90' ? 'selected' : '' }}>90 days</option>
                                        <option value="180" {{ old('expires_in_days') == '180' ? 'selected' : '' }}>180 days</option>
                                        <option value="365" {{ old('expires_in_days') == '365' ? 'selected' : '' }}>1 year</option>
                                    </select>
                                    @error('expires_in_days')
                                        <p class="text-error text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-4">
                            <a href="{{ route('merchant.api-keys.index') }}" 
                               class="btn bg-slate-150 font-medium text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90 w-full sm:w-auto justify-center">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="btn bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90 w-full sm:w-auto justify-center">
                                Create API Key
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</x-app-layout-sideblock>
