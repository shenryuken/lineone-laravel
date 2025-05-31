<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\MerchantApiKey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ApiKeyController extends Controller
{
    /**
     * Display API keys dashboard
     */
    public function index()
    {
        $user = Auth::user();
        
        $testKeys = $user->merchantApiKeys()->where('mode', 'test')->latest()->get();
        $liveKeys = $user->merchantApiKeys()->where('mode', 'live')->latest()->get();
        
        return view('merchant.api-keys.index', compact('testKeys', 'liveKeys'));
    }

    /**
     * Show the form for creating a new API key
     */
    public function create()
    {
        return view('merchant.api-keys.create');
    }

    /**
     * Store a newly created API key
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'mode' => 'required|in:test,live',
            'webhook_url' => 'nullable|url',
            'daily_limit' => 'required|numeric|min:1|max:1000000',
            'per_transaction_limit' => 'required|numeric|min:1|max:100000',
            'allowed_domains' => 'nullable|string',
            'expires_in_days' => 'nullable|integer|min:1|max:365',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = Auth::user();

        // Check limits for live keys (you can set business rules here)
        if ($request->mode === 'live') {
            $liveKeysCount = $user->merchantApiKeys()->where('mode', 'live')->count();
            if ($liveKeysCount >= 5) { // Max 5 live keys
                return back()->withErrors(['mode' => 'Maximum number of live API keys reached.'])->withInput();
            }
        }

        $keys = MerchantApiKey::generateKeys($request->mode);
        
        $allowedDomains = null;
        if ($request->allowed_domains) {
            $allowedDomains = array_map('trim', explode(',', $request->allowed_domains));
        }

        $expiresAt = null;
        if ($request->expires_in_days) {
            $expiresAt = now()->addDays($request->expires_in_days);
        }

        $apiKey = MerchantApiKey::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'description' => $request->description,
            'api_key' => $keys['api_key'],
            'secret_key' => $keys['secret_key'],
            'mode' => $request->mode,
            'webhook_url' => $request->webhook_url,
            'daily_limit' => $request->daily_limit,
            'per_transaction_limit' => $request->per_transaction_limit,
            'allowed_domains' => $allowedDomains,
            'expires_at' => $expiresAt,
            'is_active' => true,
        ]);

        // Store the secret key in session to show once
        session()->flash('new_secret_key', $keys['secret_key']);
        session()->flash('new_api_key', $keys['api_key']);

        return redirect()->route('merchant.api-keys.show', $apiKey)
            ->with('success', 'API key created successfully! Please save your secret key as it will not be shown again.');
    }

    /**
     * Display the specified API key
     */
    public function show(MerchantApiKey $apiKey)
    {
        // Ensure the API key belongs to the authenticated user
        if ($apiKey->user_id !== Auth::id()) {
            abort(403);
        }

        $recentOrders = $apiKey->paymentOrders()
            ->latest()
            ->limit(10)
            ->get();

        $todayStats = [
            'total_amount' => $apiKey->getTodayTransactionTotal(),
            'total_orders' => $apiKey->paymentOrders()->whereDate('created_at', today())->count(),
            'successful_orders' => $apiKey->paymentOrders()->where('status', 'paid')->whereDate('created_at', today())->count(),
        ];

        return view('merchant.api-keys.show', compact('apiKey', 'recentOrders', 'todayStats'));
    }

    /**
     * Show the form for editing the specified API key
     */
    public function edit(MerchantApiKey $apiKey)
    {
        // Ensure the API key belongs to the authenticated user
        if ($apiKey->user_id !== Auth::id()) {
            abort(403);
        }

        return view('merchant.api-keys.edit', compact('apiKey'));
    }

    /**
     * Update the specified API key
     */
    public function update(Request $request, MerchantApiKey $apiKey)
    {
        // Ensure the API key belongs to the authenticated user
        if ($apiKey->user_id !== Auth::id()) {
            abort(403);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'webhook_url' => 'nullable|url',
            'daily_limit' => 'required|numeric|min:1|max:1000000',
            'per_transaction_limit' => 'required|numeric|min:1|max:100000',
            'allowed_domains' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $allowedDomains = null;
        if ($request->allowed_domains) {
            $allowedDomains = array_map('trim', explode(',', $request->allowed_domains));
        }

        $apiKey->update([
            'name' => $request->name,
            'description' => $request->description,
            'webhook_url' => $request->webhook_url,
            'daily_limit' => $request->daily_limit,
            'per_transaction_limit' => $request->per_transaction_limit,
            'allowed_domains' => $allowedDomains,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('merchant.api-keys.show', $apiKey)
            ->with('success', 'API key updated successfully.');
    }

    /**
     * Remove the specified API key
     */
    public function destroy(MerchantApiKey $apiKey)
    {
        // Ensure the API key belongs to the authenticated user
        if ($apiKey->user_id !== Auth::id()) {
            abort(403);
        }

        $apiKey->delete();

        return redirect()->route('merchant.api-keys.index')
            ->with('success', 'API key deleted successfully.');
    }

    /**
     * Toggle API key status
     */
    public function toggle(MerchantApiKey $apiKey)
    {
        // Ensure the API key belongs to the authenticated user
        if ($apiKey->user_id !== Auth::id()) {
            abort(403);
        }

        $apiKey->update(['is_active' => !$apiKey->is_active]);

        $status = $apiKey->is_active ? 'activated' : 'deactivated';
        
        return back()->with('success', "API key {$status} successfully.");
    }

    /**
     * Regenerate secret key
     */
    public function regenerateSecret(MerchantApiKey $apiKey)
    {
        // Ensure the API key belongs to the authenticated user
        if ($apiKey->user_id !== Auth::id()) {
            abort(403);
        }

        $keys = MerchantApiKey::generateKeys($apiKey->mode);
        
        $apiKey->update([
            'secret_key' => $keys['secret_key']
        ]);

        // Store the new secret key in session to show once
        session()->flash('new_secret_key', $keys['secret_key']);

        return back()->with('success', 'Secret key regenerated successfully! Please save your new secret key as it will not be shown again.');
    }

    /**
     * Show API testing console
     */
    public function testConsole()
    {
        $user = Auth::user();
        $apiKeys = $user->merchantApiKeys()->where('is_active', true)->get();
        
        return view('merchant.api-keys.test', compact('apiKeys'));
    }
}
