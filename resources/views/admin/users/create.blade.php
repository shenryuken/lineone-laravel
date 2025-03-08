<x-app-layout-sideblock title="Create User" is-header-blur="true">
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        <div class="flex items-center space-x-4 py-5 lg:py-6">
            <h2 class="text-xl font-medium text-slate-800 dark:text-navy-50 lg:text-2xl">
                Create User
            </h2>
            <div class="hidden h-full py-1 sm:flex">
                <div class="h-full w-px bg-slate-300 dark:bg-navy-600"></div>
            </div>
            <ul class="hidden flex-wrap items-center space-x-2 sm:flex">
                <li class="flex items-center space-x-2">
                    <a class="text-primary transition-colors hover:text-primary-focus dark:text-accent-light dark:hover:text-accent"
                        href="{{ route('admin.users.index') }}">
                        Users
                    </a>
                    <svg x-ignore xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </li>
                <li>Create User</li>
            </ul>
        </div>
        <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
            <div class="col-span-12 sm:col-span-8">
                <div class="card p-4 sm:p-5">
                    <p class="text-base font-medium text-slate-700 dark:text-navy-100">
                        User Information
                    </p>
                    <form action="{{ route('admin.users.store') }}" method="POST" class="mt-4 space-y-4">
                        @csrf
                        <label class="block">
                            <span>Full Name</span>
                            <span class="relative mt-1.5 flex">
                                <input
                                    class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent @error('name') border-error @enderror"
                                    placeholder="Enter full name" type="text" name="name" value="{{ old('name') }}"
                                    required />
                                <span
                                    class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                    <i class="far fa-user text-base"></i>
                                </span>
                            </span>
                            @error('name')
                            <span class="text-tiny-plus text-error">{{ $message }}</span>
                            @enderror
                        </label>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <label class="block">
                                <span>Email Address</span>
                                <span class="relative mt-1.5 flex">
                                    <input
                                        class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent @error('email') border-error @enderror"
                                        placeholder="Enter email address" type="email" name="email"
                                        value="{{ old('email') }}" required />
                                    <span
                                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                        <i class="fa-regular fa-envelope text-base"></i>
                                    </span>
                                </span>
                                @error('email')
                                <span class="text-tiny-plus text-error">{{ $message }}</span>
                                @enderror
                            </label>

                            <label class="block">
                                <span>Phone Number</span>
                                <span class="relative mt-1.5 flex">
                                    <input
                                        class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent @error('phone') border-error @enderror"
                                        placeholder="(999) 999-9999" type="text" name="phone"
                                        value="{{ old('phone') }}" />
                                    <span
                                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                        <i class="fa fa-phone"></i>
                                    </span>
                                </span>
                                @error('phone')
                                <span class="text-tiny-plus text-error">{{ $message }}</span>
                                @enderror
                            </label>
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <label class="block">
                                <span>Password</span>
                                <span class="relative mt-1.5 flex">
                                    <input
                                        class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent @error('password') border-error @enderror"
                                        placeholder="Enter password" type="password" name="password" required />
                                    <span
                                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                        <i class="fa-solid fa-lock text-base"></i>
                                    </span>
                                </span>
                                @error('password')
                                <span class="text-tiny-plus text-error">{{ $message }}</span>
                                @enderror
                            </label>

                            <label class="block">
                                <span>Confirm Password</span>
                                <span class="relative mt-1.5 flex">
                                    <input
                                        class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        placeholder="Confirm password" type="password" name="password_confirmation"
                                        required />
                                    <span
                                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                        <i class="fa-solid fa-lock text-base"></i>
                                    </span>
                                </span>
                            </label>
                        </div>

                        <div>
                            <span>User Status</span>
                            <div class="mt-3 flex flex-wrap space-x-2 sm:space-x-4">
                                <label class="inline-flex items-center space-x-2">
                                    <input
                                        class="form-radio is-basic h-5 w-5 rounded-full border-slate-400/70 checked:border-primary checked:bg-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:border-accent dark:checked:bg-accent dark:hover:border-accent dark:focus:border-accent"
                                        type="radio" name="status" value="active" {{ old('status', 'active' )=='active'
                                        ? 'checked' : '' }} />
                                    <span class="text-slate-600 dark:text-navy-100">Active</span>
                                </label>
                                <label class="inline-flex items-center space-x-2">
                                    <input
                                        class="form-radio is-basic h-5 w-5 rounded-full border-slate-400/70 checked:border-primary checked:bg-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:border-accent dark:checked:bg-accent dark:hover:border-accent dark:focus:border-accent"
                                        type="radio" name="status" value="inactive" {{ old('status')=='inactive'
                                        ? 'checked' : '' }} />
                                    <span class="text-slate-600 dark:text-navy-100">Inactive</span>
                                </label>
                                <label class="inline-flex items-center space-x-2">
                                    <input
                                        class="form-radio is-basic h-5 w-5 rounded-full border-slate-400/70 checked:border-primary checked:bg-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:border-accent dark:checked:bg-accent dark:hover:border-accent dark:focus:border-accent"
                                        type="radio" name="status" value="suspended" {{ old('status')=='suspended'
                                        ? 'checked' : '' }} />
                                    <span class="text-slate-600 dark:text-navy-100">Suspended</span>
                                </label>
                            </div>
                            @error('status')
                            <span class="text-tiny-plus text-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <span>User Roles</span>
                            <div class="mt-3 grid grid-cols-2 gap-2 sm:grid-cols-3 sm:gap-4">
                                @foreach($roles as $role)
                                <label class="inline-flex items-center space-x-2">
                                    <input
                                        class="form-radio is-basic h-5 w-5 rounded border-slate-400/70 checked:border-primary checked:bg-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:border-accent dark:checked:bg-accent dark:hover:border-accent dark:focus:border-accent"
                                        type="radio" name="role" value="{{ $role->name }}" {{ old('role')==$role->name ? 'checked' : '' }}
                                    />
                                    <span class="text-slate-600 dark:text-navy-100">{{ ucfirst($role->name) }}</span>
                                </label>
                                @endforeach
                            </div>
                            @error('roles')
                            <span class="text-tiny-plus text-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex justify-end space-x-2">
                            <a href="{{ route('admin.users.index') }}"
                                class="btn space-x-2 bg-slate-150 font-medium text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>Cancel</span>
                            </a>
                            <button type="submit"
                                class="btn space-x-2 bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                                <span>Create User</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
{{--
            <div class="hidden sm:col-span-4 sm:block">
                <div class="sticky top-24 mt-3">
                    <ol class="steps is-vertical line-space">
                        <li class="step pb-8 before:bg-primary dark:before:bg-accent">
                            <div class="step-header rounded-full bg-primary text-white dark:bg-accent">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <h3 class="ml-4 text-slate-700 dark:text-navy-100">
                                Basic Information
                            </h3>
                            <p class="ml-4 mt-1 text-xs text-slate-400 dark:text-navy-300">
                                User's personal details
                            </p>
                        </li>
                        <li class="step pb-8 before:bg-slate-200 dark:before:bg-navy-500">
                            <div class="step-header rounded-full bg-primary text-white dark:bg-accent">
                                1
                            </div>
                            <h3 class="ml-4 text-slate-700 dark:text-navy-100">
                                Account Settings
                            </h3>
                            <p class="ml-4 mt-1 text-xs text-slate-400 dark:text-navy-300">
                                Roles and permissions
                            </p>
                        </li>
                        <li class="step pb-8 before:bg-slate-200 dark:before:bg-navy-500">
                            <div
                                class="step-header rounded-full bg-slate-200 text-slate-800 dark:bg-navy-500 dark:text-white">
                                2
                            </div>
                            <h3 class="ml-4 text-slate-700 dark:text-navy-100">
                                Wallet Setup
                            </h3>
                            <p class="ml-4 mt-1 text-xs text-slate-400 dark:text-navy-300">
                                Configure user wallets
                            </p>
                        </li>
                        <li class="step pb-8 before:bg-slate-200 dark:before:bg-navy-500">
                            <div
                                class="step-header rounded-full bg-slate-200 text-slate-800 dark:bg-navy-500 dark:text-white">
                                3
                            </div>
                            <h3 class="ml-4 text-slate-700 dark:text-navy-100">
                                Review & Submit
                            </h3>
                            <p class="ml-4 mt-1 text-xs text-slate-400 dark:text-navy-300">
                                Confirm user details
                            </p>
                        </li>
                    </ol>
                </div>
            </div> --}}
        </div>

        {{-- <template x-if="$store.breakpoints.isXs">
            <div x-data="{isStuck:false}" class="pb-6" x-intersect:enter.full.margin.-60px.0.0.0="isStuck = false"
                x-intersect:leave.full.margin.-60px.0.0.0="isStuck = true">
                <div :class="isStuck && 'fixed right-0 top-[60px] w-full z-10'">
                    <div class="transition-all duration-200"
                        :class="isStuck && 'py-2.5 px-4 bg-white dark:bg-navy-700 shadow-lg relative'">
                        <ol class="steps with-space-line">
                            <li class="step before:bg-primary dark:before:bg-accent">
                                <div class="step-header rounded-full bg-primary text-white dark:bg-accent">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <h3 class="text-xs font-medium text-slate-700 dark:text-navy-100">
                                    Basic Info
                                </h3>
                            </li>
                            <li class="step before:bg-slate-200 dark:before:bg-navy-500">
                                <div class="step-header rounded-full bg-primary text-white dark:bg-accent">
                                    1
                                </div>
                                <h3 class="text-xs font-medium text-slate-700 dark:text-navy-100">
                                    Account
                                </h3>
                            </li>
                            <li class="step before:bg-slate-200 dark:before:bg-navy-500">
                                <div
                                    class="step-header rounded-full bg-slate-200 text-slate-800 dark:bg-navy-500 dark:text-white">
                                    2
                                </div>
                                <h3 class="text-xs font-medium text-slate-700 dark:text-navy-100">
                                    Wallet
                                </h3>
                            </li>
                            <li class="step before:bg-slate-200 dark:before:bg-navy-500">
                                <div
                                    class="step-header rounded-full bg-slate-200 text-slate-800 dark:bg-navy-500 dark:text-white">
                                    3
                                </div>
                                <h3 class="text-xs font-medium text-slate-700 dark:text-navy-100">
                                    Review
                                </h3>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </template> --}}
    </main>
</x-app-layout-sideblock>
