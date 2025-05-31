<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Error</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
                <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                    {{ $title }}
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    {{ $message }}
                </p>
            </div>

            @if(isset($paymentRequest))
            <div class="bg-white shadow-lg rounded-lg p-6">
                <div class="space-y-4">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Order ID:</span>
                        <span class="font-mono text-sm">{{ $requestId }}</span>
                    </div>
                </div>
            </div>
            @endif

            <div class="text-center">
                <a href="{{ isset($paymentRequest) && $paymentRequest->cancel_url ? $paymentRequest->cancel_url : '/' }}" 
                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700">
                    Return to Merchant
                </a>
            </div>
        </div>
    </div>
</body>
</html>
