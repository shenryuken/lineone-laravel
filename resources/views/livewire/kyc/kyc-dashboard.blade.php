<div>
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <!-- KYC Status Card -->
        <div class="card p-4 sm:p-5">
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-base font-medium tracking-wide text-slate-700 dark:text-navy-100">
                    KYC Verification Status
                </h2>
                @if($showReapplyButton)
                <a href="{{ route('kyc.apply') }}"
                    class="btn bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                    {{ $kyc ? 'Reapply' : 'Apply Now' }}
                </a>
                @endif
            </div>

            @if($kyc)
            <div class="flex items-center space-x-4 rounded-lg border border-slate-200 p-4 dark:border-navy-500">
                <div class="flex h-12 w-12 items-center justify-center rounded-lg
                        @if($kyc->status === 'approved') bg-success/10 text-success
                        @elseif($kyc->status === 'rejected') bg-error/10 text-error
                        @elseif($kyc->status === 'kiv') bg-info/10 text-info
                        @else bg-warning/10 text-warning @endif">
                    @if($kyc->status === 'approved')
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    @elseif($kyc->status === 'rejected')
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    @elseif($kyc->status === 'kiv')
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    @else
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    @endif
                </div>
                <div class="flex-1">
                    <p class="text-sm+ font-medium text-slate-700 dark:text-navy-100">
                        {{ ucfirst($kyc->status) }}
                    </p>
                    <p class="text-xs+ text-slate-400 dark:text-navy-300">
                        @if($kyc->status === 'approved')
                        Approved on {{ $kyc->approved_at->format('M d, Y') }}
                        @elseif($kyc->status === 'rejected')
                        Rejected on {{ $kyc->rejected_at->format('M d, Y') }}
                        @elseif($kyc->status === 'kiv')
                        Under review - Keep in View
                        @else
                        Submitted on {{ $kyc->created_at->format('M d, Y') }}
                        @endif
                    </p>
                </div>
                <a href="{{ route('kyc.status') }}"
                    class="btn h-8 rounded bg-slate-150 px-3 text-xs+ font-medium text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">
                    View Details
                </a>
            </div>

            @if($kyc->status === 'rejected' && $kyc->rejection_reason)
            <div class="mt-4 rounded-lg border border-error/30 bg-error/10 p-4 text-error">
                <h3 class="text-sm font-medium">Rejection Reason:</h3>
                <p class="mt-1 text-xs+">{{ $kyc->rejection_reason }}</p>
            </div>
            @elseif($kyc->status === 'kiv' && $kyc->verification_notes)
            <div class="mt-4 rounded-lg border border-info/30 bg-info/10 p-4 text-info">
                <h3 class="text-sm font-medium">Additional Information Required:</h3>
                <p class="mt-1 text-xs+">{{ $kyc->verification_notes }}</p>
            </div>
            @elseif($kyc->status === 'pending')
            <div class="mt-4 rounded-lg border border-warning/30 bg-warning/10 p-4 text-warning">
                <h3 class="text-sm font-medium">Verification in Progress</h3>
                <p class="mt-1 text-xs+">Your KYC application is currently being reviewed. This process typically takes
                    1-3 business days.</p>
            </div>
            @endif
            @else
            <div class="flex flex-col items-center justify-center p-8 text-center">
                <div
                    class="flex h-16 w-16 items-center justify-center rounded-full bg-primary/10 text-primary dark:bg-accent-light/10 dark:text-accent-light">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                    </svg>
                </div>
                <h3 class="mt-4 text-lg font-medium text-slate-700 dark:text-navy-100">
                    KYC Verification Required
                </h3>
                <p class="mt-2 text-sm+ text-slate-400 dark:text-navy-300">
                    Complete your KYC verification to unlock all features of your wallet.
                </p>
            </div>
            @endif
        </div>

        <!-- KYC Benefits Card -->
        <div class="card p-4 sm:p-5">
            <h2 class="text-base font-medium tracking-wide text-slate-700 dark:text-navy-100 mb-3">
                Benefits of KYC Verification
            </h2>
            <div class="space-y-4">
                <div class="flex items-start space-x-3">
                    <div
                        class="flex h-8 w-8 items-center justify-center rounded-lg bg-primary/10 text-primary dark:bg-accent-light/10 dark:text-accent-light">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm+ font-medium text-slate-700 dark:text-navy-100">
                            Higher Transaction Limits
                        </p>
                        <p class="text-xs+ text-slate-400 dark:text-navy-300">
                            Increase your daily and monthly transaction limits.
                        </p>
                    </div>
                </div>
                <div class="flex items-start space-x-3">
                    <div
                        class="flex h-8 w-8 items-center justify-center rounded-lg bg-primary/10 text-primary dark:bg-accent-light/10 dark:text-accent-light">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm+ font-medium text-slate-700 dark:text-navy-100">
                            Access to More Services
                        </p>
                        <p class="text-xs+ text-slate-400 dark:text-navy-300">
                            Unlock additional financial services and features.
                        </p>
                    </div>
                </div>
                <div class="flex items-start space-x-3">
                    <div
                        class="flex h-8 w-8 items-center justify-center rounded-lg bg-primary/10 text-primary dark:bg-accent-light/10 dark:text-accent-light">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm+ font-medium text-slate-700 dark:text-navy-100">
                            Enhanced Security
                        </p>
                        <p class="text-xs+ text-slate-400 dark:text-navy-300">
                            Protect your account with verified identity.
                        </p>
                    </div>
                </div>
                <div class="flex items-start space-x-3">
                    <div
                        class="flex h-8 w-8 items-center justify-center rounded-lg bg-primary/10 text-primary dark:bg-accent-light/10 dark:text-accent-light">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm+ font-medium text-slate-700 dark:text-navy-100">
                            Lower Fees
                        </p>
                        <p class="text-xs+ text-slate-400 dark:text-navy-300">
                            Enjoy reduced transaction fees on verified accounts.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- KYC History -->
    @if(count($kycHistory) > 1)
    <div class="card p-4 sm:p-5 mt-6">
        <h2 class="text-base font-medium tracking-wide text-slate-700 dark:text-navy-100 mb-3">
            KYC Application History
        </h2>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-slate-200 dark:border-navy-500">
                        <th class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100">
                            Submission Date
                        </th>
                        <th class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100">
                            Status
                        </th>
                        <th class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100">
                            ID Type
                        </th>
                        <th class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100">
                            Result Date
                        </th>
                        <th class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kycHistory as $application)
                    <tr class="border-b border-slate-200 dark:border-navy-500">
                        <td class="whitespace-nowrap px-3 py-3">
                            {{ $application->created_at->format('M d, Y') }}
                        </td>
                        <td class="whitespace-nowrap px-3 py-3">
                            <div class="badge rounded-full
                                        @if($application->status === 'approved') bg-success/10 text-success
                                        @elseif($application->status === 'rejected') bg-error/10 text-error
                                        @elseif($application->status === 'kiv') bg-info/10 text-info
                                        @else bg-warning/10 text-warning @endif">
                                {{ ucfirst($application->status) }}
                            </div>
                        </td>
                        <td class="whitespace-nowrap px-3 py-3">
                            {{ ucfirst(str_replace('_', ' ', $application->id_type)) }}
                        </td>
                        <td class="whitespace-nowrap px-3 py-3">
                            @if($application->status === 'approved')
                            {{ $application->approved_at ? $application->approved_at->format('M d, Y') : 'N/A' }}
                            @elseif($application->status === 'rejected')
                            {{ $application->rejected_at ? $application->rejected_at->format('M d, Y') : 'N/A' }}
                            @else
                            N/A
                            @endif
                        </td>
                        <td class="whitespace-nowrap px-3 py-3">
                            <a href="{{ route('kyc.view-application', $application->id) }}"
                                class="btn h-8 w-8 rounded-full p-0 text-info hover:bg-info/20 focus:bg-info/20 active:bg-info/25">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
