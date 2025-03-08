<div>
    <div class="flex flex-col sm:flex-row items-center justify-between mb-6">
        <h2 class="text-xl font-bold text-slate-800 dark:text-navy-100">
            KYC Applications
        </h2>
        <div class="flex items-center space-x-2 mt-4 sm:mt-0">
            <select wire:model.live="perPage"
                class="form-select h-9 rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">
                <option value="10">10 per page</option>
                <option value="25">25 per page</option>
                <option value="50">50 per page</option>
                <option value="100">100 per page</option>
            </select>
        </div>
    </div>

    <div class="card p-4 sm:p-5">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-5 gap-4">
            <div class="flex flex-col sm:flex-row gap-4 w-full sm:w-auto">
                <div class="w-full sm:w-64">
                    <label class="block text-sm font-medium text-slate-700 dark:text-navy-100 mb-1">Search</label>
                    <input type="text" wire:model.live.debounce.300ms="search"
                        placeholder="Search by name, email, ID..."
                        class="form-input w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">
                </div>
                <div class="w-full sm:w-40">
                    <label class="block text-sm font-medium text-slate-700 dark:text-navy-100 mb-1">Status</label>
                    <select wire:model.live="status"
                        class="form-select w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">
                        <option value="">All Statuses</option>
                        @foreach($statusOptions as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="w-full sm:w-40">
                    <label class="block text-sm font-medium text-slate-700 dark:text-navy-100 mb-1">Verification</label>
                    <select wire:model.live="verificationStatus"
                        class="form-select w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">
                        <option value="">All Verifications</option>
                        @foreach($verificationStatusOptions as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-slate-200 dark:border-navy-500">
                        <th class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100 lg:px-5">
                            <div class="flex items-center cursor-pointer" wire:click="sortBy('id')">
                                ID
                                @if($sortField === 'id')
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    @if($sortDirection === 'asc')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 15l7-7 7 7" />
                                    @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                    @endif
                                </svg>
                                @endif
                            </div>
                        </th>
                        <th class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100 lg:px-5">
                            <div class="flex items-center cursor-pointer" wire:click="sortBy('full_name')">
                                Applicant
                                @if($sortField === 'full_name')
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    @if($sortDirection === 'asc')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 15l7-7 7 7" />
                                    @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                    @endif
                                </svg>
                                @endif
                            </div>
                        </th>
                        <th class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100 lg:px-5">
                            <div class="flex items-center cursor-pointer" wire:click="sortBy('id_type')">
                                ID Type
                                @if($sortField === 'id_type')
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    @if($sortDirection === 'asc')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 15l7-7 7 7" />
                                    @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                    @endif
                                </svg>
                                @endif
                            </div>
                        </th>
                        <th class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100 lg:px-5">
                            <div class="flex items-center cursor-pointer" wire:click="sortBy('status')">
                                Status
                                @if($sortField === 'status')
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    @if($sortDirection === 'asc')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 15l7-7 7 7" />
                                    @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                    @endif
                                </svg>
                                @endif
                            </div>
                        </th>
                        <th class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100 lg:px-5">
                            <div class="flex items-center cursor-pointer" wire:click="sortBy('verification_status')">
                                Verification
                                @if($sortField === 'verification_status')
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    @if($sortDirection === 'asc')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 15l7-7 7 7" />
                                    @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                    @endif
                                </svg>
                                @endif
                            </div>
                        </th>
                        <th class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100 lg:px-5">
                            <div class="flex items-center cursor-pointer" wire:click="sortBy('created_at')">
                                Submitted
                                @if($sortField === 'created_at')
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    @if($sortDirection === 'asc')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 15l7-7 7 7" />
                                    @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                    @endif
                                </svg>
                                @endif
                            </div>
                        </th>
                        <th class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100 lg:px-5">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kycs as $kyc)
                    <tr class="border-b border-slate-200 dark:border-navy-500 hover:bg-slate-50 dark:hover:bg-navy-600">
                        <td class="whitespace-nowrap px-3 py-3 font-medium text-slate-700 dark:text-navy-100 lg:px-5">
                            {{ $kyc->id }}
                        </td>
                        <td class="whitespace-nowrap px-3 py-3 font-medium text-slate-700 dark:text-navy-100 lg:px-5">
                            <div class="flex items-center space-x-3">
                                <div class="avatar h-8 w-8">
                                    <div
                                        class="is-initial rounded-full bg-primary/10 text-primary dark:bg-accent-light/10 dark:text-accent-light">
                                        {{ substr($kyc->user->name, 0, 1) }}
                                    </div>
                                </div>
                                <div>
                                    <p class="font-medium text-slate-700 dark:text-navy-100">{{ $kyc->full_name }}</p>
                                    <p class="text-xs text-slate-400 dark:text-navy-300">{{ $kyc->user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="whitespace-nowrap px-3 py-3 font-medium text-slate-700 dark:text-navy-100 lg:px-5">
                            {{ ucfirst(str_replace('_', ' ', $kyc->id_type)) }}
                        </td>
                        <td class="whitespace-nowrap px-3 py-3 lg:px-5">
                            <div class="badge rounded-full px-2 py-1
                                    @if($kyc->status === 'approved') bg-success/10 text-success
                                    @elseif($kyc->status === 'rejected') bg-error/10 text-error
                                    @elseif($kyc->status === 'kiv') bg-info/10 text-info
                                    @else bg-warning/10 text-warning @endif">
                                {{ ucfirst($kyc->status) }}
                            </div>
                        </td>
                        <td class="whitespace-nowrap px-3 py-3 lg:px-5">
                            <div class="badge rounded-full px-2 py-1
                                    @if($kyc->verification_status === 'pass') bg-success/10 text-success
                                    @elseif($kyc->verification_status === 'fail') bg-error/10 text-error
                                    @else bg-warning/10 text-warning @endif">
                                {{ ucfirst($kyc->verification_status) }}
                            </div>
                        </td>
                        <td class="whitespace-nowrap px-3 py-3 font-medium text-slate-700 dark:text-navy-100 lg:px-5">
                            {{ $kyc->created_at->format('M d, Y') }}
                            <div class="text-xs text-slate-400 dark:text-navy-300">{{ $kyc->created_at->format('h:i A')
                                }}</div>
                        </td>
                        <td class="whitespace-nowrap px-3 py-3 lg:px-5">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.kyc.show', $kyc) }}"
                                    class="btn h-8 w-8 rounded-full p-0 text-info hover:bg-info/20 focus:bg-info/20 active:bg-info/25">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-3 py-8 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-16 w-16 text-slate-300 dark:text-navy-300" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p class="mt-2 text-slate-500 dark:text-navy-300">No KYC applications found</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $kycs->links() }}
        </div>
    </div>
</div>
