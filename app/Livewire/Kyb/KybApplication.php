<?php

namespace App\Livewire\Kyb;

use App\Models\Kyb;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;

class KybApplication extends Component
{
    use WithFileUploads;

    // Step navigation
    public $currentStep = 1;
    public $totalSteps = 6;

    // Step 1: Business Registration Details
    public $legal_name;
    public $registration_number;
    public $business_type = 'limited_company';
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
        'entity_type' => 'individual', // individual or company
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
    public $online_presence = false;
    public $physical_presence = false;

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
    public $has_aml_policy = false;
    public $has_sanctions_screening = false;
    public $regulatory_licenses = [];
    public $has_compliance_officer = false;
    public $compliance_officer_name;
    public $compliance_officer_email;
    public $has_previous_violations = false;
    public $previous_violations_details;
    public $is_regulated_entity = false;
    public $regulator_name;

    // Step 6: Document Upload
    public $business_registration_doc;
    public $proof_of_address_doc;
    public $financial_statements_doc;
    public $ownership_structure_doc;
    public $director_id_docs = [];
    public $shareholder_id_docs = [];
    public $compliance_policy_doc;

    public function mount()
    {
        $user = Auth::user();

        // Check if user already has a KYB application
        $existingKyb = Kyb::where('user_id', $user->id)->first();
        if ($existingKyb) {
            return redirect()->route('kyb.status');
        }

        // Initialize with one empty director, shareholder, and beneficial owner
        $this->directors = [$this->newDirector];
        $this->shareholders = [$this->newShareholder];
        $this->beneficial_owners = [$this->newBeneficialOwner];
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
                    'business_registration_doc' => 'required|file|max:10240|mimes:pdf,jpg,jpeg,png',
                    'proof_of_address_doc' => 'required|file|max:10240|mimes:pdf,jpg,jpeg,png',
                    'financial_statements_doc' => 'required|file|max:10240|mimes:pdf,jpg,jpeg,png',
                    'ownership_structure_doc' => 'required|file|max:10240|mimes:pdf,jpg,jpeg,png',
                    'compliance_policy_doc' => $this->has_aml_policy ? 'required|file|max:10240|mimes:pdf,jpg,jpeg,png' : 'nullable',
                ];
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
        try {
            $this->validate([
                'business_registration_doc' => 'required|file|max:5120',
            ]);

            // Add error handling for file uploads
            if (!$this->business_registration_doc->isValid()) {
                throw new \Exception('File upload failed');
            }

            $user = Auth::user();
            $folderPath = 'kyb_documents/' . $user->id;

            $kybApplication = new Kyb();
            $kybApplication->user_id = $user->id;

            // Step 1: Business Registration Details
            $kybApplication->legal_name = $this->legal_name;
            $kybApplication->registration_number = $this->registration_number;
            $kybApplication->business_type = $this->business_type;
            $kybApplication->date_established = $this->date_established;
            $kybApplication->business_address = $this->business_address;
            $kybApplication->business_phone = $this->business_phone;
            $kybApplication->business_email = $this->business_email;
            $kybApplication->website = $this->website;
            $kybApplication->tax_id = $this->tax_id;

            // Step 2: Ownership and Control Information
            $kybApplication->directors = json_encode($this->directors);
            $kybApplication->shareholders = json_encode($this->shareholders);
            $kybApplication->beneficial_owners = json_encode($this->beneficial_owners);

            // Step 3: Business Operations
            $kybApplication->industry = $this->industry;
            $kybApplication->business_description = $this->business_description;
            $kybApplication->products_services = $this->products_services;
            $kybApplication->estimated_monthly_volume = $this->estimated_monthly_volume;
            $kybApplication->average_transaction_value = $this->average_transaction_value;
            $kybApplication->geographical_markets = json_encode($this->geographical_markets);
            $kybApplication->customer_base = $this->customer_base;
            $kybApplication->online_presence = $this->online_presence;
            $kybApplication->physical_presence = $this->physical_presence;

            // Step 4: Financial Information
            $kybApplication->bank_name = $this->bank_name;
            $kybApplication->bank_account_number = $this->bank_account_number;
            $kybApplication->bank_routing_number = $this->bank_routing_number;
            $kybApplication->annual_revenue = $this->annual_revenue;
            $kybApplication->financial_statement_date = $this->financial_statement_date;
            $kybApplication->previous_year_revenue = $this->previous_year_revenue;
            $kybApplication->current_assets = $this->current_assets;
            $kybApplication->total_liabilities = $this->total_liabilities;

            // Step 5: Compliance Information
            $kybApplication->has_aml_policy = $this->has_aml_policy;
            $kybApplication->has_sanctions_screening = $this->has_sanctions_screening;
            $kybApplication->regulatory_licenses = json_encode($this->regulatory_licenses);
            $kybApplication->has_compliance_officer = $this->has_compliance_officer;
            $kybApplication->compliance_officer_name = $this->compliance_officer_name;
            $kybApplication->compliance_officer_email = $this->compliance_officer_email;
            $kybApplication->has_previous_violations = $this->has_previous_violations;
            $kybApplication->previous_violations_details = $this->previous_violations_details;
            $kybApplication->is_regulated_entity = $this->is_regulated_entity;
            $kybApplication->regulator_name = $this->regulator_name;

            // Step 6: Document Upload
            $kybApplication->business_registration_doc = $this->business_registration_doc
                ->storeAs($folderPath, 'business_registration.' . $this->business_registration_doc->getClientOriginalExtension(), 'public');

            $kybApplication->proof_of_address_doc = $this->proof_of_address_doc
                ->storeAs($folderPath, 'proof_of_address.' . $this->proof_of_address_doc->getClientOriginalExtension(), 'public');

            $kybApplication->financial_statements_doc = $this->financial_statements_doc
                ->storeAs($folderPath, 'financial_statements.' . $this->financial_statements_doc->getClientOriginalExtension(), 'public');

            $kybApplication->ownership_structure_doc = $this->ownership_structure_doc
                ->storeAs($folderPath, 'ownership_structure.' . $this->ownership_structure_doc->getClientOriginalExtension(), 'public');

            if ($this->has_aml_policy && $this->compliance_policy_doc) {
                $kybApplication->compliance_policy_doc = $this->compliance_policy_doc
                    ->storeAs($folderPath, 'compliance_policy.' . $this->compliance_policy_doc->getClientOriginalExtension(), 'public');
            }

            // Set status to pending
            $kybApplication->status = 'pending';
            $kybApplication->verification_status = 'pending';

            $kybApplication->save();

            // Update user's KYB status
            $user->update(['kyb_status' => 'pending']);

            session()->flash('toast', [
                'type' => 'success',
                'message' => 'Your KYB application has been submitted successfully.'
            ]);

            return redirect()->route('dashboard');

        } catch (\Exception $e) {
            Log::error('KYB submission error: ' . $e->getMessage());
            session()->flash('error', 'File upload failed. Please try again.');
            return;
        }
    }

    public function render()
    {
        return view('livewire.kyb.kyb-application');
    }
}

