<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pay with Redicash</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-lg max-w-md w-full p-6">
            <!-- Header -->
            <div class="text-center mb-6">
                <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-semibold text-gray-900">Pay with Redicash</h2>
                <p class="text-sm text-gray-600">Secure payment to {{ $merchant->name }}</p>
            </div>

            <!-- Payment Details -->
            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-gray-600">Amount:</span>
                    <span class="text-xl font-bold text-gray-900">
                        {{ $paymentOrder->currency }} {{ number_format($paymentOrder->amount, 2) }}
                    </span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Description:</span>
                    <span class="text-gray-900">{{ $paymentOrder->description }}</span>
                </div>
            </div>

            <!-- Login Form -->
            <div id="login-form">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Login to Your Wallet</h3>
                <form id="wallet-login-form" class="space-y-4">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="email" name="email" required
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" id="password" name="password" required
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <button type="submit" id="login-btn"
                            class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <span id="login-text">Continue</span>
                        <span id="login-spinner" class="hidden">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Loading...
                        </span>
                    </button>
                </form>
            </div>

            <!-- Wallet Selection -->
            <div id="wallet-selection" class="hidden">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Select Wallet</h3>
                <div id="wallets-list" class="space-y-3 mb-4">
                    <!-- Wallets will be populated here -->
                </div>
                <button id="pay-btn" disabled
                        class="w-full bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 disabled:opacity-50 disabled:cursor-not-allowed">
                    <span id="pay-text">Complete Payment</span>
                    <span id="pay-spinner" class="hidden">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Processing...
                    </span>
                </button>
                <button id="back-btn" class="w-full mt-2 text-gray-600 hover:text-gray-800">
                    ← Back to Login
                </button>
            </div>

            <!-- Error Messages -->
            <div id="error-message" class="hidden mt-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
                <span id="error-text"></span>
            </div>

            <!-- Success Message -->
            <div id="success-message" class="hidden mt-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded">
                <span id="success-text"></span>
            </div>

            <!-- Footer -->
            <div class="mt-6 text-center">
                <p class="text-xs text-gray-500">
                    Secured by Redicash • 
                    <a href="https://redicash.ai/privacy" class="text-blue-600 hover:underline">Privacy Policy</a>
                </p>
            </div>
        </div>
    </div>

    <script>
        const paymentId = '{{ $paymentOrder->order_id }}';
        let selectedWalletId = null;
        let userCredentials = null;

        // CSRF token setup
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Elements
        const loginForm = document.getElementById('login-form');
        const walletSelection = document.getElementById('wallet-selection');
        const errorMessage = document.getElementById('error-message');
        const successMessage = document.getElementById('success-message');

        // Handle login form submission
        document.getElementById('wallet-login-form').addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            
            userCredentials = { email, password };
            
            showLoading('login');
            hideError();
            
            try {
                const response = await fetch(`/api/widget/wallets`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ email, password })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    displayWallets(data.data.wallets);
                    showWalletSelection();
                } else {
                    showError(data.error || 'Login failed');
                }
            } catch (error) {
                showError('Network error. Please try again.');
            } finally {
                hideLoading('login');
            }
        });

        // Handle wallet selection
        function selectWallet(walletId) {
            selectedWalletId = walletId;
            
            // Update UI
            document.querySelectorAll('.wallet-option').forEach(el => {
                el.classList.remove('ring-2', 'ring-blue-500', 'bg-blue-50');
            });
            
            document.querySelector(`[data-wallet-id="${walletId}"]`).classList.add('ring-2', 'ring-blue-500', 'bg-blue-50');
            
            document.getElementById('pay-btn').disabled = false;
        }

        // Handle payment
        document.getElementById('pay-btn').addEventListener('click', async () => {
            if (!selectedWalletId || !userCredentials) return;
            
            showLoading('pay');
            hideError();
            
            try {
                const response = await fetch(`/api/widget/payments/${paymentId}/process`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        email: userCredentials.email,
                        password: userCredentials.password,
                        wallet_id: selectedWalletId
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showSuccess('Payment completed successfully!');
                    
                    // Redirect to return URL after 2 seconds
                    setTimeout(() => {
                        if (data.data.return_url) {
                            window.top.location.href = data.data.return_url;
                        }
                    }, 2000);
                } else {
                    showError(data.error || 'Payment failed');
                }
            } catch (error) {
                showError('Network error. Please try again.');
            } finally {
                hideLoading('pay');
            }
        });

        // Handle back button
        document.getElementById('back-btn').addEventListener('click', () => {
            showLoginForm();
        });

        // Helper functions
        function displayWallets(wallets) {
            const walletsList = document.getElementById('wallets-list');
            walletsList.innerHTML = '';
            
            wallets.forEach(wallet => {
                const walletDiv = document.createElement('div');
                walletDiv.className = 'wallet-option border border-gray-300 rounded-lg p-3 cursor-pointer hover:bg-gray-50';
                walletDiv.setAttribute('data-wallet-id', wallet.id);
                walletDiv.onclick = () => selectWallet(wallet.id);
                
                walletDiv.innerHTML = `
                    <div class="flex justify-between items-center">
                        <div>
                            <div class="font-medium">${wallet.name}</div>
                            <div class="text-sm text-gray-600">${wallet.currency}</div>
                        </div>
                        <div class="text-right">
                            <div class="font-bold">${wallet.formatted_balance}</div>
                            <div class="text-xs text-gray-500">Available</div>
                        </div>
                    </div>
                `;
                
                walletsList.appendChild(walletDiv);
            });
        }

        function showWalletSelection() {
            loginForm.classList.add('hidden');
            walletSelection.classList.remove('hidden');
        }

        function showLoginForm() {
            walletSelection.classList.add('hidden');
            loginForm.classList.remove('hidden');
            selectedWalletId = null;
            userCredentials = null;
        }

        function showLoading(type) {
            const btn = document.getElementById(`${type}-btn`);
            const text = document.getElementById(`${type}-text`);
            const spinner = document.getElementById(`${type}-spinner`);
            
            btn.disabled = true;
            text.classList.add('hidden');
            spinner.classList.remove('hidden');
        }

        function hideLoading(type) {
            const btn = document.getElementById(`${type}-btn`);
            const text = document.getElementById(`${type}-text`);
            const spinner = document.getElementById(`${type}-spinner`);
            
            btn.disabled = false;
            text.classList.remove('hidden');
            spinner.classList.add('hidden');
        }

        function showError(message) {
            document.getElementById('error-text').textContent = message;
            errorMessage.classList.remove('hidden');
            successMessage.classList.add('hidden');
        }

        function hideError() {
            errorMessage.classList.add('hidden');
        }

        function showSuccess(message) {
            document.getElementById('success-text').textContent = message;
            successMessage.classList.remove('hidden');
            errorMessage.classList.add('hidden');
        }
    </script>
</body>
</html>
