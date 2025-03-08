<div>
    <button wire:click="openExportModal"
        class="btn bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
        </svg>
        {{ __('Export Data') }}
    </button>

    <!-- Export Modal -->
    <div x-data="{ shown: @entangle('exportModalOpen') }" x-show="shown"
        x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
        style="display: none;">
        <div x-show="shown" x-transition:enter="transition ease-out duration-150"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95" @click.outside="shown = false"
            class="relative w-full max-w-lg rounded-lg bg-white px-4 py-10 text-center dark:bg-navy-700 sm:px-5"
            style="display: none;">
            <div class="mt-4 px-4 sm:px-12">
                <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100">
                    {{ __('Export KYB Data') }}
                </h3>
                <p class="mt-2 text-slate-500 dark:text-navy-200">
                    {{ __('Set your export preferences and download the data.') }}
                </p>

                <form wire:submit.prevent="exportData" class="mt-6 space-y-4">
                    <div>
                        <label class="block">
                            <span class="text-left block mb-1 text-slate-700 dark:text-navy-100">{{ __('Export Format')
                                }}</span>
                            <select wire:model="exportFormat"
                                class="form-select w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">
                                <option value="csv">CSV</option>
                                <option value="json">JSON</option>
                            </select>
                        </label>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block">
                                <span class="text-left block mb-1 text-slate-700 dark:text-navy-100">{{ __('Date From')
                                    }}</span>
                                <input wire:model="dateFrom" type="date"
                                    class="form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent" />
                            </label>
                            @error('dateFrom') <span class=" text-tiny+ text-error">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block">
                                <span class="text-left block mb-1 text-slate-700 dark:text-navy-100">{{ __('Date To')
                                    }}</span>
                                <input wire:model="dateTo" type="date"
                                    class="form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent" />
                            </label>
                            @error('dateTo') <span class="text-tiny+ text-error">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block">
                            <span class="text-left block mb-1 text-slate-700 dark:text-navy-100">{{ __('Status Filter')
                                }}</span>
                            <div class="flex flex-wrap gap-2 mt-1">
                                <label class="inline-flex items-center space-x-2">
                                    <input type="checkbox" wire:model="statusFilter" value="pending"
                                        class="form-checkbox is-outline h-5 w-5 rounded border-slate-400/70 before:bg-primary checked:border-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:before:bg-accent dark:checked:border-accent dark:hover:border-accent dark:focus:border-accent">
                                    <span>{{ __('Pending') }}</span>
                                </label>
                                <label class="inline-flex items-center space-x-2">
                                    <input type="checkbox" wire:model="statusFilter" value="approved"
                                        class="form-checkbox is-outline h-5 w-5 rounded border-slate-400/70 before:bg-primary checked:border-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:before:bg-accent dark:checked:border-accent dark:hover:border-accent dark:focus:border-accent">
                                    <span>{{ __('Approved') }}</span>
                                </label>
                                <label class="inline-flex items-center space-x-2">
                                    <input type="checkbox" wire:model="statusFilter" value="rejected"
                                        class="form-checkbox is-outline h-5 w-5 rounded border-slate-400/70 before:bg-primary checked:border-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:before:bg-accent dark:checked:border-accent dark:hover:border-accent dark:focus:border-accent">
                                    <span>{{ __('Rejected') }}</span>
                                </label>
                                <label class="inline-flex items-center space-x-2">
                                    <input type="checkbox" wire:model="statusFilter" value="additional_info"
                                        class="form-checkbox is-outline h-5 w-5 rounded border-slate-400/70 before:bg-primary checked:border-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:before:bg-accent dark:checked:border-accent dark:hover:border-accent dark:focus:border-accent">
                                    <span>{{ __('Additional Info') }}</span>
                                </label>
                            </div>
                            @error('statusFilter') <span class="text-tiny+ text-error">{{ $message }}</span> @enderror
                    </div>
            </div>

            <div class="mt-6 space-x-3">
                <button type="submit"
                    class="btn min-w-[7rem] bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                    {{ __('Export') }}
                </button>
                <button type="button" wire:click="$set('exportModalOpen', false)"
                    class="btn min-w-[7rem] border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                    {{ __('Cancel') }}
                </button>
            </div>
            </form>
        </div>
    </div>

</div>
