<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KybStatusHistory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'kyb_id',
        'status',
        'comment',
        'user_id',
        'is_note',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_note' => 'boolean',
    ];

    /**
     * Get the KYB application that owns the status history.
     */
    public function kyb()
    {
        return $this->belongsTo(Kyb::class);
    }

    /**
     * Get the user who created the status history.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

