<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kyb;
use Illuminate\Support\Facades\Auth;

class KybController extends Controller
{
    public function dashboard()
    {
        return view('kyb.dashboard');
    }

    public function apply()
    {
        // Check if user already has a pending or approved KYB application
        $existingKyb = Kyb::where('user_id', Auth::id())
            ->whereIn('status', ['pending', 'approved', 'kiv'])
            ->first();

        if ($existingKyb) {
            if ($existingKyb->status === 'approved') {
                return redirect()->route('kyb.dashboard')
                    ->with('toast', [
                        'type' => 'info',
                        'message' => 'Your KYB is already approved.'
                    ]);
            } elseif ($existingKyb->status === 'pending' || $existingKyb->status === 'kiv') {
                return redirect()->route('kyb.dashboard')
                    ->with('toast', [
                        'type' => 'info',
                        'message' => 'You already have a pending KYB application.'
                    ]);
            }
        }

        return view('kyb.apply');
    }

    public function status()
    {
        // Check if user has a KYB application
        $kyb = Kyb::where('user_id', Auth::id())->latest()->first();
        if (!$kyb) {
            return redirect()->route('kyb.apply');
        }

        return view('kyb.status');
    }

    public function viewApplication(Kyb $kyb)
    {
        // Ensure the user can only view their own KYB applications
        if ($kyb->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('kyb.view-application', compact('kyb'));
    }

    public function update()
    {
        // Check if user has a KYB application that can be updated
        $kyb = Kyb::where('user_id', Auth::id())
            ->whereIn('status', ['kiv', 'pending'])
            ->latest()
            ->first();

        if (!$kyb) {
            return redirect()->route('kyb.dashboard')
                ->with('toast', [
                    'type' => 'error',
                    'message' => 'No updatable KYB application found.'
                ]);
        }

        return view('kyb.update', compact('kyb'));
    }

    public function uploadAdditionalDocument()
    {
        $kyb = Kyb::where('user_id', Auth::id())->latest()->first();

        if (!$kyb || !in_array($kyb->status, ['kiv', 'pending'])) {
            return redirect()->route('kyb.dashboard')
                ->with('toast', [
                    'type' => 'error',
                    'message' => 'No updatable KYB application found.'
                ]);
        }

        return view('kyb.upload-additional', compact('kyb'));
    }
}

