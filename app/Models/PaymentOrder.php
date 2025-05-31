<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'merchant_api_key_id',
        'order_id',
        'amount',
        'currency',
        'status',
        'customer_email',
        'customer_name',
        'description',
        'payment_method',
        'callback_url',
        'return_url',
        'metadata',
        'expires_at',
        'paid_at',
        'cancelled_at',
        'refunded_at',
        'refund_amount',
        'external_reference',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'refund_amount' => 'decimal:2',
        'metadata' => 'array',
        'expires_at' => 'datetime',
        'paid_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'refunded_at' => 'datetime',
    ];

    /**
     * Get the API key that owns the payment order
     */
    public function apiKey(): BelongsTo
    {
        return $this->belongsTo(MerchantApiKey::class, 'merchant_api_key_id');
    }

    /**
     * Get the merchant API key that owns the payment order
     */
    public function merchantApiKey(): BelongsTo
    {
        return $this->belongsTo(MerchantApiKey::class, 'merchant_api_key_id');
    }

    /**
     * Get the merchant (user) through the API key
     */
    public function merchant()
    {
        return $this->belongsTo(User::class, 'user_id')->through('merchantApiKey');
    }

    /**
     * Scope for paid orders
     */
    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    /**
     * Scope for pending orders
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for failed orders
     */
    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    /**
     * Check if order is paid
     */
    public function isPaid(): bool
    {
        return $this->status === 'paid';
    }

    /**
     * Check if order is pending
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if order has expired
     */
    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    /**
     * Get formatted amount with currency
     */
    public function getFormattedAmountAttribute(): string
    {
        return $this->currency . ' ' . number_format($this->amount, 2);
    }

    /**
     * Get the payment URL for this order - FIXED
     */
    public function getPaymentUrlAttribute(): string
    {
        try {
            return route('payment.gateway.checkout', $this->order_id);
        } catch (\Exception $e) {
            // Fallback URL if route doesn't exist
            return url("/payment-gateway/checkout/{$this->order_id}");
        }
    }
}
