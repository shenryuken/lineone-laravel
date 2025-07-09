<?php

namespace App\Models\Traits;

use App\Models\PaymentOrder;
use App\Models\MerchantApiKey;
use App\Models\ApiKey;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasPayments
{
    /**
     * Get the merchant API keys for the user.
     */
    public function merchantApiKeys(): HasMany
    {
        return $this->hasMany(MerchantApiKey::class);
    }

    /**
     * Get the API keys for the user (if you have the old ApiKey model).
     */
    public function apiKeys(): HasMany
    {
        return $this->hasMany(ApiKey::class);
    }

    /**
     * Get payment orders for this merchant
     */
    public function paymentOrders()
    {
        return PaymentOrder::query()
            ->join('merchant_api_keys', 'payment_orders.merchant_api_key_id', '=', 'merchant_api_keys.id')
            ->where('merchant_api_keys.user_id', $this->id)
            ->select('payment_orders.*'); // Select only payment_orders columns to avoid conflicts
    }
}
