<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MerchantApiKey extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'api_key',
        'secret_key',
        'is_active',
        'webhook_url',
        'allowed_domains',
        'daily_limit',
        'per_transaction_limit',
        'last_used_at',
    ];

    protected $casts = [
        'allowed_domains' => 'array',
        'is_active' => 'boolean',
        'daily_limit' => 'decimal:2',
        'per_transaction_limit' => 'decimal:2',
        'last_used_at' => 'datetime',
    ];

    protected $hidden = [
        'secret_key',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function paymentOrders(): HasMany
    {
        return $this->hasMany(PaymentOrder::class);
    }

    public function getTodayTransactionTotal(): float
    {
        return $this->paymentOrders()
            ->where('status', 'paid')
            ->whereDate('created_at', today())
            ->sum('amount');
    }
}
