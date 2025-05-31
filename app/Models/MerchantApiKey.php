<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class MerchantApiKey extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'api_key',
        'secret_key',
        'mode',
        'is_active',
        'webhook_url',
        'allowed_domains',
        'permissions',
        'daily_limit',
        'per_transaction_limit',
        'expires_at',
        'last_used_at',
    ];

    protected $casts = [
        'allowed_domains' => 'array',
        'permissions' => 'array',
        'is_active' => 'boolean',
        'daily_limit' => 'decimal:2',
        'per_transaction_limit' => 'decimal:2',
        'expires_at' => 'datetime',
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
        return $this->hasMany(PaymentOrder::class, 'merchant_api_key_id');
    }

    public function getTodayTransactionTotal(): float
    {
        return $this->paymentOrders()
            ->where('status', 'paid')
            ->whereDate('created_at', today())
            ->sum('amount');
    }

    public function isTestMode(): bool
    {
        return $this->mode === 'test';
    }

    public function isLiveMode(): bool
    {
        return $this->mode === 'live';
    }

    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    /**
     * Generate API key and secret key based on mode
     */
    public static function generateKeys(string $mode = 'test'): array
    {
        $prefix = $mode === 'test' ? 'test_' : 'live_';
        
        return [
            'api_key' => $prefix . 'pk_' . Str::random(32),
            'secret_key' => $prefix . 'sk_' . Str::random(32),
        ];
    }

    /**
     * Get masked secret key for display
     */
    public function getMaskedSecretKeyAttribute(): string
    {
        if (!$this->secret_key) {
            return '';
        }
        
        $prefix = substr($this->secret_key, 0, 12); // test_sk_ or live_sk_
        return $prefix . str_repeat('*', 20) . substr($this->secret_key, -4);
    }
}
