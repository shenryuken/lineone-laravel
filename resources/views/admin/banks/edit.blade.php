<x-app-layout-sideblock title="Edit Bank" is-header-blur="true">
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        <div class="mt-4 sm:mt-5 md:mt-6">
            <livewire:admin.banks.bank-form :id="$bank->id" />
        </div>
    </main>
</x-app-layout-sideblock>
