<!-- Add this section to your navigation for regular users -->
@auth
<!-- KYB Section -->
<li>
    <a x-data="navLink" href="{{ route('kyb.dashboard') }}"
        :class="isActive ? 'text-slate-800 font-medium dark:text-navy-100' : 'text-slate-600 dark:text-navy-200'"
        class="flex items-center justify-between py-2 hover:text-slate-800 dark:hover:text-navy-100">
        <span class="flex items-center space-x-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <span>KYB Verification</span>
        </span>
        @if(auth()->user()->kyb_status === 'pending')
        <span class="badge rounded-full bg-warning/10 text-warning">Pending</span>
        @elseif(auth()->user()->kyb_status === 'approved')
        <span class="badge rounded-full bg-success/10 text-success">Verified</span>
        @elseif(auth()->user()->kyb_status === 'rejected')
        <span class="badge rounded-full bg-error/10 text-error">Rejected</span>
        @endif
    </a>
</li>
@endauth
<!-- Add this to your navigation menu for admin users -->
@role('admin')
<!--KYC Management -->
<li x-data="{ expanded: false }">
    <a @click="expanded = !expanded"
        class="flex items-center justify-between py-2 hover:text-slate-800 dark:hover:text-navy-100"
        :class="expanded ? 'text-slate-800 font-medium dark:text-navy-100' : 'text-slate-600 dark:text-navy-200'"
        href="javascript:void(0);">
        <span class="flex items-center space-x-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <span>KYC Management</span>
        </span>
        <svg :class="expanded && 'rotate-90'" xmlns="http://www.w3.org/2000/svg"
            class="h-4 w-4 text-slate-400 transition-transform ease-in-out" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
    </a>
    <ul x-show="expanded" x-collapse class="pl-4 mt-1 space-y-1">
        <li>
            <a href="{{ route('admin.kyc.dashboard') }}"
                class="flex items-center space-x-2 py-2 text-slate-600 hover:text-slate-800 dark:text-navy-200 dark:hover:text-navy-100"
                :class="{ 'text-slate-800 font-medium dark:text-navy-100': '{{ request()->routeIs('admin.kyc.dashboard') }}' }">
                <span class="h-1.5 w-1.5 rounded-full border border-current"></span>
                <span>Dashboard</span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.kyc.index') }}"
                class="flex items-center space-x-2 py-2 text-slate-600 hover:text-slate-800 dark:text-navy-200 dark:hover:text-navy-100"
                :class="{ 'text-slate-800 font-medium dark:text-navy-100': '{{ request()->routeIs('admin.kyc.index') }}' }">
                <span class="h-1.5 w-1.5 rounded-full border border-current"></span>
                <span>All Applications</span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.kyc.index', ['status' => 'pending']) }}"
                class="flex items-center space-x-2 py-2 text-slate-600 hover:text-slate-800 dark:text-navy-200 dark:hover:text-navy-100">
                <span class="h-1.5 w-1.5 rounded-full border border-current"></span>
                <span>Pending Applications</span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.kyc.index', ['status' => 'kiv']) }}"
                class="flex items-center space-x-2 py-2 text-slate-600 hover:text-slate-800 dark:text-navy-200 dark:hover:text-navy-100">
                <span class="h-1.5 w-1.5 rounded-full border border-current"></span>
                <span>KIV Applications</span>
            </a>
        </li>
    </ul>
</li>
<!--KYB Management -->
<li x-data="{ expanded: false }">
    <a @click="expanded = !expanded"
        class="flex items-center justify-between py-2 hover:text-slate-800 dark:hover:text-navy-100"
        :class="expanded ? 'text-slate-800 font-medium dark:text-navy-100' : 'text-slate-600 dark:text-navy-200'"
        href="javascript:void(0);">
        <span class="flex items-center space-x-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
            <span>KYB Management</span>
        </span>
        <svg :class="expanded && 'rotate-90'" xmlns="http://www.w3.org/2000/svg"
            class="h-4 w-4 text-slate-400 transition-transform ease-in-out" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
    </a>
    <ul x-show="expanded" x-collapse class="pl-4 mt-1 space-y-1">
        <li>
            <a href="{{ route('admin.kyb.dashboard') }}"
                class="flex items-center space-x-2 py-2 text-slate-600 hover:text-slate-800 dark:text-navy-200 dark:hover:text-navy-100"
                :class="{ 'text-slate-800 font-medium dark:text-navy-100': '{{ request()->routeIs('admin.kyb.dashboard') }}' }">
                <span class="h-1.5 w-1.5 rounded-full border border-current"></span>
                <span>Dashboard</span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.kyb.index') }}"
                class="flex items-center space-x-2 py-2 text-slate-600 hover:text-slate-800 dark:text-navy-200 dark:hover:text-navy-100"
                :class="{ 'text-slate-800 font-medium dark:text-navy-100': '{{ request()->routeIs('admin.kyb.index') }}' }">
                <span class="h-1.5 w-1.5 rounded-full border border-current"></span>
                <span>All Applications</span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.kyb.index', ['status' => 'pending']) }}"
                class="flex items-center space-x-2 py-2 text-slate-600 hover:text-slate-800 dark:text-navy-200 dark:hover:text-navy-100">
                <span class="h-1.5 w-1.5 rounded-full border border-current"></span>
                <span>Pending Applications</span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.kyb.index', ['status' => 'kiv']) }}"
                class="flex items-center space-x-2 py-2 text-slate-600 hover:text-slate-800 dark:text-navy-200 dark:hover:text-navy-100">
                <span class="h-1.5 w-1.5 rounded-full border border-current"></span>
                <span>KIV Applications</span>
            </a>
        </li>
    </ul>
</li>
@endrole
