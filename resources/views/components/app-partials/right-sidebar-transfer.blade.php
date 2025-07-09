<div x-show="$store.global.isRightSidebarExpanded" @keydown.window.escape="$store.global.isRightSidebarExpanded = false">
    <div class="fixed inset-0 z-150 bg-slate-900/60 transition-opacity duration-200"
        @click="$store.global.isRightSidebarExpanded = false" x-show="$store.global.isRightSidebarExpanded"
        x-transition:enter="ease-out" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
    <div class="fixed right-0 top-0 z-151 h-full w-full sm:w-80">
        <div x-data="{ 
            activeTab: 'tabTransfer', 
            transferAmount: '', 
            selectedReceiver: null, 
            showTransferForm: false,
            showQrCode: false,
            showQrScanner: false,
            resetForm() {
                this.transferAmount = '';
                this.selectedReceiver = null;
            }
        }"
            class="relative flex h-full w-full transform-gpu flex-col bg-white transition-transform duration-200 dark:bg-navy-750"
            x-show="$store.global.isRightSidebarExpanded" x-transition:enter="ease-out"
            x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
            x-transition:leave="ease-in" x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full">
            
            <!-- Header -->
            <div class="flex items-center justify-between py-2 px-4 border-b border-slate-150 dark:border-navy-600">
                <p x-show="activeTab === 'tabTransfer'" class="flex shrink-0 items-center space-x-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-primary dark:text-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-sm font-medium">Quick Transfer</span>
                </p>
                <p x-show="activeTab === 'tabHistory'" class="flex shrink-0 items-center space-x-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-primary dark:text-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-sm font-medium">Recent Transfers</span>
                </p>
                <p x-show="activeTab === 'tabFavorites'" class="flex shrink-0 items-center space-x-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-primary dark:text-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                    <span class="text-sm font-medium">Favorites</span>
                </p>

                <button @click="$store.global.isRightSidebarExpanded=false"
                    class="btn -mr-1 size-6 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Transfer Tab -->
            <div x-show="activeTab === 'tabTransfer' && !showQrCode && !showQrScanner" x-transition:enter="transition-all duration-500 easy-in-out"
                x-transition:enter-start="opacity-0 [transform:translate3d(0,1rem,0)]"
                x-transition:enter-end="opacity-100 [transform:translate3d(0,0,0)]"
                class="is-scrollbar-hidden overflow-y-auto overscroll-contain pt-1 flex-1">
                
                <!-- Wallet Balance -->
                <div class="mx-3 mb-4">
                    <div class="relative flex h-32 w-full flex-col overflow-hidden rounded-xl bg-gradient-to-br from-primary to-primary-focus p-4 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs opacity-80">Available Balance</p>
                                <p class="text-2xl font-bold">RM {{ number_format(Auth::user()->wallet_balance ?? 0, 2) }}</p>
                            </div>
                            <div class="avatar size-12">
                                <div class="is-initial rounded-full bg-white/20 text-white flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="mt-auto">
                            <p class="text-xs opacity-80">{{ Auth::user()->name }}</p>
                            <p class="text-xs opacity-60">**** **** **** {{ substr(Auth::user()->phone ?? '0000', -4) }}</p>
                        </div>
                        <div class="mask is-reuleaux-triangle absolute top-0 right-0 -m-3 size-16 bg-white/10"></div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="mx-3 mb-4">
                    <div class="grid grid-cols-4 gap-3">
                        <button @click="showTransferForm = true" class="flex flex-col items-center p-3 rounded-lg bg-slate-100 hover:bg-slate-200 dark:bg-navy-600 dark:hover:bg-navy-500 transition-colors">
                            <div class="avatar size-10 mb-2">
                                <div class="is-initial rounded-full bg-success text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                </div>
                            </div>
                            <span class="text-xs font-medium">Send</span>
                        </button>
                        <button class="flex flex-col items-center p-3 rounded-lg bg-slate-100 hover:bg-slate-200 dark:bg-navy-600 dark:hover:bg-navy-500 transition-colors">
                            <div class="avatar size-10 mb-2">
                                <div class="is-initial rounded-full bg-info text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                    </svg>
                                </div>
                            </div>
                            <span class="text-xs font-medium">Request</span>
                        </button>
                        <button class="flex flex-col items-center p-3 rounded-lg bg-slate-100 hover:bg-slate-200 dark:bg-navy-600 dark:hover:bg-navy-500 transition-colors">
                            <div class="avatar size-10 mb-2">
                                <div class="is-initial rounded-full bg-warning text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                            <span class="text-xs font-medium">Top Up</span>
                        </button>
                        <button @click="showQrCode = true" class="flex flex-col items-center p-3 rounded-lg bg-slate-100 hover:bg-slate-200 dark:bg-navy-600 dark:hover:bg-navy-500 transition-colors">
                            <div class="avatar size-10 mb-2">
                                <div class="is-initial rounded-full bg-secondary text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                    </svg>
                                </div>
                            </div>
                            <span class="text-xs font-medium">QR Code</span>
                        </button>
                    </div>
                </div>

                <!-- Scan QR Button -->
                <div class="mx-3 mb-4">
                    <button @click="showQrScanner = true" class="btn w-full bg-slate-150 text-slate-800 hover:bg-slate-200 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 flex items-center justify-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>Scan QR Code to Pay</span>
                    </button>
                </div>

                <!-- Search -->
                <div class="mx-3 mb-4">
                    <label class="relative flex">
                        <input
                            class="form-input peer h-10 w-full rounded-lg bg-slate-150 px-3 py-2 pl-9 text-xs-plus ring-primary/50 placeholder:text-slate-400 hover:bg-slate-200 focus:ring-3 dark:bg-navy-900/90 dark:ring-accent/50 dark:placeholder:text-navy-300 dark:hover:bg-navy-900 dark:focus:bg-navy-900"
                            placeholder="Search contacts..." type="text" />
                        <span class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4.5 transition-colors duration-200" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M3.316 13.781l.73-.171-.73.171zm0-5.457l.73.171-.73-.171zm15.473 0l.73-.171-.73.171zm0 5.457l.73.171-.73-.171zm-5.008 5.008l-.171-.73.171.73zm-5.457 0l-.171.73.171-.73zm0-15.473l-.171-.73.171.73zm5.457 0l.171-.73-.171.73zM20.47 21.53a.75.75 0 101.06-1.06l-1.06 1.06zM4.046 13.61a11.198 11.198 0 010-5.115l-1.46-.342a12.698 12.698 0 000 5.8l1.46-.343zm14.013-5.115a11.196 11.196 0 010 5.115l1.46.342a12.698 12.698 0 000-5.8l-1.46.343zm-4.45 9.564a11.196 11.196 0 01-5.114 0l-.342 1.46c1.907.448 3.892.448 5.8 0l-.343-1.46zM8.496 4.046a11.198 11.198 0 015.115 0l.342-1.46a12.698 12.698 0 00-5.8 0l.343 1.46zm0 14.013a5.97 5.97 0 01-4.45-4.45l-1.46.343a7.47 7.47 0 005.568 5.568l.342-1.46zm5.457 1.46a7.47 7.47 0 005.568-5.567l-1.46-.342a5.97 5.97 0 01-4.45 4.45l.342 1.46zM13.61 4.046a5.97 5.97 0 014.45 4.45l1.46-.343a7.47 7.47 0 00-5.568-5.567l-.342 1.46zm-5.457-1.46a7.47 7.47 0 00-5.567 5.567l1.46.342a5.97 5.97 0 014.45-4.45l-.343-1.46zm8.652 15.28l3.665 3.664 1.06-1.06-3.665-3.665-1.06 1.06z" />
                            </svg>
                        </span>
                    </label>
                </div>

                <!-- Favorite Recipients -->
                <div class="mx-3 mb-4">
                    <h3 class="text-sm font-medium text-slate-700 dark:text-navy-100 mb-3">Favorite Recipients</h3>
                    <div class="space-y-2">
                        <!-- Favorite Contact 1 -->
                        {{-- <div @click="selectedReceiver = 'john_doe'; showTransferForm = true" class="flex items-center p-3 rounded-lg bg-slate-100 hover:bg-slate-200 dark:bg-navy-600 dark:hover:bg-navy-500 cursor-pointer transition-colors">
                            <div class="avatar size-10 mr-3">
                                <img class="rounded-full" src="{{asset('images/200x200.png')}}" alt="avatar" />
                            </div>
                            <div class="flex-1">
                                <p class="font-medium text-slate-700 dark:text-navy-100">John Doe</p>
                                <p class="text-xs text-slate-400 dark:text-navy-300">+60 12-345 6789</p>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="badge bg-success/10 text-success text-xs">Frequent</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                        </div> --}}

                        <!-- Favorite Contact 2 -->
                        {{-- <div @click="selectedReceiver = 'sarah_wilson'; showTransferForm = true" class="flex items-center p-3 rounded-lg bg-slate-100 hover:bg-slate-200 dark:bg-navy-600 dark:hover:bg-navy-500 cursor-pointer transition-colors">
                            <div class="avatar size-10 mr-3">
                                <div class="is-initial rounded-full bg-info text-white">SW</div>
                            </div>
                            <div class="flex-1">
                                <p class="font-medium text-slate-700 dark:text-navy-100">Sarah Wilson</p>
                                <p class="text-xs text-slate-400 dark:text-navy-300">sarah@example.com</p>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="badge bg-primary/10 text-primary text-xs">Family</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                        </div> --}}

                        <!-- Favorite Contact 3 -->
                        {{-- <div @click="selectedReceiver = 'mike_chen'; showTransferForm = true" class="flex items-center p-3 rounded-lg bg-slate-100 hover:bg-slate-200 dark:bg-navy-600 dark:hover:bg-navy-500 cursor-pointer transition-colors">
                            <div class="avatar size-10 mr-3">
                                <div class="is-initial rounded-full bg-warning text-white">MC</div>
                            </div>
                            <div class="flex-1">
                                <p class="font-medium text-slate-700 dark:text-navy-100">Mike Chen</p>
                                <p class="text-xs text-slate-400 dark:text-navy-300">+60 19-876 5432</p>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="badge bg-secondary/10 text-secondary text-xs">Business</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                        </div> --}}
                    </div>
                </div>

                <!-- Recent Transfers Preview -->
                <div class="mx-3 mb-4">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-sm font-medium text-slate-700 dark:text-navy-100">Recent Transfers</h3>
                        <button @click="activeTab = 'tabHistory'" class="text-xs text-primary hover:text-primary-focus dark:text-accent dark:hover:text-accent-focus">
                            View All
                        </button>
                    </div>
                    <div class="space-y-2">
                        {{-- <div class="flex items-center p-2 rounded-lg bg-slate-50 dark:bg-navy-700">
                            <div class="avatar size-8 mr-3">
                                <div class="is-initial rounded-full bg-success text-white text-xs">JD</div>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-slate-700 dark:text-navy-100">John Doe</p>
                                <p class="text-xs text-slate-400 dark:text-navy-300">2 hours ago</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-slate-700 dark:text-navy-100">-RM 50.00</p>
                                <p class="text-xs text-success">Completed</p>
                            </div>
                        </div>
                        <div class="flex items-center p-2 rounded-lg bg-slate-50 dark:bg-navy-700">
                            <div class="avatar size-8 mr-3">
                                <div class="is-initial rounded-full bg-info text-white text-xs">SW</div>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-slate-700 dark:text-navy-100">Sarah Wilson</p>
                                <p class="text-xs text-slate-400 dark:text-navy-300">Yesterday</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-slate-700 dark:text-navy-100">-RM 25.00</p>
                                <p class="text-xs text-success">Completed</p>
                            </div>
                        </div> --}}
                    </div>
                </div>

                <div class="h-18"></div>
            </div>

            <!-- QR Code View -->
            <div x-show="showQrCode" x-transition:enter="transition-all duration-300"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition-all duration-200" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="absolute inset-0 bg-white dark:bg-navy-750 z-10 flex flex-col">
                
                <div class="flex items-center justify-between p-4 border-b border-slate-150 dark:border-navy-600">
                    <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100">Your Payment QR Code</h3>
                    <button @click="showQrCode = false" class="btn size-8 rounded-full p-0 hover:bg-slate-300/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="flex-1 p-4 flex flex-col items-center justify-center">
                    <div class="mb-4 text-center">
                        <p class="text-sm text-slate-500 dark:text-navy-300 mb-1">Scan this QR code to pay me</p>
                        <p class="font-medium text-slate-700 dark:text-navy-100">{{ Auth::user()->name }}</p>
                    </div>
                    
                    <!-- QR Code Image -->
                    <div class="bg-white p-4 rounded-lg shadow-sm mb-6">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode(json_encode(['user_id' => Auth::id(), 'name' => Auth::user()->name, 'phone' => Auth::user()->phone])) }}" 
                            alt="Payment QR Code" class="w-56 h-56">
                    </div>
                    
                    <div class="text-center mb-6">
                        <p class="text-sm text-slate-500 dark:text-navy-300">ID: {{ Auth::id() }}</p>
                        <p class="text-sm text-slate-500 dark:text-navy-300">{{ Auth::user()->phone }}</p>
                    </div>
                    
                    <div class="flex space-x-3">
                        <button class="btn bg-slate-150 text-slate-800 hover:bg-slate-200 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 flex items-center space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                            </svg>
                            <span>Share</span>
                        </button>
                        <button class="btn bg-primary text-white hover:bg-primary-focus flex items-center space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            <span>Download</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- QR Scanner View -->
            <div x-show="showQrScanner" x-transition:enter="transition-all duration-300"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition-all duration-200" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="absolute inset-0 bg-white dark:bg-navy-750 z-10 flex flex-col">
                
                <div class="flex items-center justify-between p-4 border-b border-slate-150 dark:border-navy-600">
                    <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100">Scan QR Code</h3>
                    <button @click="showQrScanner = false" class="btn size-8 rounded-full p-0 hover:bg-slate-300/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="flex-1 p-4 flex flex-col">
                    <!-- Camera View -->
                    <div class="relative bg-black rounded-lg overflow-hidden h-64 mb-4 flex items-center justify-center">
                        <!-- This would be replaced with actual camera feed in production -->
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="w-48 h-48 border-2 border-white/70 rounded-lg"></div>
                        </div>
                        <p class="text-white text-center z-10">Camera permission required<br>Please allow camera access</p>
                        
                        <!-- Scan animation -->
                        <div class="absolute left-0 right-0 h-0.5 bg-primary animate-scan"></div>
                    </div>
                    
                    <p class="text-center text-sm text-slate-500 dark:text-navy-300 mb-4">
                        Position the QR code within the frame to scan
                    </p>
                    
                    <div class="mt-auto">
                        <button class="btn w-full bg-primary text-white hover:bg-primary-focus">
                            Enter Code Manually
                        </button>
                    </div>
                </div>
            </div>

            <!-- Transfer History Tab -->
            <div x-show="activeTab === 'tabHistory'" x-transition:enter="transition-all duration-500 easy-in-out"
                x-transition:enter-start="opacity-0 [transform:translate3d(0,1rem,0)]"
                x-transition:enter-end="opacity-100 [transform:translate3d(0,0,0)]"
                class="is-scrollbar-hidden overflow-y-auto overscroll-contain px-3 pt-1 flex-1">
                
                <div class="space-y-3">
                    <!-- Transaction Item -->
                    <div class="flex items-center p-3 rounded-lg bg-slate-100 dark:bg-navy-600">
                        <div class="avatar size-10 mr-3">
                            <img class="rounded-full" src="{{asset('images/200x200.png')}}" alt="avatar" />
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-slate-700 dark:text-navy-100">John Doe</p>
                            <p class="text-xs text-slate-400 dark:text-navy-300">Transfer • Today 2:30 PM</p>
                        </div>
                        <div class="text-right">
                            <p class="font-medium text-slate-700 dark:text-navy-100">-RM 50.00</p>
                            <span class="badge bg-success/10 text-success text-xs">Completed</span>
                        </div>
                    </div>

                    <!-- More transaction items... -->
                    <div class="flex items-center p-3 rounded-lg bg-slate-100 dark:bg-navy-600">
                        <div class="avatar size-10 mr-3">
                            <div class="is-initial rounded-full bg-info text-white">SW</div>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-slate-700 dark:text-navy-100">Sarah Wilson</p>
                            <p class="text-xs text-slate-400 dark:text-navy-300">Transfer • Yesterday 4:15 PM</p>
                        </div>
                        <div class="text-right">
                            <p class="font-medium text-slate-700 dark:text-navy-100">-RM 25.00</p>
                            <span class="badge bg-success/10 text-success text-xs">Completed</span>
                        </div>
                    </div>

                    <div class="flex items-center p-3 rounded-lg bg-slate-100 dark:bg-navy-600">
                        <div class="avatar size-10 mr-3">
                            <div class="is-initial rounded-full bg-warning text-white">MC</div>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-slate-700 dark:text-navy-100">Mike Chen</p>
                            <p class="text-xs text-slate-400 dark:text-navy-300">Transfer • 2 days ago</p>
                        </div>
                        <div class="text-right">
                            <p class="font-medium text-slate-700 dark:text-navy-100">-RM 100.00</p>
                            <span class="badge bg-success/10 text-success text-xs">Completed</span>
                        </div>
                    </div>
                </div>

                <div class="h-18"></div>
            </div>

            <!-- Favorites Tab -->
            <div x-show="activeTab === 'tabFavorites'" x-transition:enter="transition-all duration-500 easy-in-out"
                x-transition:enter-start="opacity-0 [transform:translate3d(0,1rem,0)]"
                x-transition:enter-end="opacity-100 [transform:translate3d(0,0,0)]"
                class="is-scrollbar-hidden overflow-y-auto overscroll-contain px-3 pt-1 flex-1">
                
                <div class="space-y-3">
                    <!-- Favorite Contact Management -->
                    <div class="flex items-center p-3 rounded-lg bg-slate-100 dark:bg-navy-600">
                        <div class="avatar size-10 mr-3">
                            <img class="rounded-full" src="{{asset('images/200x200.png')}}" alt="avatar" />
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-slate-700 dark:text-navy-100">John Doe</p>
                            <p class="text-xs text-slate-400 dark:text-navy-300">+60 12-345 6789 • 15 transfers</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button class="btn size-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- More favorite contacts... -->
                </div>

                <div class="h-18"></div>
            </div>

            <!-- Transfer Form Modal -->
            <div x-show="showTransferForm" x-transition:enter="transition-all duration-300"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition-all duration-200" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="absolute inset-0 bg-white dark:bg-navy-750 z-10 flex flex-col">
                
                <div class="flex items-center justify-between p-4 border-b border-slate-150 dark:border-navy-600">
                    <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100">Send Money</h3>
                    <button @click="showTransferForm = false; resetForm()" class="btn size-8 rounded-full p-0 hover:bg-slate-300/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="flex-1 p-4 space-y-4">
                    <!-- Recipient -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-navy-100 mb-2">To</label>
                        <div class="flex items-center p-3 rounded-lg bg-slate-100 dark:bg-navy-600">
                            <div class="avatar size-10 mr-3">
                                <div class="is-initial rounded-full bg-primary text-white">JD</div>
                            </div>
                            <div>
                                <p class="font-medium text-slate-700 dark:text-navy-100">John Doe</p>
                                <p class="text-xs text-slate-400 dark:text-navy-300">+60 12-345 6789</p>
                            </div>
                        </div>
                    </div>

                    <!-- Amount -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-navy-100 mb-2">Amount</label>
                        <div class="relative mb-3">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-slate-400">RM</span>
                            <input x-model="transferAmount" type="number" placeholder="0.00" step="0.01"
                                class="form-input w-full pl-12 text-lg font-medium">
                        </div>
                        
                        <!-- Quick Amount Buttons in Form -->
                        <div class="grid grid-cols-3 gap-2">
                            <button type="button" @click="transferAmount = '10'" class="btn btn-sm bg-slate-100 text-slate-700 hover:bg-slate-200 dark:bg-navy-600 dark:text-navy-100 dark:hover:bg-navy-500">
                                10
                            </button>
                            <button type="button" @click="transferAmount = '50'" class="btn btn-sm bg-slate-100 text-slate-700 hover:bg-slate-200 dark:bg-navy-600 dark:text-navy-100 dark:hover:bg-navy-500">
                                50
                            </button>
                            <button type="button" @click="transferAmount = '100'" class="btn btn-sm bg-slate-100 text-slate-700 hover:bg-slate-200 dark:bg-navy-600 dark:text-navy-100 dark:hover:bg-navy-500">
                                100
                            </button>
                            <button type="button" @click="transferAmount = '200'" class="btn btn-sm bg-slate-100 text-slate-700 hover:bg-slate-200 dark:bg-navy-600 dark:text-navy-100 dark:hover:bg-navy-500">
                                200
                            </button>
                            <button type="button" @click="transferAmount = '500'" class="btn btn-sm bg-slate-100 text-slate-700 hover:bg-slate-200 dark:bg-navy-600 dark:text-navy-100 dark:hover:bg-navy-500">
                                500
                            </button>
                            <button type="button" @click="transferAmount = '1000'" class="btn btn-sm bg-slate-100 text-slate-700 hover:bg-slate-200 dark:bg-navy-600 dark:text-navy-100 dark:hover:bg-navy-500">
                                1K
                            </button>
                        </div>
                    </div>

                    <!-- Note -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-navy-100 mb-2">Note (Optional)</label>
                        <textarea placeholder="Add a note..." rows="3" 
                            class="form-textarea w-full resize-none"></textarea>
                    </div>
                </div>

                <div class="p-4 border-t border-slate-150 dark:border-navy-600">
                    <button class="btn w-full bg-primary text-white hover:bg-primary-focus">
                        Send RM <span x-text="transferAmount || '0.00'"></span>
                    </button>
                </div>
            </div>

            <!-- Bottom Navigation -->
            <div class="pointer-events-none absolute bottom-4 flex w-full justify-center">
                <div class="pointer-events-auto mx-auto flex space-x-1 rounded-full border border-slate-150 bg-white px-4 py-0.5 shadow-lg dark:border-navy-700 dark:bg-navy-900">
                    <button @click="activeTab = 'tabTransfer'; showQrCode = false; showQrScanner = false"
                        :class="activeTab === 'tabTransfer' && !showQrCode && !showQrScanner && 'text-primary dark:text-accent'"
                        class="btn h-9 rounded-full py-0 px-4 hover:bg-slate-300/20 hover:text-primary focus:bg-slate-300/20 focus:text-primary active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:hover:text-accent dark:focus:bg-navy-300/20 dark:focus:text-accent dark:active:bg-navy-300/25">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </button>
                    <button @click="activeTab = 'tabHistory'; showQrCode = false; showQrScanner = false"
                        :class="activeTab === 'tabHistory' && 'text-primary dark:text-accent'"
                        class="btn h-9 rounded-full py-0 px-4 hover:bg-slate-300/20 hover:text-primary focus:bg-slate-300/20 focus:text-primary active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:hover:text-accent dark:focus:bg-navy-300/20 dark:focus:text-accent dark:active:bg-navy-300/25">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </button>
                    <button @click="activeTab = 'tabFavorites'; showQrCode = false; showQrScanner = false"
                        :class="activeTab === 'tabFavorites' && 'text-primary dark:text-accent'"
                        class="btn h-9 rounded-full py-0 px-4 hover:bg-slate-300/20 hover:text-primary focus:bg-slate-300/20 focus:text-primary active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:hover:text-accent dark:focus:bg-navy-300/20 dark:focus:text-accent dark:active:bg-navy-300/25">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes scan {
        0% {
            top: 20%;
        }
        50% {
            top: 80%;
        }
        100% {
            top: 20%;
        }
    }
    
    .animate-scan {
        position: absolute;
        animation: scan 2s infinite ease-in-out;
    }
</style>
