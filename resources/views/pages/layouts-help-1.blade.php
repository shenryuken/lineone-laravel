<x-app-layout title="Help 1" is-header-blur="true">
    <!-- Main Content Wrapper -->
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        <div class="flex items-center space-x-4 py-5 lg:py-6">
            <h2 class="text-xl font-medium text-slate-800 dark:text-navy-50 lg:text-2xl">
                Help
            </h2>
            <div class="hidden h-full py-1 sm:flex">
                <div class="h-full w-px bg-slate-300 dark:bg-navy-600"></div>
            </div>
            <ul class="hidden flex-wrap items-center space-x-2 sm:flex">
                <li class="flex items-center space-x-2">
                    <a class="text-primary transition-colors hover:text-primary-focus dark:text-accent-light dark:hover:text-accent"
                        href="#">Layouts</a>
                    <svg x-ignore xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </li>
                <li>Help</li>
            </ul>
        </div>

        <div class="relative flex flex-col items-center justify-center">
            <div class="absolute right-0 top-0 -mt-8 hidden max-w-xs p-4 lg:block">
                <img src="{{asset('images/illustrations/help.svg')}}" alt="image" />
            </div>
            <h2 class="mt-8 text-xl font-medium text-slate-600 dark:text-navy-100 lg:text-2xl">
                How we can help you?
            </h2>
            <div class="relative mt-6 w-full max-w-md">
                <input
                    class="form-input peer h-12 w-full rounded-full border border-slate-300 bg-slate-50 px-4 py-2 pl-9 text-base placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-900 dark:hover:border-navy-400 dark:focus:border-accent"
                    placeholder="Search your question" type="text" />
                <div
                    class="absolute left-0 top-0 flex h-12 w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                    <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>

            <div class="inline-space mt-3 flex flex-wrap items-center justify-center">
                <span>Popular searched:</span>
                <div>
                    <a href="#"
                        class="tag rounded-full bg-info/10 text-info hover:bg-info/20 focus:bg-info/20 active:bg-info/25">
                        Apps
                    </a>
                    <a href="#"
                        class="tag rounded-full bg-info/10 text-info hover:bg-info/20 focus:bg-info/20 active:bg-info/25">
                        Developers
                    </a>
                    <a href="#"
                        class="tag rounded-full bg-info/10 text-info hover:bg-info/20 focus:bg-info/20 active:bg-info/25">
                        Repair
                    </a>
                    <a href="#"
                        class="tag rounded-full bg-info/10 text-info hover:bg-info/20 focus:bg-info/20 active:bg-info/25">
                        Billing
                    </a>
                </div>
            </div>
        </div>

        <div class="mt-20 grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
            <div class="col-span-12 lg:col-span-4 xl:col-span-3">
                <div class="card p-4 sm:px-5">
                    <ul class="space-y-3.5 font-inter font-medium">
                        <li>
                            <a class="inline-flex items-center space-x-2 tracking-wide text-primary outline-hidden dark:text-accent-light"
                                href="#">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="size-5 text-primary dark:text-accent-light" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>

                                <span>Getting start</span>
                            </a>
                        </li>
                        <li>
                            <a class="group inline-flex items-center space-x-2 tracking-wide outline-hidden transition-colors hover:text-slate-800 focus:text-slate-800 dark:hover:text-navy-100 dark:focus:text-navy-100"
                                href="#">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="size-5 text-slate-400 transition-colors group-hover:text-slate-500 group-focus:text-slate-500 dark:text-navy-300 dark:group-hover:text-navy-200 dark:group-focus:text-navy-200"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                                </svg>

                                <span>Shipping</span>
                            </a>
                        </li>
                        <li>
                            <a class="group inline-flex items-center space-x-2 tracking-wide outline-hidden transition-colors hover:text-slate-800 focus:text-navy-800 dark:hover:text-navy-100 dark:focus:text-navy-100"
                                href="#">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="size-5 text-slate-400 transition-colors group-hover:text-slate-500 group-focus:text-slate-500 dark:text-navy-300 dark:group-hover:text-navy-200 dark:group-focus:text-navy-200"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>
                                <span>Payments</span>
                            </a>
                        </li>
                        <li>
                            <a class="group inline-flex items-center space-x-2 tracking-wide outline-hidden transition-colors hover:text-slate-800 focus:text-navy-800 dark:hover:text-navy-100 dark:focus:text-navy-100"
                                href="#">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="size-5 text-slate-400 transition-colors group-hover:text-slate-500 group-focus:text-slate-500 dark:text-navy-300 dark:group-hover:text-navy-200 dark:group-focus:text-navy-200"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z" />
                                </svg>
                                <span>Returns</span>
                            </a>
                        </li>
                    </ul>
                    <div class="my-4 h-px bg-slate-200 dark:bg-navy-500"></div>
                    <ul class="space-y-3.5 font-inter font-medium">
                        <li>
                            <a class="group inline-flex items-center space-x-2 tracking-wide outline-hidden transition-colors hover:text-slate-800 focus:text-navy-800 dark:hover:text-navy-100 dark:focus:text-navy-100"
                                href="#">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="size-5 text-slate-400 transition-colors group-hover:text-slate-500 group-focus:text-slate-500 dark:text-navy-300 dark:group-hover:text-navy-200 dark:group-focus:text-navy-200"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>

                                <span>My Account</span>
                            </a>
                        </li>
                        <li>
                            <a class="group inline-flex items-center space-x-2 tracking-wide outline-hidden transition-colors hover:text-slate-800 focus:text-navy-800 dark:hover:text-navy-100 dark:focus:text-navy-100"
                                href="#">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="size-5 text-slate-400 transition-colors group-hover:text-slate-500 group-focus:text-slate-500 dark:text-navy-300 dark:group-hover:text-navy-200 dark:group-focus:text-navy-200"
                                    viewBox="0 0 24 24" fill="none">
                                    <path
                                        d="M21 12C21 13.1819 20.7672 14.3522 20.3149 15.4442C19.8626 16.5361 19.1997 17.5282 18.364 18.364C17.5282 19.1997 16.5361 19.8626 15.4442 20.3149C14.3522 20.7672 13.1819 21 12 21C10.8181 21 9.64778 20.7672 8.55585 20.3149C7.46392 19.8626 6.47177 19.1997 5.63604 18.364C4.80031 17.5282 4.13738 16.5361 3.68508 15.4442C3.23279 14.3522 3 13.1819 3 12C3 9.61305 3.94821 7.32387 5.63604 5.63604C7.32387 3.94821 9.61305 3 12 3C14.3869 3 16.6761 3.94821 18.364 5.63604C20.0518 7.32387 21 9.61305 21 12Z"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M12.0449 15.8486C12.625 15.8486 13.1318 15.6729 13.5654 15.3213C13.999 14.9697 14.2393 14.5303 14.2861 14.0029H15.8242C15.7949 14.5479 15.6074 15.0664 15.2617 15.5586C14.916 16.0508 14.4531 16.4434 13.873 16.7363C13.2988 17.0293 12.6895 17.1758 12.0449 17.1758C10.75 17.1758 9.71875 16.7451 8.95117 15.8838C8.18945 15.0166 7.80859 13.833 7.80859 12.333V12.0605C7.80859 11.1348 7.97852 10.3115 8.31836 9.59082C8.6582 8.87012 9.14453 8.31055 9.77734 7.91211C10.416 7.51367 11.1689 7.31445 12.0361 7.31445C13.1025 7.31445 13.9873 7.63379 14.6904 8.27246C15.3994 8.91113 15.7773 9.74023 15.8242 10.7598H14.2861C14.2393 10.1445 14.0049 9.64062 13.583 9.24805C13.167 8.84961 12.6514 8.65039 12.0361 8.65039C11.21 8.65039 10.5684 8.94922 10.1113 9.54688C9.66016 10.1387 9.43457 10.9971 9.43457 12.1221V12.4297C9.43457 13.5254 9.66016 14.3691 10.1113 14.9609C10.5625 15.5527 11.207 15.8486 12.0449 15.8486Z"
                                        fill="currentColor" />
                                </svg>

                                <span>Copyright &amp; Legal</span>
                            </a>
                        </li>
                        <li>
                            <a class="group inline-flex items-center space-x-2 tracking-wide outline-hidden transition-colors hover:text-slate-800 focus:text-navy-800 dark:hover:text-navy-100 dark:focus:text-navy-100"
                                href="#">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="size-5 text-slate-400 transition-colors group-hover:text-slate-500 group-focus:text-slate-500 dark:text-navy-300 dark:group-hover:text-navy-200 dark:group-focus:text-navy-200"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                                <span>Mobile App</span>
                            </a>
                        </li>
                        <li>
                            <a class="group inline-flex items-center space-x-2 tracking-wide outline-hidden transition-colors hover:text-slate-800 focus:text-navy-800 dark:hover:text-navy-100 dark:focus:text-navy-100"
                                href="#">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="size-5 text-slate-400 transition-colors group-hover:text-slate-500 group-focus:text-slate-500 dark:text-navy-300 dark:group-hover:text-navy-200 dark:group-focus:text-navy-200"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                                <span>Security</span>
                            </a>
                        </li>
                    </ul>
                    <div class="my-4 h-px bg-slate-200 dark:bg-navy-500"></div>
                    <ul class="space-y-3.5 font-inter font-medium">
                        <li>
                            <a class="group inline-flex items-center space-x-2 tracking-wide outline-hidden transition-colors hover:text-slate-800 focus:text-slate-800 dark:hover:text-navy-100 dark:focus:text-navy-100"
                                href="#">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="size-5 text-slate-400 transition-colors group-hover:text-slate-500 group-focus:text-slate-500 dark:text-navy-300 dark:group-hover:text-navy-200 dark:group-focus:text-navy-200"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>

                                <span>Getting start</span>
                            </a>
                        </li>
                        <li>
                            <a class="group inline-flex items-center space-x-2 tracking-wide outline-hidden transition-colors hover:text-slate-800 focus:text-slate-800 dark:hover:text-navy-100 dark:focus:text-navy-100"
                                href="#">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="size-5 text-slate-400 transition-colors group-hover:text-slate-500 group-focus:text-slate-500 dark:text-navy-300 dark:group-hover:text-navy-200 dark:group-focus:text-navy-200"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                                </svg>

                                <span>Shipping</span>
                            </a>
                        </li>
                        <li>
                            <a class="group inline-flex items-center space-x-2 tracking-wide outline-hidden transition-colors hover:text-slate-800 focus:text-navy-800 dark:hover:text-navy-100 dark:focus:text-navy-100"
                                href="#">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="size-5 text-slate-400 transition-colors group-hover:text-slate-500 group-focus:text-slate-500 dark:text-navy-300 dark:group-hover:text-navy-200 dark:group-focus:text-navy-200"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>
                                <span>Payments</span>
                            </a>
                        </li>
                        <li>
                            <a class="group inline-flex items-center space-x-2 tracking-wide outline-hidden transition-colors hover:text-slate-800 focus:text-navy-800 dark:hover:text-navy-100 dark:focus:text-navy-100"
                                href="#">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="size-5 text-slate-400 transition-colors group-hover:text-slate-500 group-focus:text-slate-500 dark:text-navy-300 dark:group-hover:text-navy-200 dark:group-focus:text-navy-200"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z" />
                                </svg>
                                <span>Returns</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-span-12 lg:col-span-8 xl:col-span-9">
                <div class="flex items-center space-x-2 pb-4">
                    <div
                        class="flex size-7 items-center justify-center rounded-lg bg-primary/10 p-1 text-primary dark:bg-accent-light/10 dark:text-accent-light">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-full w-full" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>
                    <h4 class="text-lg font-medium text-slate-700 dark:text-navy-100">
                        Getting Started
                    </h4>
                </div>
                <div x-data="{ expandedItem: 'item-1' }" class="space-y-4 sm:space-y-5">
                    <div class="card" x-data="accordionItem('item-1')">
                        <div class="flex cursor-pointer items-center justify-between p-4"
                            @click="expanded = !expanded">
                            <h3 class="text-base font-medium text-slate-700 dark:text-navy-100">
                                Question 1
                            </h3>
                            <div :class="expanded && '-rotate-180'"
                                class="text-sm font-normal leading-none text-slate-400 transition-transform duration-300 dark:text-navy-300">
                                <i class="fas fa-chevron-down"></i>
                            </div>
                        </div>
                        <div x-collapse x-show="expanded">
                            <div class="px-4 pb-4">
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                    Commodi earum magni officiis possimus repellendus.
                                    Accusantium adipisci aliquid praesentium quaerat
                                    voluptate.
                                </p>
                                <div class="flex space-x-2 pt-3">
                                    <a href="#"
                                        class="tag rounded-full border border-primary text-primary dark:border-accent-light dark:text-accent-light">
                                        Tag 1
                                    </a>
                                    <a href="#"
                                        class="tag rounded-full border border-primary text-primary dark:border-accent-light dark:text-accent-light">
                                        Tag 2
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card" x-data="accordionItem('item-2')">
                        <div class="flex cursor-pointer items-center justify-between p-4"
                            @click="expanded = !expanded">
                            <h3 class="text-base font-medium text-slate-700 dark:text-navy-100">
                                Question 2
                            </h3>
                            <div :class="expanded && '-rotate-180'"
                                class="text-sm font-normal leading-none text-slate-400 transition-transform duration-300 dark:text-navy-300">
                                <i class="fas fa-chevron-down"></i>
                            </div>
                        </div>
                        <div x-collapse x-show="expanded">
                            <div class="px-4 pb-4">
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                    Commodi earum magni officiis possimus repellendus.
                                    Accusantium adipisci aliquid praesentium quaerat
                                    voluptate.
                                </p>
                                <div class="flex space-x-2 pt-3">
                                    <a href="#"
                                        class="tag rounded-full border border-primary text-primary dark:border-accent-light dark:text-accent-light">
                                        Tag 1
                                    </a>
                                    <a href="#"
                                        class="tag rounded-full border border-primary text-primary dark:border-accent-light dark:text-accent-light">
                                        Tag 2
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card" x-data="accordionItem('item-3')">
                        <div class="flex cursor-pointer items-center justify-between p-4"
                            @click="expanded = !expanded">
                            <h3 class="text-base font-medium text-slate-700 dark:text-navy-100">
                                Question 3
                            </h3>
                            <div :class="expanded && '-rotate-180'"
                                class="text-sm font-normal leading-none text-slate-400 transition-transform duration-300 dark:text-navy-300">
                                <i class="fas fa-chevron-down"></i>
                            </div>
                        </div>
                        <div x-collapse x-show="expanded">
                            <div class="px-4 pb-4">
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                    Commodi earum magni officiis possimus repellendus.
                                    Accusantium adipisci aliquid praesentium quaerat
                                    voluptate.
                                </p>
                                <div class="flex space-x-2 pt-3">
                                    <a href="#"
                                        class="tag rounded-full border border-primary text-primary dark:border-accent-light dark:text-accent-light">
                                        Tag 1
                                    </a>
                                    <a href="#"
                                        class="tag rounded-full border border-primary text-primary dark:border-accent-light dark:text-accent-light">
                                        Tag 2
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card" x-data="accordionItem('item-4')">
                        <div class="flex cursor-pointer items-center justify-between p-4"
                            @click="expanded = !expanded">
                            <h3 class="text-base font-medium text-slate-700 dark:text-navy-100">
                                Question 4
                            </h3>
                            <div :class="expanded && '-rotate-180'"
                                class="text-sm font-normal leading-none text-slate-400 transition-transform duration-300 dark:text-navy-300">
                                <i class="fas fa-chevron-down"></i>
                            </div>
                        </div>
                        <div x-collapse x-show="expanded">
                            <div class="px-4 pb-4">
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                    Commodi earum magni officiis possimus repellendus.
                                    Accusantium adipisci aliquid praesentium quaerat
                                    voluptate.
                                </p>
                                <div class="flex space-x-2 pt-3">
                                    <a href="#"
                                        class="tag rounded-full border border-primary text-primary dark:border-accent-light dark:text-accent-light">
                                        Tag 1
                                    </a>
                                    <a href="#"
                                        class="tag rounded-full border border-primary text-primary dark:border-accent-light dark:text-accent-light">
                                        Tag 2
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card" x-data="accordionItem('item-5')">
                        <div class="flex cursor-pointer items-center justify-between p-4"
                            @click="expanded = !expanded">
                            <h3 class="text-base font-medium text-slate-700 dark:text-navy-100">
                                Question 5
                            </h3>
                            <div :class="expanded && '-rotate-180'"
                                class="text-sm font-normal leading-none text-slate-400 transition-transform duration-300 dark:text-navy-300">
                                <i class="fas fa-chevron-down"></i>
                            </div>
                        </div>
                        <div x-collapse x-show="expanded">
                            <div class="px-4 pb-4">
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                    Commodi earum magni officiis possimus repellendus.
                                    Accusantium adipisci aliquid praesentium quaerat
                                    voluptate.
                                </p>
                                <div class="flex space-x-2 pt-3">
                                    <a href="#"
                                        class="tag rounded-full border border-primary text-primary dark:border-accent-light dark:text-accent-light">
                                        Tag 1
                                    </a>
                                    <a href="#"
                                        class="tag rounded-full border border-primary text-primary dark:border-accent-light dark:text-accent-light">
                                        Tag 2
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card" x-data="accordionItem('item-6')">
                        <div class="flex cursor-pointer items-center justify-between p-4"
                            @click="expanded = !expanded">
                            <h3 class="text-base font-medium text-slate-700 dark:text-navy-100">
                                Question 6
                            </h3>
                            <div :class="expanded && '-rotate-180'"
                                class="text-sm font-normal leading-none text-slate-400 transition-transform duration-300 dark:text-navy-300">
                                <i class="fas fa-chevron-down"></i>
                            </div>
                        </div>
                        <div x-collapse x-show="expanded">
                            <div class="px-4 pb-4">
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                    Commodi earum magni officiis possimus repellendus.
                                    Accusantium adipisci aliquid praesentium quaerat
                                    voluptate.
                                </p>
                                <div class="flex space-x-2 pt-3">
                                    <a href="#"
                                        class="tag rounded-full border border-primary text-primary dark:border-accent-light dark:text-accent-light">
                                        Tag 1
                                    </a>
                                    <a href="#"
                                        class="tag rounded-full border border-primary text-primary dark:border-accent-light dark:text-accent-light">
                                        Tag 2
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card" x-data="accordionItem('item-7')">
                        <div class="flex cursor-pointer items-center justify-between p-4"
                            @click="expanded = !expanded">
                            <h3 class="text-base font-medium text-slate-700 dark:text-navy-100">
                                Question 7
                            </h3>
                            <div :class="expanded && '-rotate-180'"
                                class="text-sm font-normal leading-none text-slate-400 transition-transform duration-300 dark:text-navy-300">
                                <i class="fas fa-chevron-down"></i>
                            </div>
                        </div>
                        <div x-collapse x-show="expanded">
                            <div class="px-4 pb-4">
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                    Commodi earum magni officiis possimus repellendus.
                                    Accusantium adipisci aliquid praesentium quaerat
                                    voluptate.
                                </p>
                                <div class="flex space-x-2 pt-3">
                                    <a href="#"
                                        class="tag rounded-full border border-primary text-primary dark:border-accent-light dark:text-accent-light">
                                        Tag 1
                                    </a>
                                    <a href="#"
                                        class="tag rounded-full border border-primary text-primary dark:border-accent-light dark:text-accent-light">
                                        Tag 2
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-app-layout>
