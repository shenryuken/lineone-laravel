<?php

namespace App\Services;

use App\Models\Kyc;
use App\Notifications\KycStatusUpdated;
use App\Notifications\KycAdditionalInfoRequested;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class KycService
{
    /**
     * Update the verification status of a KYC application
     *
     * @param Kyc $kyc
     * @param string $status
     * @param string|null $notes
     * @return Kyc
     */
    public function updateVerificationStatus(Kyc $kyc, string $status, ?string $notes = null): Kyc
    {
        $previousStatus = $kyc->verification_status;

        $kyc->verification_status = $status;
        $kyc->verification_notes = $notes;
        $kyc->verified_by = Auth::id();
        $kyc->verified_at = Carbon::now();
        $kyc->save();

        // If verification status changed and it's a final status (pass/fail), notify the user
        if ($previousStatus !== $status && in_array($status, ['pass', 'fail'])) {
            $kyc->user->notify(new KycStatusUpdated($kyc, $previousStatus));
        }

        return $kyc;
    }

    /**
     * Approve a KYC application
     *
     * @param Kyc $kyc
     * @param string|null $note
     * @return Kyc
     */
    public function approveKyc(Kyc $kyc, ?string $note = null): Kyc
    {
        $previousStatus = $kyc->status;

        $kyc->status = 'approved';
        $kyc->approved_by = Auth::id();
        $kyc->approved_at = Carbon::now();
        $kyc->save();

        // Update user's KYC status
        $kyc->user->update(['kyc_status' => 'approved']);

        // Notify the user about the status change
        $kyc->user->notify(new KycStatusUpdated($kyc, $previousStatus));

        return $kyc;
    }

    /**
     * Reject a KYC application
     *
     * @param Kyc $kyc
     * @param string $reason
     * @return Kyc
     */
    public function rejectKyc(Kyc $kyc, string $reason): Kyc
    {
        $previousStatus = $kyc->status;

        $kyc->status = 'rejected';
        $kyc->rejection_reason = $reason;
        $kyc->rejected_by = Auth::id();
        $kyc->rejected_at = Carbon::now();
        $kyc->save();

        // Update user's KYC status
        $kyc->user->update(['kyc_status' => 'rejected']);

        // Notify the user about the status change
        $kyc->user->notify(new KycStatusUpdated($kyc, $previousStatus));

        return $kyc;
    }

    /**
     * Mark a KYC application as Keep In View (KIV)
     *
     * @param Kyc $kyc
     * @param string $reason
     * @return Kyc
     */
    public function kivKyc(Kyc $kyc, string $reason): Kyc
    {
        $previousStatus = $kyc->status;

        $kyc->status = 'kiv';
        $kyc->verification_notes = $reason;
        $kyc->save();

        // Update user's KYC status
        $kyc->user->update(['kyc_status' => 'pending']);

        // Notify the user about the status change
        $kyc->user->notify(new KycStatusUpdated($kyc, $previousStatus));

        return $kyc;
    }

    /**
     * Request additional documents or information for a KYC application
     *
     * @param Kyc $kyc
     * @param string $request
     * @return Kyc
     */
    public function requestAdditionalInfo(Kyc $kyc, string $request): Kyc
    {
        $previousStatus = $kyc->status;

        // Add a new field to track additional info requests
        $kyc->additional_info_requested = $request;
        $kyc->additional_info_requested_at = Carbon::now();
        $kyc->additional_info_requested_by = Auth::id();
        $kyc->status = 'kiv';
        $kyc->save();

        // Update user's KYC status
        $kyc->user->update(['kyc_status' => 'pending']);

        // Create a special notification for additional info request
        $kyc->user->notify(new KycAdditionalInfoRequested($kyc, $request));

        return $kyc;
    }
}

