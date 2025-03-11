<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    // Transaction types
    const TYPE_DEPOSIT = 'deposit';
    const TYPE_WITHDRAWAL = 'withdrawal';
    const TYPE_TRANSFER = 'transfer';
    const TYPE_PAYMENT = 'payment';
    const TYPE_REFUND = 'refund';
    const TYPE_WITHDRAWAL_FEE = 'withdrawal fee';
    const TYPE_DEPOSIT_FEE = 'deposit fee';

    // Transaction statuses
    const STATUS_PENDING = 'pending';
    const STATUS_COMPLETED = 'completed';
    const STATUS_FAILED = 'failed';
    const STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'wallet_id',
        'type',
        'amount',
        'currency',
        'balance_before',
        'balance_after',
        'description',
        'status',
        'metadata',
        'reference_id'
    ];

    protected $casts = [
        'amount' => 'integer',
        'balance_before' => 'integer',
        'balance_after' => 'integer',
        'metadata' => 'array',
    ];

    /**
     * Get the wallet that owns the transaction.
     */
    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }

    /**
     * Get the sender of the transaction.
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Get the recipient of the transaction.
     */
    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }

    /**
     * Get the formatted amount.
     */
    public function getFormattedAmountAttribute(): string
    {
        // Remove the prefix logic from here since we'll handle it in the view
        return number_format(abs($this->amount) / 100, 2);
    }

    /**
     * Get the transaction icon based on type.
     */
    public function getIconAttribute(): string
    {
        switch ($this->type) {
            case self::TYPE_DEPOSIT:
                return 'arrow-up';
            case self::TYPE_WITHDRAWAL:
            case self::TYPE_TRANSFER:
                return 'arrow-down';
            case self::TYPE_PAYMENT:
                return 'credit-card';
            case self::TYPE_REFUND:
                return 'refresh-cw';
            default:
                return 'activity';
        }
    }

    /**
     * Get the transaction color based on type.
     */
    public function getColorAttribute(): string
    {
        if ($this->type === self::TYPE_TRANSFER || $this->type === self::TYPE_WITHDRAWAL ||
            $this->type === self::TYPE_WITHDRAWAL_FEE ||$this->type === self::TYPE_DEPOSIT_FEE) {
            return 'error';
        }

        return 'success';
    }

    /**
     * Scope a query to only include transactions from a specific period.
     */
    public function scopeFromPeriod($query, $days)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    /**
     * Determine if the transaction is negative for the current user
     */
    public function isNegative(): bool
    {
        // Lock the wallet record to prevent race conditions
        $wallet = $this->wallet()->lockForUpdate()->first();
        
        // All transfers and withdrawals should be shown as negative
        return ($this->type === self::TYPE_TRANSFER || $this->type === self::TYPE_WITHDRAWAL ||
                $this->type === self::TYPE_WITHDRAWAL_FEE || $this->type === self::TYPE_DEPOSIT_FEE
        )
            && $this->wallet->user_id === auth()->id();
    }
}

