<?php

namespace App\Livewire\Kyc;

use App\Models\Kyc;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Log;

class KycUpdateForm extends Component
{
    use WithFileUploads;

    public Kyc $kyc;

    public $full_name;
    public $date_of_birth;
    public $address;
    public $id_type;
    public $id_number;
    public $id_expiration_date;
    public $new_id_front_image;
    public $new_id_back_image;
    public $new_selfie_image;
    public $additional_document;
    public $additional_document_type = 'utility_bill'; // Default
    public $additionalInfo;
    public $has_expiration;

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function mount(Kyc $kyc)
    {
        $this->kyc = $kyc;
        $this->full_name = $kyc->full_name;
        $this->date_of_birth = $kyc->date_of_birth->format('Y-m-d');
        $this->address = $kyc->address;
        $this->id_type = $kyc->id_type;
        $this->id_number = $kyc->id_number;
        $this->has_expiration = $kyc->has_expiration;
        $this->id_expiration_date = $kyc->id_expiration_date ? $kyc->id_expiration_date->format('Y-m-d') : null;
    }

    protected function rules()
    {
        $rules = [
            'full_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date|before:today',
            'address' => 'required|string|max:500',
            'id_type' => 'required|in:passport,national_id,drivers_license',
            'id_number' => 'required|string|max:50',
            'has_expiration' => 'boolean',
            'new_id_front_image' => 'nullable|image|max:2048',
            'new_id_back_image' => 'nullable|image|max:2048',
            'new_selfie_image' => 'nullable|image|max:2048',
            'additional_document' => 'nullable|file|max:5120',
            'additional_document_type' => 'required_with:additional_document|in:utility_bill,bank_statement,residence_proof,other',
            'additionalInfo' => 'nullable|string|max:1000',
        ];

        if ($this->has_expiration) {
            $rules['id_expiration_date'] = 'required|date|after:today';
        }

        return $rules;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function deleteImage($imageType)
    {
        if (in_array($imageType, ['new_id_front_image', 'new_id_back_image', 'new_selfie_image', 'additional_document'])) {
            $this->$imageType = null;
        }
    }

    public function submit()
    {
        // Validate based on whether ID has expiration or not
        if ($this->has_expiration) {
            $this->validate([
                'id_expiration_date' => 'required|date|after:today',
            ]);
        }

        $this->validate();

        try {
            $user = auth()->user();
            $folderPath = 'kyc_documents/' . $user->id;

            // Update the KYC information
            $this->kyc->full_name = $this->full_name;
            $this->kyc->date_of_birth = $this->date_of_birth;
            $this->kyc->address = $this->address;
            $this->kyc->id_type = $this->id_type;
            $this->kyc->id_number = $this->id_number;
            $this->kyc->has_expiration = $this->has_expiration;

            // Only set expiration date if ID has one
            if ($this->has_expiration) {
                $this->kyc->id_expiration_date = $this->id_expiration_date;
            } else {
                $this->kyc->id_expiration_date = null;
            }

            if ($this->new_id_front_image) {
                if ($this->kyc->id_front_image && Storage::disk('public')->exists($this->kyc->id_front_image)) {
                    Storage::disk('public')->delete($this->kyc->id_front_image);
                }

                $this->kyc->id_front_image = $this->new_id_front_image
                    ->storeAs($folderPath, 'front_id_image_' . time() . '.' . $this->new_id_front_image->getClientOriginalExtension(), 'public');
            }

            if ($this->new_id_back_image) {
                if ($this->kyc->id_back_image && Storage::disk('public')->exists($this->kyc->id_back_image)) {
                    Storage::disk('public')->delete($this->kyc->id_back_image);
                }

                $this->kyc->id_back_image = $this->new_id_back_image
                    ->storeAs($folderPath, 'back_id_image_' . time() . '.' . $this->new_id_back_image->getClientOriginalExtension(), 'public');
            }

            if ($this->new_selfie_image) {
                if ($this->kyc->selfie_image && Storage::disk('public')->exists($this->kyc->selfie_image)) {
                    Storage::disk('public')->delete($this->kyc->selfie_image);
                }

                $this->kyc->selfie_image = $this->new_selfie_image
                    ->storeAs($folderPath, 'selfie_with_id_' . time() . '.' . $this->new_selfie_image->getClientOriginalExtension(), 'public');
            }

            // Store additional document if provided
            if ($this->additional_document) {
                if ($this->kyc->additional_document) {
                    Storage::delete($this->kyc->additional_document);
                }
                $this->kyc->additional_document = $this->additional_document->store($folderPath);
                $this->kyc->additional_document_type = $this->additional_document_type;
            }

            // Store additional information if provided
            if ($this->additionalInfo) {
                $this->kyc->additional_info_response = $this->additionalInfo;
                $this->kyc->additional_info_responded_at = now();
            }

            // Reset the status to pending
            if ($this->kyc->status === 'kiv') {
                $this->kyc->status = 'pending';
                $this->kyc->verification_status = 'pending';
            }

            $this->kyc->save();

            // Update user's KYC status if needed
            if (auth()->user()->kyc_status !== 'pending') {
                auth()->user()->update(['kyc_status' => 'pending']);
            }

            session()->flash('toast', [
                'type' => 'success',
                'message' => 'Your KYC information has been updated successfully.'
            ]);

            return redirect()->route('kyc.dashboard');

        } catch (\Exception $e) {
            Log::error('KYC update error: ' . $e->getMessage());
            session()->flash('toast', [
                'type' => 'error',
                'message' => 'There was an error updating your KYC information. Please try again.'
            ]);
        }
    }

    public function render()
    {
        return view('livewire.kyc.kyc-update-form');
    }
}

