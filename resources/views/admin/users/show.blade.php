<x-app-layout-sideblock title="Edit User">
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        <div class="container mx-auto px-4 py-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Profile Header --}}
                <div class="md:col-span-3">
                    @include('admin.users.partials.profile-header')
                </div>

                {{-- User Information --}}
                <div class="md:col-span-2 space-y-6">
                    {{-- Personal Information --}}
                    @include('admin.users.partials.personal-info')

                    {{-- Account Details --}}
                    @include('admin.users.partials.account-details')

                    {{-- Wallet Information --}}
                    @include('admin.users.partials.wallet-info')
                </div>

                {{-- Sidebar --}}
                <div class="space-y-6">
                    {{-- User Actions --}}
                    @include('admin.users.partials.user-actions')

                    {{-- Recent Activity --}}
                    @include('admin.users.partials.recent-activity')
                </div>
            </div>
        </div>
    </main>
</x-app-layout-sideblock>
