<!-- Sidebar -->
<div class="sidebar sidebar-panel print:hidden">
    <div class="flex h-full grow flex-col border-r border-slate-150 bg-white dark:border-navy-700 dark:bg-navy-750">
        <div class="flex items-center justify-between px-3 pt-4">
            <!-- Application Logo -->
            <div class="flex">
                <a href="{{route('dashboard')}}">
                    <img class="size-11 transition-transform duration-500 ease-in-out hover:rotate-[360deg]"
                        src="{{ asset('images/app-logo.svg') }}" alt="logo" />
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

                <li x-data="accordionItem('menu-item-2')">
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
                </li>
            </ul>

            <div class="my-3 mx-4 h-px bg-slate-200 dark:bg-navy-500"></div>

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
            </ul>
        </div>
    </div>
</div>
