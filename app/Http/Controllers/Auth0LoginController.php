<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class Auth0LoginController extends Controller
{
    /**
     * Redirect to Auth0 login page
     */
    public function login()
    {
        // Build the Auth0 authorization URL manually
        $domain = config('services.auth0.domain');
        $clientId = config('services.auth0.client_id');
        $redirectUri = url('/auth0/callback'); // Simplified callback URL
        $state = Str::random(40); // Generate a random state parameter

        // Store the state in the session for verification
        session(['auth0_state' => $state]);

        // Build the authorization URL
        $authUrl = "https://{$domain}/authorize?" . http_build_query([
            'client_id' => $clientId,
            'redirect_uri' => $redirectUri,
            'response_type' => 'code',
            'scope' => 'openid profile email',
            'state' => $state,
        ]);

        Log::info('Redirecting to Auth0', [
            'auth_url' => $authUrl,
            'redirect_uri' => $redirectUri,
            'state' => $state
        ]);

        return redirect()->away($authUrl);
    }

    /**
     * Redirect directly to Google login via Auth0
     */
    public function loginWithGoogle()
    {
        // Build the Auth0 authorization URL manually with connection=google
        $domain = config('services.auth0.domain');
        $clientId = config('services.auth0.client_id');
        $redirectUri = url('/auth0/callback'); // Same callback as regular Auth0 login
        $state = Str::random(40); // Generate a random state parameter

        // Store the state in the session for verification
        session(['auth0_state' => $state]);

        // Build the authorization URL with connection=google
        $authUrl = "https://{$domain}/authorize?" . http_build_query([
            'client_id' => $clientId,
            'redirect_uri' => $redirectUri,
            'response_type' => 'code',
            'scope' => 'openid profile email',
            'state' => $state,
            'connection' => 'google-oauth2' // Specify Google connection
        ]);

        Log::info('Redirecting to Google via Auth0', [
            'auth_url' => $authUrl,
            'redirect_uri' => $redirectUri,
            'state' => $state
        ]);

        return redirect()->away($authUrl);
    }

    /**
     * Handle the Auth0 callback
     */
    public function callback(Request $request)
    {
        try {
            // Verify state to prevent CSRF attacks
            $state = $request->input('state');
            $sessionState = session('auth0_state');

            if (!$state || $state !== $sessionState) {
                Log::error('Auth0 state mismatch', [
                    'request_state' => $state,
                    'session_state' => $sessionState
                ]);
                return redirect()->route('login')->with('error', 'Invalid state parameter. Authentication failed.');
            }

            // Clear the state from the session
            session()->forget('auth0_state');

            // Get the authorization code
            $code = $request->input('code');
            if (!$code) {
                Log::error('Auth0 callback missing code', [
                    'request' => $request->all()
                ]);
                return redirect()->route('login')->with('error', 'Authorization code missing.');
            }

            // Exchange the code for a token
            $domain = config('services.auth0.domain');
            $clientId = config('services.auth0.client_id');
            $clientSecret = config('services.auth0.client_secret');
            $redirectUri = url('/auth0/callback');

            $response = Http::post("https://{$domain}/oauth/token", [
                'grant_type' => 'authorization_code',
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
                'code' => $code,
                'redirect_uri' => $redirectUri,
            ]);

            if (!$response->successful()) {
                Log::error('Auth0 token exchange failed', [
                    'response' => $response->json()
                ]);
                return redirect()->route('login')->with('error', 'Failed to exchange authorization code for token.');
            }

            $tokens = $response->json();

            // Get user info using the access token
            $userInfoResponse = Http::withToken($tokens['access_token'])
                ->get("https://{$domain}/userinfo");

            if (!$userInfoResponse->successful()) {
                Log::error('Auth0 userinfo request failed', [
                    'response' => $userInfoResponse->json()
                ]);
                return redirect()->route('login')->with('error', 'Failed to get user information.');
            }

            $userInfo = $userInfoResponse->json();

            // Check if user exists with Auth0 ID
            $user = User::where('provider', 'auth0')
                ->where('provider_id', $userInfo['sub'])
                ->first();

            // If user doesn't exist, check if email exists
            if (!$user && isset($userInfo['email'])) {
                $user = User::where('email', $userInfo['email'])->first();

                // If user with email exists, update provider details
                if ($user) {
                    $user->update([
                        'provider' => 'auth0',
                        'provider_id' => $userInfo['sub'],
                        'avatar' => $userInfo['picture'] ?? null,
                    ]);
                } else {
                    // Create new user
                    $user = DB::transaction(function () use ($userInfo) {
                        $user = User::create([
                            'name' => $userInfo['name'] ?? ($userInfo['nickname'] ?? 'User'),
                            'email' => $userInfo['email'],
                            'password' => Hash::make(Str::random(16)), // Random password
                            'provider' => 'auth0',
                            'provider_id' => $userInfo['sub'],
                            'avatar' => $userInfo['picture'] ?? null,
                        ]);

                        $user->createWalletIfNotExists();
                        $user->assignRole('user'); // Assign default role

                        return $user;
                    });
                }
            }

            // Login the user
            Auth::login($user);

            return redirect()->route('dashboard');

        } catch (\Exception $e) {
            Log::error('Auth0 callback error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('login')->with('error', 'An error occurred during authentication. Please try again.');
        }
    }
}

