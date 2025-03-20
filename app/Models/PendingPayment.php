<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendingPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'wallet_id',
        'reference_id',
        'provider',
        'amount',
        'status',
        'metadata',
        'last_checked_at',
    ];

    protected $casts = [
        'metadata' => 'array',
        'last_checked_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }
}

