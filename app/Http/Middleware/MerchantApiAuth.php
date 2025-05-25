<?php

namespace App\Http\Middleware;

use App\Models\MerchantApiKey;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MerchantApiAuth
{
    public function handle(Request $request, Closure $next)
    {
        $apiKey = $request->header('X-API-Key');
        $signature = $request->header('X-Signature');
        $timestamp = $request->header('X-Timestamp');

        if (!$apiKey || !$signature || !$timestamp) {
            return response()->json([
                'error' => 'Missing required headers: X-API-Key, X-Signature, X-Timestamp'
            ], 401);
        }

        // Check timestamp (prevent replay attacks)
        if (abs(time() - $timestamp) > 300) { // 5 minutes tolerance
            return response()->json([
                'error' => 'Request timestamp is too old'
            ], 401);
        }

        $merchantApiKey = MerchantApiKey::where('api_key', $apiKey)
            ->where('is_active', true)
            ->first();

        if (!$merchantApiKey) {
            Log::warning('Invalid API key used', ['api_key' => $apiKey, 'ip' => $request->ip()]);
            return response()->json([
                'error' => 'Invalid API key'
            ], 401);
        }

        // Verify signature
        $payload = $request->getContent();
        $expectedSignature = hash_hmac('sha256', $timestamp . $payload, $merchantApiKey->secret_key);

        if (!hash_equals($signature, $expectedSignature)) {
            Log::warning('Invalid signature for API key', ['api_key' => $apiKey]);
            return response()->json([
                'error' => 'Invalid signature'
            ], 401);
        }

        // Update last used timestamp
        $merchantApiKey->update(['last_used_at' => now()]);

        // Add merchant API key to request
        $request->attributes->set('merchant_api_key', $merchantApiKey);

        return $next($request);
    }
}
