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

        <div x-data="{expandedItem:'menu-item-3'}" class="mt-5 h-[calc(100%-4.5rem)] overflow-x-hidden pb-6"
            x-init="$el._x_simplebar = new SimpleBar($el);">

            <ul class="flex flex-1 flex-col px-4 font-inter">
                <li>
                    <a x-data="navLink" href="{{route('dashboard')}}"
                        :class="isActive ? 'font-medium text-primary dark:text-accent-light' : 'text-slate-600 hover:text-slate-900 dark:text-navy-200 dark:hover:text-navy-50'"
                        class="flex py-2 text-xs-plus tracking-wide outline-hidden transition-colors duration-300 ease-in-out">
                        Home
                    </a>
                </li>
                {{-- <li>
                    <a x-data="navLink" href="dashboards-orders.html"
                        :class="isActive ? 'font-medium text-primary dark:text-accent-light' : 'text-slate-600 hover:text-slate-900 dark:text-navy-200 dark:hover:text-navy-50'"
                        class="flex py-2 text-xs-plus tracking-wide outline-hidden transition-colors duration-300 ease-in-out">
                        Orders
                    </a>
                </li> --}}
            </ul>

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
                            class="h-4 w-4 text-slate-400 transition-transform ease-in-out" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
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
                {{-- <li x-data="accordionItem('menu-item-2')">
                    <a :class="expanded && 'text-slate-800 font-semibold dark:text-navy-50'"
                        @click="expanded = !expanded"
                        class="flex items-center justify-between py-2 text-xs-plus tracking-wide text-slate-500 outline-hidden transition-[color,padding-left] duration-300 ease-in-out hover:text-slate-800 dark:text-navy-200 dark:hover:text-navy-50"
                        href="javascript:void(0);">
                        <span>User Card</span>
                        <svg :class="expanded && 'rotate-90'" xmlns="http://www.w3.org/2000/svg"
                            class="size-4 text-slate-400 transition-transform ease-in-out" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                    <ul x-collapse x-show="expanded">
                        <li>
                            <a x-data="navLink" href="pages-card-user-1.html"
                                :class="isActive ? 'font-medium text-primary dark:text-accent-light' : 'text-slate-600 hover:text-slate-900 dark:text-navy-200 dark:hover:text-navy-50'"
                                class="flex items-center justify-between p-2 text-xs-plus tracking-wide outline-hidden transition-[color,padding-left] duration-300 ease-in-out hover:pl-4">
                                <div class="flex items-center space-x-2">
                                    <div class="size-1.5 rounded-full border border-current opacity-40"></div>
                                    <span>User Card 1</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a x-data="navLink" href="pages-card-user-2.html"
                                :class="isActive ? 'font-medium text-primary dark:text-accent-light' : 'text-slate-600 hover:text-slate-900 dark:text-navy-200 dark:hover:text-navy-50'"
                                class="flex items-center justify-between p-2 text-xs-plus tracking-wide outline-hidden transition-[color,padding-left] duration-300 ease-in-out hover:pl-4">
                                <div class="flex items-center space-x-2">
                                    <div class="size-1.5 rounded-full border border-current opacity-40"></div>
                                    <span>User Card 2</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a x-data="navLink" href="pages-card-user-3.html"
                                :class="isActive ? 'font-medium text-primary dark:text-accent-light' : 'text-slate-600 hover:text-slate-900 dark:text-navy-200 dark:hover:text-navy-50'"
                                class="flex items-center justify-between p-2 text-xs-plus tracking-wide outline-hidden transition-[color,padding-left] duration-300 ease-in-out hover:pl-4">
                                <div class="flex items-center space-x-2">
                                    <div class="size-1.5 rounded-full border border-current opacity-40"></div>
                                    <span>User Card 3</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a x-data="navLink" href="pages-card-user-4.html"
                                :class="isActive ? 'font-medium text-primary dark:text-accent-light' : 'text-slate-600 hover:text-slate-900 dark:text-navy-200 dark:hover:text-navy-50'"
                                class="flex items-center justify-between p-2 text-xs-plus tracking-wide outline-hidden transition-[color,padding-left] duration-300 ease-in-out hover:pl-4">
                                <div class="flex items-center space-x-2">
                                    <div class="size-1.5 rounded-full border border-current opacity-40"></div>
                                    <span>User Card 4</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a x-data="navLink" href="pages-card-user-5.html"
                                :class="isActive ? 'font-medium text-primary dark:text-accent-light' : 'text-slate-600 hover:text-slate-900 dark:text-navy-200 dark:hover:text-navy-50'"
                                class="flex items-center justify-between p-2 text-xs-plus tracking-wide outline-hidden transition-[color,padding-left] duration-300 ease-in-out hover:pl-4">
                                <div class="flex items-center space-x-2">
                                    <div class="size-1.5 rounded-full border border-current opacity-40"></div>
                                    <span>User Card 5</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a x-data="navLink" href="pages-card-user-6.html"
                                :class="isActive ? 'font-medium text-primary dark:text-accent-light' : 'text-slate-600 hover:text-slate-900 dark:text-navy-200 dark:hover:text-navy-50'"
                                class="flex items-center justify-between p-2 text-xs-plus tracking-wide outline-hidden transition-[color,padding-left] duration-300 ease-in-out hover:pl-4">
                                <div class="flex items-center space-x-2">
                                    <div class="size-1.5 rounded-full border border-current opacity-40"></div>
                                    <span>User Card 6</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a x-data="navLink" href="pages-card-user-7.html"
                                :class="isActive ? 'font-medium text-primary dark:text-accent-light' : 'text-slate-600 hover:text-slate-900 dark:text-navy-200 dark:hover:text-navy-50'"
                                class="flex items-center justify-between p-2 text-xs-plus tracking-wide outline-hidden transition-[color,padding-left] duration-300 ease-in-out hover:pl-4">
                                <div class="flex items-center space-x-2">
                                    <div class="size-1.5 rounded-full border border-current opacity-40"></div>
                                    <span>User Card 7</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>

                <li x-data="accordionItem('menu-item-3')">
                    <a :class="expanded && 'text-slate-800 font-semibold dark:text-navy-50'"
                        @click="expanded = !expanded"
                        class="flex items-center justify-between py-2 text-xs-plus tracking-wide text-slate-500 outline-hidden transition-[color,padding-left] duration-300 ease-in-out hover:text-slate-800 dark:text-navy-200 dark:hover:text-navy-50"
                        href="javascript:void(0);">
                        <span>Blog Card</span>
                        <svg :class="expanded && 'rotate-90'" xmlns="http://www.w3.org/2000/svg"
                            class="size-4 text-slate-400 transition-transform ease-in-out" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                    <ul x-collapse x-show="expanded">
                        <li>
                            <a x-data="navLink" href="pages-card-blog-1.html"
                                :class="isActive ? 'font-medium text-primary dark:text-accent-light' : 'text-slate-600 hover:text-slate-900 dark:text-navy-200 dark:hover:text-navy-50'"
                                class="flex items-center justify-between p-2 text-xs-plus tracking-wide outline-hidden transition-[color,padding-left] duration-300 ease-in-out hover:pl-4">
                                <div class="flex items-center space-x-2">
                                    <div class="size-1.5 rounded-full border border-current opacity-40"></div>
                                    <span>Blog Card 1</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a x-data="navLink" href="pages-card-blog-2.html"
                                :class="isActive ? 'font-medium text-primary dark:text-accent-light' : 'text-slate-600 hover:text-slate-900 dark:text-navy-200 dark:hover:text-navy-50'"
                                class="flex items-center justify-between p-2 text-xs-plus tracking-wide outline-hidden transition-[color,padding-left] duration-300 ease-in-out hover:pl-4">
                                <div class="flex items-center space-x-2">
                                    <div class="size-1.5 rounded-full border border-current opacity-40"></div>
                                    <span>Blog Card 2</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a x-data="navLink" href="pages-card-blog-3.html"
                                :class="isActive ? 'font-medium text-primary dark:text-accent-light' : 'text-slate-600 hover:text-slate-900 dark:text-navy-200 dark:hover:text-navy-50'"
                                class="flex items-center justify-between p-2 text-xs-plus tracking-wide outline-hidden transition-[color,padding-left] duration-300 ease-in-out hover:pl-4">
                                <div class="flex items-center space-x-2">
                                    <div class="size-1.5 rounded-full border border-current opacity-40"></div>
                                    <span>Blog Card 3</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a x-data="navLink" href="pages-card-blog-4.html"
                                :class="isActive ? 'font-medium text-primary dark:text-accent-light' : 'text-slate-600 hover:text-slate-900 dark:text-navy-200 dark:hover:text-navy-50'"
                                class="flex items-center justify-between p-2 text-xs-plus tracking-wide outline-hidden transition-[color,padding-left] duration-300 ease-in-out hover:pl-4">
                                <div class="flex items-center space-x-2">
                                    <div class="size-1.5 rounded-full border border-current opacity-40"></div>
                                    <span>Blog Card 4</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a x-data="navLink" href="pages-card-blog-5.html"
                                :class="isActive ? 'font-medium text-primary dark:text-accent-light' : 'text-slate-600 hover:text-slate-900 dark:text-navy-200 dark:hover:text-navy-50'"
                                class="flex items-center justify-between p-2 text-xs-plus tracking-wide outline-hidden transition-[color,padding-left] duration-300 ease-in-out hover:pl-4">
                                <div class="flex items-center space-x-2">
                                    <div class="size-1.5 rounded-full border border-current opacity-40"></div>
                                    <span>Blog Card 5</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a x-data="navLink" href="pages-card-blog-6.html"
                                :class="isActive ? 'font-medium text-primary dark:text-accent-light' : 'text-slate-600 hover:text-slate-900 dark:text-navy-200 dark:hover:text-navy-50'"
                                class="flex items-center justify-between p-2 text-xs-plus tracking-wide outline-hidden transition-[color,padding-left] duration-300 ease-in-out hover:pl-4">
                                <div class="flex items-center space-x-2">
                                    <div class="size-1.5 rounded-full border border-current opacity-40"></div>
                                    <span>Blog Card 6</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a x-data="navLink" href="pages-card-blog-7.html"
                                :class="isActive ? 'font-medium text-primary dark:text-accent-light' : 'text-slate-600 hover:text-slate-900 dark:text-navy-200 dark:hover:text-navy-50'"
                                class="flex items-center justify-between p-2 text-xs-plus tracking-wide outline-hidden transition-[color,padding-left] duration-300 ease-in-out hover:pl-4">
                                <div class="flex items-center space-x-2">
                                    <div class="size-1.5 rounded-full border border-current opacity-40"></div>
                                    <span>Blog Card 7</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a x-data="navLink" href="pages-card-blog-8.html"
                                :class="isActive ? 'font-medium text-primary dark:text-accent-light' : 'text-slate-600 hover:text-slate-900 dark:text-navy-200 dark:hover:text-navy-50'"
                                class="flex items-center justify-between p-2 text-xs-plus tracking-wide outline-hidden transition-[color,padding-left] duration-300 ease-in-out hover:pl-4">
                                <div class="flex items-center space-x-2">
                                    <div class="size-1.5 rounded-full border border-current opacity-40"></div>
                                    <span>Blog Card 8</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>

                <li x-data="accordionItem('menu-item-4')">
                    <a :class="expanded && 'text-slate-800 font-semibold dark:text-navy-50'"
                        @click="expanded = !expanded"
                        class="flex items-center justify-between py-2 text-xs-plus tracking-wide text-slate-500 outline-hidden transition-[color,padding-left] duration-300 ease-in-out hover:text-slate-800 dark:text-navy-200 dark:hover:text-navy-50"
                        href="javascript:void(0);">
                        <span>Help</span>
                        <svg :class="expanded && 'rotate-90'" xmlns="http://www.w3.org/2000/svg"
                            class="size-4 text-slate-400 transition-transform ease-in-out" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                    <ul x-collapse x-show="expanded">
                        <li>
                            <a x-data="navLink" href="pages-help-1.html"
                                :class="isActive ? 'font-medium text-primary dark:text-accent-light' : 'text-slate-600 hover:text-slate-900 dark:text-navy-200 dark:hover:text-navy-50'"
                                class="flex items-center justify-between p-2 text-xs-plus tracking-wide outline-hidden transition-[color,padding-left] duration-300 ease-in-out hover:pl-4">
                                <div class="flex items-center space-x-2">
                                    <div class="size-1.5 rounded-full border border-current opacity-40"></div>
                                    <span>Help 1</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a x-data="navLink" href="pages-help-2.html"
                                :class="isActive ? 'font-medium text-primary dark:text-accent-light' : 'text-slate-600 hover:text-slate-900 dark:text-navy-200 dark:hover:text-navy-50'"
                                class="flex items-center justify-between p-2 text-xs-plus tracking-wide outline-hidden transition-[color,padding-left] duration-300 ease-in-out hover:pl-4">
                                <div class="flex items-center space-x-2">
                                    <div class="size-1.5 rounded-full border border-current opacity-40"></div>
                                    <span>Help 2</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a x-data="navLink" href="pages-help-3.html"
                                :class="isActive ? 'font-medium text-primary dark:text-accent-light' : 'text-slate-600 hover:text-slate-900 dark:text-navy-200 dark:hover:text-navy-50'"
                                class="flex items-center justify-between p-2 text-xs-plus tracking-wide outline-hidden transition-[color,padding-left] duration-300 ease-in-out hover:pl-4">
                                <div class="flex items-center space-x-2">
                                    <div class="size-1.5 rounded-full border border-current opacity-40"></div>
                                    <span>Help 3</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>

                <li x-data="accordionItem('menu-item-5')">
                    <a :class="expanded && 'text-slate-800 font-semibold dark:text-navy-50'"
                        @click="expanded = !expanded"
                        class="flex items-center justify-between py-2 text-xs-plus tracking-wide text-slate-500 outline-hidden transition-[color,padding-left] duration-300 ease-in-out hover:text-slate-800 dark:text-navy-200 dark:hover:text-navy-50"
                        href="javascript:void(0);">
                        <span>Price List</span>
                        <svg :class="expanded && 'rotate-90'" xmlns="http://www.w3.org/2000/svg"
                            class="size-4 text-slate-400 transition-transform ease-in-out" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                    <ul x-collapse x-show="expanded">
                        <li>
                            <a x-data="navLink" href="pages-price-list-1.html"
                                :class="isActive ? 'font-medium text-primary dark:text-accent-light' : 'text-slate-600 hover:text-slate-900 dark:text-navy-200 dark:hover:text-navy-50'"
                                class="flex items-center justify-between p-2 text-xs-plus tracking-wide outline-hidden transition-[color,padding-left] duration-300 ease-in-out hover:pl-4">
                                <div class="flex items-center space-x-2">
                                    <div class="size-1.5 rounded-full border border-current opacity-40"></div>
                                    <span>Price List 1</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a x-data="navLink" href="pages-price-list-2.html"
                                :class="isActive ? 'font-medium text-primary dark:text-accent-light' : 'text-slate-600 hover:text-slate-900 dark:text-navy-200 dark:hover:text-navy-50'"
                                class="flex items-center justify-between p-2 text-xs-plus tracking-wide outline-hidden transition-[color,padding-left] duration-300 ease-in-out hover:pl-4">
                                <div class="flex items-center space-x-2">
                                    <div class="size-1.5 rounded-full border border-current opacity-40"></div>
                                    <span>Price List 2</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a x-data="navLink" href="pages-price-list-3.html"
                                :class="isActive ? 'font-medium text-primary dark:text-accent-light' : 'text-slate-600 hover:text-slate-900 dark:text-navy-200 dark:hover:text-navy-50'"
                                class="flex items-center justify-between p-2 text-xs-plus tracking-wide outline-hidden transition-[color,padding-left] duration-300 ease-in-out hover:pl-4">
                                <div class="flex items-center space-x-2">
                                    <div class="size-1.5 rounded-full border border-current opacity-40"></div>
                                    <span>Price List 3</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>

                <li x-data="accordionItem('menu-item-6')">
                    <a :class="expanded && 'text-slate-800 font-semibold dark:text-navy-50'"
                        @click="expanded = !expanded"
                        class="flex items-center justify-between py-2 text-xs-plus tracking-wide text-slate-500 outline-hidden transition-[color,padding-left] duration-300 ease-in-out hover:text-slate-800 dark:text-navy-200 dark:hover:text-navy-50"
                        href="javascript:void(0);">
                        <span>Invoice</span>
                        <svg :class="expanded && 'rotate-90'" xmlns="http://www.w3.org/2000/svg"
                            class="size-4 text-slate-400 transition-transform ease-in-out" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                    <ul x-collapse x-show="expanded">
                        <li>
                            <a x-data="navLink" href="pages-invoice-1.html"
                                :class="isActive ? 'font-medium text-primary dark:text-accent-light' : 'text-slate-600 hover:text-slate-900 dark:text-navy-200 dark:hover:text-navy-50'"
                                class="flex items-center justify-between p-2 text-xs-plus tracking-wide outline-hidden transition-[color,padding-left] duration-300 ease-in-out hover:pl-4">
                                <div class="flex items-center space-x-2">
                                    <div class="size-1.5 rounded-full border border-current opacity-40"></div>
                                    <span>Invoice 1</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a x-data="navLink" href="pages-invoice-2.html"
                                :class="isActive ? 'font-medium text-primary dark:text-accent-light' : 'text-slate-600 hover:text-slate-900 dark:text-navy-200 dark:hover:text-navy-50'"
                                class="flex items-center justify-between p-2 text-xs-plus tracking-wide outline-hidden transition-[color,padding-left] duration-300 ease-in-out hover:pl-4">
                                <div class="flex items-center space-x-2">
                                    <div class="size-1.5 rounded-full border border-current opacity-40"></div>
                                    <span>Invoice 2</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li> --}}
            </ul>

            {{-- <div class="my-3 mx-4 h-px bg-slate-200 dark:bg-navy-500"></div>

            <ul class="flex flex-1 flex-col px-4 font-inter">
                <li x-data="accordionItem('menu-item-7')">
                    <a :class="expanded && 'text-slate-800 font-semibold dark:text-navy-50'"
                        @click="expanded = !expanded"
                        class="flex items-center justify-between py-2 text-xs-plus tracking-wide text-slate-500 outline-hidden transition-[color,padding-left] duration-300 ease-in-out hover:text-slate-800 dark:text-navy-200 dark:hover:text-navy-50"
                        href="javascript:void(0);">
                        <span>Sign In</span>
                        <svg :class="expanded && 'rotate-90'" xmlns="http://www.w3.org/2000/svg"
                            class="size-4 text-slate-400 transition-transform ease-in-out" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                    <ul x-collapse x-show="expanded">
                        <li>
                            <a x-data="navLink" href="pages-login-1.html"
                                :class="isActive ? 'font-medium text-primary dark:text-accent-light' : 'text-slate-600 hover:text-slate-900 dark:text-navy-200 dark:hover:text-navy-50'"
                                class="flex items-center justify-between p-2 text-xs-plus tracking-wide outline-hidden transition-[color,padding-left] duration-300 ease-in-out hover:pl-4">
                                <div class="flex items-center space-x-2">
                                    <div class="size-1.5 rounded-full border border-current opacity-40"></div>
                                    <span>Sign In 1</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a x-data="navLink" href="pages-login-2.html"
                                :class="isActive ? 'font-medium text-primary dark:text-accent-light' : 'text-slate-600 hover:text-slate-900 dark:text-navy-200 dark:hover:text-navy-50'"
                                class="flex items-center justify-between p-2 text-xs-plus tracking-wide outline-hidden transition-[color,padding-left] duration-300 ease-in-out hover:pl-4">
                                <div class="flex items-center space-x-2">
                                    <div class="size-1.5 rounded-full border border-current opacity-40"></div>
                                    <span>Sign In 2</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>

                <li x-data="accordionItem('menu-item-8')">
                    <a :class="expanded && 'text-slate-800 font-semibold dark:text-navy-50'"
                        @click="expanded = !expanded"
                        class="flex items-center justify-between py-2 text-xs-plus tracking-wide text-slate-500 outline-hidden transition-[color,padding-left] duration-300 ease-in-out hover:text-slate-800 dark:text-navy-200 dark:hover:text-navy-50"
                        href="javascript:void(0);">
                        <span>Sign Up</span>
                        <svg :class="expanded && 'rotate-90'" xmlns="http://www.w3.org/2000/svg"
                            class="size-4 text-slate-400 transition-transform ease-in-out" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                    <ul x-collapse x-show="expanded">
                        <li>
                            <a x-data="navLink" href="pages-singup-1.html"
                                :class="isActive ? 'font-medium text-primary dark:text-accent-light' : 'text-slate-600 hover:text-slate-900 dark:text-navy-200 dark:hover:text-navy-50'"
                                class="flex items-center justify-between p-2 text-xs-plus tracking-wide outline-hidden transition-[color,padding-left] duration-300 ease-in-out hover:pl-4">
                                <div class="flex items-center space-x-2">
                                    <div class="size-1.5 rounded-full border border-current opacity-40"></div>
                                    <span>Sign Up 1</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a x-data="navLink" href="pages-singup-2.html"
                                :class="isActive ? 'font-medium text-primary dark:text-accent-light' : 'text-slate-600 hover:text-slate-900 dark:text-navy-200 dark:hover:text-navy-50'"
                                class="flex items-center justify-between p-2 text-xs-plus tracking-wide outline-hidden transition-[color,padding-left] duration-300 ease-in-out hover:pl-4">
                                <div class="flex items-center space-x-2">
                                    <div class="size-1.5 rounded-full border border-current opacity-40"></div>
                                    <span>Sign Up 2</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>

            <div class="my-3 mx-4 h-px bg-slate-200 dark:bg-navy-500"></div>

            <ul class="flex flex-1 flex-col px-4 font-inter">
                <li x-data="accordionItem('menu-item-9')">
                    <a :class="expanded && 'text-slate-800 font-semibold dark:text-navy-50'"
                        @click="expanded = !expanded"
                        class="flex items-center justify-between py-2 text-xs-plus tracking-wide text-slate-500 outline-hidden transition-[color,padding-left] duration-300 ease-in-out hover:text-slate-800 dark:text-navy-200 dark:hover:text-navy-50"
                        href="javascript:void(0);">
                        <span>Error</span>
                        <svg :class="expanded && 'rotate-90'" xmlns="http://www.w3.org/2000/svg"
                            class="size-4 text-slate-400 transition-transform ease-in-out" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                    <ul x-collapse x-show="expanded">
                        <li>
                            <a x-data="navLink" href="pages-error-404-1.html"
                                :class="isActive ? 'font-medium text-primary dark:text-accent-light' : 'text-slate-600 hover:text-slate-900 dark:text-navy-200 dark:hover:text-navy-50'"
                                class="flex items-center justify-between p-2 text-xs-plus tracking-wide outline-hidden transition-[color,padding-left] duration-300 ease-in-out hover:pl-4">
                                <div class="flex items-center space-x-2">
                                    <div class="size-1.5 rounded-full border border-current opacity-40"></div>
                                    <span>Error 404 v1</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a x-data="navLink" href="pages-error-404-2.html"
                                :class="isActive ? 'font-medium text-primary dark:text-accent-light' : 'text-slate-600 hover:text-slate-900 dark:text-navy-200 dark:hover:text-navy-50'"
                                class="flex items-center justify-between p-2 text-xs-plus tracking-wide outline-hidden transition-[color,padding-left] duration-300 ease-in-out hover:pl-4">
                                <div class="flex items-center space-x-2">
                                    <div class="size-1.5 rounded-full border border-current opacity-40"></div>
                                    <span>Error 404 v2</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a x-data="navLink" href="pages-error-404-3.html"
                                :class="isActive ? 'font-medium text-primary dark:text-accent-light' : 'text-slate-600 hover:text-slate-900 dark:text-navy-200 dark:hover:text-navy-50'"
                                class="flex items-center justify-between p-2 text-xs-plus tracking-wide outline-hidden transition-[color,padding-left] duration-300 ease-in-out hover:pl-4">
                                <div class="flex items-center space-x-2">
                                    <div class="size-1.5 rounded-full border border-current opacity-40"></div>
                                    <span>Error 404 v3</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a x-data="navLink" href="pages-error-404-4.html"
                                :class="isActive ? 'font-medium text-primary dark:text-accent-light' : 'text-slate-600 hover:text-slate-900 dark:text-navy-200 dark:hover:text-navy-50'"
                                class="flex items-center justify-between p-2 text-xs-plus tracking-wide outline-hidden transition-[color,padding-left] duration-300 ease-in-out hover:pl-4">
                                <div class="flex items-center space-x-2">
                                    <div class="size-1.5 rounded-full border border-current opacity-40"></div>
                                    <span>Error 404 v4</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a x-data="navLink" href="pages-error-401.html"
                                :class="isActive ? 'font-medium text-primary dark:text-accent-light' : 'text-slate-600 hover:text-slate-900 dark:text-navy-200 dark:hover:text-navy-50'"
                                class="flex items-center justify-between p-2 text-xs-plus tracking-wide outline-hidden transition-[color,padding-left] duration-300 ease-in-out hover:pl-4">
                                <div class="flex items-center space-x-2">
                                    <div class="size-1.5 rounded-full border border-current opacity-40"></div>
                                    <span>Error 401</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a x-data="navLink" href="pages-error-429.html"
                                :class="isActive ? 'font-medium text-primary dark:text-accent-light' : 'text-slate-600 hover:text-slate-900 dark:text-navy-200 dark:hover:text-navy-50'"
                                class="flex items-center justify-between p-2 text-xs-plus tracking-wide outline-hidden transition-[color,padding-left] duration-300 ease-in-out hover:pl-4">
                                <div class="flex items-center space-x-2">
                                    <div class="size-1.5 rounded-full border border-current opacity-40"></div>
                                    <span>Error 429</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a x-data="navLink" href="pages-error-500.html"
                                :class="isActive ? 'font-medium text-primary dark:text-accent-light' : 'text-slate-600 hover:text-slate-900 dark:text-navy-200 dark:hover:text-navy-50'"
                                class="flex items-center justify-between p-2 text-xs-plus tracking-wide outline-hidden transition-[color,padding-left] duration-300 ease-in-out hover:pl-4">
                                <div class="flex items-center space-x-2">
                                    <div class="size-1.5 rounded-full border border-current opacity-40"></div>
                                    <span>Error 500</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>

                <li x-data="accordionItem('menu-item-10')">
                    <a :class="expanded ? 'text-slate-800 font-semibold dark:text-navy-50' : 'text-slate-600 dark:text-navy-200  hover:text-slate-800  dark:hover:text-navy-50'"
                        @click="expanded = !expanded"
                        class="flex items-center justify-between py-2 text-xs-plus tracking-wide outline-hidden transition-[color,padding-left] duration-300 ease-in-out"
                        href="javascript:void(0);">
                        <span>Starter</span>
                        <svg :class="expanded && 'rotate-90'" xmlns="http://www.w3.org/2000/svg"
                            class="size-4 text-slate-400 transition-transform ease-in-out" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                    <ul x-collapse x-show="expanded">
                        <li>
                            <a x-data="navLink" href="pages-starter-1.html"
                                :class="isActive ? 'font-medium text-primary dark:text-accent-light' : 'text-slate-600 hover:text-slate-900 dark:text-navy-200 dark:hover:text-navy-50'"
                                class="flex items-center justify-between p-2 text-xs-plus tracking-wide outline-hidden transition-[color,padding-left] duration-300 ease-in-out hover:pl-4">
                                <div class="flex items-center space-x-2">
                                    <div class="size-1.5 rounded-full border border-current opacity-40"></div>
                                    <span>Blurred Header</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a x-data="navLink" href="pages-starter-2.html"
                                :class="isActive ? 'font-medium text-primary dark:text-accent-light' : 'text-slate-600 hover:text-slate-900 dark:text-navy-200 dark:hover:text-navy-50'"
                                class="flex items-center justify-between p-2 text-xs-plus tracking-wide outline-hidden transition-[color,padding-left] duration-300 ease-in-out hover:pl-4">
                                <div class="flex items-center space-x-2">
                                    <div class="size-1.5 rounded-full border border-current opacity-40"></div>
                                    <span>Unblurred Header</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a x-data="navLink" href="pages-starter-3.html"
                                :class="isActive ? 'font-medium text-primary dark:text-accent-light' : 'text-slate-600 hover:text-slate-900 dark:text-navy-200 dark:hover:text-navy-50'"
                                class="flex items-center justify-between p-2 text-xs-plus tracking-wide outline-hidden transition-[color,padding-left] duration-300 ease-in-out hover:pl-4">
                                <div class="flex items-center space-x-2">
                                    <div class="size-1.5 rounded-full border border-current opacity-40"></div>
                                    <span>Centered Links</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a x-data="navLink" href="pages-starter-4.html"
                                :class="isActive ? 'font-medium text-primary dark:text-accent-light' : 'text-slate-600 hover:text-slate-900 dark:text-navy-200 dark:hover:text-navy-50'"
                                class="flex items-center justify-between p-2 text-xs-plus tracking-wide outline-hidden transition-[color,padding-left] duration-300 ease-in-out hover:pl-4">
                                <div class="flex items-center space-x-2">
                                    <div class="size-1.5 rounded-full border border-current opacity-40"></div>
                                    <span>Minimal Sidebar</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a x-data="navLink" href="pages-starter-5.html"
                                :class="isActive ? 'font-medium text-primary dark:text-accent-light' : 'text-slate-600 hover:text-slate-900 dark:text-navy-200 dark:hover:text-navy-50'"
                                class="flex items-center justify-between p-2 text-xs-plus tracking-wide outline-hidden transition-[color,padding-left] duration-300 ease-in-out hover:pl-4">
                                <div class="flex items-center space-x-2">
                                    <div class="size-1.5 rounded-full border border-current opacity-40"></div>
                                    <span>Horizontal Navigation</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a x-data="navLink" href="pages-starter-6.html"
                                :class="isActive ? 'font-medium text-primary dark:text-accent-light' : 'text-slate-600 hover:text-slate-900 dark:text-navy-200 dark:hover:text-navy-50'"
                                class="flex items-center justify-between p-2 text-xs-plus tracking-wide outline-hidden transition-[color,padding-left] duration-300 ease-in-out hover:pl-4">
                                <div class="flex items-center space-x-2">
                                    <div class="size-1.5 rounded-full border border-current opacity-40"></div>
                                    <span>Sideblock</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul> --}}
        </div>
       <!-- Add this just before the closing div of the sidebar -->
    <div class="mt-auto pb-4">
        <div class="mx-4">
            <div x-data="{ isOpen: false }" class="relative">
                {{-- <button @click="isOpen = !isOpen"
                    class="flex items-center space-x-3 px-3 py-2 w-full rounded-lg hover:bg-slate-100 dark:hover:bg-navy-600">
                    <div class="flex-shrink-0">
                        <img class="h-10 w-10 rounded-full" src="images/200x200.png"
                            alt="avatar">
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-slate-700 dark:text-navy-100 truncate">
                            {{ Auth::user()->name }}
                        </p>

                    </div>
                </button> --}}
                <button
                    class="btn bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90"
                    x-ref="popperRef" @click="isOpen = !isOpen">
                    Settings
                </button>

                <!-- Popup Menu -->
                <div x-show="isOpen" @click.away="isOpen = false" x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="transform opacity-100 scale-100"
                    x-transition:leave-end="transform opacity-0 scale-95"
                    class="absolute ml-2 bottom-full w-64 rounded-xl shadow-lg bg-navy-750 ring-1 ring-navy-700 divide-y divide-navy-700/50 mx-12">

                    <!-- User Info Section -->
                    <div class="p-4">
                        <div class="flex items-center space-x-3">
                            <img class="h-12 w-12 rounded-full" src="{{ Auth::user()->profile_photo_url }}"
                                alt="{{ Auth::user()->name }}">
                            <div>
                                <h4 class="text-sm font-medium text-white">{{ Auth::user()->name }}</h4>
                                <p class="text-xs text-slate-400">Product Designer</p>
                            </div>
                        </div>
                    </div>

                    <!-- Menu Items -->
                    <div class="p-2">
                        <a href="#" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-navy-600 group">
                            <div
                                class="flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-lg bg-amber-500/10">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-500" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-white group-hover:text-white">Profile</p>
                                <p class="text-xs text-slate-400">Your profile setting</p>
                            </div>
                        </a>

                        <a href="#" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-navy-600 group">
                            <div class="flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-lg bg-cyan-500/10">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-cyan-500" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9h2v2H7V9zm8 0h2v2h-2V9zM9 9h2v2H9V9z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-white group-hover:text-white">Messages</p>
                                <p class="text-xs text-slate-400">Your messages and tasks</p>
                            </div>
                        </a>

                        <a href="#" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-navy-600 group">
                            <div class="flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-lg bg-pink-500/10">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-pink-500" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path
                                        d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-white group-hover:text-white">Team</p>
                                <p class="text-xs text-slate-400">Your team activity</p>
                            </div>
                        </a>

                        <a href="#" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-navy-600 group">
                            <div
                                class="flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-lg bg-orange-500/10">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-orange-500" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-white group-hover:text-white">Activity</p>
                                <p class="text-xs text-slate-400">Your activity and events</p>
                            </div>
                        </a>

                        <a href="#" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-navy-600 group">
                            <div
                                class="flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-lg bg-emerald-500/10">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-white group-hover:text-white">Settings</p>
                                <p class="text-xs text-slate-400">Webapp settings</p>
                            </div>
                        </a>
                    </div>

                    <!-- Logout Button -->
                    <div class="p-2">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full flex items-center justify-center space-x-2 px-4 py-2 bg-indigo-500 hover:bg-indigo-600 text-white rounded-lg transition-colors">
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

</div>
