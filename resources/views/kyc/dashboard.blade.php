<x-app-layout-sideblock title="Kyc Dashboard" is-header-blur="true">
    <div class="main-content">
        <div class="px-[var(--margin-x)] transition-all duration-[.25s] pb-8 pt-6">
            <div class="flex items-center space-x-4 py-5 lg:py-6">
                <h2 class="text-xl font-medium text-slate-800 dark:text-navy-50 lg:text-2xl">
                    KYC Verification Dashboard
                </h2>
            </div>
            <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
                <div class="col-span-12">
                    <livewire:kyc.kyc-dashboard />
                </div>
            </div>
        </div>
    </div>
</x-app-layout-sideblock>
