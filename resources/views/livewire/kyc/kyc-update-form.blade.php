@php
    /*

<div>
    <form wire:submit.prevent="submit" class="space-y-5">
        <div class="card p-4 sm:p-5">
            <h2 class="text-lg font-medium text-slate-700 dark:text-navy-100 mb-5">
                Personal Information
            </h2>
            <div class="space-y-4">
                <label class="block">
                    <span class="font-medium text-slate-600 dark:text-navy-100">Full Name</span>
                    <input wire:model="full_name"
                        class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                        placeholder="Enter your full name" type="text">
                    @error('full_name') <span class="text-error text-sm">{{ $message }}</span> @enderror
                </label>

                <label class="block">
                    <span class="font-medium text-slate-600 dark:text-navy-100">Date of Birth</span>
                    <input wire:model="date_of_birth"
                        class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                        type="date">
                    @error('date_of_birth') <span class="text-error text-sm">{{ $message }}</span> @enderror
                </label>

                <label class="block">
                    <span class="font-medium text-slate-600 dark:text-navy-100">Address</span>
                    <textarea wire:model="address"
                        class="form-textarea mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                        placeholder="Enter your full address" rows="3"></textarea>
                    @error('address') <span class="text-error text-sm">{{ $message }}</span> @enderror
                </label>
            </div>
        </div>

        <div class="card p-4 sm:p-5">
            <h2 class="text-lg font-medium text-slate-700 dark:text-navy-100 mb-5">
                Identification Details
            </h2>
            <div class="space-y-4">
                <label class="block">
                    <span class="font-medium text-slate-600 dark:text-navy-100">ID Type</span>
                    <select wire:model="id_type"
                        class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">
                        <option value="national_id">National ID</option>
                        <option value="passport">Passport</option>
                        <option value="drivers_license">Driver's License</option>
                    </select>
                    @error('id_type') <span class="text-error text-sm">{{ $message }}</span> @enderror
                </label>

                <label class="block">
                    <span class="font-medium text-slate-600 dark:text-navy-100">ID Number</span>
                    <input wire:model="id_number"
                        class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                        placeholder="Enter your ID number" type="text">
                    @error('id_number') <span class="text-error text-sm">{{ $message }}</span> @enderror
                </label>

                <!-- Has Expiration Checkbox - Added with minimal layout change -->
                <label class="inline-flex items-center space-x-2 mt-2">
                    <input type="checkbox" wire:model.live="has_expiration"
                        class="form-checkbox is-basic h-5 w-5 rounded border-slate-400/70 checked:border-primary checked:bg-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:border-accent dark:checked:bg-accent dark:hover:border-accent dark:focus:border-accent">
                    <span class="font-medium text-slate-600 dark:text-navy-100">ID has expiration date</span>
                </label>

                <!-- Only show expiration date field if has_expiration is true -->
                @if($has_expiration)
                <label class="block">
                    <span class="font-medium text-slate-600 dark:text-navy-100">ID Expiration Date</span>
                    <input wire:model="id_expiration_date"
                        class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                        type="date">
                    @error('id_expiration_date') <span class="text-error text-sm">{{ $message }}</span> @enderror
                </label>
                @endif
            </div>
        </div>

        <div class="card p-4 sm:p-5">
            <h2 class="text-lg font-medium text-slate-700 dark:text-navy-100 mb-5">
                Update Documents
            </h2>
            <div class="space-y-4">
                <div>
                    <span class="font-medium text-slate-600 dark:text-navy-100">ID Front Side (Optional)</span>
                    <div class="mt-1.5 flex flex-col">
                        @if ($new_id_front_image)
                        <div class="relative">
                            <img src="{{ $new_id_front_image->temporaryUrl() }}"
                                class="h-48 w-auto object-cover rounded-lg border border-slate-300 dark:border-navy-450">
                            <button type="button" wire:click="deleteImage('new_id_front_image')"
                                class="absolute top-2 right-2 btn h-6 w-6 rounded-full p-0 bg-error/20 text-error hover:bg-error/30 focus:bg-error/30 active:bg-error/40">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        @else
                        <label
                            class="btn bg-slate-150 font-medium text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90 w-full">
                            <input type="file" wire:model="new_id_front_image" class="hidden">
                            <span>Upload New ID Front</span>
                        </label>
                        @endif
                        @error('new_id_front_image') <span class="text-error text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <span class="font-medium text-slate-600 dark:text-navy-100">ID Back Side (Optional)</span>
                    <div class="mt-1.5 flex flex-col">
                        @if ($new_id_back_image)
                        <div class="relative">
                            <img src="{{ $new_id_back_image->temporaryUrl() }}"
                                class="h-48 w-auto object-cover rounded-lg border border-slate-300 dark:border-navy-450">
                            <button type="button" wire:click="deleteImage('new_id_back_image')"
                                class="absolute top-2 right-2 btn h-6 w-6 rounded-full p-0 bg-error/20 text-error hover:bg-error/30 focus:bg-error/30 active:bg-error/40">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        @else
                        <label
                            class="btn bg-slate-150 font-medium text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90 w-full">
                            <input type="file" wire:model="new_id_back_image" class="hidden">
                            <span>Upload New ID Back</span>
                        </label>
                        @endif
                        @error('new_id_back_image') <span class="text-error text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <span class="font-medium text-slate-600 dark:text-navy-100">Selfie with ID (Optional)</span>
                    <div class="mt-1.5 flex flex-col">
                        @if ($new_selfie_image)
                        <div class="relative">
                            <img src="{{ $new_selfie_image->temporaryUrl() }}"
                                class="h-48 w-auto object-cover rounded-lg border border-slate-300 dark:border-navy-450">
                            <button type="button" wire:click="deleteImage('new_selfie_image')"
                                class="absolute top-2 right-2 btn h-6 w-6 rounded-full p-0 bg-error/20 text-error hover:bg-error/30 focus:bg-error/30 active:bg-error/40">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        @else
                        <label
                            class="btn bg-slate-150 font-medium text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90 w-full">
                            <input type="file" wire:model="new_selfie_image" class="hidden">
                            <span>Upload New Selfie</span>
                        </label>
                        @endif
                        @error('new_selfie_image') <span class="text-error text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                @if($kyc->additional_info_requested)
                <div>
                    <span class="font-medium text-slate-600 dark:text-navy-100">Additional Information Requested</span>
                    <div class="mt-1.5 p-3 rounded-lg bg-amber-50 dark:bg-amber-900/20">
                        <p class="text-sm text-amber-600 dark:text-amber-400">{{ $kyc->additional_info_requested }}</p>
                        <p class="text-xs text-amber-500/70 dark:text-amber-400/60 mt-1">
                            Requested on {{ $kyc->additional_info_requested_at ?
                            $kyc->additional_info_requested_at->format('M d, Y') : 'N/A' }}
                        </p>
                    </div>

                    <label class="block mt-3">
                        <span class="font-medium text-slate-600 dark:text-navy-100">Your Response</span>
                        <textarea wire:model="additionalInfo"
                            class="form-textarea mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                            placeholder="Provide the requested information" rows="3"></textarea>
                        @error('additionalInfo') <span class="text-error text-sm">{{ $message }}</span> @enderror
                    </label>
                </div>
                @endif

                <div>
                    <span class="font-medium text-slate-600 dark:text-navy-100">Additional Document (Optional)</span>
                    <div class="mt-1.5 space-y-3">
                        <select wire:model="additional_document_type"
                            class="form-select w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">
                            <option value="utility_bill">Utility Bill</option>
                            <option value="bank_statement">Bank Statement</option>
                            <option value="residence_proof">Proof of Residence</option>
                            <option value="other">Other Document</option>
                        </select>

                        <div class="flex flex-col">
                            @if ($additional_document)
                            <div class="relative">
                                <div
                                    class="p-3 rounded-lg border border-slate-300 dark:border-navy-450 bg-slate-50 dark:bg-navy-600">
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-10 w-10 text-primary dark:text-accent" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-slate-700 dark:text-navy-100">
                                                {{ $additional_document->getClientOriginalName() }}
                                            </p>
                                            <p class="text-xs text-slate-500 dark:text-navy-300">
                                                {{ round($additional_document->getSize() / 1024) }} KB
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" wire:click="deleteImage('additional_document')"
                                    class="absolute top-2 right-2 btn h-6 w-6 rounded-full p-0 bg-error/20 text-error hover:bg-error/30 focus:bg-error/30 active:bg-error/40">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                            @else
                            <label
                                class="btn bg-slate-150 font-medium text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90 w-full">
                                <input type="file" wire:model="additional_document" class="hidden">
                                <span>Upload Additional Document</span>
                            </label>
                            @endif
                            @error('additional_document') <span class="text-error text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end space-x-2">
            <button type="button" wire:click="$emit('closeModal')"
                class="btn border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                Cancel
            </button>
            <button type="submit"
                class="btn bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                Update KYC
            </button>
        </div>
    </form>
</div>
*/
@endphp
<div>
    <form wire:submit.prevent="submit" class="space-y-6">
        <!-- Progress Indicator -->
        <div class="card p-4 sm:p-5 bg-white dark:bg-navy-700 border-l-4 border-primary dark:border-accent">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary dark:text-accent" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h2 class="text-lg font-medium text-slate-700 dark:text-navy-100">
                        Update Your KYC Information
                    </h2>
                    <p class="text-sm text-slate-500 dark:text-navy-300">
                        Please review and update your information to complete the verification process.
                    </p>
                </div>
            </div>
        </div>

        <!-- Additional Information Request Alert (if applicable) -->
        @if($kyc->additional_info_requested)
        <div class="card p-4 sm:p-5 bg-amber-50 dark:bg-amber-900/20 border-l-4 border-amber-500 dark:border-amber-600">
            <div class="flex items-start">
                <div class="flex-shrink-0 mt-0.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-600 dark:text-amber-400"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-3 flex-1">
                    <h3 class="text-base font-medium text-amber-800 dark:text-amber-400">
                        Additional Information Requested
                    </h3>
                    <div class="mt-2 text-sm text-amber-700 dark:text-amber-300">
                        <p>{{ $kyc->additional_info_requested }}</p>
                    </div>
                    <div class="mt-1">
                        <p class="text-xs text-amber-600/80 dark:text-amber-400/60">
                            Requested on {{ $kyc->additional_info_requested_at ?
                            $kyc->additional_info_requested_at->format('M d, Y') : 'N/A' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Personal Information Section -->
        <div class="card p-5 sm:p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-base font-medium text-slate-700 dark:text-navy-100">
                    <span
                        class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-primary/10 text-primary dark:bg-accent/10 dark:text-accent mr-2 text-sm">1</span>
                    Personal Information
                </h3>
                <span
                    class="text-xs px-2 py-1 rounded-full bg-primary/10 text-primary dark:bg-accent/10 dark:text-accent">Required</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block">
                        <span class="font-medium text-slate-600 dark:text-navy-100">Full Name</span>
                        <input wire:model="full_name"
                            class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                            placeholder="Enter your full name" type="text">
                        @error('full_name') <span class="text-error text-sm mt-1">{{ $message }}</span> @enderror
                    </label>
                </div>

                <div>
                    <label class="block">
                        <span class="font-medium text-slate-600 dark:text-navy-100">Date of Birth</span>
                        <input wire:model="date_of_birth"
                            class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                            type="date">
                        @error('date_of_birth') <span class="text-error text-sm mt-1">{{ $message }}</span> @enderror
                    </label>
                </div>

                <div class="md:col-span-2">
                    <label class="block">
                        <span class="font-medium text-slate-600 dark:text-navy-100">Address</span>
                        <textarea wire:model="address"
                            class="form-textarea mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                            placeholder="Enter your full address" rows="3"></textarea>
                        @error('address') <span class="text-error text-sm mt-1">{{ $message }}</span> @enderror
                    </label>
                </div>
            </div>
        </div>

        <!-- Identification Details Section -->
        <div class="card p-5 sm:p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-base font-medium text-slate-700 dark:text-navy-100">
                    <span
                        class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-primary/10 text-primary dark:bg-accent/10 dark:text-accent mr-2 text-sm">2</span>
                    Identification Details
                </h3>
                <span
                    class="text-xs px-2 py-1 rounded-full bg-primary/10 text-primary dark:bg-accent/10 dark:text-accent">Required</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block">
                        <span class="font-medium text-slate-600 dark:text-navy-100">ID Type</span>
                        <select wire:model="id_type"
                            class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">
                            <option value="national_id">National ID</option>
                            <option value="passport">Passport</option>
                            <option value="drivers_license">Driver's License</option>
                        </select>
                        @error('id_type') <span class="text-error text-sm mt-1">{{ $message }}</span> @enderror
                    </label>
                </div>

                <div>
                    <label class="block">
                        <span class="font-medium text-slate-600 dark:text-navy-100">ID Number</span>
                        <input wire:model="id_number"
                            class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                            placeholder="Enter your ID number" type="text">
                        @error('id_number') <span class="text-error text-sm mt-1">{{ $message }}</span> @enderror
                    </label>
                </div>

                <div class="md:col-span-2">
                    <div class="flex items-center p-3 rounded-lg bg-slate-50 dark:bg-navy-600">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model.live="has_expiration"
                                class="form-checkbox is-basic h-5 w-5 rounded border-slate-400/70 checked:border-primary checked:bg-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:border-accent dark:checked:bg-accent dark:hover:border-accent dark:focus:border-accent">
                            <span class="ml-2 font-medium text-slate-600 dark:text-navy-100">ID has expiration
                                date</span>
                        </label>
                    </div>
                </div>

                @if($has_expiration)
                <div class="md:col-span-2">
                    <label class="block">
                        <span class="font-medium text-slate-600 dark:text-navy-100">ID Expiration Date</span>
                        <input wire:model="id_expiration_date"
                            class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                            type="date">
                        @error('id_expiration_date') <span class="text-error text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </label>
                </div>
                @endif
            </div>
        </div>

        <!-- Document Upload Section -->
        <div class="card p-5 sm:p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-base font-medium text-slate-700 dark:text-navy-100">
                    <span
                        class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-primary/10 text-primary dark:bg-accent/10 dark:text-accent mr-2 text-sm">3</span>
                    Document Upload
                </h3>
                <span
                    class="text-xs px-2 py-1 rounded-full bg-slate-200 text-slate-700 dark:bg-navy-500 dark:text-navy-100">Optional</span>
            </div>

            <div class="mb-4 p-3 rounded-lg bg-info/10 border border-info/20 text-info dark:border-info/30">
                <div class="flex">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 flex-shrink-0" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-sm">Only upload new documents if you need to update them. Leave empty to keep your
                        current documents.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <!-- ID Front Side -->
                <div class="space-y-3">
                    <span class="font-medium text-slate-600 dark:text-navy-100">ID Front Side</span>
                    <div class="flex flex-col">
                        @if ($new_id_front_image)
                        <div class="relative rounded-lg border border-slate-200 dark:border-navy-500 overflow-hidden">
                            <img src="{{ $new_id_front_image->temporaryUrl() }}" class="h-48 w-full object-cover">
                            <div
                                class="absolute inset-0 bg-slate-900/30 opacity-0 hover:opacity-100 transition-opacity flex items-center justify-center">
                                <button type="button" wire:click="deleteImage('new_id_front_image')"
                                    class="btn h-9 w-9 rounded-full bg-error p-0 font-medium text-white hover:bg-error-focus">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        @else
                        <label class="relative group">
                            <input type="file" wire:model="new_id_front_image" class="hidden">
                            <div
                                class="h-48 w-full rounded-lg border-2 border-dashed border-slate-300 dark:border-navy-400 flex flex-col items-center justify-center cursor-pointer hover:border-primary dark:hover:border-accent transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-10 w-10 text-slate-400 dark:text-navy-300 group-hover:text-primary dark:group-hover:text-accent"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p
                                    class="mt-2 text-xs+ text-slate-400 dark:text-navy-300 group-hover:text-primary dark:group-hover:text-accent">
                                    Upload ID Front</p>
                            </div>
                        </label>
                        @endif
                        @error('new_id_front_image') <span class="text-error text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- ID Back Side -->
                <div class="space-y-3">
                    <span class="font-medium text-slate-600 dark:text-navy-100">ID Back Side</span>
                    <div class="flex flex-col">
                        @if ($new_id_back_image)
                        <div class="relative rounded-lg border border-slate-200 dark:border-navy-500 overflow-hidden">
                            <img src="{{ $new_id_back_image->temporaryUrl() }}" class="h-48 w-full object-cover">
                            <div
                                class="absolute inset-0 bg-slate-900/30 opacity-0 hover:opacity-100 transition-opacity flex items-center justify-center">
                                <button type="button" wire:click="deleteImage('new_id_back_image')"
                                    class="btn h-9 w-9 rounded-full bg-error p-0 font-medium text-white hover:bg-error-focus">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        @else
                        <label class="relative group">
                            <input type="file" wire:model="new_id_back_image" class="hidden">
                            <div
                                class="h-48 w-full rounded-lg border-2 border-dashed border-slate-300 dark:border-navy-400 flex flex-col items-center justify-center cursor-pointer hover:border-primary dark:hover:border-accent transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-10 w-10 text-slate-400 dark:text-navy-300 group-hover:text-primary dark:group-hover:text-accent"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p
                                    class="mt-2 text-xs+ text-slate-400 dark:text-navy-300 group-hover:text-primary dark:group-hover:text-accent">
                                    Upload ID Back</p>
                            </div>
                        </label>
                        @endif
                        @error('new_id_back_image') <span class="text-error text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Selfie with ID -->
                <div class="space-y-3">
                    <span class="font-medium text-slate-600 dark:text-navy-100">Selfie with ID</span>
                    <div class="flex flex-col">
                        @if ($new_selfie_image)
                        <div class="relative rounded-lg border border-slate-200 dark:border-navy-500 overflow-hidden">
                            <img src="{{ $new_selfie_image->temporaryUrl() }}" class="h-48 w-full object-cover">
                            <div
                                class="absolute inset-0 bg-slate-900/30 opacity-0 hover:opacity-100 transition-opacity flex items-center justify-center">
                                <button type="button" wire:click="deleteImage('new_selfie_image')"
                                    class="btn h-9 w-9 rounded-full bg-error p-0 font-medium text-white hover:bg-error-focus">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        @else
                        <label class="relative group">
                            <input type="file" wire:model="new_selfie_image" class="hidden">
                            <div
                                class="h-48 w-full rounded-lg border-2 border-dashed border-slate-300 dark:border-navy-400 flex flex-col items-center justify-center cursor-pointer hover:border-primary dark:hover:border-accent transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-10 w-10 text-slate-400 dark:text-navy-300 group-hover:text-primary dark:group-hover:text-accent"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <p
                                    class="mt-2 text-xs+ text-slate-400 dark:text-navy-300 group-hover:text-primary dark:group-hover:text-accent">
                                    Upload Selfie</p>
                            </div>
                        </label>
                        @endif
                        @error('new_selfie_image') <span class="text-error text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Information Section -->
        @if($kyc->additional_info_requested)
        <div class="card p-5 sm:p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-base font-medium text-slate-700 dark:text-navy-100">
                    <span
                        class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-amber-500/10 text-amber-600 dark:bg-amber-500/20 dark:text-amber-400 mr-2 text-sm">!</span>
                    Your Response
                </h3>
                <span
                    class="text-xs px-2 py-1 rounded-full bg-amber-500/10 text-amber-600 dark:bg-amber-500/20 dark:text-amber-400">Required</span>
            </div>

            <div class="space-y-4">
                <label class="block">
                    <span class="font-medium text-slate-600 dark:text-navy-100">Provide the requested information</span>
                    <textarea wire:model="additionalInfo"
                        class="form-textarea mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                        placeholder="Enter your response to the additional information request" rows="4"></textarea>
                    @error('additionalInfo') <span class="text-error text-sm mt-1">{{ $message }}</span> @enderror
                </label>
            </div>
        </div>
        @endif

        <!-- Additional Document Section -->
        <div class="card p-5 sm:p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-base font-medium text-slate-700 dark:text-navy-100">
                    <span
                        class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-primary/10 text-primary dark:bg-accent/10 dark:text-accent mr-2 text-sm">4</span>
                    Additional Document
                </h3>
                <span
                    class="text-xs px-2 py-1 rounded-full bg-slate-200 text-slate-700 dark:bg-navy-500 dark:text-navy-100">Optional</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block">
                        <span class="font-medium text-slate-600 dark:text-navy-100">Document Type</span>
                        <select wire:model="additional_document_type"
                            class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">
                            <option value="utility_bill">Utility Bill</option>
                            <option value="bank_statement">Bank Statement</option>
                            <option value="residence_proof">Proof of Residence</option>
                            <option value="other">Other Document</option>
                        </select>
                    </label>
                </div>

                <div>
                    <span class="font-medium text-slate-600 dark:text-navy-100">Upload Document</span>
                    <div class="mt-1.5">
                        @if ($additional_document)
                        <div
                            class="relative p-4 rounded-lg border border-slate-200 dark:border-navy-500 bg-slate-50 dark:bg-navy-600">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-primary dark:text-accent"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-slate-700 dark:text-navy-100">
                                        {{ $additional_document->getClientOriginalName() }}
                                    </p>
                                    <p class="text-xs text-slate-500 dark:text-navy-300">
                                        {{ round($additional_document->getSize() / 1024) }} KB
                                    </p>
                                </div>
                            </div>
                            <button type="button" wire:click="deleteImage('additional_document')"
                                class="absolute top-2 right-2 btn h-6 w-6 rounded-full p-0 bg-error/20 text-error hover:bg-error/30 focus:bg-error/30 active:bg-error/40">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        @else
                        <label class="relative group">
                            <input type="file" wire:model="additional_document" class="hidden">
                            <div
                                class="h-20 w-full rounded-lg border-2 border-dashed border-slate-300 dark:border-navy-400 flex items-center justify-center cursor-pointer hover:border-primary dark:hover:border-accent transition-colors">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-8 w-8 text-slate-400 dark:text-navy-300 group-hover:text-primary dark:group-hover:text-accent"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <span
                                        class="ml-2 text-sm text-slate-400 dark:text-navy-300 group-hover:text-primary dark:group-hover:text-accent">Upload
                                        Document</span>
                                </div>
                            </div>
                        </label>
                        @endif
                        @error('additional_document') <span class="text-error text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex flex-col sm:flex-row sm:justify-between gap-4">
            <a href="{{ route('kyc.dashboard') }}"
                class="btn border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                Cancel
            </a>
            <button type="submit"
                class="btn bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                Update KYC Information
            </button>
        </div>
    </form>
</div>