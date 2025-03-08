<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the transactions.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.transactions.index');
    }

    /**
     * Display the specified transaction.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\View\View
     */
    public function show(Transaction $transaction)
    {
        return view('admin.transactions.show', compact('transaction'));
    }
}

