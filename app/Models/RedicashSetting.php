<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RedicashSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'mode',
        'public_key',
        'secret_key',
        'webhook_secret',
        'webhook_url',
        'active',
        'metadata',
    ];

    protected $casts = [
        'active' => 'boolean',
        'metadata' => 'array',
    ];

    /**
     * Get the active Redicash settings
     */
    public static function active()
    {
        return self::where('active', true)->first();
    }
}
