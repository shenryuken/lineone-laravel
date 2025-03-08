<x-app-layout-sideblock title="Transactions Index" is-header-blur="true">
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

    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        @livewire('admin.transactions.index')
    </main>
</x-app-layout-sideblock>
