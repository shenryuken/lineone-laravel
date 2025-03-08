<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kyb extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'legal_name',
        'registration_number',
        'business_type',
        'date_established',
        'business_address',
        'business_phone',
        'business_email',
        'website',
        'tax_id',
        'directors',
        'shareholders',
        'beneficial_owners',
        'industry',
        'business_description',
        'products_services',
        'estimated_monthly_volume',
        'average_transaction_value',
        'geographical_markets',
        'customer_base',
        'online_presence',
        'physical_presence',
        'bank_name',
        'bank_account_number',
        'bank_routing_number',
        'annual_revenue',
        'financial_statement_date',
        'previous_year_revenue',
        'current_assets',
        'total_liabilities',
        'has_aml_policy',
        'has_sanctions_screening',
        'regulatory_licenses',
        'has_compliance_officer',
        'compliance_officer_name',
        'compliance_officer_email',
        'has_previous_violations',
        'previous_violations_details',
        'is_regulated_entity',
        'regulator_name',
        'business_registration_doc',
        'proof_of_address_doc',
        'financial_statements_doc',
        'ownership_structure_doc',
        'compliance_policy_doc',
        'status',
        'verification_status',
        'verification_notes',
        'verified_by',
        'verified_at',
        'approved_by',
        'approved_at',
        'rejected_by',
        'rejected_at',
        'rejection_reason',
        'additional_info_requested',
        'additional_info_requested_at',
        'additional_info_requested_by',
        'additional_info_response',
        'additional_info_responded_at',
    ];

    protected $casts = [
        'date_established' => 'date',
        'directors' => 'array',
        'shareholders' => 'array',
        'beneficial_owners' => 'array',
        'geographical_markets' => 'array',
        'regulatory_licenses' => 'array',
        'online_presence' => 'boolean',
        'physical_presence' => 'boolean',
        'has_aml_policy' => 'boolean',
        'has_sanctions_screening' => 'boolean',
        'has_compliance_officer' => 'boolean',
        'has_previous_violations' => 'boolean',
        'is_regulated_entity' => 'boolean',
        'financial_statement_date' => 'date',
        'verified_at' => 'datetime',
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
        'additional_info_requested_at' => 'datetime',
        'additional_info_responded_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function rejector()
    {
        return $this->belongsTo(User::class, 'rejected_by');
    }

    public function additionalInfoRequester()
    {
        return $this->belongsTo(User::class, 'additional_info_requested_by');
    }
}

