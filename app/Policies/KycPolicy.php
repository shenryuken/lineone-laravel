<?php

namespace App\Policies;

use App\Models\Kyc;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class KycPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->hasAnyRole(['admin', 'staff']);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Kyc  $kyc
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Kyc $kyc)
    {
        return $user->hasAnyRole(['admin', 'staff']);
    }

    /**
     * Determine whether the user can verify the KYC.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Kyc  $kyc
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function verify(User $user, Kyc $kyc)
    {
        return $user->hasAnyRole(['admin', 'staff']);
    }

    /**
     * Determine whether the user can approve the KYC.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Kyc  $kyc
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function approve(User $user, Kyc $kyc)
    {
        return $user->hasRole('admin') &&
               $kyc->verification_status === 'pass' &&
               $kyc->status === 'pending';
    }

    /**
     * Determine whether the user can reject the KYC.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Kyc  $kyc
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function reject(User $user, Kyc $kyc)
    {
        return $user->hasRole('admin') &&
               $kyc->status !== 'rejected';
    }

    /**
     * Determine whether the user can mark the KYC as KIV.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Kyc  $kyc
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function kiv(User $user, Kyc $kyc)
    {
        return $user->hasRole('admin') &&
               $kyc->status !== 'kiv';
    }
}

