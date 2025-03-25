<!-- Sidebar -->
<div class="sidebar sidebar-panel print:hidden">
    <div class="flex h-full grow flex-col border-r border-slate-150 bg-white dark:border-navy-700 dark:bg-navy-750">
        <div class="flex items-center justify-between px-3 pt-4">
            <!-- Application Logo -->
            <div class="flex">
                <a href="{{route('dashboard')}}">
                    <img class="transition-transform duration-500 ease-in-out hover:rotate-[360deg]"
                        src="{{ asset('images/horizontal.png') }}" alt="logo" />
                </a>
            </div>
            <button @click="$store.global.isSidebarExpanded = false"
                class="btn h-7 w-7 rounded-full p-0 text-primary hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:text-accent-light/80 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25 xl:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
        </div>

        <!-- Main sidebar content with scrolling -->
        <div x-data="{expandedItem:'menu-item-3'}" class="mt-5 h-[calc(100%-9rem)] overflow-x-hidden pb-6"
            x-init="$el._x_simplebar = new SimpleBar($el);">

            <ul class="flex flex-1 flex-col px-4 font-inter">
                <li>
                    <a x-data="navLink" href="{{route('dashboard')}}"
                        :class="isActive ? 'font-medium text-primary dark:text-accent-light' : 'text-slate-600 hover:text-slate-900 dark:text-navy-200 dark:hover:text-navy-50'"
                        class="flex py-2 text-xs-plus tracking-wide outline-hidden transition-colors duration-300 ease-in-out">
                        Home
                    </a>
                </li>
            </ul>
            @role('admin')
            <ul class="flex flex-1 flex-col px-4 font-inter">
                <li>
                    <a x-data="navLink" href="{{route('admin.banks.index')}}"
                        :class="isActive ? 'font-medium text-primary dark:text-accent-light' : 'text-slate-600 hover:text-slate-900 dark:text-navy-200 dark:hover:text-navy-50'"
                        class="flex py-2 text-xs-plus tracking-wide outline-hidden transition-colors duration-300 ease-in-out">
                        Banks
                    </a>
                </li>
                <li>
                    <a x-data="navLink" href="{{route('admin.countries.index')}}"
                        :class="isActive ? 'font-medium text-primary dark:text-accent-light' : 'text-slate-600 hover:text-slate-900 dark:text-navy-200 dark:hover:text-navy-50'"
                        class="flex py-2 text-xs-plus tracking-wide outline-hidden transition-colors duration-300 ease-in-out">
                        Countries
                    </a>
                </li>
            </ul>
            @endrole
            <ul class="flex flex-1 flex-col px-4 font-inter">
                @role('admin')
                <li x-data="accordionItem('menu-item-1')">
                    <a :class="expanded && 'text-slate-800 font-semibold dark:text-navy-50'"
                        @click="expanded = !expanded"
                        class="flex items-center justify-between py-2 text-xs-plus tracking-wide text-slate-500 outline-hidden transition-[color,padding-left] duration-300 ease-in-out hover:text-slate-800 dark:text-navy-200 dark:hover:text-navy-50"
                        href="javascript:void(0);">
                        <span>Dashboard</span>
                        <svg :class="expanded && 'rotate-90'" xmlns="http://www.w3.org/2000/svg"
                            class="size-4 text-slate-400 transition-transform ease-in-out" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>

                    <ul x-collapse x-show="expanded">
                        <li>
                            <a x-data="navLink" href="{{route('admin.kyb.dashboard')}}"
                                :class="isActive ? 'font-medium text-primary dark:text-accent-light' : 'text-slate-600 hover:text-slate-900 dark:text-navy-200 dark:hover:text-navy-50'"
                                class="flex items-center justify-between p-2 text-xs-plus tracking-wide outline-hidden transition-[color,padding-left] duration-300 ease-in-out hover:pl-4">
                                <div class="flex items-center space-x-2">
                                    <div class="size-1.5 rounded-full border border-current opacity-40"></div>
                                    <span>KYB Dashboard</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a x-data="navLink" href="{{route('admin.kyc.dashboard')}}"
                                :class="isActive ? 'font-medium text-primary dark:text-accent-light' : 'text-slate-600 hover:text-slate-900 dark:text-navy-200 dark:hover:text-navy-50'"
                                class="flex items-center justify-between p-2 text-xs-plus tracking-wide outline-hidden transition-[color,padding-left] duration-300 ease-in-out hover:pl-4">
                                <div class="flex items-center space-x-2">
                                    <div class="size-1.5 rounded-full border border-current opacity-40"></div>
                                    <span>KYC Dashboard</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li x-data="accordionItem('menu-pending-payments')">
                    <a :class="expanded ? 'text-slate-800 font-semibold dark:text-navy-50' : 'text-slate-600 dark:text-navy-200'"
                        @click="expanded = !expanded"
                        class="flex items-center justify-between py-2 text-xs+ tracking-wide outline-none transition-[color,padding-left] duration-300 ease-in-out hover:text-slate-800 dark:hover:text-navy-50"
                        href="javascript:void(0);">
                        <span class="flex items-center space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <span>Payments</span>
                        </span>
                        <svg :class="expanded && 'rotate-90'" xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4 text-slate-400 transition-transform ease-in-out" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </a>
                    <ul x-collapse x-show="expanded" class="pl-4 mt-1 space-y-1">
                        <li>
                            <a x-data="navLink" href="{{ route('admin.pending-payments.index') }}"
                                :class="isActive ? 'font-medium text-primary dark:text-accent-light' : 'text-slate-600 hover:text-slate-900 dark:text-navy-200 dark:hover:text-navy-50'"
                                class="flex items-center justify-between p-2 text-xs+ tracking-wide outline-none transition-[color,padding-left] duration-300 ease-in-out hover:pl-4">
                                <div class="flex items-center space-x-2">
                                    <div class="h-1.5 w-1.5 rounded-full border border-current opacity-40"></div>
                                    <span>Pending Payments</span>
                                </div>
                                @php
                                $pendingCount = \App\Models\PendingPayment::where('status', 'pending')->count();
                                @endphp
                                @if($pendingCount > 0)
                                <div
                                    class="flex h-5 min-w-[1.25rem] items-center justify-center rounded-full bg-primary px-1 text-xs text-white dark:bg-accent">
                                    {{ $pendingCount }}
                                </div>
                                @endif
                            </a>
                        </li>
                    </ul>
                </li>
                @endrole
            </ul>
        </div>

        <!-- Fixed bottom section for user settings - always visible -->
        <div class="mt-auto border-t border-slate-150 dark:border-navy-600">
            <div x-data="{ isOpen: false }" class="relative p-4">
                <!-- User info and settings button -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div
                            class="h-10 w-10 rounded-full flex items-center justify-center bg-primary/10 text-primary dark:bg-accent/10 dark:text-accent-light overflow-hidden">
                            @if(Auth::user()->profile_photo_url)
                            <img class="h-full w-full object-cover" src="{{ Auth::user()->profile_photo_url }}"
                                alt="{{ Auth::user()->name }}"
                                onerror="this.style.display='none'; this.parentNode.innerHTML = '{{ substr(Auth::user()->name, 0, 1) }}'">
                            @else
                            {{ substr(Auth::user()->name, 0, 1) }}
                            @endif
                        </div>
                        <div class="hidden sm:block">
                            <p class="text-sm font-medium text-slate-700 dark:text-navy-100 truncate">
                                {{ Auth::user()->name }}
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <button
                            class="btn h-8 w-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25"
                            x-ref="popperRef" @click="isOpen = !isOpen">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </button>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="btn h-8 w-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Popup Menu -->
                <div x-show="isOpen" @click.away="isOpen = false" x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="transform opacity-100 scale-100"
                    x-transition:leave-end="transform opacity-0 scale-95"
                    class="absolute bottom-full left-0 mb-2 w-64 rounded-xl shadow-lg bg-white dark:bg-navy-750 ring-1 ring-slate-200 dark:ring-navy-700 divide-y divide-slate-200 dark:divide-navy-700/50 z-50">

                    <!-- User Info Section -->
                    <div class="p-4">
                        <div class="flex items-center space-x-3">
                            <div
                                class="h-12 w-12 rounded-full flex items-center justify-center bg-primary/10 text-primary dark:bg-accent/10 dark:text-accent-light overflow-hidden">
                                @if(Auth::user()->profile_photo_url)
                                <img class="h-full w-full object-cover" src="{{ Auth::user()->profile_photo_url }}"
                                    alt="{{ Auth::user()->name }}"
                                    onerror="this.style.display='none'; this.parentNode.innerHTML = '{{ substr(Auth::user()->name, 0, 1) }}'">
                                @else
                                {{ substr(Auth::user()->name, 0, 1) }}
                                @endif
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-slate-700 dark:text-white">{{ Auth::user()->name }}
                                </h4>
                                <p class="text-xs text-slate-500 dark:text-slate-400">User</p>
                            </div>
                        </div>
                    </div>

                    <!-- Menu Items -->
                    <div class="p-2">
                        <a href="#"
                            class="flex items-center space-x-3 p-2 rounded-lg hover:bg-slate-100 dark:hover:bg-navy-600 group">
                            <div
                                class="flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-lg bg-amber-500/10">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-500"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <p
                                    class="text-sm font-medium text-slate-700 dark:text-white group-hover:text-slate-900 dark:group-hover:text-white">
                                    Profile</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400">Your profile setting</p>
                            </div>
                        </a>

                        <a href="#"
                            class="flex items-center space-x-3 p-2 rounded-lg hover:bg-slate-100 dark:hover:bg-navy-600 group">
                            <div
                                class="flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-lg bg-emerald-500/10">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <p
                                    class="text-sm font-medium text-slate-700 dark:text-white group-hover:text-slate-900 dark:group-hover:text-white">
                                    Settings</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400">Webapp settings</p>
                            </div>
                        </a>
                    </div>

                    <!-- Logout Button -->
                    <div class="p-2">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full flex items-center justify-center space-x-2 px-4 py-2 bg-primary hover:bg-primary-focus text-white rounded-lg transition-colors dark:bg-accent dark:hover:bg-accent-focus">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
