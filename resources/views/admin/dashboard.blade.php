<x-app-layout-sideblock title="CRM Analytics Dashboard" is-header-blur="true">
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-xl font-medium text-slate-800 dark:text-navy-50">
                {{ __('Admin Dashboard') }}
            </h2>
            <div class="mt-3 sm:mt-0 flex items-center space-x-2">
                <span class="text-xs+ text-slate-400 dark:text-navy-300">
                    {{ __('Welcome back') }}, {{ auth()->user()->name }}
                </span>
            </div>
        </div>
    </x-slot>
    <!-- Main Content Wrapper -->
    <main class="main-content w-full pb-8">
        <livewire:admin.dashboard />
    </main>
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    @endpush
</x-app-layout-sideblock>
