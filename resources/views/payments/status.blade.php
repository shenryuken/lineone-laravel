<x-app-layout-sideblock title="Payment Status" is-header-blur="true">
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        <div class="mt-4 sm:mt-5 md:mt-6">
            <div class="flex flex-col items-center justify-center py-10">
                @if($status === 'completed')
                <div
                    class="inline-flex size-16 items-center justify-center rounded-full bg-success/10 text-success mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-8" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <h2 class="text-2xl font-medium text-slate-700 dark:text-navy-100 mb-2">Payment Successful</h2>
                @elseif($status === 'pending')
                <div
                    class="inline-flex size-16 items-center justify-center rounded-full bg-warning/10 text-warning mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-8" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-medium text-slate-700 dark:text-navy-100 mb-2">Payment Processing</h2>
                @elseif($status === 'failed')
                <div class="inline-flex size-16 items-center justify-center rounded-full bg-error/10 text-error mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-8" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
                <h2 class="text-2xl font-medium text-slate-700 dark:text-navy-100 mb-2">Payment Failed</h2>
                @else
                <div class="inline-flex size-16 items-center justify-center rounded-full bg-info/10 text-info mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-8" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-medium text-slate-700 dark:text-navy-100 mb-2">Payment Not Found</h2>
                @endif

                <p class="text-lg text-slate-600 dark:text-navy-200 mb-6">{{ $message }}</p>

                <div class="card p-4 sm:p-5 max-w-md w-full mb-6">
                    <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100 mb-3">Payment Details</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-slate-500 dark:text-navy-200">Reference ID:</span>
                            <span class="font-medium">{{ $reference }}</span>
                        </div>

                        @if(isset($transaction))
                        <div class="flex justify-between">
                            <span class="text-slate-500 dark:text-navy-200">Amount:</span>
                            <span class="font-medium">MYR {{ number_format($transaction->amount/100, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500 dark:text-navy-200">Date:</span>
                            <span class="font-medium">{{ $transaction->created_at->format('M d, Y h:i A') }}</span>
                        </div>
                        @elseif(isset($pendingPayment))
                        <div class="flex justify-between">
                            <span class="text-slate-500 dark:text-navy-200">Amount:</span>
                            <span class="font-medium">MYR {{ number_format($pendingPayment->amount, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500 dark:text-navy-200">Status:</span>
                            <span class="font-medium">{{ ucfirst($pendingPayment->status) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500 dark:text-navy-200">Created:</span>
                            <span class="font-medium">{{ $pendingPayment->created_at->format('M d, Y h:i A') }}</span>
                        </div>
                        @if($pendingPayment->last_checked_at)
                        <div class="flex justify-between">
                            <span class="text-slate-500 dark:text-navy-200">Last Checked:</span>
                            <span class="font-medium">{{ $pendingPayment->last_checked_at->format('M d, Y h:i A')
                                }}</span>
                        </div>
                        @endif
                        @endif
                    </div>
                </div>

                @if($status === 'pending')
                <div class="mb-6">
                    <button id="check-status-btn"
                        class="btn bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                        Check Status
                    </button>
                    <div id="status-loading" class="hidden mt-2 text-center">
                        <div
                            class="spinner h-7 w-7 animate-spin rounded-full border-[3px] border-primary border-r-transparent dark:border-accent dark:border-r-transparent mx-auto">
                        </div>
                        <p class="mt-1 text-sm text-slate-500 dark:text-navy-300">Checking payment status...</p>
                    </div>
                    <div id="status-result" class="hidden mt-2 p-3 rounded-lg"></div>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                      const checkBtn = document.getElementById('check-status-btn');
                      const loading = document.getElementById('status-loading');
                      const result = document.getElementById('status-result');

                      checkBtn.addEventListener('click', function() {
                          loading.classList.remove('hidden');
                          result.classList.add('hidden');

                          fetch('{{ route("payment.status.check") }}', {
                              method: 'POST',
                              headers: {
                                  'Content-Type': 'application/json',
                                  'X-CSRF-TOKEN': '{{ csrf_token() }}'
                              },
                              body: JSON.stringify({
                                  reference: '{{ $reference }}'
                              })
                          })
                          .then(response => response.json())
                          .then(data => {
                              loading.classList.add('hidden');
                              result.classList.remove('hidden');

                              if (data.success) {
                                  if (data.status === 'completed') {
                                      result.className = 'mt-2 p-3 rounded-lg bg-success/15 text-success';
                                      result.innerHTML = data.message;
                                      // Reload the page after 2 seconds
                                      setTimeout(() => {
                                          window.location.reload();
                                      }, 2000);
                                  } else if (data.status === 'failed') {
                                      result.className = 'mt-2 p-3 rounded-lg bg-error/15 text-error';
                                      result.innerHTML = data.message;
                                  } else {
                                      result.className = 'mt-2 p-3 rounded-lg bg-warning/15 text-warning';
                                      result.innerHTML = data.message;
                                  }
                              } else {
                                  result.className = 'mt-2 p-3 rounded-lg bg-error/15 text-error';
                                  result.innerHTML = data.message || 'An error occurred while checking the payment status.';
                              }
                          })
                          .catch(error => {
                              loading.classList.add('hidden');
                              result.classList.remove('hidden');
                              result.className = 'mt-2 p-3 rounded-lg bg-error/15 text-error';
                              result.innerHTML = 'An error occurred while checking the payment status.';
                              console.error('Error:', error);
                          });
                      });
                  });
                </script>
                @endif

                <div class="flex space-x-3">
                    <a href="{{ route('dashboard') }}"
                        class="btn bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                        Go to Dashboard
                    </a>
                    <a href="{{ route('transactions.history') }}"
                        class="btn border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                        View Transactions
                    </a>
                </div>
            </div>
        </div>
    </main>
</x-app-layout-sideblock>
