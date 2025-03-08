<?php

namespace App\Policies;

use App\Models\Kyb;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class KybPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Kyb $kyb): bool
    {
        // Admins can view any KYB
        if ($user->hasRole('admin')) {
            return true;
        }

        // Users can only view their own KYB
        return $user->id === $kyb->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Any authenticated user can create a KYB application
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Kyb $kyb): bool
    {
        // Only the owner can update their KYB application, and only if it's pending or KIV
        return $user->id === $kyb->user_id && in_array($kyb->status, ['pending', 'kiv']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Kyb $kyb): bool
    {
        // KYB applications should not be deleted
        return false;
    }

    /**
     * Determine whether the user can verify a KYB application.
     */
    public function verify(User $user, Kyb $kyb): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can approve a KYB application.
     */
    public function approve(User $user, Kyb $kyb): bool
    {
        // Only admins can approve, and only if it's been verified as 'pass'
        return $user->hasRole('admin') && $kyb->verification_status === 'pass';
    }

    /**
     * Determine whether the user can reject a KYB application.
     */
    public function reject(User $user, Kyb $kyb): bool
    {
        // Only admins can reject
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can mark a KYB application as KIV (Keep In View).
     */
    public function kiv(User $user, Kyb $kyb): bool
    {
        // Only admins can mark as KIV
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can request additional information.
     */
    public function requestAdditionalInfo(User $user, Kyb $kyb): bool
    {
        // Only admins can request additional information
        return $user->hasRole('admin');
    }
}

