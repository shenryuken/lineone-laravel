<?php

namespace App\Models\Traits;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait HasProfile
{
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

    /**
     * Get the user's avatar URL
     */
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            return $this->avatar;
        }
        
        // Default to UI Avatars if no custom avatar is set
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=random';
    }
}
