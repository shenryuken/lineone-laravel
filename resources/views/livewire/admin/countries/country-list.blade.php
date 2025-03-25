<div>
    <div class="flex flex-col sm:flex-row items-center justify-between mb-6">
        <h2 class="text-2xl font-medium text-slate-700 dark:text-navy-100">
            Countries Management
        </h2>
    </div>

    <!-- Filters -->
    <div class="card p-4 sm:p-5 mb-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <label for="search"
                    class="block text-sm font-medium text-slate-700 dark:text-navy-100 mb-1">Search</label>
                <input type="text" id="search" wire:model.live.debounce.300ms="search" placeholder="Search countries..."
                    class="form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent">
            </div>
            <div>
                <label for="region"
                    class="block text-sm font-medium text-slate-700 dark:text-navy-100 mb-1">Region</label>
                <select id="region" wire:model.live="region"
                    class="form-select w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent">
                    <option value="">All Regions</option>
                    @foreach($regions as $regionName)
                    <option value="{{ $regionName }}">{{ $regionName }}</option>
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

    <!-- Countries Table -->
    <div class="card">
        <div class="is-scrollbar-hidden min-w-full overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                        <th class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100 lg:px-5">
                            <div class="flex items-center cursor-pointer" wire:click="sortBy('name')">
                                Country
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
                            <div class="flex items-center cursor-pointer" wire:click="sortBy('region')">
                                Region
                                @if($sortField === 'region')
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
                            Currency
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
                    @forelse($countries as $country)
                    <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                            <div class="flex items-center space-x-4">
                                <div class="avatar h-9 w-9">
                                    <div
                                        class="is-initial rounded-full bg-primary/10 text-primary dark:bg-accent/10 dark:text-accent">
                                        {{ substr($country->code_alpha2, 0, 2) }}
                                    </div>
                                </div>
                                <div>
                                    <p class="font-medium text-slate-700 dark:text-navy-100">
                                        {{ $country->name }}
                                    </p>
                                    <p class="text-xs text-slate-400 dark:text-navy-300">
                                        {{ $country->phone_code ? '+'.$country->phone_code : '' }}
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                            <div>
                                <p>{{ $country->code }}</p>
                                <p class="text-xs text-slate-400 dark:text-navy-300">{{ $country->code_alpha2 }}</p>
                            </div>
                        </td>
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                            {{ $country->region }}
                        </td>
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                            <div>
                                <p>{{ $country->currency_code }}</p>
                                <p class="text-xs text-slate-400 dark:text-navy-300">{{ $country->currency_name }}</p>
                            </div>
                        </td>
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                            <label class="inline-flex items-center">
                                <input type="checkbox"
                                    class="form-switch h-5 w-10 rounded-full bg-slate-300 before:rounded-full before:bg-slate-50 checked:bg-primary checked:before:bg-white dark:bg-navy-900 dark:before:bg-navy-300 dark:checked:bg-accent dark:checked:before:bg-white"
                                    wire:click="toggleCountryStatus({{ $country->id }})" {{ $country->is_active ?
                                'checked' : '' }}
                                />
                            </label>
                        </td>
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                            <div class="flex items-center space-x-2">
                                <button
                                    class="btn h-8 w-8 p-0 text-info hover:bg-info/20 focus:bg-info/20 active:bg-info/25">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-16 w-16 text-slate-400 dark:text-navy-300" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9" />
                                </svg>
                                <p class="mt-2 text-slate-500 dark:text-navy-400">No countries found</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4">
            {{ $countries->links() }}
        </div>
    </div>
</div>
