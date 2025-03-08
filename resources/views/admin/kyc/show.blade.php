<x-app-layout-sideblock title="KYC Application Details" is-header-blur="true">
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        <div class="flex items-center justify-between py-5 lg:py-6">
            <div class="flex items-center space-x-1">
                <h2 class="text-xl font-medium text-slate-700 line-clamp-1 dark:text-navy-50 lg:text-2xl">
                    KYC Application Details
                </h2>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:gap-5 lg:gap-6">
            <livewire:admin.kyc.kyc-show :kyc="$kyc" />
        </div>
    </main>
</x-app-layout-sideblock>
