<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Checkout - {{ $merchant->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div class="text-center">
                <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                    Complete Your Payment
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    Secure payment powered by {{ config('app.name') }}
                </p>
            </div>

            <!-- Payment Details Card -->
            <div class="bg-white shadow-lg rounded-lg p-6">
                <div class="border-b border-gray-200 pb-4 mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Payment Details</h3>
                </div>

                <div class="space-y-4">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Merchant:</span>
                        <span class="font-medium">{{ $merchant->name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Amount:</span>
                        <span class="font-bold text-xl">{{ $currency }} {{ number_format($amount, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Description:</span>
                        <span class="font-medium">{{ $paymentRequest->description }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Order ID:</span>
                        <span class="font-mono text-sm">{{ $requestId }}</span>
                    </div>
                </div>
            </div>

            <!-- Payment Form -->
            <form method="POST" action="{{ route('payment.gateway.process', $requestId) }}" class="bg-white shadow-lg rounded-lg p-6">
                @csrf
                
                <div class="space-y-4">
                    <div>
                        <label for="customer_name" class="block text-sm font-medium text-gray-700">Full Name</label>
                        <input type="text" id="customer_name" name="customer_name" required
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                               value="{{ old('customer_name') }}">
                        @error('customer_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="customer_email" class="block text-sm font-medium text-gray-700">Email Address</label>
                        <input type="email" id="customer_email" name="customer_email" required
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                               value="{{ old('customer_email', $paymentRequest->customer_email) }}">
                        @error('customer_email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="customer_phone" class="block text-sm font-medium text-gray-700">Phone Number (Optional)</label>
                        <input type="tel" id="customer_phone" name="customer_phone"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                               value="{{ old('customer_phone') }}">
                        @error('customer_phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">Payment Method</label>
                        <div class="space-y-3">
                            <label class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio" name="payment_method" value="wallet" class="mr-3" required>
                                <div>
                                    <div class="font-medium">E-Wallet</div>
                                    <div class="text-sm text-gray-500">Pay using your digital wallet</div>
                                </div>
                            </label>
                            
                            <label class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio" name="payment_method" value="bank_transfer" class="mr-3">
                                <div>
                                    <div class="font-medium">Bank Transfer</div>
                                    <div class="text-sm text-gray-500">Transfer from your bank account</div>
                                </div>
                            </label>
                            
                            <label class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio" name="payment_method" value="card" class="mr-3">
                                <div>
                                    <div class="font-medium">Credit/Debit Card</div>
                                    <div class="text-sm text-gray-500">Pay with your card</div>
                                </div>
                            </label>
                        </div>
                        @error('payment_method')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Wallet Selection (shown when wallet is selected) -->
                    <div id="wallet-selection" class="hidden">
                        <label for="wallet_id" class="block text-sm font-medium text-gray-700">Select Wallet</label>
                        <select id="wallet_id" name="wallet_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select a wallet...</option>
                            <!-- This would be populated with actual wallets -->
                            <option value="1">Main Wallet (MYR 500.00)</option>
                            <option value="2">Savings Wallet (MYR 1,200.00)</option>
                        </select>
                    </div>

                    <!-- Bank Account (shown when bank transfer is selected) -->
                    <div id="bank-selection" class="hidden">
                        <label for="bank_account" class="block text-sm font-medium text-gray-700">Bank Account</label>
                        <input type="text" id="bank_account" name="bank_account" placeholder="Enter your bank account number"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Card Details (shown when card is selected) -->
                    <div id="card-selection" class="hidden">
                        <label for="card_token" class="block text-sm font-medium text-gray-700">Card Token</label>
                        <input type="text" id="card_token" name="card_token" placeholder="Card processing token"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <p class="mt-1 text-xs text-gray-500">In production, this would be handled by a secure card processor</p>
                    </div>
                </div>

                @if(session('error'))
                    <div class="mt-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="mt-6">
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Complete Payment
                    </button>
                </div>
            </form>

            <div class="text-center">
                <p class="text-xs text-gray-500">
                    Secured by SSL encryption. Your payment information is safe.
                </p>
            </div>
        </div>
    </div>

    <script>
        // Show/hide payment method specific fields
        document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
            radio.addEventListener('change', function() {
                // Hide all method-specific sections
                document.getElementById('wallet-selection').classList.add('hidden');
                document.getElementById('bank-selection').classList.add('hidden');
                document.getElementById('card-selection').classList.add('hidden');
                
                // Show the selected method's section
                if (this.value === 'wallet') {
                    document.getElementById('wallet-selection').classList.remove('hidden');
                } else if (this.value === 'bank_transfer') {
                    document.getElementById('bank-selection').classList.remove('hidden');
                } else if (this.value === 'card') {
                    document.getElementById('card-selection').classList.remove('hidden');
                }
            });
        });
    </script>
</body>
</html>
