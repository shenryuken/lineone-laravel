<?php

namespace App\Livewire\Admin\Kyb;

use App\Models\Kyb;
use App\Models\KybStatusHistory;
use App\Notifications\KybStatusUpdated;
use App\Notifications\KybAdditionalInfoRequested;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class KybShow extends Component
{
    public Kyb $kyb;
    public $additionalInfoRequest = '';
    public $rejectionReason = '';
    public $adminNote = '';
    public $showDocumentModal = false;
    public $currentDocument = null;

    protected $rules = [
        'additionalInfoRequest' => 'required_if:action,request_info|min:10',
        'rejectionReason' => 'required_if:action,reject|min:10',
        'adminNote' => 'nullable|max:1000',
    ];

    protected $messages = [
        'additionalInfoRequest.required_if' => 'Please provide details about the additional information required.',
        'rejectionReason.required_if' => 'Please provide a reason for rejection.',
    ];

    public function mount(Kyb $kyb)
    {
        $this->kyb = $kyb;
    }

    public function approve()
    {
        $this->kyb->status = 'approved';
        $this->kyb->approved_at = now();
        $this->kyb->approved_by = auth()->id();
        $this->kyb->save();

        // Create status history record
        KybStatusHistory::create([
            'kyb_id' => $this->kyb->id,
            'status' => 'approved',
            'comment' => $this->adminNote,
            'user_id' => auth()->id(),
        ]);

        // Notify the user
        $this->kyb->user->notify(new KybStatusUpdated($this->kyb));

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'KYB application has been approved successfully!'
        ]);
    }

    public function reject()
    {
        $this->validate([
            'rejectionReason' => 'required|min:10',
        ]);

        $this->kyb->status = 'rejected';
        $this->kyb->rejected_at = now();
        $this->kyb->rejected_by = auth()->id();
        $this->kyb->rejection_reason = $this->rejectionReason;
        $this->kyb->save();

        // Create status history record
        KybStatusHistory::create([
            'kyb_id' => $this->kyb->id,
            'status' => 'rejected',
            'comment' => $this->rejectionReason,
            'user_id' => auth()->id(),
        ]);

        // Notify the user
        $this->kyb->user->notify(new KybStatusUpdated($this->kyb));

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'KYB application has been rejected.'
        ]);

        $this->reset('rejectionReason');
    }

    public function requestAdditionalInfo()
    {
        $this->validate([
            'additionalInfoRequest' => 'required|min:10',
        ]);

        $this->kyb->status = 'additional_info';
        $this->kyb->additional_info_requested_at = now();
        $this->kyb->additional_info_requested_by = auth()->id();
        $this->kyb->additional_info_request = $this->additionalInfoRequest;
        $this->kyb->save();

        // Create status history record
        KybStatusHistory::create([
            'kyb_id' => $this->kyb->id,
            'status' => 'additional_info',
            'comment' => $this->additionalInfoRequest,
            'user_id' => auth()->id(),
        ]);

        // Notify the user
        $this->kyb->user->notify(new KybAdditionalInfoRequested($this->kyb));

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Additional information has been requested.'
        ]);

        $this->reset('additionalInfoRequest');
    }

    public function addNote()
    {
        $this->validate([
            'adminNote' => 'required|max:1000',
        ]);

        // Create status history record with note
        KybStatusHistory::create([
            'kyb_id' => $this->kyb->id,
            'status' => $this->kyb->status,
            'comment' => $this->adminNote,
            'user_id' => auth()->id(),
            'is_note' => true,
        ]);

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Note has been added successfully.'
        ]);

        $this->reset('adminNote');
    }

    // Add a method to set KIV status
    public function setKiv()
    {
        $this->kyb->status = 'kiv';
        $this->kyb->save();

        // Create status history record
        KybStatusHistory::create([
            'kyb_id' => $this->kyb->id,
            'status' => 'kiv',
            'comment' => $this->adminNote,
            'user_id' => auth()->id(),
        ]);

        // Notify the user
        $this->kyb->user->notify(new KybStatusUpdated($this->kyb));

        $this->dispatchBrowserEvent('notify', [
            'type' => 'success',
            'message' => 'KYB application has been set to KIV (Keep In View).'
        ]);

        $this->reset('adminNote');
    }

    public function viewDocument($documentPath, $documentName)
    {
        $this->currentDocument = [
            'path' => $documentPath,
            'name' => $documentName,
            'url' => Storage::url($documentPath),
        ];

        $this->showDocumentModal = true;
    }

    public function closeDocumentModal()
    {
        $this->showDocumentModal = false;
        $this->currentDocument = null;
    }

    public function render()
    {
        $statusHistory = KybStatusHistory::where('kyb_id', $this->kyb->id)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.admin.kyb.kyb-show', [
            'statusHistory' => $statusHistory,
        ]);
    }
}

