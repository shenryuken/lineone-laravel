<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

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

    /**
     * Status constants
     */
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    const STATUS_SUSPENDED = 'suspended';

    /**
     * Get all available status options
     *
     * @return array
     */
    public static function getStatusOptions(): array
    {
        return [
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_INACTIVE => 'Inactive',
            self::STATUS_SUSPENDED => 'Suspended',
        ];
    }

    /**
     * Check if user is active
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    /**
     * Check if user is inactive
     *
     * @return bool
     */
    public function isInactive(): bool
    {
        return $this->status === self::STATUS_INACTIVE;
    }

    /**
     * Check if user is suspended
     *
     * @return bool
     */
    public function isSuspended(): bool
    {
        return $this->status === self::STATUS_SUSPENDED;
    }

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

    /**
     * Get the user's avatar URL
     */
    public function getAvatarUrlAttribute()
    {
        // You can implement your own avatar logic here
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=random';
    }

    /**
     * Get the user's profile.
     */
    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    /**
     * Create a profile for the user if it doesn't exist
     */
    public function createProfile(array $attributes = []): Profile
    {
        if (!$this->profile) {
            return $this->profile()->create($attributes);
        }

        return $this->profile->fill($attributes)->save();
    }

    public function transactions(): HasManyThrough
    {
        return $this->hasManyThrough(Transaction::class, Wallet::class);
    }
}
