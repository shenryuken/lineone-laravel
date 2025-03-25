<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'swift_code',
        'type',
        'country_code',
        'country_name',
        'supported_currencies',
        'description',
        'logo_path',
        'is_active',
        'metadata',
    ];

    protected $casts = [
        'supported_currencies' => 'array',
        'is_active' => 'boolean',
        'metadata' => 'array',
    ];

    /**
     * Scope a query to only include local banks.
     */
    public function scopeLocal($query)
    {
        return $query->where('type', 'local');
    }

    /**
     * Scope a query to only include international banks.
     */
    public function scopeInternational($query)
    {
        return $query->where('type', 'international');
    }

    /**
     * Scope a query to only include active banks.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to filter by country.
     */
    public function scopeCountry($query, $countryCode)
    {
        return $query->where('country_code', $countryCode);
    }

    /**
     * Check if the bank supports a specific currency.
     */
    public function supportsCurrency($currencyCode)
    {
        return in_array($currencyCode, $this->supported_currencies);
    }

    /**
     * Get the country that the bank belongs to.
     */
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_code', 'code');
    }
}

