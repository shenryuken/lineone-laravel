<div>
    <!-- Bulk Actions Toolbar -->
    <div class="card p-4 sm:p-5 mb-5">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between">
            <div class="mb-4 sm:mb-0 flex items-center space-x-2">
                <label class="inline-flex items-center">
                    <input wire:model="selectAll" type="checkbox"
                        class="form-checkbox rounded border-slate-400/70 checked:bg-primary checked:border-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:bg-accent dark:checked:border-accent dark:hover:border-accent dark:focus:border-accent">
                    <span class="ml-2 text-slate-700 dark:text-navy-100">{{ __('Select All') }}</span>
                </label>
                <span class="text-xs+ text-slate-400 dark:text-navy-300">
                    {{ $selectedCount }} {{ __('selected') }}
                </span>
            </div>
            <div class="flex flex-wrap items-center space-x-2">
                <button wire:click="confirmBulkAction('approved')" @class([ 'btn font-medium'
                    , 'bg-success text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90'=>
                    $selectedCount > 0,
                    'bg-success/50 text-white cursor-not-allowed' => $selectedCount == 0
                    ])
                    @if($selectedCount == 0) disabled @endif
                    >
                    {{ __('Approve Selected') }}
                </button>
                <button wire:click="confirmBulkAction('rejected')" @class([ 'btn font-medium'
                    , 'bg-error text-white hover:bg-error-focus focus:bg-error-focus active:bg-error-focus/90'=>
                    $selectedCount > 0,
                    'bg-error/50 text-white cursor-not-allowed' => $selectedCount == 0
                    ])
                    @if($selectedCount == 0) disabled @endif
                    >
                    {{ __('Reject Selected') }}
                </button>
            </div>
        </div>
    </div>

    <!-- Bulk Action Modal -->
    <div x-data="{ shown: @entangle('bulkModalOpen') }" x-show="shown"
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
                <h3 class="text-lg font-medium @if($bulkAction === 'approved') text-success @else text-error @endif">
                    @if($bulkAction === 'approved')
                    {{ __('Approve Selected Applications') }}
                    @else
                    {{ __('Reject Selected Applications') }}
                    @endif
                </h3>
                <p class="mt-2 text-slate-500 dark:text-navy-200">
                    {{ __('You are about to :action :count applications. Are you sure?', [
                    'action' => $bulkAction === 'approved' ? 'approve' : 'reject',
                    'count' => $selectedCount
                    ]) }}
                </p>

                @if($bulkAction === 'rejected')
                <div class="mt-4">
                    <label class="block">
                        <span class="text-slate-700 dark:text-navy-100">{{ __('Rejection Reason') }}</span>
                        <textarea wire:model.defer="comment"
                            class="form-textarea mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent p-2.5 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                            placeholder="{{ __('Enter a reason for rejection...') }}" rows="3"></textarea>
                    </label>
                </div>
                @else
                <div class="mt-4">
                    <label class="block">
                        <span class="text-slate-700 dark:text-navy-100">{{ __('Comment (Optional)') }}</span>
                        <textarea wire:model.defer="comment"
                            class="form-textarea mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent p-2.5 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                            placeholder="{{ __('Enter an optional comment...') }}" rows="3"></textarea>
                    </label>
                </div>
                @endif
            </div>
            <div class="mt-6 space-x-3">
                <button wire:click="executeBulkAction"
                    class="btn min-w-[7rem] @if($bulkAction === 'approved') bg-success @else bg-error @endif font-medium text-white hover:bg-opacity-80 focus:bg-opacity-80 active:bg-opacity-90">
                    {{ __('Confirm') }}
                </button>
                <button wire:click="resetForm"
                    class="btn min-w-[7rem] border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                    {{ __('Cancel') }}
                </button>
            </div>
        </div>
    </div>
</div>
