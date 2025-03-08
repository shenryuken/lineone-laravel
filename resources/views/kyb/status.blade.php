<x-app-layout-sideblock>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('KYB Application Status') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @php
                    $kyb = \App\Models\Kyb::where('user_id', auth()->id())->latest()->first();
                    @endphp

                    <div class="mb-6">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-medium">Application Status</h3>
                            <span class="badge rounded-full
                                @if($kyb->status == 'approved') bg-success/10 text-success
                                @elseif($kyb->status == 'rejected') bg-error/10 text-error
                                @elseif($kyb->status == 'kiv') bg-warning/10 text-warning
                                @else bg-info/10 text-info @endif">
                                {{ ucfirst($kyb->status) }}
                            </span>
                        </div>
                    </div>

                    <div class="card p-4 mb-6">
                        <h4 class="text-base font-medium mb-3">Application Timeline</h4>
                        <div class="flex flex-col space-y-4">
                            <div class="flex items-start">
                                <div
                                    class="mr-4 flex h-10 w-10 items-center justify-center rounded-full bg-primary text-white dark:bg-accent">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium">Application Submitted</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $kyb->created_at->format('M
                                        d, Y - h:i A') }}</p>
                                </div>
                            </div>

                            @if($kyb->additional_info_requested_at)
                            <div class="flex items-start">
                                <div
                                    class="mr-4 flex h-10 w-10 items-center justify-center rounded-full bg-warning text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium">Additional Information Requested</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{
                                        \Carbon\Carbon::parse($kyb->additional_info_requested_at)->format('M d, Y - h:i
                                        A') }}</p>
                                    <p class="mt-1 text-sm">{{ $kyb->additional_info_requested }}</p>
                                </div>
                            </div>
                            @endif

                            @if($kyb->additional_info_responded_at)
                            <div class="flex items-start">
                                <div
                                    class="mr-4 flex h-10 w-10 items-center justify-center rounded-full bg-info text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium">Additional Information Provided</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{
                                        \Carbon\Carbon::parse($kyb->additional_info_responded_at)->format('M d, Y - h:i
                                        A') }}</p>
                                </div>
                            </div>
                            @endif

                            @if($kyb->verified_at)
                            <div class="flex items-start">
                                <div
                                    class="mr-4 flex h-10 w-10 items-center justify-center rounded-full bg-info text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium">Application Verified</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{
                                        \Carbon\Carbon::parse($kyb->verified_at)->format('M d, Y - h:i A') }}</p>
                                    <p class="mt-1 text-sm">Verification Status: <span class="font-medium">{{
                                            ucfirst($kyb->verification_status) }}</span></p>
                                    @if($kyb->verification_notes)
                                    <p class="mt-1 text-sm">Notes: {{ $kyb->verification_notes }}</p>
                                    @endif
                                </div>
                            </div>
                            @endif

                            @if($kyb->approved_at)
                            <div class="flex items-start">
                                <div
                                    class="mr-4 flex h-10 w-10 items-center justify-center rounded-full bg-success text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium">Application Approved</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{
                                        \Carbon\Carbon::parse($kyb->approved_at)->format('M d, Y - h:i A') }}</p>
                                </div>
                            </div>
                            @endif

                            @if($kyb->rejected_at)
                            <div class="flex items-start">
                                <div
                                    class="mr-4 flex h-10 w-10 items-center justify-center rounded-full bg-error text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium">Application Rejected</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{
                                        \Carbon\Carbon::parse($kyb->rejected_at)->format('M d, Y - h:i A') }}</p>
                                    @if($kyb->rejection_reason)
                                    <p class="mt-1 text-sm">Reason: {{ $kyb->rejection_reason }}</p>
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="flex justify-between">
                        <a href="{{ route('kyb.dashboard') }}"
                            class="btn border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                            Back to Dashboard
                        </a>

                        @if($kyb->status == 'pending' || $kyb->status == 'kiv')
                        <div class="flex space-x-2">
                            <a href="{{ route('kyb.update') }}"
                                class="btn bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                                Update Application
                            </a>

                            @if($kyb->additional_info_requested)
                            <a href="{{ route('kyb.upload-additional') }}"
                                class="btn border border-primary font-medium text-primary hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:border-accent dark:text-accent dark:hover:bg-accent/20 dark:focus:bg-accent/20 dark:active:bg-accent/25">
                                Upload Additional Documents
                            </a>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout-sideblock>
