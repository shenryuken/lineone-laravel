<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\TransferLimit;
use App\Models\Wallet;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class SettingsController extends Controller
{
    /**
     * Display the settings index page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('settings.index');
    }

    /**
     * Display the profile settings page.
     *
     * @return \Illuminate\View\View
     */
    public function profile()
    {
        return view('settings.profile');
    }

    /**
     * Display the security settings page.
     *
     * @return \Illuminate\View\View
     */
    public function security()
    {
        return view('settings.security');
    }

    /**
     * Display the notification settings page.
     *
     * @return \Illuminate\View\View
     */
    public function notifications()
    {
        return view('settings.notifications');
    }

    /**
     * Display the transfer limits settings page.
     *
     * @return \Illuminate\View\View
     */
    public function limits()
    {
        return view('settings.limits');
    }

    /**
     * Display the preferences settings page.
     *
     * @return \Illuminate\View\View
     */
    public function preferences()
    {
        return view('settings.preferences');
    }

    /**
     * Display the API settings page.
     *
     * @return \Illuminate\View\View
     */
    public function api()
    {
        // Only show API settings for merchants and admins
        if (!Auth::user()->hasAnyRole(['merchant', 'admin'])) {
            return redirect()->route('settings.index')
                ->with('error', 'You do not have permission to access API settings.');
        }
        
        return view('settings.api');
    }
}
