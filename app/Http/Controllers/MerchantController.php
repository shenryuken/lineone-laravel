<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MerchantController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:merchant']);
    }

    public function dashboard()
    {
        $user = Auth::user();
        
        // Ensure user has merchant role
        if (!$user->hasRole('merchant')) {
            abort(403, 'Access denied. Merchant role required.');
        }

        return view('merchant.dashboard', [
            'user' => $user,
            'hasCompletedKyb' => $user->hasCompletedKyb(),
            'kybStatus' => $user->kybStatus(),
        ]);
    }
}
