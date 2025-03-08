<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kyb;
use Illuminate\Http\Request;

class KybController extends Controller
{
    /**
     * Display the admin KYB dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        return view('admin.kyb.dashboard');
    }

    /**
     * Display a listing of KYB applications.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.kyb.index');
    }

    /**
     * Display the specified KYB application.
     *
     * @param  \App\Models\Kyb  $kyb
     * @return \Illuminate\View\View
     */
    public function show(Kyb $kyb)
    {
        return view('admin.kyb.show', compact('kyb'));
    }
}

