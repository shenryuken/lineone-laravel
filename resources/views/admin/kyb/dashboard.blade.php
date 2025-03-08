<x-app-layout-sideblock>
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-xl font-medium text-slate-800 dark:text-navy-50">
                {{ __('KYB Dashboard') }}
            </h2>
            <div class="mt-3 sm:mt-0 flex items-center space-x-2">
                <span class="text-xs+ text-slate-400 dark:text-navy-300">
                    {{ __('Analytics and metrics for KYB applications') }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 gap-4 sm:gap-5 lg:gap-6">
        <div>
            @livewire('admin.kyb.kyb-dashboard')
        </div>
    </div>
    </main>
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    @endpush
</x-app-layout-sideblock>
