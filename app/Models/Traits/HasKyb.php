<?php

namespace App\Models\Traits;

use App\Models\Kyb;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait HasKyb
{
    /**
     * Get the user's KYB application
     */
    public function kyb(): HasOne
    {
        return $this->hasOne(Kyb::class);
    }

    /**
     * Get KYB status with proper fallback
     */
    public function kybStatus(): string
    {
        if (!$this->kyb) {
            return 'pending submission';
        }

        return match($this->kyb->status) {
            'approved' => 'verified',
            'rejected' => 'rejected',
            'pending' => 'under review',
            'additional_info_required' => 'additional info required',
            default => 'pending submission'
        };
    }

    /**
     * Check if user has completed KYB verification
     */
    public function hasCompletedKyb(): bool
    {
        return $this->kyb && $this->kyb->status === 'approved';
    }
}
