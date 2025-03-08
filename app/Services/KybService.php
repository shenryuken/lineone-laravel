<?php

namespace App\Services;

use App\Models\Kyb;
use Illuminate\Support\Facades\DB;

class KybService
{
    public function updateVerificationStatus(Kyb $kyb, string $status, ?string $notes = null)
    {
        DB::transaction(function () use ($kyb, $status, $notes) {
            $kyb->verification_status = $status;
            $kyb->verification_notes = $notes;
            $kyb->verified_by = auth()->id();
            $kyb->verified_at = now();
            $kyb->save();
        });
    }

    public function approveKyb(Kyb $kyb, ?string $note = null)
    {
        DB::transaction(function () use ($kyb, $note) {
            $kyb->status = 'approved';
            $kyb->approval_note = $note;
            $kyb->approved_by = auth()->id();
            $kyb->approved_at = now();
            $kyb->save();

            $kyb->user->update(['kyb_status' => 'approved']);
        });
    }

    public function rejectKyb(Kyb $kyb, string $reason)
    {
        DB::transaction(function () use ($kyb, $reason) {
            $kyb->status = 'rejected';
            $kyb->rejection_reason = $reason;
            $kyb->rejected_by = auth()->id();
            $kyb->rejected_at = now();
            $kyb->save();

            $kyb->user->update(['kyb_status' => 'rejected']);
        });
    }

    public function kivKyb(Kyb $kyb, string $reason)
    {
        DB::transaction(function () use ($kyb, $reason) {
            $kyb->status = 'kiv';
            $kyb->kiv_reason = $reason;
            $kyb->kiv_by = auth()->id();
            $kyb->kiv_at = now();
            $kyb->save();

            $kyb->user->update(['kyb_status' => 'kiv']);
        });
    }
}

