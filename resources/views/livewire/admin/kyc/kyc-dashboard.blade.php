<div>
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-5 lg:grid-cols-4 lg:gap-6">
        <!-- Total Applications -->
        <div class="card p-4">
            <div class="flex justify-between space-x-1">
                <div>
                    <p class="text-lg font-semibold text-slate-700 dark:text-navy-100">
                        {{ $totalApplications }}
                    </p>
                    <p class="text-xs+ text-slate-400 dark:text-navy-300">
                        Total Applications
                    </p>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-primary/10 dark:bg-accent/10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary dark:text-accent" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Pending Applications -->
        <div class="card p-4">
            <div class="flex justify-between space-x-1">
                <div>
                    <p class="text-lg font-semibold text-slate-700 dark:text-navy-100">
                        {{ $pendingApplications }}
                    </p>
                    <p class="text-xs+ text-slate-400 dark:text-navy-300">
                        Pending Applications
                    </p>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-warning/10 dark:bg-warning/10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-warning" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Approved Applications -->
        <div class="card p-4">
            <div class="flex justify-between space-x-1">
                <div>
                    <p class="text-lg font-semibold text-slate-700 dark:text-navy-100">
                        {{ $approvedApplications }}
                    </p>
                    <p class="text-xs+ text-slate-400 dark:text-navy-300">
                        Approved Applications
                    </p>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-success/10 dark:bg-success/10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-success" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Rejected Applications -->
        <div class="card p-4">
            <div class="flex justify-between space-x-1">
                <div>
                    <p class="text-lg font-semibold text-slate-700 dark:text-navy-100">
                        {{ $rejectedApplications }}
                    </p>
                    <p class="text-xs+ text-slate-400 dark:text-navy-300">
                        Rejected Applications
                    </p>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-error/10 dark:bg-error/10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-error" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Recent Applications -->
    <div class="mt-4 grid grid-cols-12 gap-4 sm:mt-5 sm:gap-5 lg:mt-6 lg:gap-6">
        <!-- Monthly Stats Chart -->
        <div class="col-span-12 lg:col-span-8">
            <div class="card p-4 sm:p-5">
                <div class="flex items-center justify-between">
                    <h2 class="text-base font-medium tracking-wide text-slate-700 dark:text-navy-100">
                        Monthly KYC Applications
                    </h2>
                </div>
                <div class="mt-3 h-80">
                    <canvas x-init="$nextTick(() => {
                        const ctx = $el.getContext('2d');
                        const monthlyStats = {{ json_encode($monthlyStats) }};

                        const labels = monthlyStats.map(stat => stat.month);
                        const approvedData = monthlyStats.map(stat => stat.approved);
                        const pendingData = monthlyStats.map(stat => stat.pending);
                        const rejectedData = monthlyStats.map(stat => stat.rejected);
                        const kivData = monthlyStats.map(stat => stat.kiv);

                        new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: labels,
                                datasets: [
                                    {
                                        label: 'Approved',
                                        data: approvedData,
                                        backgroundColor: '#10b981',
                                        borderColor: '#10b981',
                                        borderWidth: 1
                                    },
                                    {
                                        label: 'Pending',
                                        data: pendingData,
                                        backgroundColor: '#f59e0b',
                                        borderColor: '#f59e0b',
                                        borderWidth: 1
                                    },
                                    {
                                        label: 'Rejected',
                                        data: rejectedData,
                                        backgroundColor: '#ef4444',
                                        borderColor: '#ef4444',
                                        borderWidth: 1
                                    },
                                    {
                                        label: 'KIV',
                                        data: kivData,
                                        backgroundColor: '#3b82f6',
                                        borderColor: '#3b82f6',
                                        borderWidth: 1
                                    }
                                ]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        ticks: {
                                            precision: 0
                                        }
                                    }
                                }
                            }
                        });
                    })"></canvas>
                </div>
            </div>
        </div>

        <!-- Recent Applications -->
        <div class="col-span-12 lg:col-span-4">
            <div class="card p-4 sm:p-5">
                <div class="flex items-center justify-between">
                    <h2 class="text-base font-medium tracking-wide text-slate-700 dark:text-navy-100">
                        Recent Applications
                    </h2>
                    <a href="{{ route('admin.kyc.index') }}"
                        class="border-b border-dashed border-current pb-0.5 text-xs+ font-medium text-primary outline-none transition-colors duration-300 hover:text-primary/70 focus:text-primary/70 dark:text-accent-light dark:hover:text-accent-light/70 dark:focus:text-accent-light/70">
                        View All
                    </a>
                </div>
                <div class="mt-3 space-y-3.5">
                    @forelse($recentApplications as $kyc)
                    <div class="flex items-center justify-between space-x-2">
                        <div class="flex items-center space-x-3">
                            <div class="avatar h-10 w-10">
                                <div
                                    class="is-initial rounded-full bg-primary/10 text-primary dark:bg-accent-light/10 dark:text-accent-light">
                                    {{ substr($kyc->user->name, 0, 1) }}
                                </div>
                            </div>
                            <div>
                                <p class="font-medium text-slate-700 dark:text-navy-100">
                                    {{ $kyc->full_name }}
                                </p>
                                <p class="text-xs text-slate-400 dark:text-navy-300">
                                    {{ $kyc->created_at->format('M d, Y') }}
                                </p>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <div class="badge rounded-full px-2 py-1
                                    @if($kyc->status === 'approved') bg-success/10 text-success
                                    @elseif($kyc->status === 'rejected') bg-error/10 text-error
                                    @elseif($kyc->status === 'kiv') bg-info/10 text-info
                                    @else bg-warning/10 text-warning @endif">
                                {{ ucfirst($kyc->status) }}
                            </div>
                            <a href="{{ route('admin.kyc.show', $kyc) }}"
                                class="btn h-8 w-8 rounded-full p-0 text-info hover:bg-info/20 focus:bg-info/20 active:bg-info/25">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="flex flex-col items-center justify-center py-8">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-slate-300 dark:text-navy-300"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p class="mt-2 text-slate-500 dark:text-navy-300">No recent applications</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mt-4 sm:mt-5 lg:mt-6">
        <div class="card p-4 sm:p-5">
            <h2 class="text-base font-medium tracking-wide text-slate-700 dark:text-navy-100">
                Quick Actions
            </h2>
            <div class="mt-3 grid grid-cols-1 gap-4 sm:grid-cols-3 sm:gap-5">
                <a href="{{ route('admin.kyc.index', ['status' => 'pending']) }}"
                    class="card flex flex-col items-center justify-center p-4 text-center hover:bg-slate-100 dark:hover:bg-navy-600">
                    <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-warning/10 dark:bg-warning/10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-warning" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="mt-3 text-base font-medium text-slate-700 dark:text-navy-100">
                        Pending Applications
                    </h3>
                    <p class="mt-1 text-xs+ text-slate-400 dark:text-navy-300">
                        View and process pending applications
                    </p>
                </a>

                <a href="{{ route('admin.kyc.index', ['verificationStatus' => 'pass']) }}"
                    class="card flex flex-col items-center justify-center p-4 text-center hover:bg-slate-100 dark:hover:bg-navy-600">
                    <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-success/10 dark:bg-success/10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-success" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="mt-3 text-base font-medium text-slate-700 dark:text-navy-100">
                        Verified Applications
                    </h3>
                    <p class="mt-1 text-xs+ text-slate-400 dark:text-navy-300">
                        Review and approve verified applications
                    </p>
                </a>

                <a href="{{ route('admin.kyc.index', ['status' => 'kiv']) }}"
                    class="card flex flex-col items-center justify-center p-4 text-center hover:bg-slate-100 dark:hover:bg-navy-600">
                    <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-info/10 dark:bg-info/10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-info" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="mt-3 text-base font-medium text-slate-700 dark:text-navy-100">
                        KIV Applications
                    </h3>
                    <p class="mt-1 text-xs+ text-slate-400 dark:text-navy-300">
                        Review applications marked for further review
                    </p>
                </a>
            </div>
        </div>
    </div>
</div>
