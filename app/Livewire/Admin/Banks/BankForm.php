<?php

namespace App\Livewire\Admin\Banks;

use App\Models\Bank;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class BankForm extends Component
{
    use WithFileUploads;

    public $bank;
    public $bankId;
    public $name;
    public $code;
    public $swift_code;
    public $type = 'local';
    public $country_code;
    public $country_name;
    public $supported_currencies = [];
    public $description;
    public $logo;
    public $existing_logo;
    public $is_active = true;
    public $metadata = [];

    // For UI
    public $isEditing = false;
    public $currency = '';
    public $metadataKey = '';
    public $metadataValue = '';

    public $countries = [];

    protected $listeners = ['editBank'];

    protected function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50',
            'swift_code' => 'nullable|string|max:50',
            'type' => 'required|in:local,international',
            'country_code' => 'required|string|size:3',
            'country_name' => 'required|string|max:255',
            'supported_currencies' => 'required|array|min:1',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|max:1024', // 1MB max
            'is_active' => 'boolean',
            'metadata' => 'nullable|array',
        ];

        // Add unique validation for bank code within a country
        if ($this->isEditing) {
            $rules['code'] .= '|unique:banks,code,' . $this->bankId . ',id,country_code,' . $this->country_code;
        } else {
            $rules['code'] .= '|unique:banks,code,NULL,id,country_code,' . $this->country_code;
        }

        return $rules;
    }

    protected $validationAttributes = [
        'country_code' => 'country code',
        'country_name' => 'country name',
        'supported_currencies' => 'supported currencies',
        'is_active' => 'active status',
    ];

    public function mount($id = null)
    {
        $this->isEditing = $id !== null;

        // Load countries from database
        $this->countries = \App\Models\Country::where('is_active', true)
            ->orderBy('name')
            ->get()
            ->map(function($country) {
                return [
                    'id' => $country->id,
                    'code' => $country->code,
                    'name' => $country->name,
                ];
            });

        if ($this->isEditing) {
            $this->bankId = $id;
            $this->loadBank();
        }
    }

    public function editBank($id)
    {
        $this->bankId = $id;
        $this->isEditing = true;
        $this->loadBank();
    }

    protected function loadBank()
    {
        try {
            $this->bank = Bank::findOrFail($this->bankId);
            $this->name = $this->bank->name;
            $this->code = $this->bank->code;
            $this->swift_code = $this->bank->swift_code;
            $this->type = $this->bank->type;
            $this->country_code = $this->bank->country_code;
            $this->country_name = $this->bank->country_name;
            $this->supported_currencies = $this->bank->supported_currencies;
            $this->description = $this->bank->description;
            $this->existing_logo = $this->bank->logo_path;
            $this->is_active = $this->bank->is_active;
            $this->metadata = $this->bank->metadata ?? [];
        } catch (\Exception $e) {
            Log::error('Error loading bank for editing', [
                'bank_id' => $this->bankId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            session()->flash('toast', [
                'type' => 'error',
                'message' => 'Failed to load bank: ' . $e->getMessage()
            ]);

            return redirect()->route('admin.banks.index');
        }
    }

    public function updatedCountryCode()
    {
        // Find the selected country
        $country = \App\Models\Country::where('code', $this->country_code)->first();

        if ($country) {
            $this->country_name = $country->name;
        }
    }

    public function addCurrency()
    {
        if (!empty($this->currency) && !in_array($this->currency, $this->supported_currencies)) {
            $this->supported_currencies[] = strtoupper($this->currency);
            $this->currency = '';
        }
    }

    public function removeCurrency($index)
    {
        if (isset($this->supported_currencies[$index])) {
            unset($this->supported_currencies[$index]);
            $this->supported_currencies = array_values($this->supported_currencies);
        }
    }

    public function addMetadata()
    {
        if (!empty($this->metadataKey)) {
            $this->metadata[$this->metadataKey] = $this->metadataValue;
            $this->metadataKey = '';
            $this->metadataValue = '';
        }
    }

    public function removeMetadata($key)
    {
        if (isset($this->metadata[$key])) {
            unset($this->metadata[$key]);
        }
    }

    public function save()
    {
        $this->validate();

        try {
            $data = [
                'name' => $this->name,
                'code' => $this->code,
                'swift_code' => $this->swift_code,
                'type' => $this->type,
                'country_code' => strtoupper($this->country_code),
                'country_name' => $this->country_name,
                'supported_currencies' => $this->supported_currencies,
                'description' => $this->description,
                'is_active' => $this->is_active,
                'metadata' => $this->metadata,
            ];

            // Handle logo upload
            if ($this->logo) {
                $logoPath = $this->logo->store('banks', 'public');
                $data['logo_path'] = $logoPath;

                // Delete old logo if exists
                if ($this->isEditing && $this->existing_logo) {
                    Storage::disk('public')->delete($this->existing_logo);
                }
            }

            if ($this->isEditing) {
                $this->bank->update($data);
                $message = 'Bank updated successfully!';
            } else {
                Bank::create($data);
                $message = 'Bank added successfully!';
            }

            session()->flash('toast', [
                'type' => 'success',
                'message' => $message
            ]);

            return redirect()->route('admin.banks.index');
        } catch (\Exception $e) {
            Log::error('Error saving bank', [
                'bank_id' => $this->isEditing ? $this->bankId : null,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            session()->flash('toast', [
                'type' => 'error',
                'message' => 'Failed to save bank: ' . $e->getMessage()
            ]);
        }
    }

    public function render()
    {
        // Common currency codes for dropdown
        $commonCurrencies = [
            'USD' => 'USD - US Dollar',
            'EUR' => 'EUR - Euro',
            'GBP' => 'GBP - British Pound',
            'JPY' => 'JPY - Japanese Yen',
            'AUD' => 'AUD - Australian Dollar',
            'CAD' => 'CAD - Canadian Dollar',
            'CHF' => 'CHF - Swiss Franc',
            'CNY' => 'CNY - Chinese Yuan',
            'HKD' => 'HKD - Hong Kong Dollar',
            'SGD' => 'SGD - Singapore Dollar',
            'MYR' => 'MYR - Malaysian Ringgit',
        ];

        return view('livewire.admin.banks.bank-form', [
            'commonCurrencies' => $commonCurrencies,
        ]);
    }
}

