<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kyc;
use Illuminate\Support\Facades\Auth;

class KycController extends Controller
{
    public function dashboard()
    {
        return view('kyc.dashboard');
    }

    public function apply()
    {
        // Check if user already has a pending or approved KYC application
        $existingKyc = Kyc::where('user_id', Auth::id())
            ->whereIn('status', ['pending', 'approved', 'kiv'])
            ->first();

        if ($existingKyc) {
            if ($existingKyc->status === 'approved') {
                return redirect()->route('kyc.dashboard')
                    ->with('toast', [
                        'type' => 'info',
                        'message' => 'Your KYC is already approved.'
                    ]);
            } elseif ($existingKyc->status === 'pending' || $existingKyc->status === 'kiv') {
                return redirect()->route('kyc.dashboard')
                    ->with('toast', [
                        'type' => 'info',
                        'message' => 'You already have a pending KYC application.'
                    ]);
            }
        }

        return view('kyc.apply');
    }

    public function status()
    {
        // Check if user has a KYC application
        $kyc = Kyc::where('user_id', Auth::id())->latest()->first();
        if (!$kyc) {
            return redirect()->route('kyc.apply');
        }

        return view('kyc.status');
    }

    public function viewApplication(Kyc $kyc)
    {
        // Ensure the user can only view their own KYC applications
        if ($kyc->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('kyc.view-application', compact('kyc'));
    }

    public function update()
    {
        // Check if user has a KYC application that can be updated
        $kyc = Kyc::where('user_id', Auth::id())
            ->whereIn('status', ['kiv', 'pending'])
            ->latest()
            ->first();

        if (!$kyc) {
            return redirect()->route('kyc.dashboard')
                ->with('toast', [
                    'type' => 'error',
                    'message' => 'No updatable KYC application found.'
                ]);
        }

        return view('kyc.update', compact('kyc'));
    }

    public function uploadAdditionalDocument()
    {
        $kyc = Kyc::where('user_id', Auth::id())->latest()->first();

        if (!$kyc || !in_array($kyc->status, ['kiv', 'pending'])) {
            return redirect()->route('kyc.dashboard')
                ->with('toast', [
                    'type' => 'error',
                    'message' => 'No updatable KYC application found.'
                ]);
        }

        return view('kyc.upload-additional', compact('kyc'));
    }
}

