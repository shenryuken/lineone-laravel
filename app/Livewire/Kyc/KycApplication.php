<?php

namespace App\Livewire\Kyc;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Kyc;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class KycApplication extends Component
{
    use WithFileUploads;

    public $full_name;
    public $date_of_birth;
    public $address;
    public $id_type = 'national_id';
    public $id_number;
     public $has_expiration = true;
    public $id_expiration_date;
    public $id_front_image;
    public $id_back_image;
    public $selfie_image;
    public $currentStep = 1;
    public $totalSteps = 3;

    // protected $rules = [
    //     'full_name' => 'required|string|max:255',
    //     'date_of_birth' => 'required|date|before:today',
    //     'address' => 'required|string|max:500',
    //     'id_type' => 'required|in:passport,national_id,drivers_license',
    //     'id_number' => 'required|string|max:50',
    //     //'id_expiration_date' => 'required|date|after:today',
    //     'id_front_image' => 'required|image|max:2048',
    //     'id_back_image' => 'required|image|max:2048',
    //     'selfie_image' => 'required|image|max:2048',
    //     'has_expiration' => 'boolean',
    // ];
    // Updated validation rules

    protected function rules()
    {
        $rules = [
            'full_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date|before:today',
            'address' => 'required|string|max:500',
            'id_type' => 'required|in:passport,national_id,drivers_license',
            'id_number' => 'required|string|max:50',
            'has_expiration' => 'boolean',
            'id_front_image' => 'required|image|max:2048',
            'id_back_image' => 'required|image|max:2048',
            'selfie_image' => 'required|image|max:2048',
        ];

        // Conditional validation for expiration date
        if ($this->has_expiration) {
            $rules['id_expiration_date'] = 'required|date|after:today';
        }

        return $rules;
    }

    public function mount()
    {
        $user = Auth::user();
        $this->full_name = $user->name;

        // Check if user already has a KYC application
        $existingKyc = Kyc::where('user_id', $user->id)->first();
        if ($existingKyc) {
            return redirect()->route('kyc.status');
        }
    }

    public function nextStep()
    {
        if ($this->currentStep == 1) {
            $this->validate([
                'full_name' => 'required|string|max:255',
                'date_of_birth' => 'required|date|before:today',
                'address' => 'required|string|max:500',
            ]);
        } elseif ($this->currentStep == 2) {
            $validationRules = [
                'id_type' => 'required|in:passport,national_id,drivers_license',
                'id_number' => 'required|string|max:50',
                'has_expiration' => 'boolean',
            ];

            if ($this->has_expiration) {
                $validationRules['id_expiration_date'] = 'required|date|after:today';
            }

            $this->validate($validationRules);
        }

        $this->currentStep++;
    }

    public function previousStep()
    {
        $this->currentStep--;
    }

    // New method to handle expiration toggle
    public function updatedHasExpiration()
    {
        // Clear expiration date if has_expiration is false
        if (!$this->has_expiration) {
            $this->id_expiration_date = null;
        }
    }

    public function submit()
    {
        $this->validate([
            'id_front_image' => 'required|image|max:2048',
            'id_back_image' => 'required|image|max:2048',
            'selfie_image' => 'required|image|max:2048',
        ]);

        try {
            $user = Auth::user();
            $folderPath = 'kyc_documents/' . $user->id;

            $kycApplication = new Kyc();
            $kycApplication->user_id = $user->id;
            $kycApplication->full_name = $this->full_name;
            $kycApplication->date_of_birth = $this->date_of_birth;
            $kycApplication->address = $this->address;
            $kycApplication->id_type = $this->id_type;
            $kycApplication->id_number = $this->id_number;
            $kycApplication->has_expiration = $this->has_expiration;

            // New field handling
            if ($this->has_expiration) {
                $kycApplication->id_expiration_date = $this->id_expiration_date;
            }

            $kycApplication->id_front_image = $this->id_front_image
                ->storeAs($folderPath, 'front_id_image.' . $this->id_front_image->getClientOriginalExtension(), 'public');

            $kycApplication->id_back_image = $this->id_back_image
                ->storeAs($folderPath, 'back_id_image.' . $this->id_back_image->getClientOriginalExtension(), 'public');

            $kycApplication->selfie_image = $this->selfie_image
                ->storeAs($folderPath, 'selfie_with_id.' . $this->selfie_image->getClientOriginalExtension(), 'public');

            $kycApplication->status = 'pending';
            $kycApplication->save();

            $user->update(['kyc_status' => 'pending']);

            session()->flash('toast', [
                'type' => 'success',
                'message' => 'Your KYC application has been submitted successfully.'
            ]);

            return redirect()->route('dashboard');
        } catch (\Exception $e) {
            Log::error('KYC submission error: ' . $e->getMessage());
            session()->flash('toast', [
                'type' => 'error',
                'message' => 'There was an error submitting your KYC application. Please try again.'
            ]);
        }
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function deleteImage($imageType)
    {
        if (in_array($imageType, ['id_front_image', 'id_back_image', 'selfie_image'])) {
            $this->$imageType = null;
        }
    }

    public function render()
    {
        return view('livewire.kyc.kyc-application');
    }
}

