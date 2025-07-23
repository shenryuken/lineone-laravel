<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="max-w-2xl mx-auto">
                        <!-- Header -->
                        <div class="text-center mb-8">
                            <h1 class="text-3xl font-bold text-gray-900">Complete Payment</h1>
                            <p class="text-gray-600 mt-2">Secure payment powered by Redicash</p>
                        </div>

                        <!-- Payment Summary Card -->
                        <div class="bg-gray-50 rounded-lg p-6 mb-6">
                            <h2 class="text-xl font-semibold mb-4">Payment Summary</h2>
                            
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Amount</span>
                                    <span class="font-semibold">{{ $wallet->currency }} {{ number_format($amount, 2) }}</span>
                                </div>
                                
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Processing Fee (5%)</span>
                                    <span class="font-semibold">{{ $wallet->currency }} {{ number_format($feeAmount, 2) }}</span>
                                </div>
                                
                                <div class="border-t pt-3">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Net Amount</span>
                                        <span class="font-semibold text-green-600">{{ $wallet->currency }} {{ number_format($netAmount, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Account Information -->
                        <div class="bg-gray-50 rounded-lg p-6 mb-6">
                            <h2 class="text-xl font-semibold mb-4">Account Information</h2>
                            
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Account Holder</span>
                                    <span class="font-semibold">{{ $user->name }}</span>
                                </div>
                                
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Email</span>
                                    <span class="font-semibold">{{ $user->email }}</span>
                                </div>
                                
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Wallet</span>
                                    <span class="font-semibold">{{ $wallet->currency }} Wallet</span>
                                </div>
                                
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Current Balance</span>
                                    <span class="font-semibold">{{ $wallet->currency }} {{ number_format($wallet->balance, 2) }}</span>
                                </div>
                                
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Balance After Deposit</span>
                                    <span class="font-semibold text-green-600">{{ $wallet->currency }} {{ number_format($wallet->balance + $netAmount, 2) }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Terms and Conditions -->
                        <div class="mb-6">
                            <label class="flex items-start">
                                <input type="checkbox" id="terms-checkbox" class="mt-1 mr-3" required>
                                <span class="text-sm text-gray-600">
                                    I confirm that I want to proceed with this payment from my Redicash wallet. 
                                    I understand that this transaction cannot be reversed once completed.
                                </span>
                            </label>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex space-x-4">
                            <form action="{{ route('redicash.checkout.process') }}" method="POST" class="flex-1">
                                @csrf
                                <button type="submit" id="confirm-button" 
                                        class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                                        disabled>
                                    Confirm Payment
                                </button>
                            </form>
                            
                            <a href="{{ route('redicash.checkout.cancel') }}" 
                               class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-6 rounded-lg text-center transition duration-200">
                                Cancel
                            </a>
                        </div>

                        <!-- Security Notice -->
                        <div class="mt-6 text-center">
                            <p class="text-sm text-gray-500">
                                🔒 Secured by SSL encryption
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const termsCheckbox = document.getElementById('terms-checkbox');
            const confirmButton = document.getElementById('confirm-button');
            
            termsCheckbox.addEventListener('change', function() {
                confirmButton.disabled = !this.checked;
            });
        });
    </script>
</x-app-layout>
