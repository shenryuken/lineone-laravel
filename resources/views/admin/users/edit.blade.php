<x-app-layout-sideblock title="Edit User">
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        <div class="flex items-center space-x-4 py-5 lg:py-6">
            <h2 class="text-xl font-medium text-slate-800 dark:text-navy-50">
                Edit User
            </h2>
            <div class="hidden h-full py-1 sm:flex">
                <div class="h-full w-px bg-slate-300 dark:bg-navy-600"></div>
            </div>
            <ul class="hidden flex-wrap items-center space-x-2 sm:flex">
                <li class="flex items-center space-x-2">
                    <a class="text-primary transition-colors hover:text-primary-focus dark:text-accent-light dark:hover:text-accent"
                        href="{{ route('admin.users.index') }}">User Management</a>
                    <svg x-ignore xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </li>
                <li>Edit User</li>
            </ul>
        </div>

        @if(session('success'))
        <div class="alert flex rounded-lg bg-success/10 py-4 px-4 text-success dark:bg-success/15 mb-5">
            <div class="flex">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        </div>
        @endif
        @if(session('error'))
        <div class="alert flex rounded-lg bg-danger/10 py-4 px-4 text-danger dark:bg-danger/15 mb-5">
            <div class="flex">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        </div>
        @endif

        <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
            <div class="col-span-12 lg:col-span-8">
                <div class="card">
                    <div class="tabs flex flex-col">
                        <div class="is-scrollbar-hidden overflow-x-auto">
                            <div class="border-b-2 border-slate-150 dark:border-navy-500">
                                <div class="tabs-list -mb-0.5 flex">
                                    <button data-tab="user-details"
                                        class="btn h-14 shrink-0 space-x-2 rounded-none border-b-2 border-primary px-4 font-medium text-primary dark:border-accent dark:text-accent-light sm:px-5">
                                        <i class="fa-solid fa-user text-base"></i>
                                        <span>User Details</span>
                                    </button>
                                    <button data-tab="wallets"
                                        class="btn h-14 shrink-0 space-x-2 rounded-none border-b-2 border-transparent px-4 font-medium hover:text-slate-800 focus:text-slate-800 dark:hover:text-navy-100 dark:focus:text-navy-100 sm:px-5">
                                        <i class="fa-solid fa-wallet text-base"></i>
                                        <span>Wallets</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div id="user-details" class="tab-content p-4 sm:p-5">
                            <form method="POST" action="{{ route('admin.users.update', $user) }}">
                                @csrf
                                @method('PUT')
                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                    <div>
                                        <label class="block text-sm font-medium text-slate-600 dark:text-navy-100">Full
                                            Name</label>
                                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                            class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Enter full name" required>
                                        @error('name')
                                        <span class="text-tiny-plus text-error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div>
                                        <label
                                            class="block text-sm font-medium text-slate-600 dark:text-navy-100">Email</label>
                                        <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                            class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Enter email address" required>
                                        @error('email')
                                        <span class="text-tiny-plus text-error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div>
                                        <label
                                            class="block text-sm font-medium text-slate-600 dark:text-navy-100">Password</label>
                                        <input type="password" name="password"
                                            class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Enter new password (leave blank to keep current)">
                                        @error('password')
                                        <span class="text-tiny-plus text-error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-slate-600 dark:text-navy-100">Confirm
                                            Password</label>
                                        <input type="password" name="password_confirmation"
                                            class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Confirm new password">
                                    </div>
                                </div>

                                <div class="mt-6">
                                    <span>User Status</span>

                                    <div class="mt-3 flex flex-wrap space-x-2 sm:space-x-4">
                                        @php
                                        // Determine the current status, defaulting to the user's current status or 'active'
                                        $currentStatus = old('status', $user->status ?? 'active');
                                        @endphp

                                        @foreach(['active', 'inactive', 'suspended'] as $status)
                                        <label class="inline-flex items-center space-x-2">
                                            <input class="form-radio is-basic h-5 w-5 rounded-full border-slate-400/70
                                                           checked:border-primary checked:bg-primary
                                                           hover:border-primary focus:border-primary
                                                           dark:border-navy-400 dark:checked:border-accent
                                                           dark:checked:bg-accent dark:hover:border-accent
                                                           dark:focus:border-accent" type="radio" name="status" value="{{ $status }}" {{
                                                $currentStatus==$status ? 'checked' : '' }} />
                                            <span class="text-slate-600 dark:text-navy-100">
                                                {{ ucfirst($status) }}
                                            </span>
                                        </label>
                                        @endforeach
                                    </div>

                                    @error('status')
                                    <span class="text-tiny-plus text-error">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mt-6">
                                    <label class="block text-sm font-medium text-slate-600 dark:text-navy-100">User Roles</label>
                                    <span class="text-xs-plus text-slate-400 dark:text-navy-300">
                                        Assign user roles to control access to the system
                                    </span>
                                    <div class="mt-3 grid grid-cols-2 gap-2 sm:grid-cols-3 sm:gap-4">
                                        @foreach($roles as $role)
                                        <label class="inline-flex items-center space-x-2">
                                            <input
                                                class="form-radio is-basic h-5 w-5 rounded border-slate-400/70 checked:border-primary checked:bg-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:border-accent dark:checked:bg-accent dark:hover:border-accent dark:focus:border-accent"
                                                type="radio" name="role" value="{{ $role->name }}" @checked( old('role', $user->roles->first()?->name)
                                            == $role->name) />
                                            <span class="text-slate-600 dark:text-navy-100">{{ ucfirst($role->name) }}</span>
                                        </label>
                                        @endforeach
                                    </div>
                                    @error('role')
                                    <span class="text-tiny-plus text-error">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mt-6 flex items-center justify-end space-x-2">
                                    <a href="{{ route('admin.users.index') }}"
                                        class="btn min-w-[7rem] border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                                        Cancel
                                    </a>
                                    <button type="submit"
                                        class="btn min-w-[7rem] bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                                        Update User
                                    </button>
                                </div>
                            </form>
                        </div>
                        {{-- <div id="wallets" class="tab-content hidden p-4 sm:p-5">
                            <div class="mb-5">
                                <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100">User Wallets</h3>
                                <p class="text-xs-plus text-slate-400 dark:text-navy-300">Manage user's wallets</p>
                            </div>

                            <div class="mb-4">
                                <div class="overflow-x-auto">
                                    <table class="w-full text-left">
                                        <thead>
                                            <tr
                                                class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                <th
                                                    class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100">
                                                    Account #</th>
                                                <th
                                                    class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100">
                                                    Currency</th>
                                                <th
                                                    class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100">
                                                    Type</th>
                                                <th
                                                    class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100">
                                                    Balance</th>
                                                <th
                                                    class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100">
                                                    Status</th>
                                                <th
                                                    class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100">
                                                    Default</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($wallets as $wallet)
                                            <tr
                                                class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                <td class="whitespace-nowrap px-3 py-3">{{ $wallet->account_number }}</td>
                                                <td class="whitespace-nowrap px-3 py-3">{{ $wallet->currency }}</td>
                                                <td class="whitespace-nowrap px-3 py-3">{{ ucfirst($wallet->type) }}</td>
                                                <td class="whitespace-nowrap px-3 py-3">{{ number_format($wallet->balance,
                                                    2) }}</td>
                                                <td class="whitespace-nowrap px-3 py-3">
                                                    <span
                                                        class="badge {{ $wallet->is_verify ? 'bg-success/10 text-success dark:bg-success/15' : 'bg-warning/10 text-warning dark:bg-warning/15' }}">
                                                        {{ $wallet->is_verify ? 'Verified' : 'Unverified' }}
                                                    </span>
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-3">
                                                    <span
                                                        class="badge {{ $wallet->is_default ? 'bg-primary/10 text-primary dark:bg-accent-light/15 dark:text-accent-light' : 'bg-slate-150 text-slate-800 dark:bg-navy-500 dark:text-navy-100' }}">
                                                        {{ $wallet->is_default ? 'Default' : 'No' }}
                                                    </span>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="6" class="px-3 py-8 text-center">
                                                    <p class="text-slate-500 dark:text-navy-200">No wallets found</p>
                                                </td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="mt-5">
                                <h4 class="text-base font-medium text-slate-700 dark:text-navy-100">Create New Wallet</h4>
                                <form action="{{ route('admin.users.create-wallet', $user) }}" method="POST" class="mt-3">
                                    @csrf
                                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                                        <div>
                                            <label
                                                class="block text-sm font-medium text-slate-600 dark:text-navy-100">Currency</label>
                                            <input type="text" name="currency" value="{{ old('currency', 'MYR') }}"
                                                class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                                placeholder="e.g. MYR, USD" required>
                                            @error('currency')
                                            <span class="text-tiny-plus text-error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div>
                                            <label
                                                class="block text-sm font-medium text-slate-600 dark:text-navy-100">Type</label>
                                            <input type="text" name="type" value="{{ old('type', 'default') }}"
                                                class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                                placeholder="e.g. default, savings" required>
                                            @error('type')
                                            <span class="text-tiny-plus text-error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="flex items-end">
                                            <label class="inline-flex items-center space-x-2 mt-1.5">
                                                <input
                                                    class="form-checkbox is-basic h-5 w-5 rounded border-slate-400/70 checked:border-primary checked:bg-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:border-accent dark:checked:bg-accent dark:hover:border-accent dark:focus:border-accent"
                                                    type="checkbox" name="is_default" value="1" {{ old('is_default')
                                                    ? 'checked' : '' }} />
                                                <span class="text-slate-600 dark:text-navy-100">Set as Default</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <button type="submit"
                                            class="btn bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                                            Create Wallet
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tab functionality
            const tabButtons = document.querySelectorAll('[data-tab]');
            const tabContents = document.querySelectorAll('.tab-content');

            tabButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const tabId = button.getAttribute('data-tab');

                    // Hide all tab contents
                    tabContents.forEach(content => {
                        content.classList.add('hidden');
                    });

                    // Show selected tab content
                    document.getElementById(tabId).classList.remove('hidden');

                    // Update active tab button
                    tabButtons.forEach(btn => {
                        btn.classList.remove('border-primary', 'text-primary', 'dark:border-accent', 'dark:text-accent-light');
                        btn.classList.add('border-transparent');
                    });

                    button.classList.remove('border-transparent');
                    button.classList.add('border-primary', 'text-primary', 'dark:border-accent', 'dark:text-accent-light');
                });
            });
        });
    </script>
</x-app-layout-sideblock>
