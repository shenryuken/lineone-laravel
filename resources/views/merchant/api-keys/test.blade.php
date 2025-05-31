<x-app-layout-sideblock title="API Testing" is-header-blur="true">
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
                <div class="flex space-x-2">
                    <a href="{{ route('merchant.api-keys.index') }}" 
                       class="btn h-9 rounded-full bg-slate-150 px-4 text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">
                        <span>Back to API Keys</span>
                    </a>
                </div>
            </div>

            <!-- API Key Selection -->
            <div class="mt-5">
                <div class="card p-4 sm:p-5 lg:p-6">
                    <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100 mb-4">Select API Key for Testing</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($apiKeys as $key)
                            <div class="border border-slate-200 dark:border-navy-500 rounded-lg p-4 cursor-pointer hover:bg-slate-50 dark:hover:bg-navy-600/50 transition-colors api-key-card" 
                                 data-api-key="{{ $key->api_key }}" 
                                 data-secret-key="{{ $key->secret_key }}"
                                 data-mode="{{ $key->mode }}">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h4 class="font-medium text-slate-700 dark:text-navy-100">{{ $key->name }}</h4>
                                        <p class="text-sm text-slate-500 dark:text-navy-300">{{ $key->mode === 'test' ? 'Test Environment' : 'Live Environment' }}</p>
                                    </div>
                                    <div class="bg-{{ $key->mode === 'test' ? 'warning' : 'success' }}/10 text-{{ $key->mode === 'test' ? 'warning' : 'success' }} px-3 py-1 rounded-full text-sm font-medium">
                                        {{ strtoupper($key->mode) }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Testing Interface -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6" id="testing-interface" style="display: none;">
                <!-- Request Panel -->
                <div class="card p-4 sm:p-5 lg:p-6">
                    <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100 mb-4">API Request</h3>
                    
                    <!-- Endpoint Selection -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-700 dark:text-navy-100 mb-2">Endpoint</label>
                        <select id="endpoint-select" class="form-select w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">
                            <option value="create-order">Create Payment Order</option>
                            <option value="get-order">Get Order Status</option>
                            <option value="list-orders">List Orders</option>
                            <option value="cancel-order">Cancel Order</option>
                        </select>
                    </div>

                    <!-- Request Body -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-700 dark:text-navy-100 mb-2">Request Body (JSON)</label>
                        <textarea id="request-body" rows="12" 
                                  class="form-textarea w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent font-mono text-sm"></textarea>
                    </div>

                    <!-- Send Request Button -->
                    <button id="send-request" class="btn bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90 w-full">
                        Send Request
                    </button>
                </div>

                <!-- Response Panel -->
                <div class="card p-4 sm:p-5 lg:p-6">
                    <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100 mb-4">API Response</h3>
                    
                    <!-- Response Status -->
                    <div class="mb-4">
                        <div id="response-status" class="hidden">
                            <span class="text-sm font-medium text-slate-700 dark:text-navy-100">Status: </span>
                            <span id="status-code" class="px-2 py-1 rounded text-sm font-medium"></span>
                        </div>
                    </div>

                    <!-- Response Body -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-700 dark:text-navy-100 mb-2">Response Body</label>
                        <pre id="response-body" class="bg-slate-100 dark:bg-navy-700 rounded-lg p-4 text-sm overflow-auto max-h-96 text-slate-700 dark:text-navy-100"></pre>
                    </div>

                    <!-- Copy Response Button -->
                    <button id="copy-response" class="btn bg-slate-150 font-medium text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90 w-full" disabled>
                        Copy Response
                    </button>
                </div>
            </div>

            <!-- Quick Test Examples -->
            <div class="mt-6">
                <div class="card p-4 sm:p-5 lg:p-6">
                    <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100 mb-4">Quick Test Examples</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <button class="example-btn border border-slate-200 dark:border-navy-500 rounded-lg p-4 text-left hover:bg-slate-50 dark:hover:bg-navy-600/50 transition-colors" data-example="create-order">
                            <h4 class="font-medium text-slate-700 dark:text-navy-100">Create Test Order</h4>
                            <p class="text-sm text-slate-500 dark:text-navy-300 mt-1">Create a sample payment order</p>
                        </button>
                        <button class="example-btn border border-slate-200 dark:border-navy-500 rounded-lg p-4 text-left hover:bg-slate-50 dark:hover:bg-navy-600/50 transition-colors" data-example="webhook-test">
                            <h4 class="font-medium text-slate-700 dark:text-navy-100">Test Webhook</h4>
                            <p class="text-sm text-slate-500 dark:text-navy-300 mt-1">Test webhook endpoint</p>
                        </button>
                        <button class="example-btn border border-slate-200 dark:border-navy-500 rounded-lg p-4 text-left hover:bg-slate-50 dark:hover:bg-navy-600/50 transition-colors" data-example="list-orders">
                            <h4 class="font-medium text-slate-700 dark:text-navy-100">List Orders</h4>
                            <p class="text-sm text-slate-500 dark:text-navy-300 mt-1">Get all payment orders</p>
                        </button>
                    </div>
                </div>
            </div>

            <!-- cURL Examples -->
            <div class="mt-6">
                <div class="card p-4 sm:p-5 lg:p-6">
                    <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100 mb-4">cURL Examples</h3>
                    <div class="space-y-4">
                        <div>
                            <h4 class="font-medium text-slate-700 dark:text-navy-100 mb-2">Create Payment Order</h4>
                            <pre class="bg-slate-100 dark:bg-navy-700 rounded-lg p-4 text-sm overflow-auto text-slate-700 dark:text-navy-100" id="curl-create-order"></pre>
                        </div>
                        <div>
                            <h4 class="font-medium text-slate-700 dark:text-navy-100 mb-2">Get Order Status</h4>
                            <pre class="bg-slate-100 dark:bg-navy-700 rounded-lg p-4 text-sm overflow-auto text-slate-700 dark:text-navy-100" id="curl-get-order"></pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>
    <script>
        let selectedApiKey = null;
        let selectedSecretKey = null;
        let selectedMode = null;

        // API Key Selection
        document.querySelectorAll('.api-key-card').forEach(card => {
            card.addEventListener('click', function() {
                // Remove previous selection
                document.querySelectorAll('.api-key-card').forEach(c => c.classList.remove('ring-2', 'ring-primary', 'dark:ring-accent'));
                
                // Add selection to current card
                this.classList.add('ring-2', 'ring-primary', 'dark:ring-accent');
                
                // Store selected keys
                selectedApiKey = this.dataset.apiKey;
                selectedSecretKey = this.dataset.secretKey;
                selectedMode = this.dataset.mode;
                
                // Show testing interface
                document.getElementById('testing-interface').style.display = 'grid';
                
                // Update cURL examples
                updateCurlExamples();
                
                // Set default request body
                updateRequestBody();
            });
        });

        // Endpoint Selection
        document.getElementById('endpoint-select').addEventListener('change', function() {
            updateRequestBody();
        });

        // Example buttons
        document.querySelectorAll('.example-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const example = this.dataset.example;
                loadExample(example);
            });
        });

        // Send Request
        document.getElementById('send-request').addEventListener('click', function() {
            sendApiRequest();
        });

        // Copy Response
        document.getElementById('copy-response').addEventListener('click', function() {
            const responseText = document.getElementById('response-body').textContent;
            navigator.clipboard.writeText(responseText);
            this.textContent = 'Copied!';
            setTimeout(() => {
                this.textContent = 'Copy Response';
            }, 2000);
        });

        function updateRequestBody() {
            const endpoint = document.getElementById('endpoint-select').value;
            const requestBody = document.getElementById('request-body');
            
            const examples = {
                'create-order': {
                    "amount": 100.00,
                    "currency": "MYR",
                    "description": "Test payment order",
                    "customer_email": "customer@example.com",
                    "customer_name": "John Doe",
                    "customer_phone": "+60123456789",
                    "merchant_order_id": "ORDER_" + Date.now(),
                    "return_url": "{{ url('/') }}/payment/success",
                    "cancel_url": "{{ url('/') }}/payment/cancel",
                    "expires_in": 3600,
                    "metadata": {
                        "product_id": "123",
                        "product_name": "Test Product"
                    }
                },
                'get-order': {
                    "order_id": "ORD_XXXXXXXXXXXXXXXXXX"
                },
                'list-orders': {
                    "status": "pending",
                    "per_page": 10,
                    "from_date": "2024-01-01",
                    "to_date": "2024-12-31"
                },
                'cancel-order': {
                    "order_id": "ORD_XXXXXXXXXXXXXXXXXX"
                }
            };
            
            requestBody.value = JSON.stringify(examples[endpoint], null, 2);
        }

        function loadExample(example) {
            const examples = {
                'create-order': () => {
                    document.getElementById('endpoint-select').value = 'create-order';
                    updateRequestBody();
                },
                'webhook-test': () => {
                    // This would test the webhook endpoint
                    alert('Webhook testing would be implemented here');
                },
                'list-orders': () => {
                    document.getElementById('endpoint-select').value = 'list-orders';
                    updateRequestBody();
                }
            };
            
            if (examples[example]) {
                examples[example]();
            }
        }

        function sendApiRequest() {
            if (!selectedApiKey || !selectedSecretKey) {
                alert('Please select an API key first');
                return;
            }

            const endpoint = document.getElementById('endpoint-select').value;
            const requestBody = document.getElementById('request-body').value;
            
            let url = '';
            let method = 'POST';
            
            const baseUrl = '{{ url("/api/merchant/v1") }}'; // Fixed URL
            
            switch (endpoint) {
                case 'create-order':
                    url = baseUrl + '/orders';
                    method = 'POST';
                    break;
                case 'get-order':
                    const getOrderData = JSON.parse(requestBody);
                    url = baseUrl + '/orders/' + getOrderData.order_id;
                    method = 'GET';
                    break;
                case 'list-orders':
                    url = baseUrl + '/orders';
                    method = 'GET';
                    break;
                case 'cancel-order':
                    const cancelOrderData = JSON.parse(requestBody);
                    url = baseUrl + '/orders/' + cancelOrderData.order_id + '/cancel';
                    method = 'POST';
                    break;
            }

            // Generate proper signature - using HMAC SHA256
            const timestamp = Math.floor(Date.now() / 1000);
            const payload = method === 'GET' ? '' : requestBody;

            // Use the same method as the middleware expects
            const message = timestamp + payload;
            const signature = CryptoJS.HmacSHA256(message, selectedSecretKey).toString();

            const headers = {
                'Content-Type': 'application/json',
                'X-API-Key': selectedApiKey,
                'X-Signature': signature,
                'X-Timestamp': timestamp.toString()
            };

            const options = {
                method: method,
                headers: headers
            };

            if (method !== 'GET' && requestBody.trim()) {
                options.body = requestBody;
            }

            console.log('Sending request to:', url); // Debug log
            console.log('Headers:', headers); // Debug log

            fetch(url, options)
                .then(response => {
                    const statusCode = response.status;
                    const statusElement = document.getElementById('response-status');
                    const statusCodeElement = document.getElementById('status-code');
                    
                    statusElement.classList.remove('hidden');
                    statusCodeElement.textContent = statusCode;
                    statusCodeElement.className = `px-2 py-1 rounded text-sm font-medium ${
                        statusCode >= 200 && statusCode < 300 
                            ? 'bg-success/10 text-success dark:bg-success/15' 
                            : 'bg-error/10 text-error dark:bg-error/15'
                    }`;
                    
                    // Handle both JSON and non-JSON responses
                    const contentType = response.headers.get('content-type');
                    if (contentType && contentType.includes('application/json')) {
                        return response.json();
                    } else {
                        return response.text().then(text => ({ error: 'Non-JSON response', response: text }));
                    }
                })
                .then(data => {
                    document.getElementById('response-body').textContent = typeof data === 'string' ? data : JSON.stringify(data, null, 2);
                    document.getElementById('copy-response').disabled = false;
                })
                .catch(error => {
                    console.error('Request failed:', error); // Debug log
                    document.getElementById('response-body').textContent = 'Error: ' + error.message;
                    document.getElementById('copy-response').disabled = false;
                });
        }

        function updateCurlExamples() {
            if (!selectedApiKey || !selectedSecretKey) return;

            const baseUrl = '{{ url("/") }}/api/merchant/v1';
            const timestamp = Math.floor(Date.now() / 1000);
            
            // Create Order cURL
            const createOrderCurl = `curl -X POST "${baseUrl}/orders" \\
  -H "Content-Type: application/json" \\
  -H "X-API-Key: ${selectedApiKey}" \\
  -H "X-Signature: [GENERATED_SIGNATURE]" \\
  -H "X-Timestamp: ${timestamp}" \\
  -d '{
    "amount": 100.00,
    "currency": "MYR",
    "description": "Test payment order",
    "customer_email": "customer@example.com",
    "customer_name": "John Doe"
  }'`;

            // Get Order cURL
            const getOrderCurl = `curl -X GET "${baseUrl}/orders/ORD_XXXXXXXXXXXXXXXXXX" \\
  -H "X-API-Key: ${selectedApiKey}" \\
  -H "X-Signature: [GENERATED_SIGNATURE]" \\
  -H "X-Timestamp: ${timestamp}"`;

            document.getElementById('curl-create-order').textContent = createOrderCurl;
            document.getElementById('curl-get-order').textContent = getOrderCurl;
        }
    </script>
</x-app-layout-sideblock>
