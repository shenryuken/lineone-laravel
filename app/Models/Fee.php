<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'fee_transaction_id',
        'amount',
        'currency',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }

    public function feeTransaction()
    {
        return $this->belongsTo(Transaction::class, 'fee_transaction_id');
    }
}

