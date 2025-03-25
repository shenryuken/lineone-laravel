<div>
    <div class="flex flex-col sm:flex-row items-center justify-between mb-6">
        <h2 class="text-2xl font-medium text-slate-700 dark:text-navy-100">
            Bank Management
        </h2>
        <div class="mt-3 sm:mt-0">
            <a href="{{ route('admin.banks.create') }}"
                class="btn bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Add New Bank
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="card p-4 sm:p-5 mb-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <label for="search"
                    class="block text-sm font-medium text-slate-700 dark:text-navy-100 mb-1">Search</label>
                <input type="text" id="search" wire:model.live.debounce.300ms="search" placeholder="Search banks..."
                    class="form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent">
            </div>
            <div>
                <label for="type" class="block text-sm font-medium text-slate-700 dark:text-navy-100 mb-1">Type</label>
                <select id="type" wire:model.live="type"
                    class="form-select w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent">
                    <option value="">All Types</option>
                    <option value="local">Local</option>
                    <option value="international">International</option>
                </select>
            </div>
            <div>
                <label for="country"
                    class="block text-sm font-medium text-slate-700 dark:text-navy-100 mb-1">Country</label>
                <select id="country" wire:model.live="country"
                    class="form-select w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent">
                    <option value="">All Countries</option>
                    @foreach($countries as $country)
                    <option value="{{ $country->country_code }}">{{ $country->country_name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="perPage" class="block text-sm font-medium text-slate-700 dark:text-navy-100 mb-1">Per
                    Page</label>
                <select id="perPage" wire:model.live="perPage"
                    class="form-select w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Banks Table -->
    <div class="card">
        <div class="is-scrollbar-hidden min-w-full overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                        <th class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100 lg:px-5">
                            <div class="flex items-center cursor-pointer" wire:click="sortBy('name')">
                                Bank Name
                                @if($sortField === 'name')
                                @if($sortDirection === 'asc')
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 15l7-7 7 7" />
                                </svg>
                                @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                                @endif
                                @endif
                            </div>
                        </th>
                        <th class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100 lg:px-5">
                            <div class="flex items-center cursor-pointer" wire:click="sortBy('code')">
                                Code
                                @if($sortField === 'code')
                                @if($sortDirection === 'asc')
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 15l7-7 7 7" />
                                </svg>
                                @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                                @endif
                                @endif
                            </div>
                        </th>
                        <th class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100 lg:px-5">
                            <div class="flex items-center cursor-pointer" wire:click="sortBy('type')">
                                Type
                                @if($sortField === 'type')
                                @if($sortDirection === 'asc')
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 15l7-7 7 7" />
                                </svg>
                                @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                                @endif
                                @endif
                            </div>
                        </th>
                        <th class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100 lg:px-5">
                            <div class="flex items-center cursor-pointer" wire:click="sortBy('country_name')">
                                Country
                                @if($sortField === 'country_name')
                                @if($sortDirection === 'asc')
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 15l7-7 7 7" />
                                </svg>
                                @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                                @endif
                                @endif
                            </div>
                        </th>
                        <th class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100 lg:px-5">
                            Currencies
                        </th>
                        <th class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100 lg:px-5">
                            <div class="flex items-center cursor-pointer" wire:click="sortBy('is_active')">
                                Status
                                @if($sortField === 'is_active')
                                @if($sortDirection === 'asc')
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 15l7-7 7 7" />
                                </svg>
                                @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                                @endif
                                @endif
                            </div>
                        </th>
                        <th class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100 lg:px-5">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($banks as $bank)
                    <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                            <div class="flex items-center space-x-4">
                                @if($bank->logo_path)
                                <div class="avatar h-9 w-9">
                                    <img class="rounded-full" src="{{ Storage::url($bank->logo_path) }}"
                                        alt="{{ $bank->name }}" />
                                </div>
                                @else
                                <div class="avatar h-9 w-9 bg-primary/10 dark:bg-accent/10">
                                    <div class="is-initial rounded-full text-primary dark:text-accent">
                                        {{ substr($bank->name, 0, 1) }}
                                    </div>
                                </div>
                                @endif
                                <div>
                                    <p class="font-medium text-slate-700 dark:text-navy-100">
                                        {{ $bank->name }}
                                    </p>
                                    @if($bank->swift_code)
                                    <p class="text-xs text-slate-400 dark:text-navy-300">
                                        SWIFT: {{ $bank->swift_code }}
                                    </p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                            {{ $bank->code }}
                        </td>
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                            <div
                                class="badge {{ $bank->type === 'local' ? 'bg-success/10 text-success' : 'bg-info/10 text-info' }} rounded-full">
                                {{ ucfirst($bank->type) }}
                            </div>
                        </td>
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                            {{ $bank->country_name }}
                            <span class="text-xs text-slate-400 dark:text-navy-300">({{ $bank->country_code }})</span>
                        </td>
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                            <div class="flex flex-wrap gap-1">
                                @foreach($bank->supported_currencies as $currency)
                                <span class="badge bg-primary/10 text-primary dark:bg-accent/10 dark:text-accent">
                                    {{ $currency }}
                                </span>
                                @endforeach
                            </div>
                        </td>
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                            <label class="inline-flex items-center">
                                <input type="checkbox"
                                    class="form-switch h-5 w-10 rounded-full bg-slate-300 before:rounded-full before:bg-slate-50 checked:bg-primary checked:before:bg-white dark:bg-navy-900 dark:before:bg-navy-300 dark:checked:bg-accent dark:checked:before:bg-white"
                                    wire:click="toggleBankStatus({{ $bank->id }})" {{ $bank->is_active ? 'checked' : ''
                                }}
                                />
                            </label>
                        </td>
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.banks.edit', $bank->id) }}"
                                    class="btn h-8 w-8 p-0 text-info hover:bg-info/20 focus:bg-info/20 active:bg-info/25">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <button wire:click="confirmBankDeletion({{ $bank->id }})"
                                    class="btn h-8 w-8 p-0 text-error hover:bg-error/20 focus:bg-error/20 active:bg-error/25">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-6 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-16 w-16 text-slate-400 dark:text-navy-300" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                                <p class="mt-2 text-slate-500 dark:text-navy-400">No banks found</p>
                                <a href="{{ route('admin.banks.create') }}"
                                    class="btn mt-4 bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                                    Add New Bank
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4">
            {{ $banks->links() }}
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    @if($confirmingBankDeletion)
    <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5">
        <div class="absolute inset-0 bg-slate-900/60 transition-opacity duration-300"></div>
        <div
            class="relative max-w-lg rounded-lg bg-white px-4 py-10 text-center transition-all duration-300 dark:bg-navy-700 sm:px-5">
            <svg xmlns="http://www.w3.org/2000/svg" class="inline h-28 w-28 text-error" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <h3 class="mt-4 text-xl font-semibold text-slate-800 dark:text-navy-50">
                Delete Bank
            </h3>
            <p class="mt-2 text-slate-500 dark:text-navy-200">
                Are you sure you want to delete this bank? This action cannot be undone.
            </p>
            <div class="mt-6 space-x-3">
                <button wire:click="$set('confirmingBankDeletion', false)"
                    class="btn min-w-[7rem] rounded-full border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                    Cancel
                </button>
                <button wire:click="deleteBank"
                    class="btn min-w-[7rem] rounded-full bg-error font-medium text-white hover:bg-error-focus focus:bg-error-focus active:bg-error-focus/90">
                    Delete
                </button>
            </div>
        </div>
    </div>
    @endif
</div>
