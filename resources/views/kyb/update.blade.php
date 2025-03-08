<x-app-layout-sideblock>
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Update KYB Application') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <livewire:kyb.update-application :kyb="$kyb" />
                </div>
            </div>
        </div>
    </div>
    </main>
</x-app-layout-sideblock>
