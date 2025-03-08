<div>
    <form wire:submit.prevent="submit">
        @if($kyb->additional_info_requested)
        <div class="mb-6">
            <h3 class="text-base font-medium text-slate-700 dark:text-navy-100 mb-3">
                Your Response
            </h3>
            <label class="block">
                <span class="font-medium text-slate-600 dark:text-navy-100">Response to Information Request</span>
                <textarea wire:model="additional_info_response"
                    class="form-textarea mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                    placeholder="Provide your response to the additional information request" rows="4"></textarea>
                @error('additional_info_response') <span class="text-error text-sm">{{ $message }}</span> @enderror
            </label>
        </div>
        @endif

        <h3 class="text-base font-medium text-slate-700 dark:text-navy-100 mb-4">
            Upload Documents
        </h3>

        <!-- Document upload section -->
        <div class="card p-4 sm:p-5 mb-6">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <label class="block">
                    <span class="font-medium text-slate-600 dark:text-navy-100">Document Type</span>
                    <select wire:model="additional_document_type"
                        class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">
                        <option value="supporting_document">Supporting Document</option>
                        <option value="financial_document">Financial Document</option>
                        <option value="identity_document">Identity Document</option>
                        <option value="compliance_document">Compliance Document</option>
                        <option value="other">Other</option>
                    </select>
                    @error('additional_document_type') <span class="text-error text-sm">{{ $message }}</span> @enderror
                </label>

                <div>
                    <span class="font-medium text-slate-600 dark:text-navy-100">Document File</span>
                    <div class="mt-1.5">
                        <label
                            class="btn bg-slate-150 font-medium text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90 w-full">
                            <input type="file" wire:model="additional_document" class="hidden">
                            <span>Choose Document</span>
                        </label>
                        @error('additional_document') <span class="text-error text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="mt-4 flex justify-end">
                <button type="button" wire:click="addDocument"
                    class="btn bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                    Add Document
                </button>
            </div>
        </div>

        <!-- Added Documents List -->
        <div class="mb-6">
            <h3 class="text-base font-medium text-slate-700 dark:text-navy-100 mb-4">
                Added Documents
            </h3>

            @if(empty($documents))
            <div
                class="p-4 border border-dashed rounded-lg border-slate-300 dark:border-navy-450 flex items-center justify-center">
                <p class="text-slate-500 dark:text-navy-300">No documents added yet</p>
            </div>
            @else
            <div class="space-y-3">
                @foreach($documents as $index => $document)
                <div class="p-3 border rounded-lg border-slate-200 dark:border-navy-500 bg-slate-50 dark:bg-navy-600">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary dark:text-accent"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-slate-700 dark:text-navy-100">{{ $document['name'] }}
                                </p>
                                <p class="text-xs text-slate-500 dark:text-navy-300">{{ ucfirst(str_replace('_', ' ',
                                    $document['type'])) }}</p>
                            </div>
                        </div>
                        <button type="button" wire:click="removeDocument({{ $index }})"
                            class="btn h-7 w-7 rounded-full p-0 text-error hover:bg-error/20 focus:bg-error/20 active:bg-error/25">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>

        <!-- Form Actions -->
        <div class="flex justify-between">
            <a href="{{ route('merchant.kyb.view', $kyb->id) }}"
                class="btn border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                Cancel
            </a>
            <button type="submit"
                class="btn bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                Submit Documents
            </button>
        </div>
    </form>

    <script>
        document.addEventListener('livewire:initialized', function() {
            Livewire.on('document-added', function() {
                // Show a notification when a document is added
                const event = new CustomEvent('notify', {
                    detail: {
                        type: 'success',
                        message: 'Document added successfully'
                    }
                });
                window.dispatchEvent(event);
            });
        });
    </script>
</div>
