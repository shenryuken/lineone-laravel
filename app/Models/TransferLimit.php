<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class TransferLimit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'daily_limit',
        'monthly_limit',
        'single_transfer_limit',
        'daily_used',
        'monthly_used',
        'daily_reset_date',
        'monthly_reset_date',
        'is_verified'
    ];

    protected $casts = [
        'daily_reset_date' => 'date',
        'monthly_reset_date' => 'date',
        'is_verified' => 'boolean'
    ];

    protected $attributes = [
        'daily_limit' => 500000, // 5000 MYR in cents
        'monthly_limit' => 5000000, // 50000 MYR in cents
        'single_transfer_limit' => 100000, // 1000 MYR in cents
        'daily_used' => 0,
        'monthly_used' => 0,
        'is_verified' => false
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($transferLimit) {
            if (!$transferLimit->daily_reset_date) {
                $transferLimit->daily_reset_date = Carbon::today();
            }
            if (!$transferLimit->monthly_reset_date) {
                $transferLimit->monthly_reset_date = Carbon::now()->startOfMonth();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function checkAndResetLimits()
    {
        $today = Carbon::today();
        $thisMonth = Carbon::now()->startOfMonth();

        $needsUpdate = false;
        $updates = [];

        // Handle null or outdated daily reset date
        if (!$this->daily_reset_date || $this->daily_reset_date->lt($today)) {
            $updates['daily_used'] = 0;
            $updates['daily_reset_date'] = $today;
            $needsUpdate = true;
        }

        // Handle null or outdated monthly reset date
        if (!$this->monthly_reset_date || $this->monthly_reset_date->lt($thisMonth)) {
            $updates['monthly_used'] = 0;
            $updates['monthly_reset_date'] = $thisMonth;
            $needsUpdate = true;
        }

        if ($needsUpdate) {
            $this->update($updates);
            $this->refresh();
        }
    }

    public function canTransfer($amountCents)
    {
        $this->checkAndResetLimits();

        return $amountCents <= $this->single_transfer_limit &&
               ($this->daily_used + $amountCents) <= $this->daily_limit &&
               ($this->monthly_used + $amountCents) <= $this->monthly_limit;
    }

    public function recordTransfer($amountCents)
    {
        $this->increment('daily_used', $amountCents);
        $this->increment('monthly_used', $amountCents);
    }

    public function getRemainingDailyLimitAttribute()
    {
        $this->checkAndResetLimits();
        return max(0, $this->daily_limit - $this->daily_used);
    }

    public function getRemainingMonthlyLimitAttribute()
    {
        $this->checkAndResetLimits();
        return max(0, $this->monthly_limit - $this->monthly_used);
    }

    public function getFormattedDailyLimitAttribute()
    {
        return number_format($this->daily_limit / 100, 2);
    }

    public function getFormattedMonthlyLimitAttribute()
    {
        return number_format($this->monthly_limit / 100, 2);
    }

    public function getFormattedSingleTransferLimitAttribute()
    {
        return number_format($this->single_transfer_limit / 100, 2);
    }
}
