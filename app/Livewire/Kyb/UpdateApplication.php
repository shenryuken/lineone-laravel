<?php

namespace App\Livewire\Kyb;

use App\Models\Kyb;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;

class UpdateApplication extends Component
{
    use WithFileUploads;

    public Kyb $kyb;

    // Step navigation
    public $currentStep = 1;
    public $totalSteps = 6;

    // Step 1: Business Registration Details
    public $legal_name;
    public $registration_number;
    public $business_type;
    public $date_established;
    public $business_address;
    public $business_phone;
    public $business_email;
    public $website;
    public $tax_id;

    // Step 2: Ownership and Control Information
    public $directors = [];
    public $shareholders = [];
    public $beneficial_owners = [];

    // Director template for adding new directors
    public $newDirector = [
        'name' => '',
        'position' => '',
        'date_of_birth' => '',
        'nationality' => '',
        'id_number' => ''
    ];

    // Shareholder template for adding new shareholders
    public $newShareholder = [
        'name' => '',
        'ownership_percentage' => '',
        'entity_type' => 'individual',
        'id_number' => ''
    ];

    // Beneficial owner template for adding new beneficial owners
    public $newBeneficialOwner = [
        'name' => '',
        'relationship' => '',
        'date_of_birth' => '',
        'nationality' => '',
        'id_number' => ''
    ];

    // Step 3: Business Operations
    public $industry;
    public $business_description;
    public $products_services;
    public $estimated_monthly_volume;
    public $average_transaction_value;
    public $geographical_markets = [];
    public $customer_base;
    public $online_presence;
    public $physical_presence;

    // Step 4: Financial Information
    public $bank_name;
    public $bank_account_number;
    public $bank_routing_number;
    public $annual_revenue;
    public $financial_statement_date;
    public $previous_year_revenue;
    public $current_assets;
    public $total_liabilities;

    // Step 5: Compliance Information
    public $has_aml_policy;
    public $has_sanctions_screening;
    public $regulatory_licenses = [];
    public $has_compliance_officer;
    public $compliance_officer_name;
    public $compliance_officer_email;
    public $has_previous_violations;
    public $previous_violations_details;
    public $is_regulated_entity;
    public $regulator_name;

    // Step 6: Document Upload
    public $new_business_registration_doc;
    public $new_proof_of_address_doc;
    public $new_financial_statements_doc;
    public $new_ownership_structure_doc;
    public $new_compliance_policy_doc;

    // Additional information response
    public $additional_info_response;

    public function mount(Kyb $kyb)
    {
        $this->kyb = $kyb;

        // Step 1: Business Registration Details
        $this->legal_name = $kyb->legal_name;
        $this->registration_number = $kyb->registration_number;
        $this->business_type = $kyb->business_type;
        $this->date_established = $kyb->date_established ? $kyb->date_established->format('Y-m-d') : null;
        $this->business_address = $kyb->business_address;
        $this->business_phone = $kyb->business_phone;
        $this->business_email = $kyb->business_email;
        $this->website = $kyb->website;
        $this->tax_id = $kyb->tax_id;

        // Step 2: Ownership and Control Information
        $this->directors = json_decode($kyb->directors, true) ?? [];
        $this->shareholders = json_decode($kyb->shareholders, true) ?? [];
        $this->beneficial_owners = json_decode($kyb->beneficial_owners, true) ?? [];

        // Step 3: Business Operations
        $this->industry = $kyb->industry;
        $this->business_description = $kyb->business_description;
        $this->products_services = $kyb->products_services;
        $this->estimated_monthly_volume = $kyb->estimated_monthly_volume;
        $this->average_transaction_value = $kyb->average_transaction_value;
        $this->geographical_markets = json_decode($kyb->geographical_markets, true) ?? [];
        $this->customer_base = $kyb->customer_base;
        $this->online_presence = $kyb->online_presence;
        $this->physical_presence = $kyb->physical_presence;

        // Step 4: Financial Information
        $this->bank_name = $kyb->bank_name;
        $this->bank_account_number = $kyb->bank_account_number;
        $this->bank_routing_number = $kyb->bank_routing_number;
        $this->annual_revenue = $kyb->annual_revenue;
        $this->financial_statement_date = $kyb->financial_statement_date ? $kyb->financial_statement_date->format('Y-m-d') : null;
        $this->previous_year_revenue = $kyb->previous_year_revenue;
        $this->current_assets = $kyb->current_assets;
        $this->total_liabilities = $kyb->total_liabilities;

        // Step 5: Compliance Information
        $this->has_aml_policy = $kyb->has_aml_policy;
        $this->has_sanctions_screening = $kyb->has_sanctions_screening;
        $this->regulatory_licenses = json_decode($kyb->regulatory_licenses, true) ?? [];
        $this->has_compliance_officer = $kyb->has_compliance_officer;
        $this->compliance_officer_name = $kyb->compliance_officer_name;
        $this->compliance_officer_email = $kyb->compliance_officer_email;
        $this->has_previous_violations = $kyb->has_previous_violations;
        $this->previous_violations_details = $kyb->previous_violations_details;
        $this->is_regulated_entity = $kyb->is_regulated_entity;
        $this->regulator_name = $kyb->regulator_name;

        // Additional information response
        $this->additional_info_response = $kyb->additional_info_response;
    }

    public function addDirector()
    {
        $this->directors[] = $this->newDirector;
    }

    public function removeDirector($index)
    {
        if (count($this->directors) > 1) {
            unset($this->directors[$index]);
            $this->directors = array_values($this->directors);
        }
    }

    public function addShareholder()
    {
        $this->shareholders[] = $this->newShareholder;
    }

    public function removeShareholder($index)
    {
        if (count($this->shareholders) > 1) {
            unset($this->shareholders[$index]);
            $this->shareholders = array_values($this->shareholders);
        }
    }

    public function addBeneficialOwner()
    {
        $this->beneficial_owners[] = $this->newBeneficialOwner;
    }

    public function removeBeneficialOwner($index)
    {
        if (count($this->beneficial_owners) > 1) {
            unset($this->beneficial_owners[$index]);
            $this->beneficial_owners = array_values($this->beneficial_owners);
        }
    }

    public function nextStep()
    {
        $this->validate($this->getValidationRules());
        $this->currentStep++;
    }

    public function previousStep()
    {
        $this->currentStep--;
    }

    public function getValidationRules()
    {
        $rules = [];

        switch ($this->currentStep) {
            case 1:
                $rules = [
                    'legal_name' => 'required|string|max:255',
                    'registration_number' => 'required|string|max:50',
                    'business_type' => 'required|string',
                    'date_established' => 'required|date|before:today',
                    'business_address' => 'required|string|max:500',
                    'business_phone' => 'required|string|max:20',
                    'business_email' => 'required|email|max:255',
                    'website' => 'nullable|url|max:255',
                    'tax_id' => 'required|string|max:50',
                ];
                break;
            case 2:
                $rules = [
                    'directors.*.name' => 'required|string|max:255',
                    'directors.*.position' => 'required|string|max:255',
                    'directors.*.date_of_birth' => 'required|date|before:-18 years',
                    'directors.*.nationality' => 'required|string|max:100',
                    'directors.*.id_number' => 'required|string|max:50',

                    'shareholders.*.name' => 'required|string|max:255',
                    'shareholders.*.ownership_percentage' => 'required|numeric|min:0|max:100',
                    'shareholders.*.entity_type' => 'required|in:individual,company',
                    'shareholders.*.id_number' => 'required|string|max:50',

                    'beneficial_owners.*.name' => 'required|string|max:255',
                    'beneficial_owners.*.relationship' => 'required|string|max:255',
                    'beneficial_owners.*.date_of_birth' => 'required|date|before:-18 years',
                    'beneficial_owners.*.nationality' => 'required|string|max:100',
                    'beneficial_owners.*.id_number' => 'required|string|max:50',
                ];
                break;
            case 3:
                $rules = [
                    'industry' => 'required|string|max:255',
                    'business_description' => 'required|string|max:1000',
                    'products_services' => 'required|string|max:1000',
                    'estimated_monthly_volume' => 'required|numeric|min:0',
                    'average_transaction_value' => 'required|numeric|min:0',
                    'geographical_markets' => 'required|array|min:1',
                    'customer_base' => 'required|string|max:500',
                ];
                break;
            case 4:
                $rules = [
                    'bank_name' => 'required|string|max:255',
                    'bank_account_number' => 'required|string|max:50',
                    'bank_routing_number' => 'required|string|max:50',
                    'annual_revenue' => 'required|numeric|min:0',
                    'financial_statement_date' => 'required|date|before:tomorrow',
                    'previous_year_revenue' => 'required|numeric|min:0',
                    'current_assets' => 'required|numeric|min:0',
                    'total_liabilities' => 'required|numeric|min:0',
                ];
                break;
            case 5:
                $rules = [
                    'has_aml_policy' => 'required|boolean',
                    'has_sanctions_screening' => 'required|boolean',
                    'has_compliance_officer' => 'required|boolean',
                ];

                if ($this->has_compliance_officer) {
                    $rules['compliance_officer_name'] = 'required|string|max:255';
                    $rules['compliance_officer_email'] = 'required|email|max:255';
                }

                if ($this->has_previous_violations) {
                    $rules['previous_violations_details'] = 'required|string|max:1000';
                }

                if ($this->is_regulated_entity) {
                    $rules['regulator_name'] = 'required|string|max:255';
                }
                break;
            case 6:
                $rules = [
                    'new_business_registration_doc' => 'nullable|file|max:10240|mimes:pdf,jpg,jpeg,png',
                    'new_proof_of_address_doc' => 'nullable|file|max:10240|mimes:pdf,jpg,jpeg,png',
                    'new_financial_statements_doc' => 'nullable|file|max:10240|mimes:pdf,jpg,jpeg,png',
                    'new_ownership_structure_doc' => 'nullable|file|max:10240|mimes:pdf,jpg,jpeg,png',
                ];

                if ($this->has_aml_policy) {
                    $rules['new_compliance_policy_doc'] = 'nullable|file|max:10240|mimes:pdf,jpg,jpeg,png';
                }

                if ($this->kyb->additional_info_requested) {
                    $rules['additional_info_response'] = 'required|string|max:1000';
                }
                break;
        }

        return $rules;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, $this->getValidationRules());
    }

    public function deleteDocument($documentType)
    {
        if (property_exists($this, $documentType)) {
            $this->$documentType = null;
        }
    }

    public function submit()
    {
        $this->validate($this->getValidationRules());

        try {
            $user = auth()->user();
            $folderPath = 'kyb_documents/' . $user->id;

            // Step 1: Business Registration Details
            $this->kyb->legal_name = $this->legal_name;
            $this->kyb->registration_number = $this->registration_number;
            $this->kyb->business_type = $this->business_type;
            $this->kyb->date_established = $this->date_established;
            $this->kyb->business_address = $this->business_address;
            $this->kyb->business_phone = $this->business_phone;
            $this->kyb->business_email = $this->business_email;
            $this->kyb->website = $this->website;
            $this->kyb->tax_id = $this->tax_id;

            // Step 2: Ownership and Control Information
            $this->kyb->directors = json_encode($this->directors);
            $this->kyb->shareholders = json_encode($this->shareholders);
            $this->kyb->beneficial_owners = json_encode($this->beneficial_owners);

            // Step 3: Business Operations
            $this->kyb->industry = $this->industry;
            $this->kyb->business_description = $this->business_description;
            $this->kyb->products_services = $this->products_services;
            $this->kyb->estimated_monthly_volume = $this->estimated_monthly_volume;
            $this->kyb->average_transaction_value = $this->average_transaction_value;
            $this->kyb->geographical_markets = json_encode($this->geographical_markets);
            $this->kyb->customer_base = $this->customer_base;
            $this->kyb->online_presence = $this->online_presence;
            $this->kyb->physical_presence = $this->physical_presence;

            // Step 4: Financial Information
            $this->kyb->bank_name = $this->bank_name;
            $this->kyb->bank_account_number = $this->bank_account_number;
            $this->kyb->bank_routing_number = $this->bank_routing_number;
            $this->kyb->annual_revenue = $this->annual_revenue;
            $this->kyb->financial_statement_date = $this->financial_statement_date;
            $this->kyb->previous_year_revenue = $this->previous_year_revenue;
            $this->kyb->current_assets = $this->current_assets;
            $this->kyb->total_liabilities = $this->total_liabilities;

            // Step 5: Compliance Information
            $this->kyb->has_aml_policy = $this->has_aml_policy;
            $this->kyb->has_sanctions_screening = $this->has_sanctions_screening;
            $this->kyb->regulatory_licenses = json_encode($this->regulatory_licenses);
            $this->kyb->has_compliance_officer = $this->has_compliance_officer;
            $this->kyb->compliance_officer_name = $this->compliance_officer_name;
            $this->kyb->compliance_officer_email = $this->compliance_officer_email;
            $this->kyb->has_previous_violations = $this->has_previous_violations;
            $this->kyb->previous_violations_details = $this->previous_violations_details;
            $this->kyb->is_regulated_entity = $this->is_regulated_entity;
            $this->kyb->regulator_name = $this->regulator_name;

            // Step 6: Document Upload - only if new documents are provided
            if ($this->new_business_registration_doc) {
                // Delete old document if it exists
                if ($this->kyb->business_registration_doc && Storage::disk('public')->exists($this->kyb->business_registration_doc)) {
                    Storage::disk('public')->delete($this->kyb->business_registration_doc);
                }

                $this->kyb->business_registration_doc = $this->new_business_registration_doc
                    ->storeAs($folderPath, 'business_registration_' . time() . '.' . $this->new_business_registration_doc->getClientOriginalExtension(), 'public');
            }

            if ($this->new_proof_of_address_doc) {
                if ($this->kyb->proof_of_address_doc && Storage::disk('public')->exists($this->kyb->proof_of_address_doc)) {
                    Storage::disk('public')->delete($this->kyb->proof_of_address_doc);
                }

                $this->kyb->proof_of_address_doc = $this->new_proof_of_address_doc
                    ->storeAs($folderPath, 'proof_of_address_' . time() . '.' . $this->new_proof_of_address_doc->getClientOriginalExtension(), 'public');
            }

            if ($this->new_financial_statements_doc) {
                if ($this->kyb->financial_statements_doc && Storage::disk('public')->exists($this->kyb->financial_statements_doc)) {
                    Storage::disk('public')->delete($this->kyb->financial_statements_doc);
                }

                $this->kyb->financial_statements_doc = $this->new_financial_statements_doc
                    ->storeAs($folderPath, 'financial_statements_' . time() . '.' . $this->new_financial_statements_doc->getClientOriginalExtension(), 'public');
            }

            if ($this->new_ownership_structure_doc) {
                if ($this->kyb->ownership_structure_doc && Storage::disk('public')->exists($this->kyb->ownership_structure_doc)) {
                    Storage::disk('public')->delete($this->kyb->ownership_structure_doc);
                }

                $this->kyb->ownership_structure_doc = $this->new_ownership_structure_doc
                    ->storeAs($folderPath, 'ownership_structure_' . time() . '.' . $this->new_ownership_structure_doc->getClientOriginalExtension(), 'public');
            }

            if ($this->has_aml_policy && $this->new_compliance_policy_doc) {
                if ($this->kyb->compliance_policy_doc && Storage::disk('public')->exists($this->kyb->compliance_policy_doc)) {
                    Storage::disk('public')->delete($this->kyb->compliance_policy_doc);
                }

                $this->kyb->compliance_policy_doc = $this->new_compliance_policy_doc
                    ->storeAs($folderPath, 'compliance_policy_' . time() . '.' . $this->new_compliance_policy_doc->getClientOriginalExtension(), 'public');
            }

            // Handle additional information response if requested
            if ($this->kyb->additional_info_requested) {
                $this->kyb->additional_info_response = $this->additional_info_response;
                $this->kyb->additional_info_responded_at = now();
            }

            // Reset the status to pending if it was in KIV
            if ($this->kyb->status === 'kiv') {
                $this->kyb->status = 'pending';
                $this->kyb->verification_status = 'pending';
            }

            $this->kyb->save();

            session()->flash('toast', [
                'type' => 'success',
                'message' => 'Your KYB information has been updated successfully.'
            ]);

            return redirect()->route('kyb.dashboard');

        } catch (\Exception $e) {
            Log::error('KYB update error: ' . $e->getMessage());
            session()->flash('toast', [
                'type' => 'error',
                'message' => 'There was an error updating your KYB application. Please try again.'
            ]);
        }
    }

    public function render()
    {
        return view('livewire.kyb.update-application');
    }
}

