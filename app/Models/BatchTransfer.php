<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatchTransfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'wallet_id',
        'batch_reference',
        'total_amount',
        'total_recipients',
        'successful_transfers',
        'failed_transfers',
        'status',
        'description',
        'recipients',
        'results',
        'processed_at'
    ];

    protected $casts = [
        'recipients' => 'array',
        'results' => 'array',
        'processed_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'reference_id', 'batch_reference');
    }

    public static function generateBatchReference()
    {
        return 'BATCH_' . time() . '_' . rand(1000, 9999);
    }

    public function getSuccessRateAttribute()
    {
        if ($this->total_recipients == 0) return 0;
        return round(($this->successful_transfers / $this->total_recipients) * 100, 2);
    }
}
