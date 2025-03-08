<x-app-layout-sideblock>
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Upload Additional Documents') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="card p-4 sm:p-5 mb-6">
                        <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100 mb-4">
                            Additional Information Requested
                        </h3>
                        <div class="p-4 bg-info/10 text-info rounded-lg mb-6">
                            <p>{{ $kyb->additional_info_requested }}</p>
                        </div>

                        <livewire:kyb.upload-additional-documents :kyb="$kyb" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    </main>
</x-app-layout-sideblock>
