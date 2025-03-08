<div>
    <!-- KYB Application Details -->
    <div class="grid grid-cols-1 gap-4 sm:gap-5 lg:grid-cols-3 lg:gap-6">
        <!-- Business Information -->
        <div class="card lg:col-span-2 p-4 sm:p-5">
            <div class="flex items-center justify-between space-x-2">
                <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                    {{ __('Business Information') }}
                </h2>
                <div
                    class="badge rounded-full @if($kyb->status === 'pending') bg-warning/10 text-warning dark:bg-warning/15 @elseif($kyb->status === 'approved') bg-success/10 text-success dark:bg-success/15 @elseif($kyb->status === 'rejected') bg-error/10 text-error dark:bg-error/15 @elseif($kyb->status === 'additional_info') bg-info/10 text-info dark:bg-info/15 @endif">
                    {{ ucfirst(str_replace('_', ' ', $kyb->status)) }}
                </div>
            </div>
            <div class="mt-5 space-y-4">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div class="space-y-2">
                        <h3 class="text-sm+ font-medium text-slate-700 dark:text-navy-100">
                            {{ __('Legal Business Name') }}
                        </h3>
                        <p>{{ $kyb->legal_name }}</p>
                    </div>
                    <div class="space-y-2">
                        <h3 class="text-sm+ font-medium text-slate-700 dark:text-navy-100">
                            {{ __('Registration Number') }}
                        </h3>
                        <p>{{ $kyb->registration_number }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div class="space-y-2">
                        <h3 class="text-sm+ font-medium text-slate-700 dark:text-navy-100">
                            {{ __('Business Type') }}
                        </h3>
                        <p>{{ ucfirst(str_replace('_', ' ', $kyb->business_type)) }}</p>
                    </div>
                    <div class="space-y-2">
                        <h3 class="text-sm+ font-medium text-slate-700 dark:text-navy-100">
                            {{ __('Tax ID / VAT Number') }}
                        </h3>
                        <p>{{ $kyb->tax_id }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div class="space-y-2">
                        <h3 class="text-sm+ font-medium text-slate-700 dark:text-navy-100">
                            {{ __('Incorporation Date') }}
                        </h3>
                        <p>{{ $kyb->incorporation_date ? $kyb->incorporation_date->format('M d, Y') : 'N/A' }}</p>
                    </div>
                    <div class="space-y-2">
                        <h3 class="text-sm+ font-medium text-slate-700 dark:text-navy-100">
                            {{ __('Number of Employees') }}
                        </h3>
                        <p>{{ $kyb->employee_count }}</p>
                    </div>
                </div>

                <div class="space-y-2">
                    <h3 class="text-sm+ font-medium text-slate-700 dark:text-navy-100">
                        {{ __('Business Description') }}
                    </h3>
                    <p class="text-justify">{{ $kyb->business_description }}</p>
                </div>

                <div class="space-y-2">
                    <h3 class="text-sm+ font-medium text-slate-700 dark:text-navy-100">
                        {{ __('Website') }}
                    </h3>
                    <p>
                        @if($kyb->website)
                        <a href="{{ $kyb->website }}" target="_blank"
                            class="text-primary hover:underline dark:text-accent-light">
                            {{ $kyb->website }}
                        </a>
                        @else
                        N/A
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="card p-4 sm:p-5">
            <div class="flex items-center space-x-2">
                <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                    {{ __('Contact Information') }}
                </h2>
            </div>
            <div class="mt-5 space-y-4">
                <div class="space-y-2">
                    <h3 class="text-sm+ font-medium text-slate-700 dark:text-navy-100">
                        {{ __('Business Email') }}
                    </h3>
                    <p>{{ $kyb->business_email }}</p>
                </div>

                <div class="space-y-2">
                    <h3 class="text-sm+ font-medium text-slate-700 dark:text-navy-100">
                        {{ __('Business Phone') }}
                    </h3>
                    <p>{{ $kyb->business_phone }}</p>
                </div>

                <div class="space-y-2">
                    <h3 class="text-sm+ font-medium text-slate-700 dark:text-navy-100">
                        {{ __('Contact Person') }}
                    </h3>
                    <p>{{ $kyb->contact_name }}</p>
                </div>

                <div class="space-y-2">
                    <h3 class="text-sm+ font-medium text-slate-700 dark:text-navy-100">
                        {{ __('Contact Position') }}
                    </h3>
                    <p>{{ $kyb->contact_position }}</p>
                </div>

                <div class="space-y-2">
                    <h3 class="text-sm+ font-medium text-slate-700 dark:text-navy-100">
                        {{ __('Contact Email') }}
                    </h3>
                    <p>{{ $kyb->contact_email }}</p>
                </div>

                <div class="space-y-2">
                    <h3 class="text-sm+ font-medium text-slate-700 dark:text-navy-100">
                        {{ __('Contact Phone') }}
                    </h3>
                    <p>{{ $kyb->contact_phone }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Address Information -->
    <div class="card mt-4 sm:mt-5 lg:mt-6 p-4 sm:p-5">
        <div class="flex items-center space-x-2">
            <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                {{ __('Address Information') }}
            </h2>
        </div>
        <div class="mt-5 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <div class="space-y-2">
                <h3 class="text-sm+ font-medium text-slate-700 dark:text-navy-100">
                    {{ __('Street Address') }}
                </h3>
                <p>{{ $kyb->address_street }}</p>
            </div>

            <div class="space-y-2">
                <h3 class="text-sm+ font-medium text-slate-700 dark:text-navy-100">
                    {{ __('City') }}
                </h3>
                <p>{{ $kyb->address_city }}</p>
            </div>

            <div class="space-y-2">
                <h3 class="text-sm+ font-medium text-slate-700 dark:text-navy-100">
                    {{ __('State/Province') }}
                </h3>
                <p>{{ $kyb->address_state }}</p>
            </div>

            <div class="space-y-2">
                <h3 class="text-sm+ font-medium text-slate-700 dark:text-navy-100">
                    {{ __('Postal Code') }}
                </h3>
                <p>{{ $kyb->address_postal_code }}</p>
            </div>

            <div class="space-y-2">
                <h3 class="text-sm+ font-medium text-slate-700 dark:text-navy-100">
                    {{ __('Country') }}
                </h3>
                <p>{{ $kyb->address_country }}</p>
            </div>
        </div>
    </div>

    <!-- Documents -->
    <div class="card mt-4 sm:mt-5 lg:mt-6 p-4 sm:p-5">
        <div class="flex items-center space-x-2">
            <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                {{ __('Uploaded Documents') }}
            </h2>
        </div>
        <div class="mt-5 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @if($kyb->registration_document)
            <div class="card border border-slate-150 px-4 py-4 dark:border-navy-600">
                <div class="flex justify-between space-x-1">
                    <div>
                        <p class="text-slate-700 line-clamp-1 dark:text-navy-100">
                            {{ __('Business Registration') }}
                        </p>
                        <p class="text-xs text-slate-400 line-clamp-1 dark:text-navy-300">
                            {{ basename($kyb->registration_document) }}
                        </p>
                    </div>
                    <div class="flex space-x-2">
                        <button
                            wire:click="viewDocument('{{ $kyb->registration_document }}', '{{ __('Business Registration') }}')"
                            class="btn h-7 w-7 rounded-full p-0 text-primary hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:text-accent-light dark:hover:bg-accent-light/20 dark:focus:bg-accent-light/20 dark:active:bg-accent-light/25">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                        <a href="{{ Storage::url($kyb->registration_document) }}" download
                            class="btn h-7 w-7 rounded-full p-0 text-info hover:bg-info/20 focus:bg-info/20 active:bg-info/25">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            @endif

            @if($kyb->tax_document)
            <div class="card border border-slate-150 px-4 py-4 dark:border-navy-600">
                <div class="flex justify-between space-x-1">
                    <div>
                        <p class="text-slate-700 line-clamp-1 dark:text-navy-100">
                            {{ __('Tax Document') }}
                        </p>
                        <p class="text-xs text-slate-400 line-clamp-1 dark:text-navy-300">
                            {{ basename($kyb->tax_document) }}
                        </p>
                    </div>
                    <div class="flex space-x-2">
                        <button wire:click="viewDocument('{{ $kyb->tax_document }}', '{{ __('Tax Document') }}')"
                            class="btn h-7 w-7 rounded-full p-0 text-primary hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:text-accent-light dark:hover:bg-accent-light/20 dark:focus:bg-accent-light/20 dark:active:bg-accent-light/25">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                        <a href="{{ Storage::url($kyb->tax_document) }}" download
                            class="btn h-7 w-7 rounded-full p-0 text-info hover:bg-info/20 focus:bg-info/20 active:bg-info/25">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            @endif

            @if($kyb->address_proof)
            <div class="card border border-slate-150 px-4 py-4 dark:border-navy-600">
                <div class="flex justify-between space-x-1">
                    <div>
                        <p class="text-slate-700 line-clamp-1 dark:text-navy-100">
                            {{ __('Address Proof') }}
                        </p>
                        <p class="text-xs text-slate-400 line-clamp-1 dark:text-navy-300">
                            {{ basename($kyb->address_proof) }}
                        </p>
                    </div>
                    <div class="flex space-x-2">
                        <button wire:click="viewDocument('{{ $kyb->address_proof }}', '{{ __('Address Proof') }}')"
                            class="btn h-7 w-7 rounded-full p-0 text-primary hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:text-accent-light dark:hover:bg-accent-light/20 dark:focus:bg-accent-light/20 dark:active:bg-accent-light/25">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                        <a href="{{ Storage::url($kyb->address_proof) }}" download
                            class="btn h-7 w-7 rounded-full p-0 text-info hover:bg-info/20 focus:bg-info/20 active:bg-info/25">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            @endif

            @if($kyb->bank_statement)
            <div class="card border border-slate-150 px-4 py-4 dark:border-navy-600">
                <div class="flex justify-between space-x-1">
                    <div>
                        <p class="text-slate-700 line-clamp-1 dark:text-navy-100">
                            {{ __('Bank Statement') }}
                        </p>
                        <p class="text-xs text-slate-400 line-clamp-1 dark:text-navy-300">
                            {{ basename($kyb->bank_statement) }}
                        </p>
                    </div>
                    <div class="flex space-x-2">
                        <button wire:click="viewDocument('{{ $kyb->bank_statement }}', '{{ __('Bank Statement') }}')"
                            class="btn h-7 w-7 rounded-full p-0 text-primary hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:text-accent-light dark:hover:bg-accent-light/20 dark:focus:bg-accent-light/20 dark:active:bg-accent-light/25">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                        <a href="{{ Storage::url($kyb->bank_statement) }}" download
                            class="btn h-7 w-7 rounded-full p-0 text-info hover:bg-info/20 focus:bg-info/20 active:bg-info/25">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            @endif

            @if($kyb->additional_documents)
            @foreach(json_decode($kyb->additional_documents, true) ?? [] as $index => $document)
            <div class="card border border-slate-150 px-4 py-4 dark:border-navy-600">
                <div class="flex justify-between space-x-1">
                    <div>
                        <p class="text-slate-700 line-clamp-1 dark:text-navy-100">
                            {{ __('Additional Document') }} #{{ $index + 1 }}
                        </p>
                        <p class="text-xs text-slate-400 line-clamp-1 dark:text-navy-300">
                            {{ basename($document) }}
                        </p>
                    </div>
                    <div class="flex space-x-2">
                        <button
                            wire:click="viewDocument('{{ $document }}', '{{ __('Additional Document') }} #{{ $index + 1 }}')"
                            class="btn h-7 w-7 rounded-full p-0 text-primary hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:text-accent-light dark:hover:bg-accent-light/20 dark:focus:bg-accent-light/20 dark:active:bg-accent-light/25">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                        <a href="{{ Storage::url($document) }}" download
                            class="btn h-7 w-7 rounded-full p-0 text-info hover:bg-info/20 focus:bg-info/20 active:bg-info/25">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </div>

    <!-- Verification Actions -->
    <div class="grid grid-cols-1 gap-4 sm:gap-5 lg:grid-cols-2 lg:gap-6 mt-4 sm:mt-5 lg:mt-6">
        <!-- Verification Actions -->
        <div class="card p-4 sm:p-5">
            <div class="flex items-center space-x-2">
                <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                    {{ __('Verification Actions') }}
                </h2>
            </div>
            <div class="mt-5 space-y-4">
                @if($kyb->status === 'pending' || $kyb->status === 'additional_info')
                <div class="space-y-2">
                    <button wire:click="approve"
                        class="btn w-full bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
                        {{ __('Approve Application') }}
                    </button>
                </div>

                <div class="space-y-2">
                    <button x-data x-on:click="$dispatch('open-modal', { name: 'reject-modal' })"
                        class="btn w-full bg-error font-medium text-white hover:bg-error-focus focus:bg-error-focus active:bg-error-focus/90">
                        {{ __('Reject Application') }}
                    </button>
                </div>

                <div class="space-y-2">
                    <button x-data x-on:click="$dispatch('open-modal', { name: 'request-info-modal' })"
                        class="btn w-full bg-info font-medium text-white hover:bg-info-focus focus:bg-info-focus active:bg-info-focus/90">
                        {{ __('Request Additional Information') }}
                    </button>
                </div>
                @else
                <div class="alert flex rounded-lg bg-primary/10 py-4 px-4 text-primary dark:bg-primary/15">
                    <div class="flex flex-1 items-center justify-between">
                        <p>{{ __('This application has already been processed.') }}</p>
                    </div>
                </div>
                @endif

                <div class="space-y-2">
                    <button x-data x-on:click="$dispatch('open-modal', { name: 'add-note-modal' })"
                        class="btn w-full border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                        {{ __('Add Admin Note') }}
                    </button>
                </div>
            </div>
        </div>

        <!-- Status Timeline -->
        <div class="card p-4 sm:p-5">
            <div class="flex items-center space-x-2">
                <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                    {{ __('Status Timeline') }}
                </h2>
            </div>
            <div class="mt-5 space-y-4">
                <div class="is-scrollbar-hidden min-w-full overflow-x-auto">
                    <ol class="timeline max-w-sm [--size:1.5rem]">
                        @forelse($statusHistory as $history)
                        <li class="timeline-item">
                            <div
                                class="timeline-item-point
                                    @if($history->status === 'pending') rounded-full bg-warning @elseif($history->status === 'approved') rounded-full bg-success @elseif($history->status === 'rejected') rounded-full bg-error @elseif($history->status === 'additional_info') rounded-full bg-info @else rounded-full bg-slate-300 dark:bg-navy-400 @endif">
                            </div>
                            <div class="timeline-item-content flex-1 pl-4 sm:pl-8">
                                <div class="flex flex-col justify-between pb-2 sm:flex-row sm:pb-0">
                                    <p class="pb-2 font-medium leading-none text-slate-600 dark:text-navy-100 sm:pb-0">
                                        @if($history->is_note)
                                        {{ __('Admin Note') }}
                                        @else
                                        {{ ucfirst(str_replace('_', ' ', $history->status)) }}
                                        @endif
                                    </p>
                                    <span class="text-xs text-slate-400 dark:text-navy-300">{{
                                        $history->created_at->format('M d, Y H:i') }}</span>
                                </div>
                                <p class="py-1">{{ $history->comment }}</p>
                                <div class="text-xs text-slate-400 dark:text-navy-300">
                                    {{ __('By') }}: {{ $history->user->name }}
                                </div>
                            </div>
                        </li>
                        @empty
                        <li class="timeline-item">
                            <div class="timeline-item-point rounded-full bg-slate-300 dark:bg-navy-400"></div>
                            <div class="timeline-item-content flex-1 pl-4 sm:pl-8">
                                <div class="flex flex-col justify-between pb-2 sm:flex-row sm:pb-0">
                                    <p class="pb-2 font-medium leading-none text-slate-600 dark:text-navy-100 sm:pb-0">
                                        {{ __('Application Submitted') }}
                                    </p>
                                    <span class="text-xs text-slate-400 dark:text-navy-300">{{
                                        $kyb->created_at->format('M d, Y H:i') }}</span>
                                </div>
                                <p class="py-1">{{ __('KYB application was submitted.') }}</p>
                            </div>
                        </li>
                        @endforelse
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Document Modal -->
    <div x-data="{ isOpen: @entangle('showDocumentModal') }" x-show="isOpen"
        x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
        style="display: none;">
        <div x-show="isOpen" x-transition:enter="transition ease-out duration-150"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="relative max-w-lg rounded-lg bg-white px-4 py-10 text-center dark:bg-navy-700 sm:px-5"
            style="display: none;">
            <div class="mt-4 px-4 sm:px-12">
                <h3 class="text-lg text-slate-800 dark:text-navy-50">
                    {{ $currentDocument ? $currentDocument['name'] : '' }}
                </h3>
                <div class="mt-4">
                    @if($currentDocument)
                    <div class="flex justify-center">
                        @php
                        $extension = pathinfo($currentDocument['path'], PATHINFO_EXTENSION);
                        $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                        $isPdf = strtolower($extension) === 'pdf';
                        @endphp

                        @if($isImage)
                        <img src="{{ Storage::url($currentDocument['path']) }}" alt="{{ $currentDocument['name'] }}"
                            class="max-h-96 max-w-full object-contain">
                        @elseif($isPdf)
                        <iframe src="{{ Storage::url($currentDocument['path']) }}" class="h-96 w-full"></iframe>
                        @else
                        <div
                            class="flex h-40 w-full items-center justify-center rounded-lg border border-dashed border-slate-300 dark:border-navy-500">
                            <span class="text-slate-500 dark:text-navy-200">{{ __('Preview not available. Please
                                download the file.') }}</span>
                        </div>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
            <div class="mt-6 space-x-3">
                @if($currentDocument)
                <a href="{{ Storage::url($currentDocument['path']) }}" download
                    class="btn min-w-[7rem] bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                    {{ __('Download') }}
                </a>
                @endif
                <button wire:click="closeDocumentModal"
                    class="btn min-w-[7rem] border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                    {{ __('Close') }}
                </button>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div x-data="{ shown: false, name: '' }" x-show="shown"
        x-on:open-modal.window="if($event.detail.name === name) shown = true"
        x-on:close-modal.window="if($event.detail.name === name) shown = false"
        x-on:keydown.escape.window="shown = false" x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
        x-init="name = 'reject-modal'" style="display: none;">
        <div x-show="shown" x-transition:enter="transition ease-out duration-150"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95" @click.outside="shown = false"
            class="relative w-full max-w-lg rounded-lg bg-white px-4 py-10 text-center dark:bg-navy-700 sm:px-5"
            style="display: none;">
            <div class="mt-4 px-4 sm:px-12">
                <h3 class="text-lg text-slate-800 dark:text-navy-50">
                    {{ __('Reject KYB Application') }}
                </h3>
                <p class="mt-2 text-slate-500 dark:text-navy-200">
                    {{ __('Please provide a reason for rejecting this application.') }}
                </p>
                <div class="mt-4">
                    <textarea wire:model.defer="rejectionReason"
                        class="form-textarea w-full rounded-lg border border-slate-300 bg-transparent p-2.5 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                        rows="4" placeholder="{{ __('Enter rejection reason...') }}"></textarea>
                    @error('rejectionReason')
                    <span class="text-tiny+ text-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="mt-6 space-x-3">
                <button wire:click="reject"
                    class="btn min-w-[7rem] bg-error font-medium text-white hover:bg-error-focus focus:bg-error-focus active:bg-error-focus/90">
                    {{ __('Reject') }}
                </button>
                <button @click="shown = false"
                    class="btn min-w-[7rem] border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                    {{ __('Cancel') }}
                </button>
            </div>
        </div>
    </div>

    <!-- Request Additional Info Modal -->
    <div x-data="{ shown: false, name: '' }" x-show="shown"
        x-on:open-modal.window="if($event.detail.name === name) shown = true"
        x-on:close-modal.window="if($event.detail.name === name) shown = false"
        x-on:keydown.escape.window="shown = false" x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
        x-init="name = 'request-info-modal'" style="display: none;">
        <div x-show="shown" x-transition:enter="transition ease-out duration-150"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95" @click.outside="shown = false"
            class="relative w-full max-w-lg rounded-lg bg-white px-4 py-10 text-center dark:bg-navy-700 sm:px-5"
            style="display: none;">
            <div class="mt-4 px-4 sm:px-12">
                <h3 class="text-lg text-slate-800 dark:text-navy-50">
                    {{ __('Request Additional Information') }}
                </h3>
                <p class="mt-2 text-slate-500 dark:text-navy-200">
                    {{ __('Please specify what additional information is required.') }}
                </p>
                <div class="mt-4">
                    <textarea wire:model.defer="additionalInfoRequest"
                        class="form-textarea w-full rounded-lg border border-slate-300 bg-transparent p-2.5 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                        rows="4" placeholder="{{ __('Enter details about required information...') }}"></textarea>
                    @error('additionalInfoRequest')
                    <span class="text-tiny+ text-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="mt-6 space-x-3">
                <button wire:click="requestAdditionalInfo"
                    class="btn min-w-[7rem] bg-info font-medium text-white hover:bg-info-focus focus:bg-info-focus active:bg-info-focus/90">
                    {{ __('Request Info') }}
                </button>
                <button @click="shown = false"
                    class="btn min-w-[7rem] border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                    {{ __('Cancel') }}
                </button>
            </div>
        </div>
    </div>

    <!-- Add Note Modal -->
    <div x-data="{ shown: false, name: '' }" x-show="shown"
        x-on:open-modal.window="if($event.detail.name === name) shown = true"
        x-on:close-modal.window="if($event.detail.name === name) shown = false"
        x-on:keydown.escape.window="shown = false" x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
        x-init="name = 'add-note-modal'" style="display: none;">
        <div x-show="shown" x-transition:enter="transition ease-out duration-150"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95" @click.outside="shown = false"
            class="relative w-full max-w-lg rounded-lg bg-white px-4 py-10 text-center dark:bg-navy-700 sm:px-5"
            style="display: none;">
            <div class="mt-4 px-4 sm:px-12">
                <h3 class="text-lg text-slate-800 dark:text-navy-50">
                    {{ __('Add Admin Note') }}
                </h3>
                <p class="mt-2 text-slate-500 dark:text-navy-200">
                    {{ __('Add a note to this application (visible only to admins).') }}
                </p>
                <div class="mt-4">
                    <textarea wire:model.defer="adminNote"
                        class="form-textarea w-full rounded-lg border border-slate-300 bg-transparent p-2.5 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                        rows="4" placeholder="{{ __('Enter your note...') }}"></textarea>
                    @error('adminNote')
                    <span class="text-tiny+ text-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="mt-6 space-x-3">
                <button wire:click="addNote"
                    class="btn min-w-[7rem] bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                    {{ __('Add Note') }}
                </button>
                <button @click="shown = false"
                    class="btn min-w-[7rem] border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                    {{ __('Cancel') }}
                </button>
            </div>
        </div>
    </div>
</div>