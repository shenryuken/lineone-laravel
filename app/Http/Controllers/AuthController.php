<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\DB;

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
}
