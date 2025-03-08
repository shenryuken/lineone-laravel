<div class="mt-6 card p-4 sm:p-5">
    <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
        {{ __('Know Your Business (KYB) Application') }}
    </h2>
    <!-- Step Progress Indicator -->
    <div class="mb-6">
        <div class="flex items-center justify-between">
            @for ($i = 1; $i <= $totalSteps; $i++) <div class="flex flex-col items-center">
                <div
                    class="w-10 h-10 flex items-center justify-center rounded-full {{ $currentStep >= $i ? 'bg-primary text-white' : 'bg-slate-200 text-slate-600' }} dark:{{ $currentStep >= $i ? 'bg-accent text-white' : 'bg-navy-500 text-navy-200' }}">
                    {{ $i }}
                </div>
                <span
                    class="mt-2 text-xs text-center {{ $currentStep >= $i ? 'text-primary dark:text-accent' : 'text-slate-500 dark:text-navy-300' }}">
                    @switch($i)
                    @case(1)
                    Business Details
                    @break
                    @case(2)
                    Ownership
                    @break
                    @case(3)
                    Operations
                    @break
                    @case(4)
                    Financial
                    @break
                    @case(5)
                    Compliance
                    @break
                    @case(6)
                    Documents
                    @break
                    @endswitch
                </span>
        </div>

        @if ($i < $totalSteps) <div
            class="flex-1 h-1 mx-2 bg-slate-200 dark:bg-navy-500 {{ $currentStep > $i ? 'bg-primary dark:bg-accent' : '' }}">
    </div>
    @endif
    @endfor
</div>
</div>

<!-- Step 1: Business Registration Details -->
@if ($currentStep == 1)
<div class="card p-4 sm:p-5">
    <h2 class="text-lg font-medium text-slate-700 dark:text-navy-100 mb-5">
        Business Registration Details
    </h2>
    <div class="space-y-4">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <label class="block">
                <span class="font-medium text-slate-600 dark:text-navy-100">Legal Business Name</span>
                <input wire:model="legal_name"
                    class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                    placeholder="Enter legal business name" type="text">
                @error('legal_name') <span class="text-error text-sm">{{ $message }}</span> @enderror
            </label>

            <label class="block">
                <span class="font-medium text-slate-600 dark:text-navy-100">Registration/Incorporation Number</span>
                <input wire:model="registration_number"
                    class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                    placeholder="Enter registration number" type="text">
                @error('registration_number') <span class="text-error text-sm">{{ $message }}</span> @enderror
            </label>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <label class="block">
                <span class="font-medium text-slate-600 dark:text-navy-100">Business Type</span>
                <select wire:model="business_type"
                    class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">
                    <option value="sole_proprietorship">Sole Proprietorship</option>
                    <option value="partnership">Partnership</option>
                    <option value="limited_company">Limited Company</option>
                    <option value="corporation">Corporation</option>
                    <option value="llc">Limited Liability Company (LLC)</option>
                    <option value="non_profit">Non-Profit Organization</option>
                    <option value="other">Other</option>
                </select>
                @error('business_type') <span class="text-error text-sm">{{ $message }}</span> @enderror
            </label>

            <label class="block">
                <span class="font-medium text-slate-600 dark:text-navy-100">Date Established</span>
                <input wire:model="date_established"
                    class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                    type="date">
                @error('date_established') <span class="text-error text-sm">{{ $message }}</span> @enderror
            </label>
        </div>

        <label class="block">
            <span class="font-medium text-slate-600 dark:text-navy-100">Business Address</span>
            <textarea wire:model="business_address"
                class="form-textarea mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                placeholder="Enter complete business address" rows="3"></textarea>
            @error('business_address') <span class="text-error text-sm">{{ $message }}</span> @enderror
        </label>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 mt-4">
            <label class="block">
                <span class="font-medium text-slate-600 dark:text-navy-100">Business Phone</span>
                <input wire:model="business_phone"
                    class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                    placeholder="Enter business phone number" type="tel">
                @error('business_phone') <span class="text-error text-sm">{{ $message }}</span> @enderror
            </label>

            <label class="block">
                <span class="font-medium text-slate-600 dark:text-navy-100">Business Email</span>
                <input wire:model="business_email"
                    class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                    placeholder="Enter business email" type="email">
                @error('business_email') <span class="text-error text-sm">{{ $message }}</span> @enderror
            </label>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <label class="block">
                <span class="font-medium text-slate-600 dark:text-navy-100">Website (Optional)</span>
                <input wire:model="website"
                    class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                    placeholder="Enter business website" type="url">
                @error('website') <span class="text-error text-sm">{{ $message }}</span> @enderror
            </label>

            <label class="block">
                <span class="font-medium text-slate-600 dark:text-navy-100">Tax ID / VAT Number</span>
                <input wire:model="tax_id"
                    class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                    placeholder="Enter tax ID or VAT number" type="text">
                @error('tax_id') <span class="text-error text-sm">{{ $message }}</span> @enderror
            </label>
        </div>
    </div>

    <div class="mt-6 flex justify-end">
        <button wire:click="nextStep"
            class="btn bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
            Next
        </button>
    </div>
</div>
@endif

<!-- Step 2: Ownership and Control Information -->
@if ($currentStep == 2)
<div class="card p-4 sm:p-5">
    <h2 class="text-lg font-medium text-slate-700 dark:text-navy-100 mb-5">
        Ownership and Control Information
    </h2>

    <!-- Directors Section -->
    <div class="mb-6">
        <h3 class="text-base font-medium text-slate-700 dark:text-navy-100 mb-3">Directors</h3>

        @foreach($directors as $index => $director)
        <div class="p-4 mb-4 border rounded-lg border-slate-200 dark:border-navy-500">
            <div class="flex justify-between items-center mb-3">
                <h4 class="text-sm font-medium text-slate-700 dark:text-navy-100">Director {{ $index + 1 }}</h4>
                @if(count($directors) > 1)
                <button type="button" wire:click="removeDirector({{ $index }})"
                    class="btn h-7 w-7 rounded-full p-0 text-error hover:bg-error/20 focus:bg-error/20 active:bg-error/25">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                @endif
            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <label class="block">
                    <span class="font-medium text-slate-600 dark:text-navy-100">Full Name</span>
                    <input wire:model="directors.{{ $index }}.name"
                        class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                        placeholder="Enter director's full name" type="text">
                    @error("directors.{$index}.name") <span class="text-error text-sm">{{ $message }}</span> @enderror
                </label>

                <label class="block">
                    <span class="font-medium text-slate-600 dark:text-navy-100">Position</span>
                    <input wire:model="directors.{{ $index }}.position"
                        class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                        placeholder="Enter director's position" type="text">
                    @error("directors.{$index}.position") <span class="text-error text-sm">{{ $message }}</span>
                    @enderror
                </label>
            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 mt-4">
                <label class="block">
                    <span class="font-medium text-slate-600 dark:text-navy-100">Date of Birth</span>
                    <input wire:model="directors.{{ $index }}.date_of_birth"
                        class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                        type="date">
                    @error("directors.{$index}.date_of_birth") <span class="text-error text-sm">{{ $message }}</span>
                    @enderror
                </label>

                <label class="block">
                    <span class="font-medium text-slate-600 dark:text-navy-100">Nationality</span>
                    <input wire:model="directors.{{ $index }}.nationality"
                        class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                        placeholder="Enter nationality" type="text">
                    @error("directors.{$index}.nationality") <span class="text-error text-sm">{{ $message }}</span>
                    @enderror
                </label>
            </div>

            <div class="mt-4">
                <label class="block">
                    <span class="font-medium text-slate-600 dark:text-navy-100">ID Number</span>
                    <input wire:model="directors.{{ $index }}.id_number"
                        class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                        placeholder="Enter ID number (passport, national ID, etc.)" type="text">
                    @error("directors.{$index}.id_number") <span class="text-error text-sm">{{ $message }}</span>
                    @enderror
                </label>
            </div>
        </div>
        @endforeach

        <button type="button" wire:click="addDirector"
            class="btn bg-slate-150 font-medium text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Add Another Director
        </button>
    </div>

    <!-- Shareholders Section -->
    <div class="mb-6">
        <h3 class="text-base font-medium text-slate-700 dark:text-navy-100 mb-3">Shareholders (with significant control)
        </h3>

        @foreach($shareholders as $index => $shareholder)
        <div class="p-4 mb-4 border rounded-lg border-slate-200 dark:border-navy-500">
            <div class="flex justify-between items-center mb-3">
                <h4 class="text-sm font-medium text-slate-700 dark:text-navy-100">Shareholder {{ $index + 1 }}</h4>
                @if(count($shareholders) > 1)
                <button type="button" wire:click="removeShareholder({{ $index }})"
                    class="btn h-7 w-7 rounded-full p-0 text-error hover:bg-error/20 focus:bg-error/20 active:bg-error/25">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                @endif
            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <label class="block">
                    <span class="font-medium text-slate-600 dark:text-navy-100">Name</span>
                    <input wire:model="shareholders.{{ $index }}.name"
                        class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                        placeholder="Enter shareholder's name" type="text">
                    @error("shareholders.{$index}.name") <span class="text-error text-sm">{{ $message }}</span>
                    @enderror
                </label>

                <label class="block">
                    <span class="font-medium text-slate-600 dark:text-navy-100">Ownership Percentage (%)</span>
                    <input wire:model="shareholders.{{ $index }}.ownership_percentage"
                        class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                        placeholder="Enter ownership percentage" type="number" min="0" max="100" step="0.01">
                    @error("shareholders.{$index}.ownership_percentage") <span class="text-error text-sm">{{ $message
                        }}</span> @enderror
                </label>
            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 mt-4">
                <label class="block">
                    <span class="font-medium text-slate-600 dark:text-navy-100">Entity Type</span>
                    <select wire:model="shareholders.{{ $index }}.entity_type"
                        class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">
                        <option value="individual">Individual</option>
                        <option value="company">Company</option>
                    </select>
                    @error("shareholders.{$index}.entity_type") <span class="text-error text-sm">{{ $message }}</span>
                    @enderror
                </label>

                <label class="block">
                    <span class="font-medium text-slate-600 dark:text-navy-100">ID Number</span>
                    <input wire:model="shareholders.{{ $index }}.id_number"
                        class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                        placeholder="{{ $shareholders[$index]['entity_type'] === 'individual' ? 'Enter ID number' : 'Enter company registration number' }}"
                        type="text">
                    @error("shareholders.{$index}.id_number") <span class="text-error text-sm">{{ $message }}</span>
                    @enderror
                </label>
            </div>
        </div>
        @endforeach

        <button type="button" wire:click="addShareholder"
            class="btn bg-slate-150 font-medium text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Add Another Shareholder
        </button>
    </div>

    <!-- Beneficial Owners Section -->
    <div class="mb-6">
        <h3 class="text-base font-medium text-slate-700 dark:text-navy-100 mb-3">Beneficial Owners</h3>

        @foreach($beneficial_owners as $index => $owner)
        <div class="p-4 mb-4 border rounded-lg border-slate-200 dark:border-navy-500">
            <div class="flex justify-between items-center mb-3">
                <h4 class="text-sm font-medium text-slate-700 dark:text-navy-100">Beneficial Owner {{ $index + 1 }}</h4>
                @if(count($beneficial_owners) > 1)
                <button type="button" wire:click="removeBeneficialOwner({{ $index }})"
                    class="btn h-7 w-7 rounded-full p-0 text-error hover:bg-error/20 focus:bg-error/20 active:bg-error/25">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                @endif
            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <label class="block">
                    <span class="font-medium text-slate-600 dark:text-navy-100">Full Name</span>
                    <input wire:model="beneficial_owners.{{ $index }}.name"
                        class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                        placeholder="Enter beneficial owner's full name" type="text">
                    @error("beneficial_owners.{$index}.name") <span class="text-error text-sm">{{ $message }}</span>
                    @enderror
                </label>

                <label class="block">
                    <span class="font-medium text-slate-600 dark:text-navy-100">Relationship to Business</span>
                    <input wire:model="beneficial_owners.{{ $index }}.relationship"
                        class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                        placeholder="Enter relationship to business" type="text">
                    @error("beneficial_owners.{$index}.relationship") <span class="text-error text-sm">{{ $message
                        }}</span> @enderror
                </label>
            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 mt-4">
                <label class="block">
                    <span class="font-medium text-slate-600 dark:text-navy-100">Date of Birth</span>
                    <input wire:model="beneficial_owners.{{ $index }}.date_of_birth"
                        class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                        type="date">
                    @error("beneficial_owners.{$index}.date_of_birth") <span class="text-error text-sm">{{ $message
                        }}</span> @enderror
                </label>

                <label class="block">
                    <span class="font-medium text-slate-600 dark:text-navy-100">Nationality</span>
                    <input wire:model="beneficial_owners.{{ $index }}.nationality"
                        class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                        placeholder="Enter nationality" type="text">
                    @error("beneficial_owners.{$index}.nationality") <span class="text-error text-sm">{{ $message
                        }}</span> @enderror
                </label>
            </div>

            <div class="mt-4">
                <label class="block">
                    <span class="font-medium text-slate-600 dark:text-navy-100">ID Number</span>
                    <input wire:model="beneficial_owners.{{ $index }}.id_number"
                        class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                        placeholder="Enter ID number (passport, national ID, etc.)" type="text">
                    @error("beneficial_owners.{$index}.id_number") <span class="text-error text-sm">{{ $message
                        }}</span> @enderror
                </label>
            </div>
        </div>
        @endforeach

        <button type="button" wire:click="addBeneficialOwner"
            class="btn bg-slate-150 font-medium text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Add Another Beneficial Owner
        </button>
    </div>

    <div class="mt-6 flex justify-between">
        <button wire:click="previousStep"
            class="btn border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
            Previous
        </button>
        <button wire:click="nextStep"
            class="btn bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
            Next
        </button>
    </div>
</div>
@endif

<!-- Step 3: Business Operations -->
@if ($currentStep == 3)
<div class="card p-4 sm:p-5">
    <h2 class="text-lg font-medium text-slate-700 dark:text-navy-100 mb-5">
        Business Operations
    </h2>
    <div class="space-y-4">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <label class="block">
                <span class="font-medium text-slate-600 dark:text-navy-100">Industry/Sector</span>
                <input wire:model="industry"
                    class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                    placeholder="Enter your industry or sector" type="text">
                @error('industry') <span class="text-error text-sm">{{ $message }}</span> @enderror
            </label>

            <div class="flex space-x-4">
                <label class="inline-flex items-center space-x-2 mt-5">
                    <input type="checkbox" wire:model="online_presence"
                        class="form-checkbox is-basic h-5 w-5 rounded border-slate-400/70 checked:border-primary checked:bg-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:border-accent dark:checked:bg-accent dark:hover:border-accent dark:focus:border-accent">
                    <span class="font-medium text-slate-600 dark:text-navy-100">Online Presence</span>
                </label>

                <label class="inline-flex items-center space-x-2 mt-5">
                    <input type="checkbox" wire:model="physical_presence"
                        class="form-checkbox is-basic h-5 w-5 rounded border-slate-400/70 checked:border-primary checked:bg-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:border-accent dark:checked:bg-accent dark:hover:border-accent dark:focus:border-accent">
                    <span class="font-medium text-slate-600 dark:text-navy-100">Physical Presence</span>
                </label>
            </div>
        </div>

        <label class="block">
            <span class="font-medium text-slate-600 dark:text-navy-100">Business Description</span>
            <textarea wire:model="business_description"
                class="form-textarea mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                placeholder="Provide a detailed description of your business" rows="3"></textarea>
            @error('business_description') <span class="text-error text-sm">{{ $message }}</span> @enderror
        </label>

        <label class="block">
            <span class="font-medium text-slate-600 dark:text-navy-100">Products/Services Offered</span>
            <textarea wire:model="products_services"
                class="form-textarea mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                placeholder="List the main products or services your business offers" rows="3"></textarea>
            @error('products_services') <span class="text-error text-sm">{{ $message }}</span> @enderror
        </label>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <label class="block">
                <span class="font-medium text-slate-600 dark:text-navy-100">Estimated Monthly Transaction Volume</span>
                <input wire:model="estimated_monthly_volume"
                    class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                    placeholder="Enter estimated monthly transaction volume" type="number" min="0" step="0.01">
                @error('estimated_monthly_volume') <span class="text-error text-sm">{{ $message }}</span> @enderror
            </label>

            <label class="block">
                <span class="font-medium text-slate-600 dark:text-navy-100">Average Transaction Value</span>
                <input wire:model="average_transaction_value"
                    class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                    placeholder="Enter average transaction value" type="number" min="0" step="0.01">
                @error('average_transaction_value') <span class="text-error text-sm">{{ $message }}</span> @enderror
            </label>
        </div>

        <label class="block">
            <span class="font-medium text-slate-600 dark:text-navy-100">Geographical Markets</span>
            <div class="mt-1.5 grid grid-cols-1 gap-4 sm:grid-cols-3">
                <label class="inline-flex items-center space-x-2">
                    <input type="checkbox" wire:model="geographical_markets" value="domestic"
                        class="form-checkbox is-basic h-5 w-5 rounded border-slate-400/70 checked:border-primary checked:bg-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:border-accent dark:checked:bg-accent dark:hover:border-accent dark:focus:border-accent">
                    <span class="font-medium text-slate-600 dark:text-navy-100">Domestic</span>
                </label>

                <label class="inline-flex items-center space-x-2">
                    <input type="checkbox" wire:model="geographical_markets" value="regional"
                        class="form-checkbox is-basic h-5 w-5 rounded border-slate-400/70 checked:border-primary checked:bg-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:border-accent dark:checked:bg-accent dark:hover:border-accent dark:focus:border-accent">
                    <span class="font-medium text-slate-600 dark:text-navy-100">Regional</span>
                </label>

                <label class="inline-flex items-center space-x-2">
                    <input type="checkbox" wire:model="geographical_markets" value="international"
                        class="form-checkbox is-basic h-5 w-5 rounded border-slate-400/70 checked:border-primary checked:bg-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:border-accent dark:checked:bg-accent dark:hover:border-accent dark:focus:border-accent">
                    <span class="font-medium text-slate-600 dark:text-navy-100">International</span>
                </label>
            </div>
            @error('geographical_markets') <span class="text-error text-sm">{{ $message }}</span> @enderror
        </label>

        <label class="block">
            <span class="font-medium text-slate-600 dark:text-navy-100">Customer Base</span>
            <textarea wire:model="customer_base"
                class="form-textarea mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                placeholder="Describe your primary customer base (e.g., B2B, B2C, demographics)" rows="2"></textarea>
            @error('customer_base') <span class="text-error text-sm">{{ $message }}</span> @enderror
        </label>
    </div>

    <div class="mt-6 flex justify-between">
        <button wire:click="previousStep"
            class="btn border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
            Previous
        </button>
        <button wire:click="nextStep"
            class="btn bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
            Next
        </button>
    </div>
</div>
@endif

<!-- Step 4: Financial Information -->
@if ($currentStep == 4)
<div class="card p-4 sm:p-5">
    <h2 class="text-lg font-medium text-slate-700 dark:text-navy-100 mb-5">
        Financial Information
    </h2>
    <div class="space-y-4">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <label class="block">
                <span class="font-medium text-slate-600 dark:text-navy-100">Bank Name</span>
                <input wire:model="bank_name"
                    class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                    placeholder="Enter bank name" type="text">
                @error('bank_name') <span class="text-error text-sm">{{ $message }}</span> @enderror
            </label>

            <label class="block">
                <span class="font-medium text-slate-600 dark:text-navy-100">Bank Account Number</span>
                <input wire:model="bank_account_number"
                    class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                    placeholder="Enter bank account number" type="text">
                @error('bank_account_number') <span class="text-error text-sm">{{ $message }}</span> @enderror
            </label>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <label class="block">
                <span class="font-medium text-slate-600 dark:text-navy-100">Bank Routing Number</span>
                <input wire:model="bank_routing_number"
                    class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                    placeholder="Enter bank routing number" type="text">
                @error('bank_routing_number') <span class="text-error text-sm">{{ $message }}</span> @enderror
            </label>

            <label class="block">
                <span class="font-medium text-slate-600 dark:text-navy-100">Annual Revenue</span>
                <input wire:model="annual_revenue"
                    class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                    placeholder="Enter annual revenue" type="number" min="0" step="0.01">
                @error('annual_revenue') <span class="text-error text-sm">{{ $message }}</span> @enderror
            </label>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <label class="block">
                <span class="font-medium text-slate-600 dark:text-navy-100">Financial Statement Date</span>
                <input wire:model="financial_statement_date"
                    class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                    type="date">
                @error('financial_statement_date') <span class="text-error text-sm">{{ $message }}</span> @enderror
            </label>

            <label class="block">
                <span class="font-medium text-slate-600 dark:text-navy-100">Previous Year Revenue</span>
                <input wire:model="previous_year_revenue"
                    class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                    placeholder="Enter previous year revenue" type="number" min="0" step="0.01">
                @error('previous_year_revenue') <span class="text-error text-sm">{{ $message }}</span> @enderror
            </label>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <label class="block">
                <span class="font-medium text-slate-600 dark:text-navy-100">Current Assets</span>
                <input wire:model="current_assets"
                    class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                    placeholder="Enter current assets value" type="number" min="0" step="0.01">
                @error('current_assets') <span class="text-error text-sm">{{ $message }}</span> @enderror
            </label>

            <label class="block">
                <span class="font-medium text-slate-600 dark:text-navy-100">Total Liabilities</span>
                <input wire:model="total_liabilities"
                    class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                    placeholder="Enter total liabilities" type="number" min="0" step="0.01">
                @error('total_liabilities') <span class="text-error text-sm">{{ $message }}</span> @enderror
            </label>
        </div>
    </div>

    <div class="mt-6 flex justify-between">
        <button wire:click="previousStep"
            class="btn border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
            Previous
        </button>
        <button wire:click="nextStep"
            class="btn bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
            Next
        </button>
    </div>
</div>
@endif

<!-- Step 5: Compliance Information -->
@if ($currentStep == 5)
<div class="card p-4 sm:p-5">
    <h2 class="text-lg font-medium text-slate-700 dark:text-navy-100 mb-5">
        Compliance Information
    </h2>
    <div class="space-y-4">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <label class="inline-flex items-center space-x-2">
                <input type="checkbox" wire:model="has_aml_policy"
                    class="form-checkbox is-basic h-5 w-5 rounded border-slate-400/70 checked:border-primary checked:bg-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:border-accent dark:checked:bg-accent dark:hover:border-accent dark:focus:border-accent">
                <span class="font-medium text-slate-600 dark:text-navy-100">Has Anti-Money Laundering (AML)
                    Policy</span>
            </label>

            <label class="inline-flex items-center space-x-2">
                <input type="checkbox" wire:model="has_sanctions_screening"
                    class="form-checkbox is-basic h-5 w-5 rounded border-slate-400/70 checked:border-primary checked:bg-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:border-accent dark:checked:bg-accent dark:hover:border-accent dark:focus:border-accent">
                <span class="font-medium text-slate-600 dark:text-navy-100">Conducts Sanctions Screening</span>
            </label>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <label class="inline-flex items-center space-x-2">
                <input type="checkbox" wire:model="has_compliance_officer"
                    class="form-checkbox is-basic h-5 w-5 rounded border-slate-400/70 checked:border-primary checked:bg-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:border-accent dark:checked:bg-accent dark:hover:border-accent dark:focus:border-accent">
                <span class="font-medium text-slate-600 dark:text-navy-100">Has Compliance Officer</span>
            </label>

            <label class="inline-flex items-center space-x-2">
                <input type="checkbox" wire:model="is_regulated_entity"
                    class="form-checkbox is-basic h-5 w-5 rounded border-slate-400/70 checked:border-primary checked:bg-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:border-accent dark:checked:bg-accent dark:hover:border-accent dark:focus:border-accent">
                <span class="font-medium text-slate-600 dark:text-navy-100">Is a Regulated Entity</span>
            </label>
        </div>

        @if($has_compliance_officer)
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <label class="block">
                <span class="font-medium text-slate-600 dark:text-navy-100">Compliance Officer Name</span>
                <input wire:model="compliance_officer_name"
                    class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                    placeholder="Enter compliance officer name" type="text">
                @error('compliance_officer_name') <span class="text-error text-sm">{{ $message }}</span> @enderror
            </label>

            <label class="block">
                <span class="font-medium text-slate-600 dark:text-navy-100">Compliance Officer Email</span>
                <input wire:model="compliance_officer_email"
                    class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                    placeholder="Enter compliance officer email" type="email">
                @error('compliance_officer_email') <span class="text-error text-sm">{{ $message }}</span> @enderror
            </label>
        </div>
        @endif

        @if($is_regulated_entity)
        <label class="block">
            <span class="font-medium text-slate-600 dark:text-navy-100">Regulator Name</span>
            <input wire:model="regulator_name"
                class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                placeholder="Enter regulator name" type="text">
            @error('regulator_name') <span class="text-error text-sm">{{ $message }}</span> @enderror
        </label>
        @endif

        <div class="grid grid-cols-1 gap-4">
            <label class="inline-flex items-center space-x-2">
                <input type="checkbox" wire:model="has_previous_violations"
                    class="form-checkbox is-basic h-5 w-5 rounded border-slate-400/70 checked:border-primary checked:bg-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:border-accent dark:checked:bg-accent dark:hover:border-accent dark:focus:border-accent">
                <span class="font-medium text-slate-600 dark:text-navy-100">Has Previous Compliance Violations</span>
            </label>

            @if($has_previous_violations)
            <label class="block">
                <span class="font-medium text-slate-600 dark:text-navy-100">Previous Violations Details</span>
                <textarea wire:model="previous_violations_details"
                    class="form-textarea mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                    placeholder="Provide details about previous compliance violations" rows="3"></textarea>
                @error('previous_violations_details') <span class="text-error text-sm">{{ $message }}</span> @enderror
            </label>
            @endif
        </div>

        <label class="block">
            <span class="font-medium text-slate-600 dark:text-navy-100">Regulatory Licenses (if any)</span>
            <div class="mt-1.5 grid grid-cols-1 gap-4 sm:grid-cols-3">
                <label class="inline-flex items-center space-x-2">
                    <input type="checkbox" wire:model="regulatory_licenses" value="financial_services"
                        class="form-checkbox is-basic h-5 w-5 rounded border-slate-400/70 checked:border-primary checked:bg-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:border-accent dark:checked:bg-accent dark:hover:border-accent dark:focus:border-accent">
                    <span class="font-medium text-slate-600 dark:text-navy-100">Financial Services</span>
                </label>

                <label class="inline-flex items-center space-x-2">
                    <input type="checkbox" wire:model="regulatory_licenses" value="money_transmitter"
                        class="form-checkbox is-basic h-5 w-5 rounded border-slate-400/70 checked:border-primary checked:bg-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:border-accent dark:checked:bg-accent dark:hover:border-accent dark:focus:border-accent">
                    <span class="font-medium text-slate-600 dark:text-navy-100">Money Transmitter</span>
                </label>

                <label class="inline-flex items-center space-x-2">
                    <input type="checkbox" wire:model="regulatory_licenses" value="payment_processor"
                        class="form-checkbox is-basic h-5 w-5 rounded border-slate-400/70 checked:border-primary checked:bg-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:border-accent dark:checked:bg-accent dark:hover:border-accent dark:focus:border-accent">
                    <span class="font-medium text-slate-600 dark:text-navy-100">Payment Processor</span>
                </label>

                <label class="inline-flex items-center space-x-2">
                    <input type="checkbox" wire:model="regulatory_licenses" value="banking"
                        class="form-checkbox is-basic h-5 w-5 rounded border-slate-400/70 checked:border-primary checked:bg-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:border-accent dark:checked:bg-accent dark:hover:border-accent dark:focus:border-accent">
                    <span class="font-medium text-slate-600 dark:text-navy-100">Banking</span>
                </label>

                <label class="inline-flex items-center space-x-2">
                    <input type="checkbox" wire:model="regulatory_licenses" value="insurance"
                        class="form-checkbox is-basic h-5 w-5 rounded border-slate-400/70 checked:border-primary checked:bg-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:border-accent dark:checked:bg-accent dark:hover:border-accent dark:focus:border-accent">
                    <span class="font-medium text-slate-600 dark:text-navy-100">Insurance</span>
                </label>

                <label class="inline-flex items-center space-x-2">
                    <input type="checkbox" wire:model="regulatory_licenses" value="other"
                        class="form-checkbox is-basic h-5 w-5 rounded border-slate-400/70 checked:border-primary checked:bg-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:border-accent dark:checked:bg-accent dark:hover:border-accent dark:focus:border-accent">
                    <span class="font-medium text-slate-600 dark:text-navy-100">Other</span>
                </label>
            </div>
        </label>
    </div>

    <div class="mt-6 flex justify-between">
        <button wire:click="previousStep"
            class="btn border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
            Previous
        </button>
        <button wire:click="nextStep"
            class="btn bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
            Next
        </button>
    </div>
</div>
@endif

<!-- Step 6: Document Upload -->
@if ($currentStep == 6)
<div class="card p-4 sm:p-5">
    <h2 class="text-lg font-medium text-slate-700 dark:text-navy-100 mb-5">
        Document Upload
    </h2>
    <div class="space-y-6">
        <!-- Business Registration Document -->
        <div>
            <span class="font-medium text-slate-600 dark:text-navy-100">Business Registration Certificate</span>
            <div class="mt-1.5 flex flex-col">
                @if ($business_registration_doc)
                <div class="relative">
                    @if(in_array(strtolower($business_registration_doc->getClientOriginalExtension()), ['jpg', 'jpeg',
                    'png', 'gif']))
                    <img src="{{ $business_registration_doc->temporaryUrl() }}"
                        class="h-48 w-auto object-cover rounded-lg border border-slate-300 dark:border-navy-450">
                    @else
                    <div
                        class="h-48 flex items-center justify-center rounded-lg border border-slate-300 dark:border-navy-450 bg-slate-50 dark:bg-navy-600">
                        <div class="flex flex-col items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-primary dark:text-accent"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span class="mt-2 text-sm font-medium text-slate-600 dark:text-navy-100">{{
                                $business_registration_doc->getClientOriginalName() }}</span>
                        </div>
                    </div>
                    @endif
                    <button wire:click="deleteDocument('business_registration_doc')"
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
                    <input type="file" wire:model="business_registration_doc" class="hidden">
                    <span>Upload Business Registration Certificate</span>
                </label>
                @endif
                @error('business_registration_doc') <span class="text-error text-sm">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Proof of Address Document -->
        <div>
            <span class="font-medium text-slate-600 dark:text-navy-100">Proof of Business Address</span>
            <div class="mt-1.5 flex flex-col">
                @if ($proof_of_address_doc)
                <div class="relative">
                    @if(in_array(strtolower($proof_of_address_doc->getClientOriginalExtension()), ['jpg', 'jpeg', 'png',
                    'gif']))
                    <img src="{{ $proof_of_address_doc->temporaryUrl() }}"
                        class="h-48 w-auto object-cover rounded-lg border border-slate-300 dark:border-navy-450">
                    @else
                    <div
                        class="h-48 flex items-center justify-center rounded-lg border border-slate-300 dark:border-navy-450 bg-slate-50 dark:bg-navy-600">
                        <div class="flex flex-col items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-primary dark:text-accent"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span class="mt-2 text-sm font-medium text-slate-600 dark:text-navy-100">{{
                                $proof_of_address_doc->getClientOriginalName() }}</span>
                        </div>
                    </div>
                    @endif
                    <button wire:click="deleteDocument('proof_of_address_doc')"
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
                    <input type="file" wire:model="proof_of_address_doc" class="hidden">
                    <span>Upload Proof of Address</span>
                </label>
                @endif
                @error('proof_of_address_doc') <span class="text-error text-sm">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Financial Statements Document -->
        <div>
            <span class="font-medium text-slate-600 dark:text-navy-100">Financial Statements</span>
            <div class="mt-1.5 flex flex-col">
                @if ($financial_statements_doc)
                <div class="relative">
                    @if(in_array(strtolower($financial_statements_doc->getClientOriginalExtension()), ['jpg', 'jpeg',
                    'png', 'gif']))
                    <img src="{{ $financial_statements_doc->temporaryUrl() }}"
                        class="h-48 w-auto object-cover rounded-lg border border-slate-300 dark:border-navy-450">
                    @else
                    <div
                        class="h-48 flex items-center justify-center rounded-lg border border-slate-300 dark:border-navy-450 bg-slate-50 dark:bg-navy-600">
                        <div class="flex flex-col items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-primary dark:text-accent"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span class="mt-2 text-sm font-medium text-slate-600 dark:text-navy-100">{{
                                $financial_statements_doc->getClientOriginalName() }}</span>
                        </div>
                    </div>
                    @endif
                    <button wire:click="deleteDocument('financial_statements_doc')"
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
                    <input type="file" wire:model="financial_statements_doc" class="hidden">
                    <span>Upload Financial Statements</span>
                </label>
                @endif
                @error('financial_statements_doc') <span class="text-error text-sm">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Ownership Structure Document -->
        <div>
            <span class="font-medium text-slate-600 dark:text-navy-100">Ownership Structure Document</span>
            <div class="mt-1.5 flex flex-col">
                @if ($ownership_structure_doc)
                <div class="relative">
                    @if(in_array(strtolower($ownership_structure_doc->getClientOriginalExtension()), ['jpg', 'jpeg',
                    'png', 'gif']))
                    <img src="{{ $ownership_structure_doc->temporaryUrl() }}"
                        class="h-48 w-auto object-cover rounded-lg border border-slate-300 dark:border-navy-450">
                    @else
                    <div
                        class="h-48 flex items-center justify-center rounded-lg border border-slate-300 dark:border-navy-450 bg-slate-50 dark:bg-navy-600">
                        <div class="flex flex-col items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-primary dark:text-accent"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span class="mt-2 text-sm font-medium text-slate-600 dark:text-navy-100">{{
                                $ownership_structure_doc->getClientOriginalName() }}</span>
                        </div>
                    </div>
                    @endif
                    <button wire:click="deleteDocument('ownership_structure_doc')"
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
                    <input type="file" wire:model="ownership_structure_doc" class="hidden">
                    <span>Upload Ownership Structure Document</span>
                </label>
                @endif
                @error('ownership_structure_doc') <span class="text-error text-sm">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Compliance Policy Document (if applicable) -->
        @if($has_aml_policy)
        <div>
            <span class="font-medium text-slate-600 dark:text-navy-100">Compliance Policy Document</span>
            <div class="mt-1.5 flex flex-col">
                @if ($compliance_policy_doc)
                <div class="relative">
                    @if(in_array(strtolower($compliance_policy_doc->getClientOriginalExtension()), ['jpg', 'jpeg',
                    'png', 'gif']))
                    <img src="{{ $compliance_policy_doc->temporaryUrl() }}"
                        class="h-48 w-auto object-cover rounded-lg border border-slate-300 dark:border-navy-450">
                    @else
                    <div
                        class="h-48 flex items-center justify-center rounded-lg border border-slate-300 dark:border-navy-450 bg-slate-50 dark:bg-navy-600">
                        <div class="flex flex-col items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-primary dark:text-accent"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span class="mt-2 text-sm font-medium text-slate-600 dark:text-navy-100">{{
                                $compliance_policy_doc->getClientOriginalName() }}</span>
                        </div>
                    </div>
                    @endif
                    <button wire:click="deleteDocument('compliance_policy_doc')"
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
                    <input type="file" wire:model="compliance_policy_doc" class="hidden">
                    <span>Upload Compliance Policy Document</span>
                </label>
                @endif
                @error('compliance_policy_doc') <span class="text-error text-sm">{{ $message }}</span> @enderror
            </div>
        </div>
        @endif
    </div>

    <div class="mt-6 flex justify-between">
        <button wire:click="previousStep"
            class="btn border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
            Previous
        </button>
        <button wire:click="submit"
            class="btn bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
            Submit Application
        </button>
    </div>
</div>
@endif
</div>
