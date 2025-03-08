<?php

namespace App\Livewire\Kyc;

use Livewire\Component;
use App\Models\Kyc;

class KycTimeline extends Component
{
    public $kyc;

    public function mount(Kyc $kyc)
    {
        $this->kyc = $kyc;
    }

    public function getTimelineEventsProperty()
    {
        $events = [];

        // Submission event
        $events[] = [
            'status' => 'Submitted',
            'date' => $this->kyc->created_at,
            'description' => 'Your KYC application has been submitted.',
            'completed' => true,
            'icon' => 'upload',
            'color' => 'primary'
        ];

        // Verification event
        if ($this->kyc->verified_at) {
            $events[] = [
                'status' => $this->kyc->verification_status === 'pass' ? 'Verification Passed' : 'Verification Failed',
                'date' => $this->kyc->verified_at,
                'description' => $this->kyc->verification_notes ?: ($this->kyc->verification_status === 'pass' ? 'Your documents have been verified.' : 'Verification could not be completed.'),
                'completed' => true,
                'icon' => $this->kyc->verification_status === 'pass' ? 'check-circle' : 'alert-circle',
                'color' => $this->kyc->verification_status === 'pass' ? 'success' : 'warning'
            ];
        } else {
            $events[] = [
                'status' => 'Verification',
                'date' => null,
                'description' => 'Your documents are being verified.',
                'completed' => false,
                'icon' => 'search',
                'color' => 'slate'
            ];
        }

        // Final approval or rejection event
        if ($this->kyc->status === 'approved') {
            $events[] = [
                'status' => 'Approved',
                'date' => $this->kyc->approved_at,
                'description' => 'Your KYC application has been approved.',
                'completed' => true,
                'icon' => 'shield-check',
                'color' => 'success'
            ];
        } elseif ($this->kyc->status === 'rejected') {
            $events[] = [
                'status' => 'Rejected',
                'date' => $this->kyc->rejected_at,
                'description' => 'Your KYC application has been rejected: ' . $this->kyc->rejection_reason,
                'completed' => true,
                'icon' => 'x-circle',
                'color' => 'error'
            ];
        } elseif ($this->kyc->status === 'kiv') {
            $events[] = [
                'status' => 'Keep In View',
                'date' => $this->kyc->updated_at,
                'description' => 'Your application requires additional review.',
                'completed' => true,
                'icon' => 'clock',
                'color' => 'warning'
            ];
        } else {
            $events[] = [
                'status' => 'Final Review',
                'date' => null,
                'description' => 'Your application is waiting for final approval.',
                'completed' => false,
                'icon' => 'clipboard-check',
                'color' => 'slate'
            ];
        }

        return $events;
    }

    public function render()
    {
        return view('livewire.kyc.kyc-timeline', [
            'events' => $this->getTimelineEventsProperty()
        ]);
    }
}

