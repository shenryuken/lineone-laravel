<div class="py-12">
    <!-- Period Selector -->
    <div class="card mb-5 p-3">
        <div class="flex flex-wrap items-center justify-between">
            <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                {{ __('KYB Analytics') }}
            </h2>
            <div class="flex">
                <select wire:model="period"
                    class="form-select rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">
                    <option value="week">{{ __('Last 7 Days') }}</option>
                    <option value="month">{{ __('Last 30 Days') }}</option>
                    <option value="quarter">{{ __('Last Quarter') }}</option>
                    <option value="year">{{ __('Last Year') }}</option>
                </select>
            </div>
        </div>
    </div>

    <!-- KYB Status Cards -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-5 lg:grid-cols-4 lg:gap-6 mb-5">
        <div class="card p-4 sm:p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-lg font-semibold text-slate-700 dark:text-navy-100">
                        {{ $statusDistribution['pending'] ?? 0 }}
                    </p>
                    <p class="text-xs+ text-slate-400 dark:text-navy-300">
                        {{ __('Pending Applications') }}
                    </p>
                </div>
                <div class="mask is-squircle bg-warning/10 p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-warning" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.kyb.index') }}?status=pending"
                    class="border-b border-dashed border-current pb-0.5 font-medium text-warning outline-none transition-colors duration-300 hover:text-warning/70 focus:text-warning/70">
                    {{ __('View Applications') }}
                </a>
            </div>
        </div>

        <div class="card p-4 sm:p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-lg font-semibold text-slate-700 dark:text-navy-100">
                        {{ $statusDistribution['approved'] ?? 0 }}
                    </p>
                    <p class="text-xs+ text-slate-400 dark:text-navy-300">
                        {{ __('Approved') }}
                    </p>
                </div>
                <div class="mask is-squircle bg-success/10 p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-success" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.kyb.index') }}?status=approved"
                    class="border-b border-dashed border-current pb-0.5 font-medium text-success outline-none transition-colors duration-300 hover:text-success/70 focus:text-success/70">
                    {{ __('View Applications') }}
                </a>
            </div>
        </div>

        <div class="card p-4 sm:p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-lg font-semibold text-slate-700 dark:text-navy-100">
                        {{ $statusDistribution['rejected'] ?? 0 }}
                    </p>
                    <p class="text-xs+ text-slate-400 dark:text-navy-300">
                        {{ __('Rejected') }}
                    </p>
                </div>
                <div class="mask is-squircle bg-error/10 p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-error" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.kyb.index') }}?status=rejected"
                    class="border-b border-dashed border-current pb-0.5 font-medium text-error outline-none transition-colors duration-300 hover:text-error/70 focus:text-error/70">
                    {{ __('View Applications') }}
                </a>
            </div>
        </div>

        <div class="card p-4 sm:p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-lg font-semibold text-slate-700 dark:text-navy-100">
                        {{ $statusDistribution['additional_info'] ?? 0 }}
                    </p>
                    <p class="text-xs+ text-slate-400 dark:text-navy-300">
                        {{ __('Additional Info') }}
                    </p>
                </div>
                <div class="mask is-squircle bg-info/10 p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-info" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.kyb.index') }}?status=additional_info"
                    class="border-b border-dashed border-current pb-0.5 font-medium text-info outline-none transition-colors duration-300 hover:text-info/70 focus:text-info/70">
                    {{ __('View Applications') }}
                </a>
            </div>
        </div>

        <div class="card p-4 sm:p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-lg font-semibold text-slate-700 dark:text-navy-100">
                        {{ $statusDistribution['kiv'] ?? 0 }}
                    </p>
                    <p class="text-xs+ text-slate-400 dark:text-navy-300">
                        {{ __('KIV') }}
                    </p>
                </div>
                <div class="mask is-squircle bg-purple-500/10 p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-500" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.kyb.index') }}?status=kiv"
                    class="border-b border-dashed border-current pb-0.5 font-medium text-purple-500 outline-none transition-colors duration-300 hover:text-purple-500/70 focus:text-purple-500/70">
                    {{ __('View Applications') }}
                </a>
            </div>
        </div>
    </div>

    <!-- KYB Metrics -->
    <div class="grid grid-cols-1 gap-4 sm:gap-5 lg:grid-cols-3 lg:gap-6 mb-5">
        <div class="card p-4 sm:p-5">
            <div class="flex items-center justify-between">
                <h2 class="font-medium tracking-wide text-slate-700 dark:text-navy-100">
                    {{ __('Processing Statistics') }}
                </h2>
            </div>
            <div class="mt-5 space-y-4">
                <div class="flex justify-between">
                    <p class="text-slate-700 dark:text-navy-100">{{ __('Avg. Processing Time') }}</p>
                    <p class="font-medium text-slate-700 dark:text-navy-100">
                        {{ $processingTimeAvg }} {{ __('hrs') }}
                    </p>
                </div>
                <div class="flex justify-between">
                    <p class="text-slate-700 dark:text-navy-100">{{ __('Pending Applications') }}</p>
                    <p class="font-medium text-slate-700 dark:text-navy-100">{{ $pendingApplicationsCount }}</p>
                </div>
                <div class="flex justify-between">
                    <p class="text-slate-700 dark:text-navy-100">{{ __('Approval Rate') }}</p>
                    <p class="font-medium text-success dark:text-success">{{ $approvalRate }}%</p>
                </div>
                <div class="flex justify-between">
                    <p class="text-slate-700 dark:text-navy-100">{{ __('Rejection Rate') }}</p>
                    <p class="font-medium text-error dark:text-error">{{ $rejectionRate }}%</p>
                </div>
                <div class="flex justify-between">
                    <p class="text-slate-700 dark:text-navy-100">{{ __('Additional Info Rate') }}</p>
                    <p class="font-medium text-info dark:text-info">{{ $additionalInfoRate }}%</p>
                </div>
            </div>
        </div>

        <div class="card p-4 sm:p-5 lg:col-span-2">
            <div class="flex items-center justify-between">
                <h2 class="font-medium tracking-wide text-slate-700 dark:text-navy-100">
                    {{ __('Applications Over Time') }}
                </h2>
            </div>
            <div class="mt-3 h-80">
                <div id="applicationsChart" class="h-full w-full"></div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4 sm:gap-5 lg:grid-cols-2 lg:gap-6 mb-5">
        <!-- Business Type Distribution -->
        <div class="card p-4 sm:p-5">
            <div class="flex items-center justify-between">
                <h2 class="font-medium tracking-wide text-slate-700 dark:text-navy-100">
                    {{ __('Business Type Distribution') }}
                </h2>
            </div>
            <div class="mt-5 space-y-4">
                @foreach($businessTypeDistribution as $business)
                <div>
                    <div class="flex justify-between">
                        <p class="text-slate-700 dark:text-navy-100">{{ $business['type'] }}</p>
                        <p class="font-medium text-slate-700 dark:text-navy-100">{{ $business['count'] }}</p>
                    </div>
                    <div class="mt-2 h-2 w-full rounded-full bg-slate-150 dark:bg-navy-500">
                        @php
                        $maxCount = 1;
                        foreach($businessTypeDistribution as $type) {
                        if(isset($type['count']) && $type['count'] > $maxCount) {
                        $maxCount = $type['count'];
                        }
                        }
                        $percentage = ($business['count'] / $maxCount) * 100;
                        @endphp
                        <div class="h-full rounded-full bg-primary dark:bg-accent" style="width: {{ $percentage }}%">
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Top Reviewers -->
        <div class="card p-4 sm:p-5">
            <div class="flex items-center justify-between">
                <h2 class="font-medium tracking-wide text-slate-700 dark:text-navy-100">
                    {{ __('Top Reviewers') }}
                </h2>
            </div>
            <div class="mt-5">
                @if(count($topReviewers) > 0)
                <div class="is-scrollbar-hidden min-w-full overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                <th class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100">
                                    {{ __('Admin') }}
                                </th>
                                <th class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100">
                                    {{ __('Actions') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topReviewers as $reviewer)
                            <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                    <div class="flex items-center space-x-4">
                                        <div class="avatar h-9 w-9">
                                            <div
                                                class="is-initial rounded-full bg-primary/10 text-primary dark:bg-accent/10 dark:text-accent">
                                                {{ substr($reviewer['name'], 0, 1) }}
                                            </div>
                                        </div>
                                        <div>
                                            <p class="font-medium text-slate-700 dark:text-navy-100">
                                                {{ $reviewer['name'] }}
                                            </p>
                                            <p class="text-xs text-slate-400 dark:text-navy-300">
                                                {{ $reviewer['email'] }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                    <div class="badge bg-primary/10 text-primary dark:bg-accent/10 dark:text-accent">
                                        {{ $reviewer['actions'] }} {{ __('Reviews') }}
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="flex flex-col items-center justify-center py-5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-slate-300 dark:text-navy-300"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 4v16m8-8H4" />
                    </svg>
                    <p class="mt-2 text-slate-500 dark:text-navy-200">{{ __('No review activity yet') }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="card p-4 sm:p-5 mb-5">
        <div class="flex items-center justify-between">
            <h2 class="font-medium tracking-wide text-slate-700 dark:text-navy-100">
                {{ __('Recent Activity') }}
            </h2>
            <a href="{{ route('admin.kyb.index') }}"
                class="border-b border-dashed border-current pb-0.5 font-medium text-primary outline-none transition-colors duration-300 hover:text-primary/70 focus:text-primary/70 dark:text-accent-light dark:hover:text-accent-light/70 dark:focus:text-accent-light/70">
                {{ __('View All') }}
            </a>
        </div>
        <div class="mt-5">
            @if(count($recentActivities) > 0)
            <div class="is-scrollbar-hidden min-w-full overflow-x-auto">
                <ol class="timeline [--size:1.5rem]">
                    @foreach($recentActivities as $activity)
                    <li class="timeline-item">
                        <div class="timeline-item-point
                                    @if($activity->status === 'pending') rounded-full bg-warning
                                    @elseif($activity->status === 'approved') rounded-full bg-success
                                    @elseif($activity->status === 'rejected') rounded-full bg-error
                                    @elseif($activity->status === 'additional_info') rounded-full bg-info
                                    @else rounded-full bg-slate-300 dark:bg-navy-400 @endif">
                        </div>
                        <div class="timeline-item-content flex-1 pl-4 sm:pl-8">
                            <div class="flex flex-col justify-between pb-2 sm:flex-row sm:pb-0">
                                <p class="pb-2 font-medium leading-none text-slate-600 dark:text-navy-100 sm:pb-0">
                                    @if($activity->is_note)
                                    {{ __('Admin Note') }}
                                    @else
                                    {{ ucfirst(str_replace('_', ' ', $activity->status)) }}
                                    @endif
                                    - {{ $activity->kyb->legal_name }}
                                </p>
                                <span class="text-xs text-slate-400 dark:text-navy-300">{{
                                    $activity->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="py-1">{{ Str::limit($activity->comment, 50) }}</p>
                            <div class="flex justify-between items-center text-xs text-slate-400 dark:text-navy-300">
                                <span>{{ __('By') }}: {{ $activity->user->name }}</span>
                                <a href="{{ route('admin.kyb.show', $activity->kyb) }}"
                                    class="text-primary dark:text-accent-light">{{ __('View Details') }}</a>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ol>
            </div>
            @else
            <div class="flex flex-col items-center justify-center py-5">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-slate-300 dark:text-navy-300" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="mt-2 text-slate-500 dark:text-navy-200">{{ __('No recent activity') }}</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mt-4 sm:mt-5 lg:mt-6">
        <div class="card p-4 sm:p-5">
            <h2 class="text-base font-medium tracking-wide text-slate-700 dark:text-navy-100">
                Quick Actions
            </h2>
            <div class="mt-3 grid grid-cols-1 gap-4 sm:grid-cols-3 sm:gap-5">
                <a href="{{ route('admin.kyb.index', ['status' => 'pending']) }}"
                    class="card flex flex-col items-center justify-center p-4 text-center hover:bg-slate-100 dark:hover:bg-navy-600">
                    <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-warning/10 dark:bg-warning/10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-warning" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
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

                <a href="{{ route('admin.kyb.index', ['verificationStatus' => 'pass']) }}"
                    class="card flex flex-col items-center justify-center p-4 text-center hover:bg-slate-100 dark:hover:bg-navy-600">
                    <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-success/10 dark:bg-success/10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-success" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
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

                <a href="{{ route('admin.kyb.index', ['status' => 'kiv']) }}"
                    class="card flex flex-col items-center justify-center p-4 text-center hover:bg-slate-100 dark:hover:bg-navy-600">
                    <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-info/10 dark:bg-info/10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-info" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
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

    <!-- JavaScript for Charts -->
    <script>
        document.addEventListener('livewire:load', function() {
            initializeCharts();
            Livewire.on('refreshDashboard', function() {
                initializeCharts();
            });
        });

        function initializeCharts() {
            // Application Chart
            const timeframeData = @json($timeframeData);

            if (document.getElementById('applicationsChart')) {
                const options = {
                    series: [
                        {
                            name: 'Submitted',
                            data: timeframeData.map(item => item.submitted)
                        },
                        {
                            name: 'Approved',
                            data: timeframeData.map(item => item.approved)
                        }
                    ],
                    chart: {
                        height: 290,
                        type: 'line',
                        toolbar: {
                            show: false
                        }
                    },
                    colors: ['#1e40af', '#10b981'],
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: 'smooth',
                        width: 3
                    },
                    grid: {
                        borderColor: '#e0e0e0',
                        row: {
                            colors: ['transparent', 'transparent'],
                            opacity: 0.2
                        }
                    },
                    markers: {
                        size: 4
                    },
                    xaxis: {
                        categories: timeframeData.map(item => item.date),
                        labels: {
                            style: {
                                colors: '#64748b'
                            }
                        }
                    },
                    yaxis: {
                        min: 0,
                        labels: {
                            style: {
                                colors: '#64748b'
                            }
                        }
                    },
                    legend: {
                        position: 'top',
                        horizontalAlign: 'right',
                        floating: true,
                        offsetY: -25,
                        offsetX: -5
                    },
                    tooltip: {
                        theme: 'dark'
                    }
                };

                // Clear any existing charts
                document.getElementById('applicationsChart').innerHTML = '';

                const chart = new ApexCharts(document.getElementById('applicationsChart'), options);
                chart.render();
            }
        }
    </script>
</div>
