<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password as PasswordBroker;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class AuthController extends Controller
{
    public function loginView()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email', 'exists:users'],
            'password' => ['required'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();

        if (\Auth::attempt(array('email' => $validated['email'], 'password' => $validated['password']))) {
            return redirect()->route('dashboard');
        } else {
            $validator->errors()->add(
                'password', 'The password does not match with username'
            );
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    public function registerView(){
        return view('register');
    }

    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'email' => ['required', 'email','unique:users'],
            'password' => ['required',"confirmed", Password::min(7)],
            'account_type' => ['required', 'in:personal,merchant'],
        ]);

        $validated = $validator->validated();

        $user = DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $user->createWalletIfNotExists();

            $role = $request->account_type === 'merchant' ? 'merchant' : 'user';
            $user->assignRole($role);

            return $user;
        });

        auth()->login($user);

        return redirect()->route('dashboard');
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }

    /**
     * Show the forgot password form
     */
    public function forgotPasswordView()
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle forgot password form submission
     */
    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $status = PasswordBroker::sendResetLink(
                $request->only('email')
            );

            Log::info('Password reset requested', ['email' => $request->email, 'status' => $status]);

            if ($status === PasswordBroker::RESET_LINK_SENT) {
                return back()->with('status', __('A password reset link has been sent to your email address.'));
            } else {
                return back()->withErrors(['email' => __('We could not find a user with that email address.')]);
            }
        } catch (\Exception $e) {
            Log::error('Error sending password reset link', [
                'email' => $request->email,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->withErrors(['email' => __('An error occurred while sending the password reset link. Please try again later.')]);
        }
    }

    /**
     * Show the reset password form
     */
    public function resetPasswordView(Request $request)
    {
        return view('auth.reset-password', [
            'token' => $request->token,
            'email' => $request->email
        ]);
    }

    /**
     * Handle reset password form submission
     */
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $status = PasswordBroker::reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function ($user, $password) {
                    $user->forceFill([
                        'password' => Hash::make($password)
                    ])->setRememberToken(Str::random(60));

                    $user->save();

                    event(new PasswordReset($user));
                }
            );

            Log::info('Password reset attempted', ['email' => $request->email, 'status' => $status]);

            if ($status === PasswordBroker::PASSWORD_RESET) {
                return redirect()->route('login')->with('status', __('Your password has been reset successfully!'));
            } else {
                return back()->withErrors(['email' => __('We could not reset your password. Please try again or request a new reset link.')]);
            }
        } catch (\Exception $e) {
            Log::error('Error resetting password', [
                'email' => $request->email,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->withErrors(['email' => __('An error occurred while resetting your password. Please try again later.')]);
        }
    }

    /**
     * Redirect the user to the provider authentication page.
     *
     * @param string $provider
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($provider)
    {
        try {
            // Validate that the provider is supported
            if (!in_array($provider, ['google', 'facebook', 'auth0'])) {
                return redirect()->route('login')->with('error', 'Unsupported login provider.');
            }

            // For debugging
            \Log::info('Redirecting to provider', ['provider' => $provider]);

            return Socialite::driver($provider)->redirect();
        } catch (Exception $e) {
            Log::error('Social login redirect error', [
                'provider' => $provider,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('login')->with('error', 'Unable to connect with ' . ucfirst($provider) . '. Please try again.');
        }
    }

    /**
     * Obtain the user information from the provider.
     *
     * @param string $provider
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider)
    {
        try {
            // Validate that the provider is supported
            if (!in_array($provider, ['google', 'facebook', 'auth0'])) {
                return redirect()->route('login')->with('error', 'Unsupported login provider.');
            }

            $socialUser = Socialite::driver($provider)->user();

            // Get the user ID based on the provider
            $providerId = $socialUser->getId();

            // For Auth0, the ID is in the sub field
            if ($provider === 'auth0' && empty($providerId) && isset($socialUser->user['sub'])) {
                $providerId = $socialUser->user['sub'];
            }

            // Check if user already exists with this provider
            $user = User::where('provider', $provider)
                ->where('provider_id', $providerId)
                ->first();

            // If user doesn't exist, check if email exists
            if (!$user) {
                $user = User::where('email', $socialUser->getEmail())->first();

                // If user with email exists, update provider details
                if ($user) {
                    $user->update([
                        'provider' => $provider,
                        'provider_id' => $providerId,
                        'avatar' => $socialUser->getAvatar(),
                    ]);
                } else {
                    // Create new user
                    $user = DB::transaction(function () use ($socialUser, $provider, $providerId) {
                        $user = User::create([
                            'name' => $socialUser->getName(),
                            'email' => $socialUser->getEmail(),
                            'password' => Hash::make(Str::random(16)), // Random password
                            'provider' => $provider,
                            'provider_id' => $providerId,
                            'avatar' => $socialUser->getAvatar(),
                        ]);

                        $user->createWalletIfNotExists();
                        $user->assignRole('user'); // Assign default role

                        return $user;
                    });
                }
            }

            // Login the user
            auth()->login($user);

            return redirect()->route('dashboard');

        } catch (Exception $e) {
            Log::error('Social login callback error', [
                'provider' => $provider,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('login')->with('error', 'Unable to login with ' . ucfirst($provider) . '. Please try again.');
        }
    }
}

