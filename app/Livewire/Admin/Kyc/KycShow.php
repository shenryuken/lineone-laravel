<?php

namespace App\Livewire\Admin\Kyc;

use App\Models\Kyc;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class KycShow extends Component
{
    use AuthorizesRequests;

    public Kyc $kyc;

    // Verification form
    public $verification_status = '';
    public $verification_notes = '';

    // Approval form
    public $approval_note = '';

    // Rejection form
    public $rejection_reason = '';

    // KIV form
    public $kiv_reason = '';

    // Additional info request form
    public $request_details = '';

    // Modal states
    public $showVerificationModal = false;
    public $showApprovalModal = false;
    public $showRejectionModal = false;
    public $showKivModal = false;
    public $showRequestInfoModal = false;

    public function mount(Kyc $kyc)
    {
        $this->authorize('view', $kyc);
        $this->kyc = $kyc;
        $this->verification_status = $kyc->verification_status;
    }

    public function openVerificationModal()
    {
        $this->authorize('verify', $this->kyc);
        $this->verification_status = $this->kyc->verification_status;
        $this->verification_notes = $this->kyc->verification_notes;
        $this->showVerificationModal = true;
    }

    public function openApprovalModal()
    {
        $this->authorize('approve', $this->kyc);
        $this->approval_note = '';
        $this->showApprovalModal = true;
    }

    public function openRejectionModal()
    {
        $this->authorize('reject', $this->kyc);
        $this->rejection_reason = '';
        $this->showRejectionModal = true;
    }

    public function openKivModal()
    {
        $this->authorize('kiv', $this->kyc);
        $this->kiv_reason = '';
        $this->showKivModal = true;
    }

    public function openRequestInfoModal()
    {
        $this->authorize('kiv', $this->kyc);
        $this->request_details = '';
        $this->showRequestInfoModal = true;
    }

    public function updateVerificationStatus()
    {
        $this->authorize('verify', $this->kyc);

        $this->validate([
            'verification_status' => 'required|in:pending,pass,fail',
            'verification_notes' => 'nullable|string|max:500',
        ]);

        try {
            $this->kyc->verification_status = $this->verification_status;
            $this->kyc->verification_notes = $this->verification_notes;
            $this->kyc->verified_by = auth()->id();
            $this->kyc->verified_at = now();
            $this->kyc->save();

            $this->showVerificationModal = false;
            $this->dispatch('notify', [
                'type' => 'success',
                'message' => 'Verification status updated successfully.'
            ]);

            // Refresh the kyc data
            $this->kyc = Kyc::find($this->kyc->id);
        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Failed to update verification status: ' . $e->getMessage()
            ]);
        }
    }

    public function approveKyc()
    {
        $this->authorize('approve', $this->kyc);

        $this->validate([
            'approval_note' => 'nullable|string|max:500',
        ]);

        try {
            $this->kyc->status = 'approved';
            $this->kyc->approved_by = auth()->id();
            $this->kyc->approved_at = now();
            $this->kyc->save();

            // Update user's KYC status
            $this->kyc->user->update(['kyc_status' => 'approved']);

            $this->showApprovalModal = false;
            $this->dispatch('notify', [
                'type' => 'success',
                'message' => 'KYC application approved successfully.'
            ]);

            // Refresh the kyc data
            $this->kyc = Kyc::find($this->kyc->id);
        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Failed to approve KYC application: ' . $e->getMessage()
            ]);
        }
    }

    public function rejectKyc()
    {
        $this->authorize('reject', $this->kyc);

        $this->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        try {
            $this->kyc->status = 'rejected';
            $this->kyc->rejection_reason = $this->rejection_reason;
            $this->kyc->rejected_by = auth()->id();
            $this->kyc->rejected_at = now();
            $this->kyc->save();

            // Update user's KYC status
            $this->kyc->user->update(['kyc_status' => 'rejected']);

            $this->showRejectionModal = false;
            $this->dispatch('notify', [
                'type' => 'success',
                'message' => 'KYC application rejected successfully.'
            ]);

            // Refresh the kyc data
            $this->kyc = Kyc::find($this->kyc->id);
        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Failed to reject KYC application: ' . $e->getMessage()
            ]);
        }
    }

    public function kivKyc()
    {
        $this->authorize('kiv', $this->kyc);

        $this->validate([
            'kiv_reason' => 'required|string|max:500',
        ]);

        try {
            $this->kyc->status = 'kiv';
            $this->kyc->verification_notes = $this->kiv_reason;
            $this->kyc->save();

            // Update user's KYC status
            $this->kyc->user->update(['kyc_status' => 'pending']);

            $this->showKivModal = false;
            $this->dispatch('notify', [
                'type' => 'success',
                'message' => 'KYC application marked as KIV successfully.'
            ]);

            // Refresh the kyc data
            $this->kyc = Kyc::find($this->kyc->id);
        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Failed to mark KYC application as KIV: ' . $e->getMessage()
            ]);
        }
    }

    public function requestAdditionalInfo()
    {
        $this->authorize('kiv', $this->kyc);

        $this->validate([
            'request_details' => 'required|string|max:500',
        ]);

        try {
            $this->kyc->additional_info_requested = $this->request_details;
            $this->kyc->additional_info_requested_at = now();
            $this->kyc->additional_info_requested_by = auth()->id();
            $this->kyc->status = 'kiv';
            $this->kyc->save();

            // Update user's KYC status
            $this->kyc->user->update(['kyc_status' => 'pending']);

            $this->showRequestInfoModal = false;
            $this->dispatch('notify', [
                'type' => 'success',
                'message' => 'Additional information requested successfully.'
            ]);

            // Refresh the kyc data
            $this->kyc = Kyc::find($this->kyc->id);
        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Failed to request additional information: ' . $e->getMessage()
            ]);
        }
    }

    public function render()
    {
        return view('livewire.admin.kyc.kyc-show');
    }
}

