<x-app-layout-sideblock title="Profile Settings" is-header-blur="true">
<div class="py-5">
    <div class="container mx-auto px-4">
        <div class="flex flex-col lg:flex-row">
            <!-- Settings Sidebar -->
            <div class="w-full lg:w-64 mb-6 lg:mb-0 lg:mr-8">
                <div class="card p-4">
                    <h2 class="text-lg font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 mb-4">
                        Settings
                    </h2>
                    <div class="space-y-1">
                        <a href="{{ route('settings.profile') }}" 
                           class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('settings.profile') ? 'bg-primary/10 text-primary dark:bg-accent-light/10 dark:text-accent-light' : 'hover:bg-slate-100 dark:hover:bg-navy-600' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span>Profile</span>
                        </a>
                        <a href="{{ route('settings.security') }}" 
                           class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('settings.security') ? 'bg-primary/10 text-primary dark:bg-accent-light/10 dark:text-accent-light' : 'hover:bg-slate-100 dark:hover:bg-navy-600' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            <span>Security</span>
                        </a>
                        <a href="{{ route('settings.notifications') }}" 
                           class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('settings.notifications') ? 'bg-primary/10 text-primary dark:bg-accent-light/10 dark:text-accent-light' : 'hover:bg-slate-100 dark:hover:bg-navy-600' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            <span>Notifications</span>
                        </a>
                        <a href="{{ route('settings.limits') }}" 
                           class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('settings.limits') ? 'bg-primary/10 text-primary dark:bg-accent-light/10 dark:text-accent-light' : 'hover:bg-slate-100 dark:hover:bg-navy-600' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Transfer Limits</span>
                        </a>
                        <a href="{{ route('settings.preferences') }}" 
                           class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('settings.preferences') ? 'bg-primary/10 text-primary dark:bg-accent-light/10 dark:text-accent-light' : 'hover:bg-slate-100 dark:hover:bg-navy-600' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>Preferences</span>
                        </a>
                        @if(auth()->user()->hasAnyRole(['merchant', 'admin']))
                        <a href="{{ route('settings.api') }}" 
                           class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('settings.api') ? 'bg-primary/10 text-primary dark:bg-accent-light/10 dark:text-accent-light' : 'hover:bg-slate-100 dark:hover:bg-navy-600' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                            </svg>
                            <span>API Settings</span>
                        </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <main class="main-content w-full px-[var(--margin-x)] pb-8">
                <div class="card p-4 sm:p-5">
                    <h2 class="text-lg font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 mb-4">
                        Profile Information
                    </h2>
                    
                    <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
                        @csrf
                        @method('patch')
                        
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-navy-100">
                                    Name
                                </label>
                                <input type="text" name="name" value="{{ auth()->user()->name }}"
                                    class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">
                                @error('name')
                                    <span class="text-tiny+ text-error">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-navy-100">
                                    Email
                                </label>
                                <input type="email" name="email" value="{{ auth()->user()->email }}"
                                    class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">
                                @error('email')
                                    <span class="text-tiny+ text-error">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-navy-100">
                                    Phone Number
                                </label>
                                <input type="tel" name="phone" value="{{ auth()->user()->phone }}"
                                    class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">
                                @error('phone')
                                    <span class="text-tiny+ text-error">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-navy-100">
                                    Country
                                </label>
                                <select name="country"
                                    class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">
                                    <option value="MY" {{ auth()->user()->country == 'MY' ? 'selected' : '' }}>Malaysia</option>
                                    <option value="SG" {{ auth()->user()->country == 'SG' ? 'selected' : '' }}>Singapore</option>
                                    <option value="ID" {{ auth()->user()->country == 'ID' ? 'selected' : '' }}>Indonesia</option>
                                    <option value="TH" {{ auth()->user()->country == 'TH' ? 'selected' : '' }}>Thailand</option>
                                </select>
                                @error('country')
                                    <span class="text-tiny+ text-error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-navy-100">
                                Address
                            </label>
                            <textarea name="address" rows="3"
                                class="form-textarea mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">{{ auth()->user()->address }}</textarea>
                            @error('address')
                                <span class="text-tiny+ text-error">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="flex justify-end space-x-2">
                            <button type="submit"
                                class="btn bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>
</div>
</x-app-layout-sideblock>
