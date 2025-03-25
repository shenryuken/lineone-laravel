<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'code_alpha2',
        'name',
        'currency_code',
        'currency_name',
        'currency_symbol',
        'phone_code',
        'flag_path',
        'region',
        'is_active',
        'metadata',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'metadata' => 'array',
    ];

    /**
     * Scope a query to only include active countries.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to filter by region.
     */
    public function scopeRegion($query, $region)
    {
        return $query->where('region', $region);
    }

    /**
     * Get the banks associated with this country.
     */
    public function banks()
    {
        return $this->hasMany(Bank::class, 'country_code', 'code');
    }

    /**
     * Get the flag URL.
     */
    public function getFlagUrlAttribute()
    {
        if ($this->flag_path) {
            return asset('storage/' . $this->flag_path);
        }

        // Return a default flag image or generate one based on the country code
        return asset('images/flags/' . strtolower($this->code_alpha2) . '.png');
    }
}

