<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * Display a listing of the countries.
     */
    public function index()
    {
        return view('admin.countries.index');
    }

    /**
     * Show the details of a specific country.
     */
    public function show(Country $country)
    {
        return view('admin.countries.show', compact('country'));
    }
}

