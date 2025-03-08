<div class="p-4 bg-slate-50 rounded-xl dark:bg-navy-800">
    <h3 class="mb-4 text-lg font-semibold text-slate-700 dark:text-navy-100">Verification Timeline</h3>

    <div class="relative py-2">
        <!-- Timeline Line -->
        <div class="absolute inset-0 w-px h-full bg-slate-300 dark:bg-navy-500 left-7 ml-0.5"></div>

        <!-- Timeline Events -->
        <div class="space-y-8">
            @foreach($events as $event)
            <div class="relative flex items-start">
                <!-- Timeline Dot -->
                <div
                    class="flex items-center justify-center w-7 h-7 rounded-full {{ $event['completed'] ? 'bg-' . $event['color'] . ' text-white' : 'bg-slate-200 text-slate-500 dark:bg-navy-500 dark:text-navy-100' }} z-10">
                    @if($event['icon'] === 'check-circle')
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    @elseif($event['icon'] === 'alert-circle')
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    @elseif($event['icon'] === 'search')
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    @elseif($event['icon'] === 'shield-check')
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    @elseif($event['icon'] === 'x-circle')
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    @elseif($event['icon'] === 'clock')
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    @elseif($event['icon'] === 'clipboard-check')
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                    @elseif($event['icon'] === 'upload')
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                    </svg>
                    @endif
                </div>

                <!-- Timeline Content -->
                <div class="ml-4 w-full">
                    <div class="flex items-center justify-between">
                        <h4 class="text-sm font-medium text-slate-700 dark:text-navy-100">{{ $event['status'] }}</h4>
                        @if($event['date'])
                        <span class="text-xs text-slate-500 dark:text-navy-300">{{ $event['date']->format('M d, Y - h:i
                            A') }}</span>
                        @endif
                    </div>
                    <p class="mt-1 text-xs text-slate-500 dark:text-navy-300">{{ $event['description'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
