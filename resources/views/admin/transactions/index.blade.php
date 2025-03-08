<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-xl font-medium text-slate-800 dark:text-navy-50">
                {{ __('Transactions') }}
            </h2>
            <div class="mt-3 sm:mt-0 flex items-center space-x-2">
                <span class="text-xs+ text-slate-400 dark:text-navy-300">
                    {{ __('Manage all transactions') }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 gap-4 sm:gap-5 lg:gap-6">
        <div>
            @livewire('admin.transactions.index')
        </div>
    </div>
</x-app-layout>
