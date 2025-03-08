<div class="card p-4 sm:p-5">
    <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100 mb-5">
        KYC Verification
    </h2>

    <div class="mb-5">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <div
                    class="flex h-7 w-7 items-center justify-center rounded-full {{ $currentStep >= 1 ? 'bg-primary text-white dark:bg-accent' : 'bg-slate-200 text-slate-500 dark:bg-navy-500' }}">
                    <span>1</span>
                </div>
                <p class="text-sm+ font-medium">Personal Information</p>
            </div>
            <div class="hidden sm:block w-24 h-px bg-slate-200 dark:bg-navy-500"></div>
            <div class="flex items-center space-x-2">
                <div
                    class="flex h-7 w-7 items-center justify-center rounded-full {{ $currentStep >= 2 ? 'bg-primary text-white dark:bg-accent' : 'bg-slate-200 text-slate-500 dark:bg-navy-500' }}">
                    <span>2</span>
                </div>
                <p class="text-sm+ font-medium">ID Information</p>
            </div>
            <div class="hidden sm:block w-24 h-px bg-slate-200 dark:bg-navy-500"></div>
            <div class="flex items-center space-x-2">
                <div
                    class="flex h-7 w-7 items-center justify-center rounded-full {{ $currentStep >= 3 ? 'bg-primary text-white dark:bg-accent' : 'bg-slate-200 text-slate-500 dark:bg-navy-500' }}">
                    <span>3</span>
                </div>
                <p class="text-sm+ font-medium">Document Upload</p>
            </div>
        </div>
    </div>

    <form wire:submit.prevent="{{ $currentStep < $totalSteps ? 'nextStep' : 'submit' }}">
        @if($currentStep === 1)
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-navy-100">
                    Full Name
                </label>
                <input type="text" wire:model="full_name"
                    class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                    placeholder="Enter your full name as it appears on your ID">
                @error('full_name') <span class="text-error text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-navy-100">
                    Date of Birth
                </label>
                <input type="date" wire:model="date_of_birth"
                    class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">
                @error('date_of_birth') <span class="text-error text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-navy-100">
                    Address
                </label>
                <textarea wire:model="address"
                    class="form-textarea mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                    placeholder="Enter your current residential address" rows="3"></textarea>
                @error('address') <span class="text-error text-sm">{{ $message }}</span> @enderror
            </div>
        </div>
        @elseif($currentStep === 2)
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-navy-100">
                    ID Type
                </label>
                <select wire:model="id_type"
                    class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">
                    <option value="passport">Passport</option>
                    <option value="national_id">National ID</option>
                    <option value="drivers_license">Driver's License</option>
                </select>
                @error('id_type') <span class="text-error text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-navy-100">
                    ID Number
                </label>
                <input type="text" wire:model="id_number"
                    class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                    placeholder="Enter your ID number">
                @error('id_number') <span class="text-error text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-navy-100">
                    ID Expiration Date
                </label>
                <input type="date" wire:model="id_expiration_date"
                    class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">
                @error('id_expiration_date') <span class="text-error text-sm">{{ $message }}</span> @enderror
            </div> --}}
            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-navy-100">
                    ID Expiration Date
                </label>

                {{-- Toggle for has expiration --}}
                <div class="mb-3 flex items-center space-x-3">
                    <label class="inline-flex items-center space-x-2">
                        <input type="checkbox" wire:model.live="has_expiration" class="form-checkbox is-basic h-4.5 w-4.5 rounded border-slate-400/70
                                   checked:border-primary checked:bg-primary
                                   hover:border-primary focus:border-primary
                                   dark:border-navy-400 dark:checked:border-accent
                                   dark:checked:bg-accent dark:hover:border-accent
                                   dark:focus:border-accent" />
                        <span class="text-slate-600 dark:text-navy-100">
                            Does this ID have an expiration date?
                        </span>
                    </label>
                </div>

                @if($has_expiration)
                <input type="date" wire:model="id_expiration_date" class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2
                               placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary
                               dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400
                               dark:focus:border-accent">
                @error('id_expiration_date')
                <span class="text-error text-sm">{{ $message }}</span>
                @enderror
                @endif
            </div>
        </div>
        @elseif($currentStep === 3)
        <div class="space-y-5">
            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-navy-100 mb-2">
                    Front of ID
                </label>
                <div class="grid grid-cols-1 gap-4">
                    <div class="relative rounded-lg border border-slate-300 dark:border-navy-450 p-3">
                        @if($id_front_image)
                        <div class="relative">
                            <img src="{{ $id_front_image->temporaryUrl() }}" class="mx-auto max-h-48 rounded">
                            <button type="button" wire:click="deleteImage('id_front_image')"
                                class="absolute top-2 right-2 btn h-6 w-6 rounded-full p-0 bg-error/20 text-error hover:bg-error/30">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        @else
                        <div x-data="{ isUploading: false, progress: 0 }"
                            x-on:livewire-upload-start="isUploading = true"
                            x-on:livewire-upload-finish="isUploading = false"
                            x-on:livewire-upload-error="isUploading = false"
                            x-on:livewire-upload-progress="progress = $event.detail.progress"
                            class="flex flex-col items-center justify-center">
                            <label
                                class="flex h-32 w-full cursor-pointer flex-col items-center justify-center rounded-lg border-2 border-dashed border-slate-300 hover:bg-slate-50 dark:border-navy-450 dark:hover:bg-navy-600">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="mb-3 h-10 w-10 text-slate-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                        </path>
                                    </svg>
                                    <p class="mb-1 text-sm text-slate-500 dark:text-navy-200">
                                        <span class="font-semibold">Click to upload</span> or drag and drop
                                    </p>
                                    <p class="text-xs text-slate-400 dark:text-navy-300">
                                        PNG, JPG or JPEG (MAX. 2MB)
                                    </p>
                                </div>
                                <input type="file" wire:model="id_front_image" class="hidden" accept="image/*" />
                            </label>
                            <div x-show="isUploading" class="mt-2 w-full">
                                <div class="relative pt-1">
                                    <div class="flex mb-2 items-center justify-between">
                                        <div>
                                            <span
                                                class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-primary bg-primary-50">
                                                Uploading
                                            </span>
                                        </div>
                                        <div class="text-right">
                                            <span class="text-xs font-semibold inline-block text-primary"
                                                x-text="progress + '%'"></span>
                                        </div>
                                    </div>
                                    <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-primary-50">
                                        <div :style="`width: ${progress}%`"
                                            class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-primary">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    @error('id_front_image') <span class="text-error text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-navy-100 mb-2">
                    Back of ID
                </label>
                <div class="grid grid-cols-1 gap-4">
                    <div class="relative rounded-lg border border-slate-300 dark:border-navy-450 p-3">
                        @if($id_back_image)
                        <div class="relative">
                            <img src="{{ $id_back_image->temporaryUrl() }}" class="mx-auto max-h-48 rounded">
                            <button type="button" wire:click="deleteImage('id_back_image')"
                                class="absolute top-2 right-2 btn h-6 w-6 rounded-full p-0 bg-error/20 text-error hover:bg-error/30">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        @else
                        <div x-data="{ isUploading: false, progress: 0 }"
                            x-on:livewire-upload-start="isUploading = true"
                            x-on:livewire-upload-finish="isUploading = false"
                            x-on:livewire-upload-error="isUploading = false"
                            x-on:livewire-upload-progress="progress = $event.detail.progress"
                            class="flex flex-col items-center justify-center">
                            <label
                                class="flex h-32 w-full cursor-pointer flex-col items-center justify-center rounded-lg border-2 border-dashed border-slate-300 hover:bg-slate-50 dark:border-navy-450 dark:hover:bg-navy-600">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="mb-3 h-10 w-10 text-slate-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                        </path>
                                    </svg>
                                    <p class="mb-1 text-sm text-slate-500 dark:text-navy-200">
                                        <span class="font-semibold">Click to upload</span> or drag and drop
                                    </p>
                                    <p class="text-xs text-slate-400 dark:text-navy-300">
                                        PNG, JPG or JPEG (MAX. 2MB)
                                    </p>
                                </div>
                                <input type="file" wire:model="id_back_image" class="hidden" accept="image/*" />
                            </label>
                            <div x-show="isUploading" class="mt-2 w-full">
                                <div class="relative pt-1">
                                    <div class="flex mb-2 items-center justify-between">
                                        <div>
                                            <span
                                                class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-primary bg-primary-50">
                                                Uploading
                                            </span>
                                        </div>
                                        <div class="text-right">
                                            <span class="text-xs font-semibold inline-block text-primary"
                                                x-text="progress + '%'"></span>
                                        </div>
                                    </div>
                                    <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-primary-50">
                                        <div :style="`width: ${progress}%`"
                                            class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-primary">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    @error('id_back_image') <span class="text-error text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-navy-100 mb-2">
                    Selfie with ID
                </label>
                <div class="grid grid-cols-1 gap-4">
                    <div class="relative rounded-lg border border-slate-300 dark:border-navy-450 p-3">
                        @if($selfie_image)
                        <div class="relative">
                            <img src="{{ $selfie_image->temporaryUrl() }}" class="mx-auto max-h-48 rounded">
                            <button type="button" wire:click="deleteImage('selfie_image')"
                                class="absolute top-2 right-2 btn h-6 w-6 rounded-full p-0 bg-error/20 text-error hover:bg-error/30">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        @else
                        <div x-data="{ isUploading: false, progress: 0 }"
                            x-on:livewire-upload-start="isUploading = true"
                            x-on:livewire-upload-finish="isUploading = false"
                            x-on:livewire-upload-error="isUploading = false"
                            x-on:livewire-upload-progress="progress = $event.detail.progress"
                            class="flex flex-col items-center justify-center">
                            <label
                                class="flex h-32 w-full cursor-pointer flex-col items-center justify-center rounded-lg border-2 border-dashed border-slate-300 hover:bg-slate-50 dark:border-navy-450 dark:hover:bg-navy-600">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="mb-3 h-10 w-10 text-slate-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                        </path>
                                    </svg>
                                    <p class="mb-1 text-sm text-slate-500 dark:text-navy-200">
                                        <span class="font-semibold">Click to upload</span> or drag and drop
                                    </p>
                                    <p class="text-xs text-slate-400 dark:text-navy-300">
                                        PNG, JPG or JPEG (MAX. 2MB)
                                    </p>
                                </div>
                                <input type="file" wire:model="selfie_image" class="hidden" accept="image/*" />
                            </label>
                            <div x-show="isUploading" class="mt-2 w-full">
                                <div class="relative pt-1">
                                    <div class="flex mb-2 items-center justify-between">
                                        <div>
                                            <span
                                                class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-primary bg-primary-50">
                                                Uploading
                                            </span>
                                        </div>
                                        <div class="text-right">
                                            <span class="text-xs font-semibold inline-block text-primary"
                                                x-text="progress + '%'"></span>
                                        </div>
                                    </div>
                                    <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-primary-50">
                                        <div :style="`width: ${progress}%`"
                                            class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-primary">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    @error('selfie_image') <span class="text-error text-sm">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
        @endif

        <div class="mt-6 flex justify-between">
            @if($currentStep > 1)
            <button type="button" wire:click="previousStep"
                class="btn border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                Previous
            </button>
            @else
            <div></div>
            @endif

            <button type="submit"
                class="btn bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                {{ $currentStep < $totalSteps ? 'Next' : 'Submit' }} </button>
        </div>
    </form>
</div>
