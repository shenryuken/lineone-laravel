<x-app-layout-sideblock>
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
    <div
        class="mt-6 flex flex-col items-center justify-between space-y-2 text-center sm:flex-row sm:space-y-0 sm:text-left">
        <div class="py-6">
            <h3 class="text-xl font-semibold text-slate-700 dark:text-navy-100">
                {{ __('KYB Application Details') }}
            </h3>
            <p class="mt-1 hidden sm:block">List of kyb details</p>
        </div>
        <button
            class="btn space-x-2 bg-primary font-medium text-white shadow-lg shadow-primary/50 hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:shadow-accent/50 dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-indigo-50" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            <span> {{ __('Submitted') }}: {{ $kyb->created_at->format('M d, Y') }} </span>
        </button>
    </div>
        {{-- <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center space-x-2">
                <a href="{{ route('admin.kyb.index') }}"
                    class="btn h-8 w-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
                <h2 class="text-xl font-medium text-slate-800 dark:text-navy-50">
                    {{ __('KYB Application Details') }}
                </h2>
            </div>
            <div class="mt-3 sm:mt-0 flex items-center space-x-2">
                <span class="text-xs+ text-slate-400 dark:text-navy-300">
                    {{ __('Submitted') }}: {{ $kyb->created_at->format('M d, Y') }}
                </span>
            </div>
        </div> --}}

    {{-- <div class="grid grid-cols-1 gap-4 sm:gap-5 lg:gap-6">
        <div> --}}
    @livewire('admin.kyb.kyb-show', ['kyb' => $kyb])
        {{-- </div>
    </div> --}}
    </main>
</x-app-layout-sideblock>
