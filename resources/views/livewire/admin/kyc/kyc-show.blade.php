
<div>
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6">
        <div>
            <h2 class="text-xl font-bold text-slate-800 dark:text-navy-100">
                KYC Application #{{ $kyc->id }}
            </h2>
            <p class="text-sm text-slate-500 dark:text-navy-300 mt-1">
                Submitted on {{ $kyc->created_at->format('M d, Y \a\t h:i A') }}
            </p>
        </div>
        <div class="flex items-center space-x-2 mt-4 sm:mt-0">
            <a href="{{ route('admin.kyc.index') }}"
                class="btn space-x-2 bg-slate-150 font-medium text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                <span>Back to List</span>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
        <!-- KYC Status Card -->
        <div class="col-span-12 lg:col-span-4">
            <div class="card p-4 sm:p-5">
                <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100 mb-4">
                    Application Status
                </h3>

                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-slate-700 dark:text-navy-100">Status</span>
                        <div class="badge rounded-full px-2 py-1
                            @if($kyc->status === 'approved') bg-success/10 text-success
                            @elseif($kyc->status === 'rejected') bg-error/10 text-error
                            @elseif($kyc->status === 'kiv') bg-info/10 text-info
                            @else bg-warning/10 text-warning @endif">
                            {{ ucfirst($kyc->status) }}
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-slate-700 dark:text-navy-100">Verification</span>
                        <div class="badge rounded-full px-2 py-1
                            @if($kyc->verification_status === 'pass') bg-success/10 text-success
                            @elseif($kyc->verification_status === 'fail') bg-error/10 text-error
                            @else bg-warning/10 text-warning @endif">
                            {{ ucfirst($kyc->verification_status) }}
                        </div>
                    </div>

                    @if($kyc->verified_at)
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-slate-700 dark:text-navy-100">Verified By</span>
                        <span class="text-sm text-slate-600 dark:text-navy-200">
                            {{ $kyc->verifier ? $kyc->verifier->name : 'N/A' }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-slate-700 dark:text-navy-100">Verified At</span>
                        <span class="text-sm text-slate-600 dark:text-navy-200">
                            {{ $kyc->verified_at->format('M d, Y h:i A') }}
                        </span>
                    </div>
                    @endif

                    @if($kyc->approved_at)
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-slate-700 dark:text-navy-100">Approved By</span>
                        <span class="text-sm text-slate-600 dark:text-navy-200">
                            {{ $kyc->approver ? $kyc->approver->name : 'N/A' }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-slate-700 dark:text-navy-100">Approved At</span>
                        <span class="text-sm text-slate-600 dark:text-navy-200">
                            {{ $kyc->approved_at->format('M d, Y h:i A') }}
                        </span>
                    </div>
                    @endif

                    @if($kyc->rejected_at)
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-slate-700 dark:text-navy-100">Rejected By</span>
                        <span class="text-sm text-slate-600 dark:text-navy-200">
                            {{ $kyc->rejector ? $kyc->rejector->name : 'N/A' }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-slate-700 dark:text-navy-100">Rejected At</span>
                        <span class="text-sm text-slate-600 dark:text-navy-200">
                            {{ $kyc->rejected_at->format('M d, Y h:i A') }}
                        </span>
                    </div>
                    @endif

                    @if($kyc->verification_notes)
                    <div class="mt-4 p-3 rounded-lg bg-slate-100 dark:bg-navy-600">
                        <h4 class="text-sm font-medium text-slate-700 dark:text-navy-100 mb-1">Verification Notes</h4>
                        <p class="text-sm text-slate-600 dark:text-navy-200">{{ $kyc->verification_notes }}</p>
                    </div>
                    @endif

                    @if($kyc->rejection_reason)
                    <div class="mt-4 p-3 rounded-lg bg-error/10">
                        <h4 class="text-sm font-medium text-error mb-1">Rejection Reason</h4>
                        <p class="text-sm text-error/80">{{ $kyc->rejection_reason }}</p>
                    </div>
                    @endif

                    @if($kyc->additional_info_requested)
                    <div class="mt-4 p-3 rounded-lg bg-amber-50 dark:bg-amber-900/20">
                        <h4 class="text-sm font-medium text-amber-600 dark:text-amber-400 mb-1">Additional Information
                            Requested</h4>
                        <p class="text-sm text-amber-600/80 dark:text-amber-400/80">{{ $kyc->additional_info_requested
                            }}</p>
                        <p class="text-xs text-amber-500/70 dark:text-amber-400/60 mt-1">
                            Requested on {{ $kyc->additional_info_requested_at ?
                            $kyc->additional_info_requested_at->format('M d, Y') : 'N/A' }}
                        </p>
                    </div>

                    @if($kyc->additional_info_response)
                    <div class="mt-4 p-3 rounded-lg bg-slate-100 dark:bg-navy-600">
                        <h4 class="text-sm font-medium text-slate-700 dark:text-navy-100 mb-1">User Response</h4>
                        <p class="text-sm text-slate-600 dark:text-navy-200">{{ $kyc->additional_info_response }}</p>
                        <p class="text-xs text-slate-500 dark:text-navy-300 mt-1">
                            Responded on {{ $kyc->additional_info_responded_at ?
                            $kyc->additional_info_responded_at->format('M d, Y') : 'N/A' }}
                        </p>
                    </div>
                    @endif
                    @endif
                </div>

                <!-- Action Buttons -->
                <div class="mt-6 space-y-3">
                    @can('verify', $kyc)
                    <button wire:click="openVerificationModal"
                        class="btn w-full bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                        Update Verification Status
                    </button>
                    @endcan

                    @can('approve', $kyc)
                    <button wire:click="openApprovalModal"
                        class="btn w-full bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
                        Approve Application
                    </button>
                    @endcan

                    @can('reject', $kyc)
                    <button wire:click="openRejectionModal"
                        class="btn w-full bg-error font-medium text-white hover:bg-error-focus focus:bg-error-focus active:bg-error-focus/90">
                        Reject Application
                    </button>
                    @endcan

                    @can('kiv', $kyc)
                    <button wire:click="openKivModal"
                        class="btn w-full bg-info font-medium text-white hover:bg-info-focus focus:bg-info-focus active:bg-info-focus/90">
                        Mark as KIV
                    </button>

                    <button wire:click="openRequestInfoModal"
                        class="btn w-full border border-primary/30 bg-primary/10 font-medium text-primary hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:border-accent-light/30 dark:bg-accent-light/10 dark:text-accent-light dark:hover:bg-accent-light/20 dark:focus:bg-accent-light/20 dark:active:bg-accent-light/25">
                        Request Additional Information
                    </button>
                    @endcan
                </div>
            </div>
        </div>

        <!-- KYC Details Card -->
        <div class="col-span-12 lg:col-span-8">
            <div class="card p-4 sm:p-5">
                <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100 mb-4">
                    Applicant Details
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Personal Information -->
                    <div class="space-y-4">
                        <h4 class="text-base font-medium text-slate-700 dark:text-navy-100">Personal Information</h4>

                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-sm text-slate-500 dark:text-navy-300">Full Name</span>
                                <span class="text-sm font-medium text-slate-700 dark:text-navy-100">{{ $kyc->full_name
                                    }}</span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-sm text-slate-500 dark:text-navy-300">Date of Birth</span>
                                <span class="text-sm font-medium text-slate-700 dark:text-navy-100">{{
                                    $kyc->date_of_birth->format('M d, Y') }}</span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-sm text-slate-500 dark:text-navy-300">Email</span>
                                <span class="text-sm font-medium text-slate-700 dark:text-navy-100">{{ $kyc->user->email
                                    }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- ID Information -->
                    <div class="space-y-4">
                        <h4 class="text-base font-medium text-slate-700 dark:text-navy-100">ID Information</h4>

                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-sm text-slate-500 dark:text-navy-300">ID Type</span>
                                <span class="text-sm font-medium text-slate-700 dark:text-navy-100">{{
                                    ucfirst(str_replace('_', ' ', $kyc->id_type)) }}</span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-sm text-slate-500 dark:text-navy-300">ID Number</span>
                                <span class="text-sm font-medium text-slate-700 dark:text-navy-100">{{ $kyc->id_number
                                    }}</span>
                            </div>

                            <!-- Find the Expiration Date display in the ID Information section and replace it with this -->
                            <div class="flex justify-between">
                                <span class="text-sm text-slate-500 dark:text-navy-300">Expiration Date</span>
                                <span class="text-sm font-medium text-slate-700 dark:text-navy-100">
                                    @if($kyc->has_expiration)
                                    {{ $kyc->id_expiration_date->format('M d, Y') }}
                                    @else
                                    <span class="text-xs italic">No Expiration</span>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Address Information -->
                    <div class="space-y-4 md:col-span-2">
                        <h4 class="text-base font-medium text-slate-700 dark:text-navy-100">Address</h4>

                        <div class="p-3 rounded-lg bg-slate-50 dark:bg-navy-600">
                            <p class="text-sm text-slate-700 dark:text-navy-100">{{ $kyc->address }}</p>
                        </div>
                    </div>
                </div>

                <!-- Document Images -->
                <div class="mt-8">
                    <h4 class="text-base font-medium text-slate-700 dark:text-navy-100 mb-4">Verification Documents</h4>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- ID Front -->
                        <div class="space-y-2">
                            <p class="text-sm font-medium text-slate-700 dark:text-navy-100">ID Front</p>
                            <div
                                class="relative aspect-[4/3] overflow-hidden rounded-lg border border-slate-200 dark:border-navy-500">
                                <img src="{{ asset('storage/' . $kyc->id_front_image) }}" alt="ID Front"
                                    class="h-full w-full object-cover"
                                    onclick="openImageModal('{{ asset('storage/' . $kyc->id_front_image) }}')">
                                <div
                                    class="absolute inset-0 bg-slate-900/30 opacity-0 hover:opacity-100 transition-opacity flex items-center justify-center">
                                    <button type="button"
                                        onclick="openImageModal('{{ asset('storage/' . $kyc->id_front_image) }}')"
                                        class="btn h-9 w-9 rounded-full bg-white/20 p-0 text-white hover:bg-white/30 focus:bg-white/30">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- ID Back -->
                        <div class="space-y-2">
                            <p class="text-sm font-medium text-slate-700 dark:text-navy-100">ID Back</p>
                            <div
                                class="relative aspect-[4/3] overflow-hidden rounded-lg border border-slate-200 dark:border-navy-500">
                                <img src="{{ asset('storage/' . $kyc->id_back_image) }}" alt="ID Back"
                                    class="h-full w-full object-cover"
                                    onclick="openImageModal('{{ asset('storage/' . $kyc->id_back_image) }}')">
                                <div
                                    class="absolute inset-0 bg-slate-900/30 opacity-0 hover:opacity-100 transition-opacity flex items-center justify-center">
                                    <button type="button"
                                        onclick="openImageModal('{{ asset('storage/' . $kyc->id_back_image) }}')"
                                        class="btn h-9 w-9 rounded-full bg-white/20 p-0 text-white hover:bg-white/30 focus:bg-white/30">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Selfie -->
                        <div class="space-y-2">
                            <p class="text-sm font-medium text-slate-700 dark:text-navy-100">Selfie with ID</p>
                            <div
                                class="relative aspect-[4/3] overflow-hidden rounded-lg border border-slate-200 dark:border-navy-500">
                                <img src="{{ asset('storage/' . $kyc->selfie_image) }}" alt="Selfie with ID"
                                    class="h-full w-full object-cover"
                                    onclick="openImageModal('{{ asset('storage/' . $kyc->selfie_image) }}')">
                                <div
                                    class="absolute inset-0 bg-slate-900/30 opacity-0 hover:opacity-100 transition-opacity flex items-center justify-center">
                                    <button type="button"
                                        onclick="openImageModal('{{ asset('storage/' . $kyc->selfie_image) }}')"
                                        class="btn h-9 w-9 rounded-full bg-white/20 p-0 text-white hover:bg-white/30 focus:bg-white/30">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Documents -->
                @if(isset($kyc->additional_documents) && $kyc->additional_documents)
                @php
                $additionalDocs = json_decode($kyc->additional_documents, true);
                @endphp
                @if(count($additionalDocs) > 0)
                <div class="mt-8">
                    <h4 class="text-base font-medium text-slate-700 dark:text-navy-100 mb-4">Additional Documents</h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($additionalDocs as $doc)
                        <div class="flex items-center p-3 border border-slate-200 rounded-lg dark:border-navy-600">
                            <div class="flex-shrink-0">
                                @if(Str::endsWith($doc['path'], ['.pdf']))
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-error" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                @else
                                <img src="{{ asset('storage/' . $doc['path']) }}" alt="Document"
                                    class="h-10 w-10 object-cover rounded">
                                @endif
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-slate-700 dark:text-navy-100">
                                    {{ ucfirst(str_replace('_', ' ', $doc['type'])) }}
                                </p>
                                <p class="text-xs text-slate-500 dark:text-navy-300">
                                    {{ \Carbon\Carbon::parse($doc['uploaded_at'])->format('M d, Y') }}
                                </p>
                            </div>
                            <div class="ml-auto flex">
                                @if(!Str::endsWith($doc['path'], ['.pdf']))
                                <button type="button" onclick="openImageModal('{{ asset('storage/' . $doc['path']) }}')"
                                    class="p-1 text-slate-500 hover:text-primary dark:text-navy-300 dark:hover:text-accent-light">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                                @endif
                                <a href="{{ asset('storage/' . $doc['path']) }}" target="_blank"
                                    class="p-1 text-slate-500 hover:text-primary dark:text-navy-300 dark:hover:text-accent-light ml-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
                @endif
            </div>
        </div>
    </div>

    <!-- Verification Modal -->
    <div x-data="{ show: @entangle('showVerificationModal') }" x-show="show" x-cloak
        class="fixed inset-0 z-[100] flex items-center justify-center overflow-y-auto bg-slate-900/60 dark:bg-navy-900/60">
        <div x-show="show" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-90" class="w-full max-w-lg p-3 sm:p-5">
            <div class="card bg-white dark:bg-navy-700">
                <div class="flex justify-between p-4 sm:p-5">
                    <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100">
                        Update Verification Status
                    </h3>
                    <button @click="show = false"
                        class="btn -mr-1.5 h-7 w-7 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="p-4 sm:p-5">
                    <form wire:submit.prevent="updateVerificationStatus">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-navy-100">
                                    Verification Status
                                </label>
                                <select wire:model="verification_status"
                                    class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">
                                    <option value="pending">Pending</option>
                                    <option value="pass">Pass</option>
                                    <option value="fail">Fail</option>
                                </select>
                                @error('verification_status') <span class="text-error text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-navy-100">
                                    Verification Notes
                                </label>
                                <textarea wire:model="verification_notes"
                                    class="form-textarea mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                                    rows="3" placeholder="Enter verification notes"></textarea>
                                @error('verification_notes') <span class="text-error text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end space-x-2">
                            <button type="button" @click="show = false"
                                class="btn border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                                Cancel
                            </button>
                            <button type="submit"
                                class="btn bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                                Update Status
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Approval Modal -->
    <div x-data="{ show: @entangle('showApprovalModal') }" x-show="show" x-cloak
        class="fixed inset-0 z-[100] flex items-center justify-center overflow-y-auto bg-slate-900/60 dark:bg-navy-900/60">
        <div x-show="show" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-90" class="w-full max-w-lg p-3 sm:p-5">
            <div class="card bg-white dark:bg-navy-700">
                <div class="flex justify-between p-4 sm:p-5">
                    <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100">
                        Approve KYC Application
                    </h3>
                    <button @click="show = false"
                        class="btn -mr-1.5 h-7 w-7 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="p-4 sm:p-5">
                    <form wire:submit.prevent="approveKyc">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-navy-100">
                                    Approval Note (Optional)
                                </label>
                                <textarea wire:model="approval_note"
                                    class="form-textarea mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                                    rows="3" placeholder="Enter approval note"></textarea>
                                @error('approval_note') <span class="text-error text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div class="p-3 rounded-lg bg-slate-50 dark:bg-navy-600">
                                <p class="text-sm text-slate-600 dark:text-navy-200">
                                    <span class="font-medium text-slate-700 dark:text-navy-100">Note:</span> Approving
                                    this application will grant the user full access to all features. This action cannot
                                    be undone.
                                </p>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end space-x-2">
                            <button type="button" @click="show = false"
                                class="btn border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                                Cancel
                            </button>
                            <button type="submit"
                                class="btn bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
                                Approve Application
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Rejection Modal -->
    <div x-data="{ show: @entangle('showRejectionModal') }" x-show="show" x-cloak
        class="fixed inset-0 z-[100] flex items-center justify-center overflow-y-auto bg-slate-900/60 dark:bg-navy-900/60">
        <div x-show="show" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-90" class="w-full max-w-lg p-3 sm:p-5">
            <div class="card bg-white dark:bg-navy-700">
                <div class="flex justify-between p-4 sm:p-5">
                    <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100">
                        Reject KYC Application
                    </h3>
                    <button @click="show = false"
                        class="btn -mr-1.5 h-7 w-7 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="p-4 sm:p-5">
                    <form wire:submit.prevent="rejectKyc">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-navy-100">
                                    Rejection Reason <span class="text-error">*</span>
                                </label>
                                <textarea wire:model="rejection_reason"
                                    class="form-textarea mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                                    rows="3" placeholder="Enter rejection reason"></textarea>
                                @error('rejection_reason') <span class="text-error text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="p-3 rounded-lg bg-slate-50 dark:bg-navy-600">
                                <p class="text-sm text-slate-600 dark:text-navy-200">
                                    <span class="font-medium text-slate-700 dark:text-navy-100">Note:</span> Rejecting
                                    this application will require the user to submit a new application. Please provide a
                                    clear reason for rejection.
                                </p>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end space-x-2">
                            <button type="button" @click="show = false"
                                class="btn border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                                Cancel
                            </button>
                            <button type="submit"
                                class="btn bg-error font-medium text-white hover:bg-error-focus focus:bg-error-focus active:bg-error-focus/90">
                                Reject Application
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- KIV Modal -->
    <div x-data="{ show: @entangle('showKivModal') }" x-show="show" x-cloak
        class="fixed inset-0 z-[100] flex items-center justify-center overflow-y-auto bg-slate-900/60 dark:bg-navy-900/60">
        <div x-show="show" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-90" class="w-full max-w-lg p-3 sm:p-5">
            <div class="card bg-white dark:bg-navy-700">
                <div class="flex justify-between p-4 sm:p-5">
                    <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100">
                        Mark as Keep In View (KIV)
                    </h3>
                    <button @click="show = false"
                        class="btn -mr-1.5 h-7 w-7 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="p-4 sm:p-5">
                    <form wire:submit.prevent="kivKyc">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-navy-100">
                                    Reason for KIV <span class="text-error">*</span>
                                </label>
                                <textarea wire:model="kiv_reason"
                                    class="form-textarea mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                                    rows="3" placeholder="Enter reason for keeping in view"></textarea>
                                @error('kiv_reason') <span class="text-error text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div class="p-3 rounded-lg bg-slate-50 dark:bg-navy-600">
                                <p class="text-sm text-slate-600 dark:text-navy-200">
                                    <span class="font-medium text-slate-700 dark:text-navy-100">Note:</span> Marking as
                                    KIV will put this application on hold for further review. The user will be notified
                                    that their application requires additional review.
                                </p>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end space-x-2">
                            <button type="button" @click="show = false"
                                class="btn border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                                Cancel
                            </button>
                            <button type="submit"
                                class="btn bg-info font-medium text-white hover:bg-info-focus focus:bg-info-focus active:bg-info-focus/90">
                                Mark as KIV
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Request Additional Info Modal -->
    <div x-data="{ show: @entangle('showRequestInfoModal') }" x-show="show" x-cloak
        class="fixed inset-0 z-[100] flex items-center justify-center overflow-y-auto bg-slate-900/60 dark:bg-navy-900/60">
        <div x-show="show" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-90" class="w-full max-w-lg p-3 sm:p-5">
            <div class="card bg-white dark:bg-navy-700">
                <div class="flex justify-between p-4 sm:p-5">
                    <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100">
                        Request Additional Information
                    </h3>
                    <button @click="show = false"
                        class="btn -mr-1.5 h-7 w-7 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="p-4 sm:p-5">
                    <form wire:submit.prevent="requestAdditionalInfo">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-navy-100">
                                    Information Requested <span class="text-error">*</span>
                                </label>
                                <textarea wire:model="request_details"
                                    class="form-textarea mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                                    rows="3"
                                    placeholder="Specify what additional information or documents are needed"></textarea>
                                @error('request_details') <span class="text-error text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="p-3 rounded-lg bg-slate-50 dark:bg-navy-600">
                                <p class="text-sm text-slate-600 dark:text-navy-200">
                                    <span class="font-medium text-slate-700 dark:text-navy-100">Note:</span> The user
                                    will be notified about this request and will be able to update their application
                                    with the requested information.
                                </p>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end space-x-2">
                            <button type="button" @click="show = false"
                                class="btn border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                                Cancel
                            </button>
                            <button type="submit"
                                class="btn bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                                Send Request
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Modal -->
    <div id="imageModal" class="fixed inset-0 z-[200] hidden bg-slate-900/60 backdrop-blur-sm">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="relative w-full max-w-4xl bg-white shadow-xl rounded-xl dark:bg-navy-700">
                <button onclick="closeImageModal()" class="absolute text-white top-2 right-2 hover:text-slate-300 z-10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <img id="modalImage" src="/placeholder.svg" alt="Full size document" class="w-full h-auto rounded-xl">
            </div>
        </div>
    </div>

    <script>
        function openImageModal(imageSrc) {
            const imageModal = document.getElementById('imageModal');
            const modalImage = document.getElementById('modalImage');

            if (imageModal && modalImage) {
                modalImage.src = imageSrc;
                imageModal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
        }

        function closeImageModal() {
            const imageModal = document.getElementById('imageModal');

            if (imageModal) {
                imageModal.classList.add('hidden');
                document.body.style.overflow = '';
            }
        }

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeImageModal();
            }
        });
    </script>
</div>
