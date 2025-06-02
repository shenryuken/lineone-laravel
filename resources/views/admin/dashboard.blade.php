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
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        <div class="mt-4 sm:mt-5 md:mt-6">
            <div
                class="flex flex-col sm:flex-row sm:items-center justify-between space-y-2 sm:space-y-0 pb-5 border-b border-slate-200 dark:border-navy-500">
                <div>
                    <h2 class="text-xl font-medium text-slate-700 dark:text-navy-50">
                        Welcome back, {{ auth()->user()->name }}
                    </h2>
                    <p class="mt-1 text-sm text-slate-500 dark:text-navy-300">
                        Here's what's happening today
                    </p>
                </div>
            </div>
        </div>
        <livewire:admin.dashboard />
    </main>
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    @endpush
</x-app-layout-sideblock>
