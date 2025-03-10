<x-app-layout-sideblock>
    <main class="main-content w-full px-[var(--margin-x)] pb-8">

        @livewire('admin.kyb.kyb-dashboard')

    </main>
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    @endpush
</x-app-layout-sideblock>
