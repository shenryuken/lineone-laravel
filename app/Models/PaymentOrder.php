<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'merchant_api_key_id',
        'amount',
        'currency',
        'description',
        'customer_email',
        'customer_name',
        'customer_phone',
        'merchant_order_id',
        'return_url',
        'cancel_url',
        'status',
        'transaction_id',
        'expires_at',
        'paid_at',
        'metadata',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'expires_at' => 'datetime',
        'paid_at' => 'datetime',
        'metadata' => 'array',
    ];

    public function merchantApiKey(): BelongsTo
    {
        return $this->belongsTo(MerchantApiKey::class);
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    public function getPaymentUrlAttribute(): string
    {
        return route('payment.checkout', $this->order_id);
    }

    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    public function canBePaid(): bool
    {
        return $this->status === 'pending' && !$this->isExpired();
    }
}
