<?php

namespace App\Models\Traits;

use App\Models\TransferLimit;
use App\Models\BatchTransfer;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasTransfers
{
    public function transferLimit(): HasOne
    {
        return $this->hasOne(TransferLimit::class);
    }

    public function batchTransfers(): HasMany
    {
        return $this->hasMany(BatchTransfer::class);
    }

    /**
     * Get or create transfer limit for user
     */
    public function getOrCreateTransferLimit()
    {
        return $this->transferLimit ?: $this->transferLimit()->create([]);
    }

    /**
     * Check if user can perform batch transfers
     */
    public function canBatchTransfer(): bool
    {
        return in_array($this->role, ['admin', 'fund_manager', 'merchant']);
    }
}
