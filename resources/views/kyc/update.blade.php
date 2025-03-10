<x-app-layout-sideblock title="Update KYC Information" is-header-blur="true">
    <main class="main-content w-full px-[var(--margin-x)] pb-8">

        <div class="px-[var(--margin-x)] transition-all duration-[.25s] pb-8 pt-6">
            <div class="flex items-center space-x-4 py-5 lg:py-6">
                <h2 class="text-xl font-medium text-slate-800 dark:text-navy-50 lg:text-2xl">
                    Update KYC Information
                </h2>
            </div>
            <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
                <div class="col-span-12">
                    <livewire:kyc.kyc-update-form :kyc="$kyc" />
                </div>
            </div>
        </div>

    </main>
</x-app-layout-sideblock>
