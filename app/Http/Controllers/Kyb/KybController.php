<?php

namespace App\Http\Controllers\Kyb;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kyb;

class KybController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        $kyb = Kyb::where('user_id', $user->id)->first();

        return view('kyb.dashboard', compact('kyb'));
    }

    public function application()
    {
        $user = auth()->user();
        $kyb = Kyb::where('user_id', $user->id)->first();

        // If no KYB application exists, create a new one
        if (!$kyb) {
            $kyb = new Kyb();
            $kyb->user_id = $user->id;
            $kyb->status = 'pending';
            $kyb->verification_status = 'pending';
            $kyb->save();
        }

        return view('kyb.application', compact('kyb'));
    }
}

