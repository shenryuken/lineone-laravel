<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Traits\HasStatus;
use App\Models\Traits\HasWallets;
use App\Models\Traits\HasProfile;
use App\Models\Traits\HasKyb;
use App\Models\Traits\HasPayments;
use App\Models\Traits\HasTransfers;

class User extends Authenticatable
{
    use HasFactory, 
        Notifiable, 
        HasRoles,
        HasStatus,
        HasWallets,
        HasProfile,
        HasKyb,
        HasPayments,
        HasTransfers;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'kyc_status',
        'account_type',
        'provider',
        'provider_id',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
