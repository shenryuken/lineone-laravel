<x-app-layout-sideblock>
    {{-- <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Know Your Business (KYB) Dashboard') }}
        </h2>
    </x-slot> --}}
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @php
                    $kyb = \App\Models\Kyb::where('user_id', auth()->id())->latest()->first();
                    @endphp

                    @if (!$kyb)
                    <div class="mb-6 text-center">
                        <h3 class="text-lg font-medium">You haven't submitted your KYB application yet</h3>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                            Complete your KYB application to verify your business and access all features.
                        </p>
                        <div class="mt-4">
                            <a href="{{ route('merchant.kyb.apply') }}"
                                class="btn bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                                Start KYB Application
                            </a>
                        </div>
                    </div>
                    @else
                    <div class="mb-6">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-medium">KYB Application Status</h3>
                            <span class="badge rounded-full
                                    @if($kyb->status == 'approved') bg-success/10 text-success
                                    @elseif($kyb->status == 'rejected') bg-error/10 text-error
                                    @elseif($kyb->status == 'kiv') bg-warning/10 text-warning
                                    @else bg-info/10 text-info @endif">
                                {{ ucfirst($kyb->status) }}
                            </span>
                        </div>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                            Application submitted on {{ $kyb->created_at->format('M d, Y') }}
                        </p>
                    </div>

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div class="card p-4">
                            <h4 class="text-base font-medium mb-3">Business Information</h4>
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Legal Name:</span>
                                    <span class="font-medium">{{ $kyb->legal_name }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Registration Number:</span>
                                    <span class="font-medium">{{ $kyb->registration_number }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Business Type:</span>
                                    <span class="font-medium">{{ ucfirst(str_replace('_', ' ', $kyb->business_type))
                                        }}</span>
                                </div>
                            </div>
                            <div class="mt-4">
                                <a href="{{ route('merchant.kyb.view', $kyb) }}"
                                    class="btn bg-slate-150 font-medium text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">
                                    View Full Application
                                </a>
                            </div>
                        </div>

                        <div class="card p-4">
                            <h4 class="text-base font-medium mb-3">Actions</h4>
                            @if($kyb->status == 'pending' || $kyb->status == 'kiv')
                            <div class="space-y-3">
                                <a href="{{ route('merchant.kyb.update') }}"
                                    class="btn w-full bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                                    Update Application
                                </a>

                                @if($kyb->additional_info_requested)
                                <a href="{{ route('kyb.upload-additional') }}"
                                    class="btn w-full border border-primary font-medium text-primary hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:border-accent dark:text-accent dark:hover:bg-accent/20 dark:focus:bg-accent/20 dark:active:bg-accent/25">
                                    Upload Additional Documents
                                </a>
                                @endif
                            </div>
                            @elseif($kyb->status == 'rejected')
                            <div class="p-3 bg-error/10 text-error rounded-lg">
                                <p class="text-sm">Your application was rejected. Please review the feedback and
                                    reapply.</p>
                                @if($kyb->rejection_reason)
                                <p class="mt-2 text-sm font-medium">Reason: {{ $kyb->rejection_reason }}</p>
                                @endif
                            </div>
                            <div class="mt-3">
                                <a href="{{ route('kyb.apply') }}"
                                    class="btn w-full bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                                    Submit New Application
                                </a>
                            </div>
                            @elseif($kyb->status == 'approved')
                            <div class="p-3 bg-success/10 text-success rounded-lg">
                                <p class="text-sm">Your KYB application has been approved. Your business is now
                                    verified.</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    </main>
</x-app-layout-sideblock>
