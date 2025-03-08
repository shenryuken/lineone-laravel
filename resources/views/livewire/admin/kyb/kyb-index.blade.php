{{-- <div>
    <!-- KYB Status Cards -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-5 lg:grid-cols-4 lg:gap-6 mb-5">
        <div class="card p-4 sm:p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-lg font-semibold text-slate-700 dark:text-navy-100">
                        {{ $statusCounts['pending'] }}
                    </p>
                    <p class="text-xs+ text-slate-400 dark:text-navy-300">
                        {{ __('Pending') }}
                    </p>
                </div>
                <div class="mask is-squircle bg-warning/10 p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-warning" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <a href="#" wire:click.prevent="$set('status', 'pending')"
                    class="border-b border-dashed border-current pb-0.5 font-medium text-warning outline-none transition-colors duration-300 hover:text-warning/70 focus:text-warning/70">
                    {{ __('View Applications') }}
                </a>
            </div>
        </div>

        <div class="card p-4 sm:p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-lg font-semibold text-slate-700 dark:text-navy-100">
                        {{ $statusCounts['approved'] }}
                    </p>
                    <p class="text-xs+ text-slate-400 dark:text-navy-300">
                        {{ __('Approved') }}
                    </p>
                </div>
                <div class="mask is-squircle bg-success/10 p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-success" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <a href="#" wire:click.prevent="$set('status', 'approved')"
                    class="border-b border-dashed border-current pb-0.5 font-medium text-success outline-none transition-colors duration-300 hover:text-success/70 focus:text-success/70">
                    {{ __('View Applications') }}
                </a>
            </div>
        </div>

        <div class="card p-4 sm:p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-lg font-semibold text-slate-700 dark:text-navy-100">
                        {{ $statusCounts['rejected'] }}
                    </p>
                    <p class="text-xs+ text-slate-400 dark:text-navy-300">
                        {{ __('Rejected') }}
                    </p>
                </div>
                <div class="mask is-squircle bg-error/10 p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-error" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <a href="#" wire:click.prevent="$set('status', 'rejected')"
                    class="border-b border-dashed border-current pb-0.5 font-medium text-error outline-none transition-colors duration-300 hover:text-error/70 focus:text-error/70">
                    {{ __('View Applications') }}
                </a>
            </div>
        </div>

        <div class="card p-4 sm:p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-lg font-semibold text-slate-700 dark:text-navy-100">
                        {{ $statusCounts['additional_info'] }}
                    </p>
                    <p class="text-xs+ text-slate-400 dark:text-navy-300">
                        {{ __('Additional Info') }}
                    </p>
                </div>
                <div class="mask is-squircle bg-info/10 p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-info" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <a href="#" wire:click.prevent="$set('status', 'additional_info')"
                    class="border-b border-dashed border-current pb-0.5 font-medium text-info outline-none transition-colors duration-300 hover:text-info/70 focus:text-info/70">
                    {{ __('View Applications') }}
                </a>
            </div>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="card p-4 sm:p-5 mb-5">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between">
            <div class="mb-4 sm:mb-0">
                <div class="relative w-full sm:w-72">
                    <input wire:model.debounce.300ms="search"
                        class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                        placeholder="Search by business name, email..." type="text" />
                    <span
                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5 transition-colors duration-200"
                            fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M3.316 13.781l.73-.171-.73.171zm0-5.457l.73.171-.73-.171zm15.473 0l.73-.171-.73.171zm0 5.457l.73.171-.73-.171zm-5.008 5.008l-.171-.73.171.73zm-5.457 0l-.171.73.171-.73zm0-15.473l-.171-.73.171.73zm5.457 0l.171-.73-.171.73zM20.47 21.53a.75.75 0 101.06-1.06l-1.06 1.06zM4.046 13.61a11.198 11.198 0 010-5.115l-1.46-.342a12.698 12.698 0 000 5.8l1.46-.343zm14.013-5.115a11.196 11.196 0 010 5.115l1.46.342a12.698 12.698 0 000-5.8l-1.46.343zm-4.45 9.564a11.196 11.196 0 01-5.114 0l-.342 1.46c1.907.448 3.892.448 5.8 0l-.343-1.46zM8.496 4.046a11.198 11.198 0 015.115 0l.342-1.46a12.698 12.698 0 00-5.8 0l.343 1.46zm0 14.013a5.97 5.97 0 01-4.45-4.45l-1.46.343a7.47 7.47 0 005.568 5.568l.342-1.46zm5.457 1.46a7.47 7.47 0 005.568-5.567l-1.46-.342a5.97 5.97 0 01-4.45 4.45l.342 1.46zM13.61 4.046a5.97 5.97 0 014.45 4.45l1.46-.343a7.47 7.47 0 00-5.568-5.567l-.342 1.46zm-5.457-1.46a7.47 7.47 0 00-5.567 5.567l1.46.342a5.97 5.97 0 014.45-4.45l-.343-1.46zm8.652 15.28l3.665 3.664 1.06-1.06-3.665-3.665-1.06 1.06z" />
                        </svg>
                    </span>
                </div>
            </div>
            <div class="flex flex-wrap items-center space-x-2 space-y-2 sm:space-y-0">
                <div>
                    <select wire:model="status"
                        class="form-select w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">
                        <option value="">{{ __('All Statuses') }}</option>
                        <option value="pending">{{ __('Pending') }}</option>
                        <option value="approved">{{ __('Approved') }}</option>
                        <option value="rejected">{{ __('Rejected') }}</option>
                        <option value="additional_info">{{ __('Additional Info') }}</option>
                    </select>
                </div>
                <div>
                    <select wire:model="perPage"
                        class="form-select w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">
                        <option>10</option>
                        <option>25</option>
                        <option>50</option>
                        <option>100</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- KYB Applications Table -->
    <div class="card">
        <div class="is-scrollbar-hidden min-w-full overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                        <th class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100">
                            <a href="#" wire:click.prevent="sortBy('legal_name')" class="flex items-center">
                                {{ __('Business Name') }}
                                @if ($sortField === 'legal_name')
                                @if ($sortDirection === 'asc')
                                <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-3 w-3" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 15l7-7 7 7" />
                                </svg>
                                @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-3 w-3" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                                @endif
                                @endif
                            </a>
                        </th>
                        <th class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100">
                            {{ __('Registration Number') }}
                        </th>
                        <th class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100">
                            {{ __('Business Type') }}
                        </th>
                        <th class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100">
                            <a href="#" wire:click.prevent="sortBy('status')" class="flex items-center">
                                {{ __('Status') }}
                                @if ($sortField === 'status')
                                @if ($sortDirection === 'asc')
                                <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-3 w-3" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 15l7-7 7 7" />
                                </svg>
                                @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-3 w-3" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                                @endif
                                @endif
                            </a>
                        </th>
                        <th class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100">
                            <a href="#" wire:click.prevent="sortBy('created_at')" class="flex items-center">
                                {{ __('Submitted') }}
                                @if ($sortField === 'created_at')
                                @if ($sortDirection === 'asc')
                                <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-3 w-3" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 15l7-7 7 7" />
                                </svg>
                                @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-3 w-3" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                                @endif
                                @endif
                            </a>
                        </th>
                        <th class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100">
                            <a href="#" wire:click.prevent="sortBy('updated_at')" class="flex items-center">
                                {{ __('Last Updated') }}
                                @if ($sortField === 'updated_at')
                                @if ($sortDirection === 'asc')
                                <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-3 w-3" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 15l7-7 7 7" />
                                </svg>
                                @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-3 w-3" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                                @endif
                                @endif
                            </a>
                        </th>
                        <th class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100">
                            {{ __('Actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kybs as $kyb)
                    <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                            <div class="flex items-center space-x-4">
                                <div class="avatar h-9 w-9">
                                    <div
                                        class="is-initial rounded-full bg-primary/10 text-primary dark:bg-accent/10 dark:text-accent">
                                        {{ substr($kyb->legal_name, 0, 1) }}
                                    </div>
                                </div>
                                <div>
                                    <p class="font-medium text-slate-700 dark:text-navy-100">
                                        {{ $kyb->legal_name }}
                                    </p>
                                    <p class="text-xs text-slate-400 dark:text-navy-300">
                                        {{ $kyb->user->email }}
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                            {{ $kyb->registration_number }}
                        </td>
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                            <div
                                class="badge rounded-full bg-slate-100 text-slate-600 dark:bg-navy-700 dark:text-navy-100">
                                {{ ucfirst(str_replace('_', ' ', $kyb->business_type)) }}
                            </div>
                        </td>
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                            @if($kyb->status === 'pending')
                            <div class="badge rounded-full bg-warning/10 text-warning dark:bg-warning/15">
                                {{ __('Pending') }}
                            </div>
                            @elseif($kyb->status === 'approved')
                            <div class="badge rounded-full bg-success/10 text-success dark:bg-success/15">
                                {{ __('Approved') }}
                            </div>
                            @elseif($kyb->status === 'rejected')
                            <div class="badge rounded-full bg-error/10 text-error dark:bg-error/15">
                                {{ __('Rejected') }}
                            </div>
                            @elseif($kyb->status === 'additional_info')
                            <div class="badge rounded-full bg-info/10 text-info dark:bg-info/15">
                                {{ __('Additional Info') }}
                            </div>
                            @endif
                        </td>
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                            {{ $kyb->created_at->format('M d, Y') }}
                        </td>
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                            {{ $kyb->updated_at->format('M d, Y') }}
                        </td>
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                            <a href="{{ route('admin.kyb.show', $kyb) }}"
                                class="btn h-8 w-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center sm:px-5">
                            <div class="flex flex-col items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-16 w-16 text-slate-300 dark:text-navy-300" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p class="mt-2 text-slate-500 dark:text-navy-200">{{ __('No KYB applications found') }}
                                </p>
                                @if($search || $status)
                                <button wire:click="$set('search', ''); $set('status', '');"
                                    class="btn mt-4 bg-slate-150 font-medium text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">
                                    {{ __('Clear Filters') }}
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 sm:p-5">
            {{ $kybs->links() }}
        </div>
    </div>
</div> --}}
<div>
    <!-- KYB Status Cards -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-5 lg:grid-cols-4 lg:gap-6 mb-5">
        <div class="card p-4 sm:p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-lg font-semibold text-slate-700 dark:text-navy-100">
                        {{ $statusCounts['pending'] }}
                    </p>
                    <p class="text-xs+ text-slate-400 dark:text-navy-300">
                        {{ __('Pending') }}
                    </p>
                </div>
                <div class="mask is-squircle bg-warning/10 p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-warning" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <a href="#" wire:click.prevent="$set('status', 'pending')"
                    class="border-b border-dashed border-current pb-0.5 font-medium text-warning outline-none transition-colors duration-300 hover:text-warning/70 focus:text-warning/70">
                    {{ __('View Applications') }}
                </a>
            </div>
        </div>

        <div class="card p-4 sm:p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-lg font-semibold text-slate-700 dark:text-navy-100">
                        {{ $statusCounts['approved'] }}
                    </p>
                    <p class="text-xs+ text-slate-400 dark:text-navy-300">
                        {{ __('Approved') }}
                    </p>
                </div>
                <div class="mask is-squircle bg-success/10 p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-success" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <a href="#" wire:click.prevent="$set('status', 'approved')"
                    class="border-b border-dashed border-current pb-0.5 font-medium text-success outline-none transition-colors duration-300 hover:text-success/70 focus:text-success/70">
                    {{ __('View Applications') }}
                </a>
            </div>
        </div>

        <div class="card p-4 sm:p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-lg font-semibold text-slate-700 dark:text-navy-100">
                        {{ $statusCounts['rejected'] }}
                    </p>
                    <p class="text-xs+ text-slate-400 dark:text-navy-300">
                        {{ __('Rejected') }}
                    </p>
                </div>
                <div class="mask is-squircle bg-error/10 p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-error" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <a href="#" wire:click.prevent="$set('status', 'rejected')"
                    class="border-b border-dashed border-current pb-0.5 font-medium text-error outline-none transition-colors duration-300 hover:text-error/70 focus:text-error/70">
                    {{ __('View Applications') }}
                </a>
            </div>
        </div>

        <div class="card p-4 sm:p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-lg font-semibold text-slate-700 dark:text-navy-100">
                        {{ $statusCounts['additional_info'] }}
                    </p>
                    <p class="text-xs+ text-slate-400 dark:text-navy-300">
                        {{ __('Additional Info') }}
                    </p>
                </div>
                <div class="mask is-squircle bg-info/10 p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-info" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <a href="#" wire:click.prevent="$set('status', 'additional_info')"
                    class="border-b border-dashed border-current pb-0.5 font-medium text-info outline-none transition-colors duration-300 hover:text-info/70 focus:text-info/70">
                    {{ __('View Applications') }}
                </a>
            </div>
        </div>
    </div>

    <!-- Add Bulk Actions Component -->
    @if($status === 'pending')
    @livewire('admin.kyb.bulk-actions')
    @endif

    <!-- Search and Filters -->
    <div class="card p-4 sm:p-5 mb-5">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between">
            <div class="mb-4 sm:mb-0">
                <div class="relative w-full sm:w-72">
                    <input wire:model.debounce.300ms="search"
                        class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                        placeholder="Search by business name, email..." type="text" />
                    <span
                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5 transition-colors duration-200"
                            fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M3.316 13.781l.73-.171-.73.171zm0-5.457l.73.171-.73-.171zm15.473 0l.73-.171-.73.171zm0 5.457l.73.171-.73-.171zm-5.008 5.008l-.171-.73.171.73zm-5.457 0l-.171.73.171-.73zm0-15.473l-.171-.73.171.73zm5.457 0l.171-.73-.171.73zM20.47 21.53a.75.75 0 101.06-1.06l-1.06 1.06zM4.046 13.61a11.198 11.198 0 010-5.115l-1.46-.342a12.698 12.698 0 000 5.8l1.46-.343zm14.013-5.115a11.196 11.196 0 010 5.115l1.46.342a12.698 12.698 0 000-5.8l-1.46.343zm-4.45 9.564a11.196 11.196 0 01-5.114 0l-.342 1.46c1.907.448 3.892.448 5.8 0l-.343-1.46zM8.496 4.046a11.198 11.198 0 015.115 0l.342-1.46a12.698 12.698 0 00-5.8 0l.343 1.46zm0 14.013a5.97 5.97 0 01-4.45-4.45l-1.46.343a7.47 7.47 0 005.568 5.568l.342-1.46zm5.457 1.46a7.47 7.47 0 005.568-5.567l-1.46-.342a5.97 5.97 0 01-4.45 4.45l.342 1.46zM13.61 4.046a5.97 5.97 0 014.45 4.45l1.46-.343a7.47 7.47 0 00-5.568-5.567l-.342 1.46zm-5.457-1.46a7.47 7.47 0 00-5.567 5.567l1.46.342a5.97 5.97 0 014.45-4.45l-.343-1.46zm8.652 15.28l3.665 3.664 1.06-1.06-3.665-3.665-1.06 1.06z" />
                        </svg>
                    </span>
                </div>
            </div>
            <div class="flex flex-wrap items-center space-x-2 space-y-2 sm:space-y-0">
                <div>
                    <select wire:model="status"
                        class="form-select w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">
                        <option value="">{{ __('All Statuses') }}</option>
                        <option value="pending">{{ __('Pending') }}</option>
                        <option value="approved">{{ __('Approved') }}</option>
                        <option value="rejected">{{ __('Rejected') }}</option>
                        <option value="additional_info">{{ __('Additional Info') }}</option>
                    </select>
                </div>
                <div>
                    <select wire:model="perPage"
                        class="form-select w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">
                        <option>10</option>
                        <option>25</option>
                        <option>50</option>
                        <option>100</option>
                    </select>
                </div>
                <!-- Add Export Button -->
                <div>
                    @livewire('admin.kyb.export-kyb')
                </div>
            </div>
        </div>
    </div>

    <!-- KYB Applications Table -->
    <div class="card">
        <div class="is-scrollbar-hidden min-w-full overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                        @if($status === 'pending')
                        <th class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100">
                            <span class="sr-only">Select</span>
                        </th>
                        @endif
                        <th class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100">
                            <a href="#" wire:click.prevent="sortBy('legal_name')" class="flex items-center">
                                {{ __('Business Name') }}
                                @if ($sortField === 'legal_name')
                                @if ($sortDirection === 'asc')
                                <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-3 w-3" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 15l7-7 7 7" />
                                </svg>
                                @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-3 w-3" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                                @endif
                                @endif
                            </a>
                        </th>
                        <th class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100">
                            {{ __('Registration Number') }}
                        </th>
                        <th class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100">
                            {{ __('Business Type') }}
                        </th>
                        <th class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100">
                            <a href="#" wire:click.prevent="sortBy('status')" class="flex items-center">
                                {{ __('Status') }}
                                @if ($sortField === 'status')
                                @if ($sortDirection === 'asc')
                                <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-3 w-3" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 15l7-7 7 7" />
                                </svg>
                                @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-3 w-3" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                                @endif
                                @endif
                            </a>
                        </th>
                        <th class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100">
                            <a href="#" wire:click.prevent="sortBy('created_at')" class="flex items-center">
                                {{ __('Submitted') }}
                                @if ($sortField === 'created_at')
                                @if ($sortDirection === 'asc')
                                <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-3 w-3" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 15l7-7 7 7" />
                                </svg>
                                @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-3 w-3" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                                @endif
                                @endif
                            </a>
                        </th>
                        <th class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100">
                            <a href="#" wire:click.prevent="sortBy('updated_at')" class="flex items-center">
                                {{ __('Last Updated') }}
                                @if ($sortField === 'updated_at')
                                @if ($sortDirection === 'asc')
                                <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-3 w-3" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 15l7-7 7 7" />
                                </svg>
                                @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-3 w-3" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                                @endif
                                @endif
                            </a>
                        </th>
                        <th class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100">
                            {{ __('Actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kybs as $kyb)
                    <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                        @if($status === 'pending')
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                            @livewire('admin.kyb.bulk-selection', ['kybId' => $kyb->id], key('select-' . $kyb->id))
                        </td>
                        @endif
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                            <div class="flex items-center space-x-4">
                                <div class="avatar h-9 w-9">
                                    <div
                                        class="is-initial rounded-full bg-primary/10 text-primary dark:bg-accent/10 dark:text-accent">
                                        {{ substr($kyb->legal_name, 0, 1) }}
                                    </div>
                                </div>
                                <div>
                                    <p class="font-medium text-slate-700 dark:text-navy-100">
                                        {{ $kyb->legal_name }}
                                    </p>
                                    <p class="text-xs text-slate-400 dark:text-navy-300">
                                        {{ $kyb->user->email }}
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                            {{ $kyb->registration_number }}
                        </td>
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                            <div
                                class="badge rounded-full bg-slate-100 text-slate-600 dark:bg-navy-700 dark:text-navy-100">
                                {{ ucfirst(str_replace('_', ' ', $kyb->business_type)) }}
                            </div>
                        </td>
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                            @if($kyb->status === 'pending')
                            <div class="badge rounded-full bg-warning/10 text-warning dark:bg-warning/15">
                                {{ __('Pending') }}
                            </div>
                            @elseif($kyb->status === 'approved')
                            <div class="badge rounded-full bg-success/10 text-success dark:bg-success/15">
                                {{ __('Approved') }}
                            </div>
                            @elseif($kyb->status === 'rejected')
                            <div class="badge rounded-full bg-error/10 text-error dark:bg-error/15">
                                {{ __('Rejected') }}
                            </div>
                            @elseif($kyb->status === 'additional_info')
                            <div class="badge rounded-full bg-info/10 text-info dark:bg-info/15">
                                {{ __('Additional Info') }}
                            </div>
                            @endif
                        </td>
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                            {{ $kyb->created_at->format('M d, Y') }}
                        </td>
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                            {{ $kyb->updated_at->format('M d, Y') }}
                        </td>
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                            <a href="{{ route('admin.kyb.show', $kyb) }}"
                                class="btn h-8 w-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center sm:px-5">
                            <div class="flex flex-col items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-16 w-16 text-slate-300 dark:text-navy-300" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p class="mt-2 text-slate-500 dark:text-navy-200">{{ __('No KYB applications found') }}
                                </p>
                                @if($search || $status)
                                <button wire:click="$set('search', ''); $set('status', '');"
                                    class="btn mt-4 bg-slate-150 font-medium text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">
                                    {{ __('Clear Filters') }}
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 sm:p-5">
            {{ $kybs->links() }}
        </div>
    </div>
</div>
