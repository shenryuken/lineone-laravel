<x-app-layout-sideblock title="Complete Payment" is-header-blur="true">
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        <div class="mt-4 sm:mt-5 md:mt-6">
            <div
                class="flex flex-col sm:flex-row sm:items-center justify-between space-y-2 sm:space-y-0 pb-5 border-b border-slate-200 dark:border-navy-500">
                <div>
                    <h2 class="text-xl font-medium text-slate-700 dark:text-navy-50">
                        Complete Your Payment
                    </h2>
                    <p class="mt-1 text-sm text-slate-500 dark:text-navy-300">
                        Please review and confirm your payment details
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-5 lg:gap-6 mt-5">
                <!-- Payment Summary Card -->
                <div class="card p-4 sm:p-5">
                    <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100 mb-4">
                        Payment Summary
                    </h2>

                    <div class="rounded-lg bg-slate-100 p-4 dark:bg-navy-600 mb-4">
                        <div class="flex justify-between mb-2">
                            <span class="text-slate-500 dark:text-navy-200">To Wallet:</span>
                            <span class="font-medium">{{ $wallet->currency }} Wallet</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span class="text-slate-500 dark:text-navy-200">Amount:</span>
                            <span class="font-medium">{{ $wallet->currency }} {{ number_format($amount, 2) }}</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span class="text-slate-500 dark:text-navy-200">Processing Fee (5%):</span>
                            <span class="font-medium text-error">- {{ $wallet->currency }} {{ number_format($feeAmount,
                                2) }}</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span class="text-slate-500 dark:text-navy-200">Net Amount:</span>
                            <span class="font-medium">{{ $wallet->currency }} {{ number_format($netAmount, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500 dark:text-navy-200">Payment Method:</span>
                            <span class="font-medium">Stripe</span>
                        </div>
                    </div>
                </div>

                <!-- Payment Form Card -->
                <div class="card p-4 sm:p-5">
                    <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100 mb-4">
                        Card Details
                    </h2>

                    <form id="payment-form">
                        <div id="payment-element" class="mb-4">
                            <!-- Stripe Elements will be inserted here -->
                        </div>

                        <div id="payment-message" class="hidden mb-4 rounded-lg bg-error/15 px-4 py-3 text-error"></div>

                        <div class="flex justify-between space-x-2">
                            <a href="{{ route('dashboard') }}"
                                class="btn border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                                Cancel
                            </a>
                            <button id="submit-button" type="submit"
                                class="btn bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                                Pay Now
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <!-- Stripe JS -->
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            initializeStripe();
        });

        function initializeStripe() {
            console.log('Initializing Stripe...');

            const form = document.getElementById('payment-form');
            const submitButton = document.getElementById('submit-button');
            const paymentMessage = document.getElementById('payment-message');

            if (!form || !submitButton || !paymentMessage) {
                console.error('Required DOM elements not found');
                return;
            }

            // Initialize Stripe
            const stripe = Stripe('{{ config('services.stripe.key') }}');
            const clientSecret = '{{ $clientSecret }}';

            if (!clientSecret) {
                console.error('Client secret is missing');
                showMessage('Configuration error. Please try again later.', true);
                return;
            }

            // Create Stripe Elements
            const elements = stripe.elements({
                clientSecret: clientSecret,
                appearance: {
                    theme: 'stripe',
                    variables: {
                        colorPrimary: '#7e3af2',
                    }
                }
            });

            // Create and mount the Payment Element
            const paymentElement = elements.create('payment');
            paymentElement.mount('#payment-element');

            // Handle form submission
            form.addEventListener('submit', async function(e) {
                e.preventDefault();
                console.log('Form submitted');

                // Disable the submit button and show loading state
                submitButton.disabled = true;
                submitButton.innerHTML = '<svg class="h-5 w-5 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Processing...';

                try {
                    // Confirm the payment
                    const result = await stripe.confirmPayment({
                        elements,
                        confirmParams: {
                            return_url: '{{ route('stripe.success') }}',
                        }
                    });

                    // This point will only be reached if there is an immediate error when
                    // confirming the payment. Otherwise, your customer will be redirected to
                    // your `return_url`.
                    if (result.error) {
                        showMessage(result.error.message, true);
                        submitButton.disabled = false;
                        submitButton.innerHTML = 'Pay Now';
                    }
                } catch (error) {
                    console.error('Error during payment confirmation:', error);
                    showMessage('An unexpected error occurred. Please try again.', true);
                    submitButton.disabled = false;
                    submitButton.innerHTML = 'Pay Now';
                }
            });

            // Helper function to show messages
            function showMessage(messageText, isError) {
                paymentMessage.classList.remove('hidden');
                paymentMessage.textContent = messageText;

                if (isError) {
                    paymentMessage.classList.add('bg-error/15', 'text-error');
                    paymentMessage.classList.remove('bg-success/15', 'text-success');
                } else {
                    paymentMessage.classList.add('bg-success/15', 'text-success');
                    paymentMessage.classList.remove('bg-error/15', 'text-error');
                }
            }

            console.log('Stripe setup complete');
        }
    </script>
</x-app-layout-sideblock>
