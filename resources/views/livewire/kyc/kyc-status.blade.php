<div class="card p-4 sm:p-5">
    <div class="py-4">
        <div class="mx-auto">
            <div class="transition-all duration-200 bg-white shadow-sm rounded-xl dark:bg-navy-700">
                <div class="p-6 sm:p-8">
                    <!-- Status Section -->
                    <div class="mb-8 overflow-hidden bg-slate-50 shadow-sm rounded-xl dark:bg-navy-800">
                        <div class="p-6">
                            <h3 class="mb-4 text-lg font-medium text-slate-700 dark:text-navy-100">KYC Status</h3>

                            <div class="grid gap-4 md:grid-cols-1">
                                <!-- Verification Status -->
                                <div class="p-4 rounded-lg bg-white dark:bg-navy-700">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-sm font-medium text-slate-500 dark:text-navy-300">Verification
                                            Status</span>
                                        <span class="px-2 py-1 text-xs font-medium rounded-full
                                                        {{ $kyc->status === 'approved' ? 'bg-success/10 text-success' :
                                                           ($kyc->status === 'rejected' ? 'bg-error/10 text-error' :
                                                           'bg-warning/10 text-warning') }}">
                                            {{ ucfirst($kyc->status) }}
                                        </span>
                                    </div>
                                    @if($kyc->rejection_reason)
                                    <div class="mt-2 p-3 rounded-lg border border-error/30 bg-error/10 text-error">
                                        <p class="text-sm">
                                            <span class="font-semibold">Reason:</span> {{ $kyc->rejection_reason }}
                                        </p>
                                    </div>
                                    @endif

                                    <!-- Additional Information Request Alert -->
                                    @if($kyc->additional_info_requested)
                                    <div class="mt-4 p-3 rounded-lg border border-amber-300/30 bg-amber-50 dark:border-amber-400/20 dark:bg-amber-900/20">
                                        <div class="flex items-start">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-5 w-5 text-amber-500 dark:text-amber-400 mt-0.5 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <div>
                                                <h4 class="text-sm font-medium text-amber-600 dark:text-amber-400">Additional Information Requested</h4>
                                                <p class="mt-1 text-sm text-amber-600/80 dark:text-amber-400/80">{{ $kyc->additional_info_requested }}</p>
                                                <p class="mt-1 text-xs text-amber-500/70 dark:text-amber-400/60">
                                                    Requested on {{ $kyc->additional_info_requested_at ? $kyc->additional_info_requested_at->format('M d,
                                                    Y') : 'N/A' }}
                                                </p>
                                                <div class="mt-3">
                                                    <a href="{{ route('kyc.update', $kyc) }}"
                                                        class="btn bg-amber-500 font-medium text-white hover:bg-amber-600 focus:bg-amber-600 active:bg-amber-600/90 dark:bg-amber-600 dark:hover:bg-amber-500 dark:focus:bg-amber-500 dark:active:bg-amber-500/90">
                                                        Update KYC Information
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
                        <!-- Personal Information Card -->
                        <div class="p-6 bg-slate-50 rounded-xl dark:bg-navy-800">
                            <h3 class="mb-4 text-lg font-semibold text-slate-700 dark:text-navy-100">Personal
                                Information
                            </h3>
                            <dl class="space-y-3">
                                <div
                                    class="flex items-center justify-between py-2 border-b border-slate-200 dark:border-navy-600">
                                    <dt class="text-sm text-slate-500 dark:text-navy-300">Full Name</dt>
                                    <dd class="text-sm font-medium text-slate-700 dark:text-navy-100">{{ $kyc->full_name
                                        }}</dd>
                                </div>
                                <div
                                    class="flex items-center justify-between py-2 border-b border-slate-200 dark:border-navy-600">
                                    <dt class="text-sm text-slate-500 dark:text-navy-300">Date of Birth</dt>
                                    <dd class="text-sm font-medium text-slate-700 dark:text-navy-100">{{
                                        $kyc->date_of_birth->format('M d, Y') }}</dd>
                                </div>
                                <div
                                    class="flex items-center justify-between py-2 border-b border-slate-200 dark:border-navy-600">
                                    <dt class="text-sm text-slate-500 dark:text-navy-300">Submission Date</dt>
                                    <dd class="text-sm font-medium text-slate-700 dark:text-navy-100">{{
                                        $kyc->created_at->format('M d, Y') }}</dd>
                                </div>
                            </dl>
                        </div>

                        <!-- Document Information Card -->
                        <div class="p-6 bg-slate-50 rounded-xl dark:bg-navy-800">
                            <h3 class="mb-4 text-lg font-semibold text-slate-700 dark:text-navy-100">Document Details
                            </h3>
                            <dl class="space-y-3">
                                <div
                                    class="flex items-center justify-between py-2 border-b border-slate-200 dark:border-navy-600">
                                    <dt class="text-sm text-slate-500 dark:text-navy-300">ID Type</dt>
                                    <dd class="text-sm font-medium text-slate-700 dark:text-navy-100">
                                        {{ ucfirst(str_replace('_', ' ', $kyc->id_type)) }}
                                    </dd>
                                </div>
                                <div
                                    class="flex items-center justify-between py-2 border-b border-slate-200 dark:border-navy-600">
                                    <dt class="text-sm text-slate-500 dark:text-navy-300">ID Number</dt>
                                    <dd class="text-sm font-medium text-slate-700 dark:text-navy-100">{{ $kyc->id_number
                                        }}</dd>
                                </div>
                                <div class="flex items-center justify-between py-2">
                                    <dt class="text-sm text-slate-500 dark:text-navy-300">Expiration Date</dt>
                                    <dd class="text-sm font-medium text-slate-700 dark:text-navy-100">
                                        @if($kyc->has_expiration)
                                        {{ $kyc->id_expiration_date->format('M d, Y') }}
                                        @else
                                        <span class="text-xs italic">No Expiration</span>
                                        @endif
                                    </dd>
                                </div>
                            </dl>
                        </div>

                        <!-- Address Card -->
                        <div class="p-6 bg-slate-50 rounded-xl dark:bg-navy-800">
                            <h3 class="mb-4 text-lg font-semibold text-slate-700 dark:text-navy-100">Address Information
                            </h3>
                            <dl class="space-y-3">
                                <div
                                    class="flex items-center justify-between py-2 border-b border-slate-200 dark:border-navy-600">
                                    <dt class="text-sm text-slate-500 dark:text-navy-300">Address</dt>
                                    <dd class="text-sm font-medium text-slate-700 dark:text-navy-100">{{ $kyc->address
                                        }}</dd>
                                </div>
                            </dl>
                        </div>

                        <!-- Document Preview Card -->
                        <div class="p-6 bg-slate-50 rounded-xl dark:bg-navy-800">
                            <h3 class="mb-4 text-lg font-semibold text-slate-700 dark:text-navy-100">Document Preview
                            </h3>
                            <div class="grid grid-cols-2 gap-4">
                                @php
                                $documents = [
                                'ID Front' => $kyc->id_front_image ?? null,
                                'ID Back' => $kyc->id_back_image ?? null,
                                'Selfie' => $kyc->selfie_image ?? null,
                                ];
                                @endphp
                                @foreach($documents as $type => $image)
                                @if($image)
                                <div
                                    class="relative overflow-hidden bg-slate-100 border border-slate-200 rounded-lg group aspect-video dark:border-navy-600 dark:bg-navy-700">
                                    <img src="{{ asset('storage/' . $image) }}" alt="{{ $type }}"
                                        class="object-cover w-full h-full transition-opacity duration-300"
                                        onerror="this.onerror=null;this.src='{{ asset('placeholder-document.svg') }}'">
                                    <div
                                        class="absolute inset-0 flex items-center justify-center transition-opacity opacity-0 bg-gradient-to-t from-slate-900/50 group-hover:opacity-100">
                                        <button type="button"
                                            onclick="openImageModal('{{ asset('storage/' . $image) }}')"
                                            class="p-2 text-white transition-colors bg-slate-800 rounded-full hover:bg-slate-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>
                                        <a href="{{ asset('storage/' . $image) }}" target="_blank"
                                            class="p-2 ml-2 text-white transition-colors bg-slate-800 rounded-full hover:bg-slate-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                                @endif
                                @endforeach
                            </div>
                        </div>
                    </div>

                    @if($kyc->status === 'rejected')
                    <div class="mt-6">
                        <a href="{{ route('kyc.apply') }}"
                            class="btn w-full bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                            Submit New Application
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Image Modal -->
    <div id="imageModal" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm">
        <div class="flex items-center justify-center min-h-screen p-4" @click.self="closeImageModal()">
            <div class="relative w-full max-w-4xl bg-white shadow-xl rounded-xl dark:bg-navy-700">
                <button onclick="closeImageModal()"
                    class="absolute text-slate-500 top-2 right-2 hover:text-slate-700 dark:text-navy-300 dark:hover:text-navy-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <img id="modalImage" src="/placeholder.svg" alt="Full size document" class="w-full h-auto rounded-xl">
            </div>
        </div>
    </div>

    <script>
        // Document ready equivalent
        document.addEventListener('DOMContentLoaded', function() {
            // Make sure the modal is hidden initially
            const imageModal = document.getElementById('imageModal');
            if (imageModal) {
                imageModal.classList.add('hidden');
            }
        });

        // Function to open the image modal
        function openImageModal(imageSrc) {
            const imageModal = document.getElementById('imageModal');
            const modalImage = document.getElementById('modalImage');

            if (imageModal && modalImage) {
                // Set the image source
                modalImage.src = imageSrc;

                // Show the modal
                imageModal.classList.remove('hidden');

                // Prevent scrolling on the body
                document.body.style.overflow = 'hidden';

                // Log for debugging
                console.log('Opening modal with image:', imageSrc);
            } else {
                console.error('Modal elements not found');
            }
        }

        // Function to close the image modal
        function closeImageModal() {
            const imageModal = document.getElementById('imageModal');

            if (imageModal) {
                // Hide the modal
                imageModal.classList.add('hidden');

                // Re-enable scrolling on the body
                document.body.style.overflow = '';

                // Log for debugging
                console.log('Closing modal');
            }
        }

        // Close modal when clicking outside the image
        document.addEventListener('click', function(event) {
            const imageModal = document.getElementById('imageModal');
            const modalContent = document.querySelector('#imageModal .max-w-4xl');

            if (imageModal && !imageModal.classList.contains('hidden')) {
                // If the click is on the modal background (not on the content)
                if (event.target === imageModal || event.target === document.querySelector('#imageModal .flex')) {
                    closeImageModal();
                }
            }
        });

        // Close modal on escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeImageModal();
            }
        });
    </script>
</div>
