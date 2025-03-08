<x-app-layout-sideblock>

    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        <x-slot name="header">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    {{ __('Business Verification Details') }}
                </h2>
                <span class="badge rounded-full px-3 py-1.5 text-sm font-medium
                    @if($kyb->status == 'approved') bg-success/10 text-success
                    @elseif($kyb->status == 'rejected') bg-error/10 text-error
                    @elseif($kyb->status == 'kiv') bg-warning/10 text-warning
                    @else bg-info/10 text-info @endif">
                    {{ ucfirst($kyb->status) }}
                </span>
            </div>
        </x-slot>

        <div class="py-6">
            <div class="mx-auto max-w-7xl">
                <!-- Application Progress -->
                <div class="card p-5 mb-6">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-5">
                        <div>
                            <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100">
                                Application Status
                            </h3>
                            <p class="mt-1 text-sm text-slate-500 dark:text-navy-300">
                                Submitted on {{ \Carbon\Carbon::parse($kyb->created_at)->format('M d, Y') }}
                                @if($kyb->updated_at && $kyb->updated_at->ne($kyb->created_at))
                                • Last updated {{ \Carbon\Carbon::parse($kyb->updated_at)->format('M d, Y') }}
                                @endif
                            </p>
                        </div>

                        @if($kyb->status == 'pending' || $kyb->status == 'kiv')
                        <div class="flex gap-2">
                            <a href="{{ route('merchant.kyb.update') }}"
                                class="btn bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                <span>Update Application</span>
                            </a>
                        </div>
                        @endif
                    </div>

                    <div class="w-full bg-slate-200 dark:bg-navy-500 h-2 rounded-full overflow-hidden">
                        <div class="h-full rounded-full
                            @if($kyb->status == 'approved') bg-success
                            @elseif($kyb->status == 'rejected') bg-error
                            @elseif($kyb->status == 'kiv') bg-warning w-3/4
                            @else bg-info w-1/2 @endif" @if($kyb->status == 'approved' || $kyb->status == 'rejected')
                            style="width: 100%" @endif>
                        </div>
                    </div>

                    <div class="mt-4 grid grid-cols-2 sm:grid-cols-4 gap-2">
                        <div class="text-center">
                            <div
                                class="flex h-7 w-7 items-center justify-center rounded-full bg-primary/10 text-primary dark:bg-accent/10 dark:text-accent-light mx-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <p class="mt-1 text-xs font-medium">Submitted</p>
                        </div>

                        <div class="text-center">
                            <div class="flex h-7 w-7 items-center justify-center rounded-full
                                @if($kyb->status != 'pending') bg-primary/10 text-primary dark:bg-accent/10 dark:text-accent-light
                                @else bg-slate-200 text-slate-500 dark:bg-navy-500 dark:text-navy-200 @endif mx-auto">
                                @if($kyb->status != 'pending')
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                @else
                                <span class="text-xs font-bold">2</span>
                                @endif
                            </div>
                            <p class="mt-1 text-xs font-medium">In Review</p>
                        </div>

                        <div class="text-center">
                            <div class="flex h-7 w-7 items-center justify-center rounded-full
                                @if($kyb->status == 'approved' || $kyb->status == 'rejected') bg-primary/10 text-primary dark:bg-accent/10 dark:text-accent-light
                                @else bg-slate-200 text-slate-500 dark:bg-navy-500 dark:text-navy-200 @endif mx-auto">
                                @if($kyb->status == 'approved' || $kyb->status == 'rejected')
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                @else
                                <span class="text-xs font-bold">3</span>
                                @endif
                            </div>
                            <p class="mt-1 text-xs font-medium">Decision</p>
                        </div>

                        <div class="text-center">
                            <div class="flex h-7 w-7 items-center justify-center rounded-full
                                @if($kyb->status == 'approved') bg-success/10 text-success
                                @elseif($kyb->status == 'rejected') bg-error/10 text-error
                                @else bg-slate-200 text-slate-500 dark:bg-navy-500 dark:text-navy-200 @endif mx-auto">
                                @if($kyb->status == 'approved')
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                @elseif($kyb->status == 'rejected')
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                @else
                                <span class="text-xs font-bold">4</span>
                                @endif
                            </div>
                            <p class="mt-1 text-xs font-medium">
                                @if($kyb->status == 'approved')
                                Approved
                                @elseif($kyb->status == 'rejected')
                                Rejected
                                @else
                                Completion
                                @endif
                            </p>
                        </div>
                    </div>

                    @if($kyb->additional_info_requested)
                    <div class="mt-5 p-4 bg-amber-50 dark:bg-amber-900/20 border-l-4 border-amber-500 rounded-r-lg">
                        <div class="flex">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-6 w-6 text-amber-600 dark:text-amber-400 mr-3 flex-shrink-0" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <h4 class="text-sm font-medium text-amber-800 dark:text-amber-400">Additional
                                    Information Requested</h4>
                                <p class="mt-1 text-sm text-amber-700 dark:text-amber-300">{{
                                    $kyb->additional_info_requested }}</p>
                                <div class="mt-3">
                                    <a href="{{ route('kyb.upload-additional') }}"
                                        class="btn bg-amber-600 font-medium text-white hover:bg-amber-700 focus:bg-amber-700 active:bg-amber-700/90 h-8 px-3 text-xs">
                                        Upload Additional Documents
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Tab Navigation -->
                <div x-data="{activeTab: 'business'}" class="mb-6">
                    <div class="flex overflow-x-auto tabs-list scrollbar-sm">
                        <button @click="activeTab = 'business'"
                            :class="{'border-primary dark:border-accent text-primary dark:text-accent-light': activeTab === 'business'}"
                            class="btn shrink-0 rounded-none border-b-2 px-4 py-2 font-medium">
                            Business Details
                        </button>
                        <button @click="activeTab = 'ownership'"
                            :class="{'border-primary dark:border-accent text-primary dark:text-accent-light': activeTab === 'ownership'}"
                            class="btn shrink-0 rounded-none border-b-2 px-4 py-2 font-medium">
                            Ownership
                        </button>
                        <button @click="activeTab = 'operations'"
                            :class="{'border-primary dark:border-accent text-primary dark:text-accent-light': activeTab === 'operations'}"
                            class="btn shrink-0 rounded-none border-b-2 px-4 py-2 font-medium">
                            Operations
                        </button>
                        <button @click="activeTab = 'financial'"
                            :class="{'border-primary dark:border-accent text-primary dark:text-accent-light': activeTab === 'financial'}"
                            class="btn shrink-0 rounded-none border-b-2 px-4 py-2 font-medium">
                            Financial
                        </button>
                        <button @click="activeTab = 'compliance'"
                            :class="{'border-primary dark:border-accent text-primary dark:text-accent-light': activeTab === 'compliance'}"
                            class="btn shrink-0 rounded-none border-b-2 px-4 py-2 font-medium">
                            Compliance
                        </button>
                        <button @click="activeTab = 'documents'"
                            :class="{'border-primary dark:border-accent text-primary dark:text-accent-light': activeTab === 'documents'}"
                            class="btn shrink-0 rounded-none border-b-2 px-4 py-2 font-medium">
                            Documents
                        </button>
                    </div>

                    <!-- Business Registration Details -->
                    <div x-show="activeTab === 'business'"
                        x-transition:enter="transition-opacity ease-in-out duration-300"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="card p-5 mt-5">
                        <div class="flex items-center justify-between mb-5">
                            <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100">
                                Business Registration Details
                            </h3>
                            <span
                                class="badge bg-primary/10 text-primary dark:bg-accent/10 dark:text-accent-light px-3 py-1">
                                {{ ucfirst(str_replace('_', ' ', $kyb->business_type)) }}
                            </span>
                        </div>

                        <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-6">
                            <div class="space-y-1.5">
                                <p class="text-xs text-slate-400 dark:text-navy-300">Legal Business Name</p>
                                <p class="font-medium text-slate-700 dark:text-navy-100">{{ $kyb->legal_name }}</p>
                            </div>

                            <div class="space-y-1.5">
                                <p class="text-xs text-slate-400 dark:text-navy-300">Registration Number</p>
                                <p class="font-medium text-slate-700 dark:text-navy-100">{{ $kyb->registration_number }}
                                </p>
                            </div>

                            <div class="space-y-1.5">
                                <p class="text-xs text-slate-400 dark:text-navy-300">Date Established</p>
                                <p class="font-medium text-slate-700 dark:text-navy-100">{{
                                    \Carbon\Carbon::parse($kyb->date_established)->format('M d, Y') }}</p>
                            </div>

                            <div class="space-y-1.5">
                                <p class="text-xs text-slate-400 dark:text-navy-300">Tax ID</p>
                                <p class="font-medium text-slate-700 dark:text-navy-100">{{ $kyb->tax_id }}</p>
                            </div>

                            <div class="space-y-1.5 sm:col-span-2">
                                <p class="text-xs text-slate-400 dark:text-navy-300">Business Address</p>
                                <p class="font-medium text-slate-700 dark:text-navy-100">{{ $kyb->business_address }}
                                </p>
                            </div>

                            <div class="space-y-1.5">
                                <p class="text-xs text-slate-400 dark:text-navy-300">Business Phone</p>
                                <p class="font-medium text-slate-700 dark:text-navy-100">{{ $kyb->business_phone }}</p>
                            </div>

                            <div class="space-y-1.5">
                                <p class="text-xs text-slate-400 dark:text-navy-300">Business Email</p>
                                <p class="font-medium text-slate-700 dark:text-navy-100">{{ $kyb->business_email }}</p>
                            </div>

                            <div class="space-y-1.5 sm:col-span-2">
                                <p class="text-xs text-slate-400 dark:text-navy-300">Website</p>
                                <p class="font-medium text-slate-700 dark:text-navy-100">
                                    @if($kyb->website)
                                    <a href="{{ $kyb->website }}" target="_blank"
                                        class="text-primary dark:text-accent-light hover:underline">
                                        {{ $kyb->website }}
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 inline-block ml-1"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                        </svg>
                                    </a>
                                    @else
                                    <span class="text-slate-500 dark:text-navy-300">Not provided</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Ownership and Control Information -->
                    <div x-show="activeTab === 'ownership'"
                        x-transition:enter="transition-opacity ease-in-out duration-300"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="card p-5 mt-5">
                        <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100 mb-5">
                            Ownership and Control Information
                        </h3>

                        <!-- Directors -->
                        <div x-data="{expanded: true}" class="mb-6">
                            <div @click="expanded = !expanded"
                                class="flex items-center justify-between cursor-pointer pb-2 border-b border-slate-200 dark:border-navy-500">
                                <h4 class="text-base font-medium text-slate-700 dark:text-navy-100">Directors</h4>
                                <button
                                    class="btn h-7 w-7 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                                    <svg :class="expanded ? 'rotate-180' : ''" xmlns="http://www.w3.org/2000/svg"
                                        class="h-4.5 w-4.5 transition-transform" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                            </div>

                            <div x-show="expanded" x-collapse class="pt-3">
                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                                    @foreach(json_decode($kyb->directors) as $index => $director)
                                    <div
                                        class="card p-4 border border-slate-200 dark:border-navy-500 hover:shadow-sm transition-shadow">
                                        <div class="flex items-center mb-3">
                                            <div class="avatar h-10 w-10 bg-primary/10 dark:bg-accent/10">
                                                <div
                                                    class="text-base font-semibold text-primary dark:text-accent-light">
                                                    {{ substr($director->name, 0, 1) }}</div>
                                            </div>
                                            <div class="ml-3">
                                                <p class="font-medium text-slate-700 dark:text-navy-100">{{
                                                    $director->name }}</p>
                                                <p class="text-xs text-slate-400 dark:text-navy-300">{{
                                                    $director->position }}</p>
                                            </div>
                                        </div>

                                        <div class="space-y-2.5">
                                            <div class="flex justify-between">
                                                <span class="text-xs text-slate-400 dark:text-navy-300">Date of
                                                    Birth:</span>
                                                <span class="text-xs font-medium text-slate-700 dark:text-navy-100">{{
                                                    \Carbon\Carbon::parse($director->date_of_birth)->format('M d, Y')
                                                    }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span
                                                    class="text-xs text-slate-400 dark:text-navy-300">Nationality:</span>
                                                <span class="text-xs font-medium text-slate-700 dark:text-navy-100">{{
                                                    $director->nationality }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-xs text-slate-400 dark:text-navy-300">ID
                                                    Number:</span>
                                                <span class="text-xs font-medium text-slate-700 dark:text-navy-100">{{
                                                    $director->id_number }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Shareholders -->
                        <div x-data="{expanded: true}" class="mb-6">
                            <div @click="expanded = !expanded"
                                class="flex items-center justify-between cursor-pointer pb-2 border-b border-slate-200 dark:border-navy-500">
                                <h4 class="text-base font-medium text-slate-700 dark:text-navy-100">Shareholders</h4>
                                <button
                                    class="btn h-7 w-7 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                                    <svg :class="expanded ? 'rotate-180' : ''" xmlns="http://www.w3.org/2000/svg"
                                        class="h-4.5 w-4.5 transition-transform" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                            </div>

                            <div x-show="expanded" x-collapse class="pt-3">
                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                                    @foreach(json_decode($kyb->shareholders) as $index => $shareholder)
                                    <div
                                        class="card p-4 border border-slate-200 dark:border-navy-500 hover:shadow-sm transition-shadow">
                                        <div class="flex items-center justify-between mb-3">
                                            <div class="flex items-center">
                                                <div class="avatar h-10 w-10 bg-success/10 dark:bg-success/15">
                                                    <div class="text-base font-semibold text-success">{{
                                                        substr($shareholder->name, 0, 1) }}</div>
                                                </div>
                                                <div class="ml-3">
                                                    <p class="font-medium text-slate-700 dark:text-navy-100">{{
                                                        $shareholder->name }}</p>
                                                    <p class="text-xs text-slate-400 dark:text-navy-300">{{
                                                        ucfirst($shareholder->entity_type) }}</p>
                                                </div>
                                            </div>
                                            <div class="badge bg-success/10 text-success dark:bg-success/15 px-2 py-1">
                                                {{ $shareholder->ownership_percentage }}%
                                            </div>
                                        </div>

                                        <div class="space-y-2.5">
                                            <div class="flex justify-between">
                                                <span class="text-xs text-slate-400 dark:text-navy-300">ID
                                                    Number:</span>
                                                <span class="text-xs font-medium text-slate-700 dark:text-navy-100">{{
                                                    $shareholder->id_number }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Beneficial Owners -->
                        <div x-data="{expanded: true}">
                            <div @click="expanded = !expanded"
                                class="flex items-center justify-between cursor-pointer pb-2 border-b border-slate-200 dark:border-navy-500">
                                <h4 class="text-base font-medium text-slate-700 dark:text-navy-100">Beneficial Owners
                                </h4>
                                <button
                                    class="btn h-7 w-7 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                                    <svg :class="expanded ? 'rotate-180' : ''" xmlns="http://www.w3.org/2000/svg"
                                        class="h-4.5 w-4.5 transition-transform" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                            </div>

                            <div x-show="expanded" x-collapse class="pt-3">
                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                                    @foreach(json_decode($kyb->beneficial_owners) as $index => $owner)
                                    <div
                                        class="card p-4 border border-slate-200 dark:border-navy-500 hover:shadow-sm transition-shadow">
                                        <div class="flex items-center mb-3">
                                            <div class="avatar h-10 w-10 bg-warning/10 dark:bg-warning/15">
                                                <div class="text-base font-semibold text-warning">{{
                                                    substr($owner->name, 0, 1) }}</div>
                                            </div>
                                            <div class="ml-3">
                                                <p class="font-medium text-slate-700 dark:text-navy-100">{{ $owner->name
                                                    }}</p>
                                                <p class="text-xs text-slate-400 dark:text-navy-300">{{
                                                    $owner->relationship }}</p>
                                            </div>
                                        </div>

                                        <div class="space-y-2.5">
                                            <div class="flex justify-between">
                                                <span class="text-xs text-slate-400 dark:text-navy-300">Date of
                                                    Birth:</span>
                                                <span class="text-xs font-medium text-slate-700 dark:text-navy-100">{{
                                                    \Carbon\Carbon::parse($owner->date_of_birth)->format('M d, Y')
                                                    }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span
                                                    class="text-xs text-slate-400 dark:text-navy-300">Nationality:</span>
                                                <span class="text-xs font-medium text-slate-700 dark:text-navy-100">{{
                                                    $owner->nationality }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-xs text-slate-400 dark:text-navy-300">ID
                                                    Number:</span>
                                                <span class="text-xs font-medium text-slate-700 dark:text-navy-100">{{
                                                    $owner->id_number }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Business Operations -->
                    <div x-show="activeTab === 'operations'"
                        x-transition:enter="transition-opacity ease-in-out duration-300"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="card p-5 mt-5">
                        <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100 mb-5">
                            Business Operations
                        </h3>

                        <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-6">
                            <div class="space-y-1.5">
                                <p class="text-xs text-slate-400 dark:text-navy-300">Industry</p>
                                <p class="font-medium text-slate-700 dark:text-navy-100">{{ $kyb->industry }}</p>
                            </div>

                            <div class="space-y-1.5">
                                <p class="text-xs text-slate-400 dark:text-navy-300">Presence Type</p>
                                <p class="font-medium text-slate-700 dark:text-navy-100">
                                    @if($kyb->online_presence && $kyb->physical_presence)
                                    <span class="badge bg-info/10 text-info dark:bg-info/15 mr-1">Online</span>
                                    <span class="badge bg-info/10 text-info dark:bg-info/15">Physical</span>
                                    @elseif($kyb->online_presence)
                                    <span class="badge bg-info/10 text-info dark:bg-info/15">Online Only</span>
                                    @elseif($kyb->physical_presence)
                                    <span class="badge bg-info/10 text-info dark:bg-info/15">Physical Only</span>
                                    @else
                                    <span class="text-slate-500 dark:text-navy-300">Not Specified</span>
                                    @endif
                                </p>
                            </div>

                            <div class="space-y-1.5 sm:col-span-2">
                                <p class="text-xs text-slate-400 dark:text-navy-300">Business Description</p>
                                <p class="font-medium text-slate-700 dark:text-navy-100">{{ $kyb->business_description
                                    }}</p>
                            </div>

                            <div class="space-y-1.5 sm:col-span-2">
                                <p class="text-xs text-slate-400 dark:text-navy-300">Products/Services</p>
                                <p class="font-medium text-slate-700 dark:text-navy-100">{{ $kyb->products_services }}
                                </p>
                            </div>

                            <div class="space-y-1.5">
                                <p class="text-xs text-slate-400 dark:text-navy-300">Estimated Monthly Volume</p>
                                <p class="font-medium text-slate-700 dark:text-navy-100">${{
                                    number_format($kyb->estimated_monthly_volume, 2) }}</p>
                            </div>

                            <div class="space-y-1.5">
                                <p class="text-xs text-slate-400 dark:text-navy-300">Average Transaction Value</p>
                                <p class="font-medium text-slate-700 dark:text-navy-100">${{
                                    number_format($kyb->average_transaction_value, 2) }}</p>
                            </div>

                            <div class="space-y-1.5">
                                <p class="text-xs text-slate-400 dark:text-navy-300">Geographical Markets</p>
                                <div class="flex flex-wrap gap-1.5 mt-1">
                                    @php
                                    $markets = json_decode($kyb->geographical_markets);
                                    @endphp

                                    @foreach($markets as $market)
                                    <span class="badge bg-slate-150 text-slate-800 dark:bg-navy-700 dark:text-navy-100">
                                        {{ ucfirst($market) }}
                                    </span>
                                    @endforeach
                                </div>
                            </div>

                            <div class="space-y-1.5">
                                <p class="text-xs text-slate-400 dark:text-navy-300">Customer Base</p>
                                <p class="font-medium text-slate-700 dark:text-navy-100">{{ $kyb->customer_base }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Financial Information -->
                    <div x-show="activeTab === 'financial'"
                        x-transition:enter="transition-opacity ease-in-out duration-300"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="card p-5 mt-5">
                        <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100 mb-5">
                            Financial Information
                        </h3>

                        <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-6">
                            <div class="space-y-1.5">
                                <p class="text-xs text-slate-400 dark:text-navy-300">Bank Name</p>
                                <p class="font-medium text-slate-700 dark:text-navy-100">{{ $kyb->bank_name }}</p>
                            </div>

                            <div class="space-y-1.5">
                                <p class="text-xs text-slate-400 dark:text-navy-300">Bank Account Number</p>
                                <p class="font-medium text-slate-700 dark:text-navy-100">•••• {{
                                    substr($kyb->bank_account_number, -4) }}</p>
                            </div>

                            <div class="space-y-1.5">
                                <p class="text-xs text-slate-400 dark:text-navy-300">Bank Routing Number</p>
                                <p class="font-medium text-slate-700 dark:text-navy-100">•••• {{
                                    substr($kyb->bank_routing_number, -4) }}</p>
                            </div>

                            <div class="space-y-1.5">
                                <p class="text-xs text-slate-400 dark:text-navy-300">Financial Statement Date</p>
                                <p class="font-medium text-slate-700 dark:text-navy-100">{{
                                    \Carbon\Carbon::parse($kyb->financial_statement_date)->format('M d, Y') }}</p>
                            </div>

                            <div class="space-y-1.5">
                                <p class="text-xs text-slate-400 dark:text-navy-300">Annual Revenue</p>
                                <p class="font-medium text-slate-700 dark:text-navy-100">${{
                                    number_format($kyb->annual_revenue, 2) }}</p>
                            </div>

                            <div class="space-y-1.5">
                                <p class="text-xs text-slate-400 dark:text-navy-300">Previous Year Revenue</p>
                                <p class="font-medium text-slate-700 dark:text-navy-100">${{
                                    number_format($kyb->previous_year_revenue, 2) }}</p>
                            </div>

                            <div class="space-y-1.5">
                                <p class="text-xs text-slate-400 dark:text-navy-300">Current Assets</p>
                                <p class="font-medium text-slate-700 dark:text-navy-100">${{
                                    number_format($kyb->current_assets, 2) }}</p>
                            </div>

                            <div class="space-y-1.5">
                                <p class="text-xs text-slate-400 dark:text-navy-300">Total Liabilities</p>
                                <p class="font-medium text-slate-700 dark:text-navy-100">${{
                                    number_format($kyb->total_liabilities, 2) }}</p>
                            </div>
                        </div>

                        <div class="mt-6">
                            <div class="rounded-lg bg-slate-50 p-4 dark:bg-navy-600">
                                <div class="flex items-center space-x-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-info" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="text-sm text-slate-700 dark:text-navy-100">
                                        Financial information is securely stored and only accessible to authorized
                                        personnel for verification purposes.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Compliance Information -->
                    <div x-show="activeTab === 'compliance'"
                        x-transition:enter="transition-opacity ease-in-out duration-300"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="card p-5 mt-5">
                        <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100 mb-5">
                            Compliance Information
                        </h3>

                        <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-6">
                            <div class="space-y-1.5">
                                <p class="text-xs text-slate-400 dark:text-navy-300">AML Policy</p>
                                <p class="font-medium text-slate-700 dark:text-navy-100">
                                    @if($kyb->has_aml_policy)
                                    <span class="badge bg-success/10 text-success dark:bg-success/15">Yes</span>
                                    @else
                                    <span class="badge bg-error/10 text-error dark:bg-error/15">No</span>
                                    @endif
                                </p>
                            </div>

                            <div class="space-y-1.5">
                                <p class="text-xs text-slate-400 dark:text-navy-300">Sanctions Screening</p>
                                <p class="font-medium text-slate-700 dark:text-navy-100">
                                    @if($kyb->has_sanctions_screening)
                                    <span class="badge bg-success/10 text-success dark:bg-success/15">Yes</span>
                                    @else
                                    <span class="badge bg-error/10 text-error dark:bg-error/15">No</span>
                                    @endif
                                </p>
                            </div>

                            <div class="space-y-1.5">
                                <p class="text-xs text-slate-400 dark:text-navy-300">Compliance Officer</p>
                                <p class="font-medium text-slate-700 dark:text-navy-100">
                                    @if($kyb->has_compliance_officer)
                                    <span class="badge bg-success/10 text-success dark:bg-success/15">Yes</span>
                                    @else
                                    <span class="badge bg-error/10 text-error dark:bg-error/15">No</span>
                                    @endif
                                </p>
                            </div>

                            <div class="space-y-1.5">
                                <p class="text-xs text-slate-400 dark:text-navy-300">Regulated Entity</p>
                                <p class="font-medium text-slate-700 dark:text-navy-100">
                                    @if($kyb->is_regulated_entity)
                                    <span class="badge bg-success/10 text-success dark:bg-success/15">Yes</span>
                                    @else
                                    <span class="badge bg-error/10 text-error dark:bg-error/15">No</span>
                                    @endif
                                </p>
                            </div>

                            @if($kyb->has_compliance_officer)
                            <div class="space-y-1.5">
                                <p class="text-xs text-slate-400 dark:text-navy-300">Compliance Officer Name</p>
                                <p class="font-medium text-slate-700 dark:text-navy-100">{{
                                    $kyb->compliance_officer_name }}</p>
                            </div>

                            <div class="space-y-1.5">
                                <p class="text-xs text-slate-400 dark:text-navy-300">Compliance Officer Email</p>
                                <p class="font-medium text-slate-700 dark:text-navy-100">{{
                                    $kyb->compliance_officer_email }}</p>
                            </div>
                            @endif

                            @if($kyb->is_regulated_entity)
                            <div class="space-y-1.5 sm:col-span-2">
                                <p class="text-xs text-slate-400 dark:text-navy-300">Regulator Name</p>
                                <p class="font-medium text-slate-700 dark:text-navy-100">{{ $kyb->regulator_name }}</p>
                            </div>
                            @endif

                            <div class="space-y-1.5">
                                <p class="text-xs text-slate-400 dark:text-navy-300">Previous Violations</p>
                                <p class="font-medium text-slate-700 dark:text-navy-100">
                                    @if($kyb->has_previous_violations)
                                    <span class="badge bg-warning/10 text-warning dark:bg-warning/15">Yes</span>
                                    @else
                                    <span class="badge bg-success/10 text-success dark:bg-success/15">No</span>
                                    @endif
                                </p>
                            </div>

                            @if($kyb->has_previous_violations)
                            <div class="space-y-1.5 sm:col-span-2">
                                <p class="text-xs text-slate-400 dark:text-navy-300">Previous Violations Details</p>
                                <p class="font-medium text-slate-700 dark:text-navy-100">{{
                                    $kyb->previous_violations_details }}</p>
                            </div>
                            @endif

                            <div class="space-y-1.5 sm:col-span-2">
                                <p class="text-xs text-slate-400 dark:text-navy-300">Regulatory Licenses</p>
                                <div class="flex flex-wrap gap-1.5 mt-1">
                                    @php
                                    $licenses = json_decode($kyb->regulatory_licenses);
                                    @endphp

                                    @if(!empty($licenses))
                                    @foreach($licenses as $license)
                                    <span class="badge bg-slate-150 text-slate-800 dark:bg-navy-700 dark:text-navy-100">
                                        {{ ucfirst(str_replace('_', ' ', $license)) }}
                                    </span>
                                    @endforeach
                                    @else
                                    <span class="text-slate-500 dark:text-navy-300">None</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Documents -->
                    <div x-show="activeTab === 'documents'"
                        x-transition:enter="transition-opacity ease-in-out duration-300"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="card p-5 mt-5">
                        <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100 mb-5">
                            Uploaded Documents
                        </h3>

                        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
                            <div
                                class="card p-3 border border-slate-200 dark:border-navy-500 hover:shadow-sm transition-shadow">
                                <div class="flex items-center justify-between mb-3">
                                    <h4 class="text-sm font-medium text-slate-700 dark:text-navy-100">Business
                                        Registration</h4>
                                    <a href="{{ Storage::url($kyb->business_registration_doc) }}" target="_blank"
                                        class="btn h-7 w-7 rounded-full bg-primary/10 p-0 text-primary hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:bg-accent/10 dark:text-accent-light dark:hover:bg-accent/20 dark:focus:bg-accent/20 dark:active:bg-accent/25">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                        </svg>
                                    </a>
                                </div>

                                <div
                                    class="h-20 w-full flex items-center justify-center rounded-lg border border-slate-300 dark:border-navy-450 bg-slate-50 dark:bg-navy-600">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-10 w-10 text-primary dark:text-accent" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>

                                <div class="mt-2 text-xs text-center text-slate-500 dark:text-navy-300">
                                    Uploaded on {{ \Carbon\Carbon::parse($kyb->created_at)->format('M d, Y') }}
                                </div>
                            </div>

                            <div
                                class="card p-3 border border-slate-200 dark:border-navy-500 hover:shadow-sm transition-shadow">
                                <div class="flex items-center justify-between mb-3">
                                    <h4 class="text-sm font-medium text-slate-700 dark:text-navy-100">Proof of Address
                                    </h4>
                                    <a href="{{ Storage::url($kyb->proof_of_address_doc) }}" target="_blank"
                                        class="btn h-7 w-7 rounded-full bg-primary/10 p-0 text-primary hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:bg-accent/10 dark:text-accent-light dark:hover:bg-accent/20 dark:focus:bg-accent/20 dark:active:bg-accent/25">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                        </svg>
                                    </a>
                                </div>

                                <div
                                    class="h-20 w-full flex items-center justify-center rounded-lg border border-slate-300 dark:border-navy-450 bg-slate-50 dark:bg-navy-600">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-10 w-10 text-primary dark:text-accent" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>

                                <div class="mt-2 text-xs text-center text-slate-500 dark:text-navy-300">
                                    Uploaded on {{ \Carbon\Carbon::parse($kyb->created_at)->format('M d, Y') }}
                                </div>
                            </div>

                            <div
                                class="card p-3 border border-slate-200 dark:border-navy-500 hover:shadow-sm transition-shadow">
                                <div class="flex items-center justify-between mb-3">
                                    <h4 class="text-sm font-medium text-slate-700 dark:text-navy-100">Financial
                                        Statements</h4>
                                    <a href="{{ Storage::url($kyb->financial_statements_doc) }}" target="_blank"
                                        class="btn h-7 w-7 rounded-full bg-primary/10 p-0 text-primary hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:bg-accent/10 dark:text-accent-light dark:hover:bg-accent/20 dark:focus:bg-accent/20 dark:active:bg-accent/25">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                        </svg>
                                    </a>
                                </div>

                                <div
                                    class="h-20 w-full flex items-center justify-center rounded-lg border border-slate-300 dark:border-navy-450 bg-slate-50 dark:bg-navy-600">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-10 w-10 text-primary dark:text-accent" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>

                                <div class="mt-2 text-xs text-center text-slate-500 dark:text-navy-300">
                                    Uploaded on {{ \Carbon\Carbon::parse($kyb->created_at)->format('M d, Y') }}
                                </div>
                            </div>

                            <div
                                class="card p-3 border border-slate-200 dark:border-navy-500 hover:shadow-sm transition-shadow">
                                <div class="flex items-center justify-between mb-3">
                                    <h4 class="text-sm font-medium text-slate-700 dark:text-navy-100">Ownership
                                        Structure</h4>
                                    <a href="{{ Storage::url($kyb->ownership_structure_doc) }}" target="_blank"
                                        class="btn h-7 w-7 rounded-full bg-primary/10 p-0 text-primary hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:bg-accent/10 dark:text-accent-light dark:hover:bg-accent/20 dark:focus:bg-accent/20 dark:active:bg-accent/25">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                        </svg>
                                    </a>
                                </div>

                                <div
                                    class="h-20 w-full flex items-center justify-center rounded-lg border border-slate-300 dark:border-navy-450 bg-slate-50 dark:bg-navy-600">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-10 w-10 text-primary dark:text-accent" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>

                                <div class="mt-2 text-xs text-center text-slate-500 dark:text-navy-300">
                                    Uploaded on {{ \Carbon\Carbon::parse($kyb->created_at)->format('M d, Y') }}
                                </div>
                            </div>

                            @if($kyb->has_aml_policy && $kyb->compliance_policy_doc)
                            <div
                                class="card p-3 border border-slate-200 dark:border-navy-500 hover:shadow-sm transition-shadow">
                                <div class="flex items-center justify-between mb-3">
                                    <h4 class="text-sm font-medium text-slate-700 dark:text-navy-100">Compliance Policy
                                    </h4>
                                    <a href="{{ Storage::url($kyb->compliance_policy_doc) }}" target="_blank"
                                        class="btn h-7 w-7 rounded-full bg-primary/10 p-0 text-primary hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:bg-accent/10 dark:text-accent-light dark:hover:bg-accent/20 dark:focus:bg-accent/20 dark:active:bg-accent/25">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                        </svg>
                                    </a>
                                </div>

                                <div
                                    class="h-20 w-full flex items-center justify-center rounded-lg border border-slate-300 dark:border-navy-450 bg-slate-50 dark:bg-navy-600">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-10 w-10 text-primary dark:text-accent" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>

                                <div class="mt-2 text-xs text-center text-slate-500 dark:text-navy-300">
                                    Uploaded on {{ \Carbon\Carbon::parse($kyb->created_at)->format('M d, Y') }}
                                </div>
                            </div>
                            @endif

                            @if($kyb->additional_documents)
                            <div class="sm:col-span-2 lg:col-span-3 mt-3">
                                <h4 class="text-base font-medium text-slate-700 dark:text-navy-100 mb-3">Additional
                                    Documents</h4>

                                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
                                    @php
                                    $additionalDocs = json_decode($kyb->additional_documents, true) ?: [];
                                    @endphp

                                    @foreach($additionalDocs as $doc)
                                    <div
                                        class="card p-3 border border-slate-200 dark:border-navy-500 hover:shadow-sm transition-shadow">
                                        <div class="flex items-center justify-between mb-3">
                                            <h4 class="text-sm font-medium text-slate-700 dark:text-navy-100">{{
                                                ucfirst(str_replace('_', ' ', $doc['type'])) }}</h4>
                                            <a href="{{ Storage::url($doc['path']) }}" target="_blank"
                                                class="btn h-7 w-7 rounded-full bg-primary/10 p-0 text-primary hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:bg-accent/10 dark:text-accent-light dark:hover:bg-accent/20 dark:focus:bg-accent/20 dark:active:bg-accent/25">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor"> class="h-4.5 w-4.5"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                </svg>
                                            </a>
                                        </div>

                                        <div
                                            class="h-20 w-full flex items-center justify-center rounded-lg border border-slate-300 dark:border-navy-450 bg-slate-50 dark:bg-navy-600">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-10 w-10 text-primary dark:text-accent" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </div>

                                        <div class="mt-2 text-xs text-center text-slate-500 dark:text-navy-300">
                                            Uploaded on {{ \Carbon\Carbon::parse($doc['uploaded_at'])->format('M d, Y')
                                            }}
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-between mt-6">
                        <a href="{{ route('merchant.kyb.dashboard') }}"
                            class="btn border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                            </svg>
                            <span>Back to Dashboard</span>
                        </a>

                        @if($kyb->status == 'pending' || $kyb->status == 'kiv')
                        <div class="flex gap-2">
                            <a href="{{ route('merchant.kyb.upload-additional') }}"
                                class="btn bg-warning font-medium text-white hover:bg-warning-focus focus:bg-warning-focus active:bg-warning-focus/90">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                </svg>
                                <span>Upload Documents</span>
                            </a>

                            <a href="{{ route('merchant.kyb.update') }}"
                                class="btn bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                <span>Update Application</span>
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-app-layout-sideblock>
