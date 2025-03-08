<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kybs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Business Registration Details
            $table->string('legal_name');
            $table->string('registration_number');
            $table->string('business_type');
            $table->date('date_established');
            $table->text('business_address');
            $table->string('business_phone');
            $table->string('business_email');
            $table->string('website')->nullable();
            $table->string('tax_id');

            // Ownership and Control Information
            $table->json('directors');
            $table->json('shareholders');
            $table->json('beneficial_owners');

            // Business Operations
            $table->string('industry');
            $table->text('business_description');
            $table->text('products_services');
            $table->decimal('estimated_monthly_volume', 15, 2);
            $table->decimal('average_transaction_value', 15, 2);
            $table->json('geographical_markets');
            $table->text('customer_base');
            $table->boolean('online_presence')->default(false);
            $table->boolean('physical_presence')->default(false);

            // Financial Information
            $table->string('bank_name');
            $table->string('bank_account_number');
            $table->string('bank_routing_number');
            $table->decimal('annual_revenue', 15, 2);
            $table->date('financial_statement_date');
            $table->decimal('previous_year_revenue', 15, 2);
            $table->decimal('current_assets', 15, 2);
            $table->decimal('total_liabilities', 15, 2);

            // Compliance Information
            $table->boolean('has_aml_policy')->default(false);
            $table->boolean('has_sanctions_screening')->default(false);
            $table->json('regulatory_licenses')->nullable();
            $table->boolean('has_compliance_officer')->default(false);
            $table->string('compliance_officer_name')->nullable();
            $table->string('compliance_officer_email')->nullable();
            $table->boolean('has_previous_violations')->default(false);
            $table->text('previous_violations_details')->nullable();
            $table->boolean('is_regulated_entity')->default(false);
            $table->string('regulator_name')->nullable();

            // Document Uploads
            $table->string('business_registration_doc');
            $table->string('proof_of_address_doc');
            $table->string('financial_statements_doc');
            $table->string('ownership_structure_doc');
            $table->string('compliance_policy_doc')->nullable();

            // Status and Verification
            $table->enum('status', ['pending', 'approved', 'rejected', 'kiv'])->default('pending');
            $table->enum('verification_status', ['pending', 'pass', 'fail'])->default('pending');
            $table->text('verification_notes')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users');
            $table->timestamp('verified_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('rejected_by')->nullable()->constrained('users');
            $table->timestamp('rejected_at')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->text('additional_info_requested')->nullable();
            $table->timestamp('additional_info_requested_at')->nullable();
            $table->foreignId('additional_info_requested_by')->nullable()->constrained('users');
            $table->text('additional_info_response')->nullable();
            $table->timestamp('additional_info_responded_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kybs');
    }
};
