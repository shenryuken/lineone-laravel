<x-app-layout title="User Card 6" is-header-blur="true">
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        <div class="flex items-center justify-between py-5 lg:py-6">
            <div class="flex items-center space-x-1">
                <h2 class="text-xl font-medium text-slate-700 line-clamp-1 dark:text-navy-50 lg:text-2xl">
                    User Card
                </h2>
                <div x-data="usePopper({ placement: 'bottom-start', offset: 4 })" @click.outside="if(isShowPopper) isShowPopper = false" class="inline-flex">
                    <button x-ref="popperRef" @click="isShowPopper = !isShowPopper"
                        class="btn size-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                        <i class="fas fa-chevron-down"></i>
                    </button>

                    <div x-ref="popperRoot" class="popper-root" :class="isShowPopper && 'show'">
                        <div
                            class="popper-box rounded-md border border-slate-150 bg-white py-1.5 font-inter dark:border-navy-500 dark:bg-navy-700">
                            <ul>
                                <li>
                                    <a href="#"
                                        class="flex h-8 items-center space-x-3 px-3 pr-8 font-medium tracking-wide outline-hidden transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="mt-px size-4.5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                        </svg>
                                        <span> New User</span></a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="flex h-8 items-center space-x-3 px-3 pr-8 font-medium tracking-wide outline-hidden transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="mt-px size-4.5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                        </svg>
                                        <span>Export Users</span></a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="flex h-8 items-center space-x-3 px-3 pr-8 font-medium tracking-wide outline-hidden transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="mt-px size-4.5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <span>Setting</span></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center space-x-2">
                <label class="relative hidden sm:flex">
                    <input
                        class="form-input peer h-9 w-full rounded-full border border-slate-300 bg-transparent px-3 py-2 pl-9 text-xs-plus placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                        placeholder="Search users..." type="text" />
                    <span
                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 transition-colors duration-200"
                            fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M3.316 13.781l.73-.171-.73.171zm0-5.457l.73.171-.73-.171zm15.473 0l.73-.171-.73.171zm0 5.457l.73.171-.73-.171zm-5.008 5.008l-.171-.73.171.73zm-5.457 0l-.171.73.171-.73zm0-15.473l-.171-.73.171.73zm5.457 0l.171-.73-.171.73zM20.47 21.53a.75.75 0 101.06-1.06l-1.06 1.06zM4.046 13.61a11.198 11.198 0 010-5.115l-1.46-.342a12.698 12.698 0 000 5.8l1.46-.343zm14.013-5.115a11.196 11.196 0 010 5.115l1.46.342a12.698 12.698 0 000-5.8l-1.46.343zm-4.45 9.564a11.196 11.196 0 01-5.114 0l-.342 1.46c1.907.448 3.892.448 5.8 0l-.343-1.46zM8.496 4.046a11.198 11.198 0 015.115 0l.342-1.46a12.698 12.698 0 00-5.8 0l.343 1.46zm0 14.013a5.97 5.97 0 01-4.45-4.45l-1.46.343a7.47 7.47 0 005.568 5.568l.342-1.46zm5.457 1.46a7.47 7.47 0 005.568-5.567l-1.46-.342a5.97 5.97 0 01-4.45 4.45l.342 1.46zM13.61 4.046a5.97 5.97 0 014.45 4.45l1.46-.343a7.47 7.47 0 00-5.568-5.567l-.342 1.46zm-5.457-1.46a7.47 7.47 0 00-5.567 5.567l1.46.342a5.97 5.97 0 014.45-4.45l-.343-1.46zm8.652 15.28l3.665 3.664 1.06-1.06-3.665-3.665-1.06 1.06z" />
                        </svg>
                    </span>
                </label>

                <div class="flex">
                    <button
                        class="btn size-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25 sm:hidden sm:h-9 sm:w-9">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5" stroke="currentColor" fill="none"
                            viewBox="0 0 24 24">
                            <circle cx="10.2" cy="10.2" r="7.2" stroke-width="1.5"></circle>
                            <path stroke-width="1.5" stroke-linecap="round" d="M21 21l-3.6-3.6" />
                        </svg>
                    </button>
                    <button
                        class="btn size-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25 sm:h-9 sm:w-9">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24">
                            <path fill="currentColor"
                                d="M3 5.109C3 4.496 3.47 4 4.05 4h16.79c.58 0 1.049.496 1.049 1.109 0 .612-.47 1.108-1.05 1.108H4.05C3.47 6.217 3 5.721 3 5.11zM5.798 12.5c0-.612.47-1.109 1.05-1.109H18.04c.58 0 1.05.497 1.05 1.109s-.47 1.109-1.05 1.109H6.848c-.58 0-1.05-.497-1.05-1.109zM9.646 18.783c-.58 0-1.05.496-1.05 1.108 0 .613.47 1.109 1.05 1.109h5.597c.58 0 1.05-.496 1.05-1.109 0-.612-.47-1.108-1.05-1.108H9.646z" />
                        </svg>
                    </button>
                    <button
                        class="btn size-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25 sm:h-9 sm:w-9">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-5 lg:grid-cols-3 lg:gap-6 xl:grid-cols-4">
            <div class="card">
                <div class="flex flex-col items-center p-4 text-center sm:p-5">
                    <div class="avatar size-20">
                        <img class="rounded-full " src="{{asset('images/200x200.png')}}" alt="avatar" />
                    </div>
                    <h3 class="pt-3 text-lg font-medium text-slate-700 dark:text-navy-100">
                        Konnor Guzman
                    </h3>
                    <p class="text-xs-plus">Senior Developer</p>
                    <div class="my-3.5 flex flex-wrap space-x-2">
                        <div class="avatar size-8">
                            <img class="rounded-full " src="{{asset('images/200x200.png')}}" alt="avatar" />
                        </div>

                        <div class="avatar size-8">
                            <div class="is-initial rounded-full bg-info text-xs-plus uppercase text-white">
                                jd
                            </div>
                        </div>

                        <div class="avatar size-8">
                            <img class="rounded-full " src="{{asset('images/200x200.png')}}" alt="avatar" />
                        </div>
                    </div>
                </div>
                <div
                    class="flex divide-x divide-slate-150 border-t border-slate-150 dark:divide-navy-500 dark:border-navy-500">
                    <button
                        class="btn h-11 w-full rounded-none rounded-bl-lg font-medium text-slate-700 hover:bg-slate-300/20 active:bg-slate-300/25 dark:text-navy-100 dark:hover:bg-navy-300/20 dark:active:bg-navy-300/25">
                        Profile
                    </button>
                    <button
                        class="btn h-11 w-full rounded-none rounded-br-lg font-medium text-primary hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:text-accent-light dark:hover:bg-accent-light/20 dark:focus:bg-accent-light/20 dark:active:bg-accent-light/25">
                        Chat
                    </button>
                </div>
            </div>
            <div class="card">
                <div class="flex flex-col items-center p-4 text-center sm:p-5">
                    <div class="avatar size-20">
                        <img class="rounded-full " src="{{asset('images/200x200.png')}}" alt="avatar" />
                    </div>
                    <h3 class="pt-3 text-lg font-medium text-slate-700 dark:text-navy-100">
                        Travis Fuller
                    </h3>
                    <p class="text-xs-plus">Backend Developer</p>
                    <div class="my-3.5 flex flex-wrap space-x-2">
                        <div class="avatar size-8">
                            <img class="rounded-full " src="{{asset('images/200x200.png')}}" alt="avatar" />
                        </div>

                        <div class="avatar size-8">
                            <div class="is-initial rounded-full bg-info/10 text-xs-plus uppercase text-info">
                                sm
                            </div>
                        </div>
                        <div class="avatar size-8">
                            <div
                                class="is-initial rounded-full border border-warning/30 bg-warning/10 text-xs-plus uppercase text-warning">
                                uh
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="flex divide-x divide-slate-150 border-t border-slate-150 dark:divide-navy-500 dark:border-navy-500">
                    <button
                        class="btn h-11 w-full rounded-none rounded-bl-lg font-medium text-slate-700 hover:bg-slate-300/20 active:bg-slate-300/25 dark:text-navy-100 dark:hover:bg-navy-300/20 dark:active:bg-navy-300/25">
                        Profile
                    </button>
                    <button
                        class="btn h-11 w-full rounded-none rounded-br-lg font-medium text-primary hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:text-accent-light dark:hover:bg-accent-light/20 dark:focus:bg-accent-light/20 dark:active:bg-accent-light/25">
                        Chat
                    </button>
                </div>
            </div>
            <div class="card">
                <div class="flex flex-col items-center p-4 text-center sm:p-5">
                    <div class="avatar size-20">
                        <img class="rounded-full " src="{{asset('images/200x200.png')}}" alt="avatar" />
                    </div>
                    <h3 class="pt-3 text-lg font-medium text-slate-700 dark:text-navy-100">
                        Alfredo Elliott
                    </h3>
                    <p class="text-xs-plus">Android Developer</p>
                    <div class="my-3.5 flex flex-wrap space-x-2">
                        <div class="avatar size-8">
                            <div class="is-initial rounded-full bg-secondary text-xs-plus uppercase text-white">
                                TS
                            </div>
                        </div>
                        <div class="avatar size-8">
                            <img class="rounded-full " src="{{asset('images/200x200.png')}}" alt="avatar" />
                        </div>
                        <div class="avatar size-8">
                            <img class="rounded-full " src="{{asset('images/200x200.png')}}" alt="avatar" />
                        </div>
                    </div>
                </div>
                <div
                    class="flex divide-x divide-slate-150 border-t border-slate-150 dark:divide-navy-500 dark:border-navy-500">
                    <button
                        class="btn h-11 w-full rounded-none rounded-bl-lg font-medium text-slate-700 hover:bg-slate-300/20 active:bg-slate-300/25 dark:text-navy-100 dark:hover:bg-navy-300/20 dark:active:bg-navy-300/25">
                        Profile
                    </button>
                    <button
                        class="btn h-11 w-full rounded-none rounded-br-lg font-medium text-primary hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:text-accent-light dark:hover:bg-accent-light/20 dark:focus:bg-accent-light/20 dark:active:bg-accent-light/25">
                        Chat
                    </button>
                </div>
            </div>
            <div class="card">
                <div class="flex flex-col items-center p-4 text-center sm:p-5">
                    <div class="avatar size-20">
                        <img class="rounded-full " src="{{asset('images/200x200.png')}}" alt="avatar" />
                    </div>
                    <h3 class="pt-3 text-lg font-medium text-slate-700 dark:text-navy-100">
                        Derrick Simmons
                    </h3>
                    <p class="text-xs-plus">Laravel Developer</p>
                    <div class="my-3.5 flex flex-wrap space-x-2">
                        <div class="avatar size-8">
                            <div
                                class="is-initial rounded-full bg-primary text-xs-plus uppercase text-white dark:bg-accent">
                                AF
                            </div>
                        </div>
                        <div class="avatar size-8">
                            <img class="rounded-full " src="{{asset('images/200x200.png')}}" alt="avatar" />
                        </div>
                    </div>
                </div>
                <div
                    class="flex divide-x divide-slate-150 border-t border-slate-150 dark:divide-navy-500 dark:border-navy-500">
                    <button
                        class="btn h-11 w-full rounded-none rounded-bl-lg font-medium text-slate-700 hover:bg-slate-300/20 active:bg-slate-300/25 dark:text-navy-100 dark:hover:bg-navy-300/20 dark:active:bg-navy-300/25">
                        Profile
                    </button>
                    <button
                        class="btn h-11 w-full rounded-none rounded-br-lg font-medium text-primary hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:text-accent-light dark:hover:bg-accent-light/20 dark:focus:bg-accent-light/20 dark:active:bg-accent-light/25">
                        Chat
                    </button>
                </div>
            </div>
            <div class="card">
                <div class="flex flex-col items-center p-4 text-center sm:p-5">
                    <div class="avatar size-20">
                        <img class="rounded-full " src="{{asset('images/200x200.png')}}" alt="avatar" />
                    </div>
                    <h3 class="pt-3 text-lg font-medium text-slate-700 dark:text-navy-100">
                        Katrina West
                    </h3>
                    <p class="text-xs-plus">VueJS Developer</p>
                    <div class="my-3.5 flex flex-wrap space-x-2">
                        <div class="avatar size-8">
                            <div
                                class="is-initial rounded-full border border-primary/30 bg-primary/10 text-xs-plus uppercase text-primary dark:border-accent-light/30 dark:bg-accent-light/10 dark:text-accent-light">
                                SI
                            </div>
                        </div>
                        <div class="avatar size-8">
                            <img class="rounded-full " src="{{asset('images/200x200.png')}}" alt="avatar" />
                        </div>
                        <div class="avatar size-8">
                            <div class="is-initial rounded-full bg-success text-xs-plus uppercase text-white">
                                Io
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="flex divide-x divide-slate-150 border-t border-slate-150 dark:divide-navy-500 dark:border-navy-500">
                    <button
                        class="btn h-11 w-full rounded-none rounded-bl-lg font-medium text-slate-700 hover:bg-slate-300/20 active:bg-slate-300/25 dark:text-navy-100 dark:hover:bg-navy-300/20 dark:active:bg-navy-300/25">
                        Profile
                    </button>
                    <button
                        class="btn h-11 w-full rounded-none rounded-br-lg font-medium text-primary hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:text-accent-light dark:hover:bg-accent-light/20 dark:focus:bg-accent-light/20 dark:active:bg-accent-light/25">
                        Chat
                    </button>
                </div>
            </div>
            <div class="card">
                <div class="flex flex-col items-center p-4 text-center sm:p-5">
                    <div class="avatar size-20">
                        <img class="rounded-full " src="{{asset('images/200x200.png')}}" alt="avatar" />
                    </div>
                    <h3 class="pt-3 text-lg font-medium text-slate-700 dark:text-navy-100">
                        Henry Curtis
                    </h3>
                    <p class="text-xs-plus">Full Stack Developer</p>
                    <div class="my-3.5 flex flex-wrap space-x-2">
                        <div class="avatar size-8">
                            <img class="rounded-full " src="{{asset('images/200x200.png')}}" alt="avatar" />
                        </div>
                        <div class="avatar size-8">
                            <img class="rounded-full " src="{{asset('images/200x200.png')}}" alt="avatar" />
                        </div>
                        <div class="avatar size-8">
                            <div
                                class="is-initial rounded-full border border-success/30 bg-success/10 text-xs-plus uppercase text-success">
                                tr
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="flex divide-x divide-slate-150 border-t border-slate-150 dark:divide-navy-500 dark:border-navy-500">
                    <button
                        class="btn h-11 w-full rounded-none rounded-bl-lg font-medium text-slate-700 hover:bg-slate-300/20 active:bg-slate-300/25 dark:text-navy-100 dark:hover:bg-navy-300/20 dark:active:bg-navy-300/25">
                        Profile
                    </button>
                    <button
                        class="btn h-11 w-full rounded-none rounded-br-lg font-medium text-primary hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:text-accent-light dark:hover:bg-accent-light/20 dark:focus:bg-accent-light/20 dark:active:bg-accent-light/25">
                        Chat
                    </button>
                </div>
            </div>
            <div class="card">
                <div class="flex flex-col items-center p-4 text-center sm:p-5">
                    <div class="avatar size-20">
                        <img class="rounded-full " src="{{asset('images/200x200.png')}}" alt="avatar" />
                    </div>
                    <h3 class="pt-3 text-lg font-medium text-slate-700 dark:text-navy-100">
                        Raul Bradley
                    </h3>
                    <p class="text-xs-plus">Android Developer</p>
                    <div class="my-3.5 flex flex-wrap space-x-2">
                        <div class="avatar size-8">
                            <img class="rounded-full " src="{{asset('images/200x200.png')}}" alt="avatar" />
                        </div>
                        <div class="avatar size-8">
                            <div class="is-initial rounded-full bg-warning text-xs-plus uppercase text-white">
                                tr
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="flex divide-x divide-slate-150 border-t border-slate-150 dark:divide-navy-500 dark:border-navy-500">
                    <button
                        class="btn h-11 w-full rounded-none rounded-bl-lg font-medium text-slate-700 hover:bg-slate-300/20 active:bg-slate-300/25 dark:text-navy-100 dark:hover:bg-navy-300/20 dark:active:bg-navy-300/25">
                        Profile
                    </button>
                    <button
                        class="btn h-11 w-full rounded-none rounded-br-lg font-medium text-primary hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:text-accent-light dark:hover:bg-accent-light/20 dark:focus:bg-accent-light/20 dark:active:bg-accent-light/25">
                        Chat
                    </button>
                </div>
            </div>
            <div class="card">
                <div class="flex flex-col items-center p-4 text-center sm:p-5">
                    <div class="avatar size-20">
                        <img class="rounded-full " src="{{asset('images/200x200.png')}}" alt="avatar" />
                    </div>
                    <h3 class="pt-3 text-lg font-medium text-slate-700 dark:text-navy-100">
                        Samantha Shelton
                    </h3>
                    <p class="text-xs-plus">Laravel Developer</p>
                    <div class="my-3.5 flex flex-wrap space-x-2">
                        <div class="avatar size-8">
                            <img class="rounded-full " src="{{asset('images/200x200.png')}}" alt="avatar" />
                        </div>
                        <div class="avatar size-8">
                            <div
                                class="is-initial rounded-full bg-secondary/10 text-xs-plus uppercase text-secondary dark:bg-secondary-light/10 dark:text-secondary-light">
                                ec
                            </div>
                        </div>
                        <div class="avatar size-8">
                            <img class="rounded-full " src="{{asset('images/200x200.png')}}" alt="avatar" />
                        </div>
                    </div>
                </div>
                <div
                    class="flex divide-x divide-slate-150 border-t border-slate-150 dark:divide-navy-500 dark:border-navy-500">
                    <button
                        class="btn h-11 w-full rounded-none rounded-bl-lg font-medium text-slate-700 hover:bg-slate-300/20 active:bg-slate-300/25 dark:text-navy-100 dark:hover:bg-navy-300/20 dark:active:bg-navy-300/25">
                        Profile
                    </button>
                    <button
                        class="btn h-11 w-full rounded-none rounded-br-lg font-medium text-primary hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:text-accent-light dark:hover:bg-accent-light/20 dark:focus:bg-accent-light/20 dark:active:bg-accent-light/25">
                        Chat
                    </button>
                </div>
            </div>
            <div class="card">
                <div class="flex flex-col items-center p-4 text-center sm:p-5">
                    <div class="avatar size-20">
                        <img class="rounded-full " src="{{asset('images/200x200.png')}}" alt="avatar" />
                    </div>
                    <h3 class="pt-3 text-lg font-medium text-slate-700 dark:text-navy-100">
                        Corey Evans
                    </h3>
                    <p class="text-xs-plus">UI/UX Designer</p>
                    <div class="my-3.5 flex flex-wrap space-x-2">
                        <div class="avatar size-8">
                            <img class="rounded-full " src="{{asset('images/200x200.png')}}" alt="avatar" />
                        </div>

                        <div class="avatar size-8">
                            <img class="rounded-full " src="{{asset('images/200x200.png')}}" alt="avatar" />
                        </div>
                        <div class="avatar size-8">
                            <div class="is-initial rounded-full bg-error text-xs-plus uppercase text-white">
                                ve
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="flex divide-x divide-slate-150 border-t border-slate-150 dark:divide-navy-500 dark:border-navy-500">
                    <button
                        class="btn h-11 w-full rounded-none rounded-bl-lg font-medium text-slate-700 hover:bg-slate-300/20 active:bg-slate-300/25 dark:text-navy-100 dark:hover:bg-navy-300/20 dark:active:bg-navy-300/25">
                        Profile
                    </button>
                    <button
                        class="btn h-11 w-full rounded-none rounded-br-lg font-medium text-primary hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:text-accent-light dark:hover:bg-accent-light/20 dark:focus:bg-accent-light/20 dark:active:bg-accent-light/25">
                        Chat
                    </button>
                </div>
            </div>
            <div class="card">
                <div class="flex flex-col items-center p-4 text-center sm:p-5">
                    <div class="avatar size-20">
                        <img class="rounded-full " src="{{asset('images/200x200.png')}}" alt="avatar" />
                    </div>
                    <h3 class="pt-3 text-lg font-medium text-slate-700 dark:text-navy-100">
                        Lance Tucker
                    </h3>
                    <p class="text-xs-plus">Frontend Designer</p>
                    <div class="my-3.5 flex flex-wrap space-x-2">
                        <div class="avatar size-8">
                            <img class="rounded-full " src="{{asset('images/200x200.png')}}" alt="avatar" />
                        </div>

                        <div class="avatar size-8">
                            <div class="is-initial rounded-full bg-info text-xs-plus uppercase text-white">
                                ip
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="flex divide-x divide-slate-150 border-t border-slate-150 dark:divide-navy-500 dark:border-navy-500">
                    <button
                        class="btn h-11 w-full rounded-none rounded-bl-lg font-medium text-slate-700 hover:bg-slate-300/20 active:bg-slate-300/25 dark:text-navy-100 dark:hover:bg-navy-300/20 dark:active:bg-navy-300/25">
                        Profile
                    </button>
                    <button
                        class="btn h-11 w-full rounded-none rounded-br-lg font-medium text-primary hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:text-accent-light dark:hover:bg-accent-light/20 dark:focus:bg-accent-light/20 dark:active:bg-accent-light/25">
                        Chat
                    </button>
                </div>
            </div>
            <div class="card">
                <div class="flex flex-col items-center p-4 text-center sm:p-5">
                    <div class="avatar size-20">
                        <img class="rounded-full " src="{{asset('images/200x200.png')}}" alt="avatar" />
                    </div>
                    <h3 class="pt-3 text-lg font-medium text-slate-700 dark:text-navy-100">
                        Joe Perkins
                    </h3>
                    <p class="text-xs-plus">React Designer</p>
                    <div class="my-3.5 flex flex-wrap space-x-2">
                        <div class="avatar size-8">
                            <img class="rounded-full " src="{{asset('images/200x200.png')}}" alt="avatar" />
                        </div>
                        <div class="avatar size-8">
                            <img class="rounded-full " src="{{asset('images/200x200.png')}}" alt="avatar" />
                        </div>

                        <div class="avatar size-8">
                            <div
                                class="is-initial rounded-full border border-info/30 bg-info/10 text-xs-plus uppercase text-info">
                                ds
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="flex divide-x divide-slate-150 border-t border-slate-150 dark:divide-navy-500 dark:border-navy-500">
                    <button
                        class="btn h-11 w-full rounded-none rounded-bl-lg font-medium text-slate-700 hover:bg-slate-300/20 active:bg-slate-300/25 dark:text-navy-100 dark:hover:bg-navy-300/20 dark:active:bg-navy-300/25">
                        Profile
                    </button>
                    <button
                        class="btn h-11 w-full rounded-none rounded-br-lg font-medium text-primary hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:text-accent-light dark:hover:bg-accent-light/20 dark:focus:bg-accent-light/20 dark:active:bg-accent-light/25">
                        Chat
                    </button>
                </div>
            </div>
            <div class="card">
                <div class="flex flex-col items-center p-4 text-center sm:p-5">
                    <div class="avatar size-20">
                        <img class="rounded-full " src="{{asset('images/200x200.png')}}" alt="avatar" />
                    </div>
                    <h3 class="pt-3 text-lg font-medium text-slate-700 dark:text-navy-100">
                        Joe Perkins
                    </h3>
                    <p class="text-xs-plus">React Designer</p>
                    <div class="my-3.5 flex flex-wrap space-x-2">
                        <div class="avatar size-8">
                            <img class="rounded-full " src="{{asset('images/200x200.png')}}" alt="avatar" />
                        </div>
                        <div class="avatar size-8">
                            <div class="is-initial rounded-full bg-warning text-xs-plus uppercase text-white">
                                ds
                            </div>
                        </div>
                        <div class="avatar size-8">
                            <div
                                class="is-initial rounded-full bg-primary/10 text-xs-plus uppercase text-primary dark:bg-accent-light/10 dark:text-accent-light">
                                mf
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="flex divide-x divide-slate-150 border-t border-slate-150 dark:divide-navy-500 dark:border-navy-500">
                    <button
                        class="btn h-11 w-full rounded-none rounded-bl-lg font-medium text-slate-700 hover:bg-slate-300/20 active:bg-slate-300/25 dark:text-navy-100 dark:hover:bg-navy-300/20 dark:active:bg-navy-300/25">
                        Profile
                    </button>
                    <button
                        class="btn h-11 w-full rounded-none rounded-br-lg font-medium text-primary hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:text-accent-light dark:hover:bg-accent-light/20 dark:focus:bg-accent-light/20 dark:active:bg-accent-light/25">
                        Chat
                    </button>
                </div>
            </div>
        </div>
    </main>
</x-app-layout>
