<x-app-layout-sideblock title="API Testing" is-header-blur="true">
    <!-- Add CryptoJS for proper signature generation -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>
    
    <!-- Main Content Wrapper -->
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        <div class="mt-4 sm:mt-5 md:mt-6">
            <!-- Page Header -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between space-y-2 sm:space-y-0 pb-5 border-b border-slate-200 dark:border-navy-500">
                <div>
                    <h2 class="text-xl font-medium text-slate-700 dark:text-navy-50">
                        API Testing Console
                    </h2>
                    <p class="mt-1 text-sm text-slate-500 dark:text-navy-300">
                        Test your payment gateway API endpoints
                    </p>
                </div>
            </div>

            <!-- Quick Test Section -->
            <div class="mt-5">
                <div class="card p-4 sm:p-5 lg:p-6">
                    <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100 mb-4">Quick API Test</h3>
                    
                    <!-- API Key Input -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-navy-100 mb-2">API Key</label>
                            <input type="text" id="api-key-input" placeholder="test_pk_..." 
                                   class="form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-navy-100 mb-2">Secret Key</label>
                            <input type="password" id="secret-key-input" placeholder="test_sk_..." 
                                   class="form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2">
                        </div>
                    </div>

                    <!-- Test Button -->
                    <button id="quick-test" class="btn bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                        Test Create Order
                    </button>

                    <!-- Response Area -->
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-slate-700 dark:text-navy-100 mb-2">Response</label>
                        <pre id="test-response" class="bg-slate-100 dark:bg-navy-700 rounded-lg p-4 text-sm overflow-auto max-h-96 text-slate-700 dark:text-navy-100">Click "Test Create Order" to see response...</pre>
                    </div>
                </div>
            </div>

            <!-- Available API Keys -->
            @if($apiKeys->count() > 0)
            <div class="mt-6">
                <div class="card p-4 sm:p-5 lg:p-6">
                    <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100 mb-4">Your API Keys</h3>
                    <div class="space-y-3">
                        @foreach($apiKeys as $key)
                            <div class="border border-slate-200 dark:border-navy-500 rounded-lg p-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h4 class="font-medium text-slate-700 dark:text-navy-100">{{ $key->name }}</h4>
                                        <p class="text-sm text-slate-500 dark:text-navy-300">{{ $key->mode === 'test' ? 'Test Environment' : 'Live Environment' }}</p>
                                        <code class="text-xs bg-slate-100 dark:bg-navy-700 px-2 py-1 rounded mt-1 inline-block">{{ $key->api_key }}</code>
                                    </div>
                                    <button onclick="useApiKey('{{ $key->api_key }}', '{{ $key->secret_key }}')" 
                                            class="btn bg-slate-150 font-medium text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">
                                        Use This Key
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
    </main>

    <script>
        function useApiKey(apiKey, secretKey) {
            document.getElementById('api-key-input').value = apiKey;
            document.getElementById('secret-key-input').value = secretKey;
        }

        document.getElementById('quick-test').addEventListener('click', function() {
            const apiKey = document.getElementById('api-key-input').value;
            const secretKey = document.getElementById('secret-key-input').value;
            
            if (!apiKey || !secretKey) {
                alert('Please enter both API key and secret key');
                return;
            }

            const timestamp = Math.floor(Date.now() / 1000);
            const payload = JSON.stringify({
                "amount": 100.00,
                "currency": "MYR",
                "description": "Test payment order",
                "customer_email": "test@example.com",
                "customer_name": "Test Customer"
            });

            // Generate signature using HMAC SHA256
            const message = timestamp + payload;
            const signature = CryptoJS.HmacSHA256(message, secretKey).toString();

            const url = '{{ url("/api/merchant/v1/orders") }}';
            
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-API-Key': apiKey,
                    'X-Signature': signature,
                    'X-Timestamp': timestamp.toString()
                },
                body: payload
            })
            .then(response => {
                const statusCode = response.status;
                const contentType = response.headers.get('content-type');
                
                if (contentType && contentType.includes('application/json')) {
                    return response.json().then(data => ({
                        status: statusCode,
                        data: data
                    }));
                } else {
                    return response.text().then(text => ({
                        status: statusCode,
                        data: { error: 'Non-JSON response', response: text }
                    }));
                }
            })
            .then(result => {
                const responseElement = document.getElementById('test-response');
                responseElement.textContent = `Status: ${result.status}\n\n${JSON.stringify(result.data, null, 2)}`;
                
                // Color code the response based on status
                if (result.status >= 200 && result.status < 300) {
                    responseElement.className = responseElement.className.replace('text-slate-700 dark:text-navy-100', 'text-green-700 dark:text-green-300');
                } else {
                    responseElement.className = responseElement.className.replace('text-slate-700 dark:text-navy-100', 'text-red-700 dark:text-red-300');
                }
            })
            .catch(error => {
                const responseElement = document.getElementById('test-response');
                responseElement.textContent = `Error: ${error.message}`;
                responseElement.className = responseElement.className.replace('text-slate-700 dark:text-navy-100', 'text-red-700 dark:text-red-300');
            });
        });
    </script>
</x-app-layout-sideblock>
