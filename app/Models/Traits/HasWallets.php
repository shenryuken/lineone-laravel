<?php

namespace App\Models\Traits;

use App\Models\Wallet;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

trait HasWallets
{
    public function wallets(): HasMany
    {
        return $this->hasMany(Wallet::class);
    }

    /**
     * Get wallet dynamically based on default, currency, or first available
     *
     * @param string|null $identifier Currency or wallet type
     * @return Wallet|null
     */
    public function wallet(?string $identifier = null)
    {
        $query = $this->wallets();

        // If no identifier, return default or first wallet
        if ($identifier === null) {
            return $query->where('is_default', true)->first()
                   ?? $query->first();
        }

        // Search by currency (case-insensitive)
        return $query->where(function($q) use ($identifier) {
            $q->where('currency', strtoupper($identifier))
              ->orWhere('type', strtolower($identifier));
        })->first();
    }

    /**
     * Create a wallet if not exists
     *
     * @param string $currency Currency of the wallet
     * @param string $type Wallet type
     * @return Wallet
     */
    public function createWalletIfNotExists(
        string $currency = 'MYR',
        string $type = 'default'
    ): Wallet {
        // Check if wallet already exists
        $existingWallet = $this->wallet($currency);

        if ($existingWallet) {
            return $existingWallet;
        }

        // Determine if this should be the default wallet
        $isDefault = $this->wallets()->count() === 0 || $type === 'default';

        return $this->wallets()->create([
            'account_number' => Wallet::generateUniqueAccountNumber(strtoupper($currency)),
            'currency' => strtoupper($currency),
            'balance' => 0,
            'type' => $type,
            'is_default' => $isDefault,
            'is_verify' => false
        ]);
    }

    public function transactions(): HasManyThrough
    {
        return $this->hasManyThrough(Transaction::class, Wallet::class);
    }
}
