<div>
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-medium text-slate-700 dark:text-navy-100">
            {{ $isEditing ? 'Edit Bank' : 'Add New Bank' }}
        </h2>
        <a href="{{ route('admin.banks.index') }}"
            class="btn border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
            </svg>
            Back to List
        </a>
    </div>

    <div class="card p-4 sm:p-5">
        <form wire:submit.prevent="save">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <!-- Bank Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700 dark:text-navy-100 mb-1">Bank Name
                        <span class="text-error">*</span></label>
                    <input type="text" id="name" wire:model="name"
                        class="form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                        placeholder="Enter bank name">
                    @error('name') <span class="text-error text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Bank Code -->
                <div>
                    <label for="code" class="block text-sm font-medium text-slate-700 dark:text-navy-100 mb-1">Bank
                        Code</label>
                    <input type="text" id="code" wire:model="code"
                        class="form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                        placeholder="Enter bank code">
                    @error('code') <span class="text-error text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- SWIFT Code -->
                <div>
                    <label for="swift_code"
                        class="block text-sm font-medium text-slate-700 dark:text-navy-100 mb-1">SWIFT Code</label>
                    <input type="text" id="swift_code" wire:model="swift_code"
                        class="form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                        placeholder="Enter SWIFT code">
                    @error('swift_code') <span class="text-error text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Bank Type -->
                <div>
                    <label for="type" class="block text-sm font-medium text-slate-700 dark:text-navy-100 mb-1">Bank Type
                        <span class="text-error">*</span></label>
                    <select id="type" wire:model="type"
                        class="form-select w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent">
                        <option value="local">Local</option>
                        <option value="international">International</option>
                    </select>
                    @error('type') <span class="text-error text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Country Selection -->
                <div>
                    <label for="country_code"
                        class="block text-sm font-medium text-slate-700 dark:text-navy-100 mb-1">Country <span
                            class="text-error">*</span></label>
                    <select id="country_code" wire:model.live="country_code"
                        class="form-select w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent">
                        <option value="">Select a country</option>
                        @foreach($countries as $country)
                        <option value="{{ $country['code'] }}">{{ $country['name'] }} ({{ $country['code'] }})</option>
                        @endforeach
                    </select>
                    @error('country_code') <span class="text-error text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Country Name (Hidden) -->
                <div class="hidden">
                    <input type="hidden" id="country_name" wire:model="country_name">
                    @error('country_name') <span class="text-error text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Bank Logo -->
                <div class="sm:col-span-2 lg:col-span-3">
                    <label for="logo" class="block text-sm font-medium text-slate-700 dark:text-navy-100 mb-1">Bank
                        Logo</label>
                    <div class="flex items-center space-x-4">
                        @if($existing_logo)
                        <div class="avatar h-20 w-20">
                            <img class="rounded-lg" src="{{ Storage::url($existing_logo) }}" alt="{{ $name }}" />
                        </div>
                        @endif
                        <div class="flex-1">
                            <input type="file" id="logo" wire:model="logo"
                                class="form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                accept="image/*">
                            <p class="mt-1 text-xs text-slate-400 dark:text-navy-300">
                                Upload a bank logo (max 1MB). Recommended size: 200x200px.
                            </p>
                        </div>
                    </div>
                    @error('logo') <span class="text-error text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Description -->
                <div class="sm:col-span-2 lg:col-span-3">
                    <label for="description"
                        class="block text-sm font-medium text-slate-700 dark:text-navy-100 mb-1">Description</label>
                    <textarea id="description" wire:model="description" rows="3"
                        class="form-textarea w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                        placeholder="Enter bank description"></textarea>
                    @error('description') <span class="text-error text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Supported Currencies -->
                <div class="sm:col-span-2 lg:col-span-3">
                    <label class="block text-sm font-medium text-slate-700 dark:text-navy-100 mb-1">Supported Currencies
                        <span class="text-error">*</span></label>
                    <div class="flex flex-wrap gap-2 mb-2">
                        @foreach($supported_currencies as $index => $currency)
                        <div class="badge bg-primary/10 text-primary dark:bg-accent/10 dark:text-accent p-0 h-7">
                            <span class="px-2">{{ $currency }}</span>
                            <button type="button" wire:click="removeCurrency({{ $index }})"
                                class="flex h-7 w-7 items-center justify-center rounded-r-full hover:bg-primary/20 dark:hover:bg-accent/20">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        @endforeach
                    </div>
                    <div class="flex space-x-2">
                        <div class="flex-1">
                            <select wire:model="currency"
                                class="form-select w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent">
                                <option value="">Select currency</option>
                                @foreach($commonCurrencies as $code => $name)
                                <option value="{{ $code }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="button" wire:click="addCurrency"
                            class="btn bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                            Add
                        </button>
                    </div>
                    <p class="mt-1 text-xs text-slate-400 dark:text-navy-300">
                        Add all currencies supported by this bank.
                    </p>
                    @error('supported_currencies') <span class="text-error text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Additional Metadata -->
                <div class="sm:col-span-2 lg:col-span-3">
                    <label class="block text-sm font-medium text-slate-700 dark:text-navy-100 mb-1">Additional
                        Information</label>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left mb-2">
                            <thead>
                                <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                    <th
                                        class="whitespace-nowrap px-3 py-2 font-semibold text-slate-800 dark:text-navy-100">
                                        Key</th>
                                    <th
                                        class="whitespace-nowrap px-3 py-2 font-semibold text-slate-800 dark:text-navy-100">
                                        Value</th>
                                    <th
                                        class="whitespace-nowrap px-3 py-2 font-semibold text-slate-800 dark:text-navy-100 w-20">
                                        Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($metadata as $key => $value)
                                <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                    <td class="whitespace-nowrap px-3 py-2">{{ $key }}</td>
                                    <td class="whitespace-nowrap px-3 py-2">{{ $value }}</td>
                                    <td class="whitespace-nowrap px-3 py-2">
                                        <button type="button" wire:click="removeMetadata('{{ $key }}')"
                                            class="btn h-8 w-8 p-0 text-error hover:bg-error/20 focus:bg-error/20 active:bg-error/25">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3"
                                        class="px-3 py-2 text-center text-sm text-slate-500 dark:text-navy-200">
                                        No additional information added yet.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="flex space-x-2">
                        <input type="text" wire:model="metadataKey"
                            class="form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                            placeholder="Key (e.g., routing_number)">
                        <input type="text" wire:model="metadataValue"
                            class="form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                            placeholder="Value">
                        <button type="button" wire:click="addMetadata"
                            class="btn bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                            Add
                        </button>
                    </div>
                    <p class="mt-1 text-xs text-slate-400 dark:text-navy-300">
                        Add any additional information about the bank (e.g., routing numbers, branch codes, etc.)
                    </p>
                </div>

                <!-- Status -->
                <div class="sm:col-span-2 lg:col-span-3">
                    <label class="inline-flex items-center space-x-2">
                        <input type="checkbox" wire:model="is_active"
                            class="form-checkbox is-basic h-5 w-5 rounded border-slate-400/70 checked:border-primary checked:bg-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:border-accent dark:checked:bg-accent dark:hover:border-accent dark:focus:border-accent">
                        <span class="text-sm font-medium text-slate-700 dark:text-navy-100">Active</span>
                    </label>
                    <p class="mt-1 text-xs text-slate-400 dark:text-navy-300">
                        Inactive banks will not be shown to users.
                    </p>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('admin.banks.index') }}"
                    class="btn min-w-[7rem] border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                    Cancel
                </a>
                <button type="submit"
                    class="btn min-w-[7rem] bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                    {{ $isEditing ? 'Update' : 'Save' }}
                </button>
            </div>
        </form>
    </div>
</div>
