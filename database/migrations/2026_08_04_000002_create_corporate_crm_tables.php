<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. Companies Table
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('cr_number')->unique()->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('city')->nullable();
            $table->text('address')->nullable();
            $table->string('status')->default('active'); // active, inactive, suspended
            $table->timestamps();
        });

        // 2. Corporate Contract Requests Table
        Schema::create('contract_requests', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('cr_number')->nullable();
            $table->string('contact_person');
            $table->string('phone');
            $table->string('email');
            $table->string('city')->nullable();
            $table->text('requested_services')->nullable();
            $table->integer('expected_beneficiaries')->default(0);
            $table->text('notes')->nullable();
            $table->string('status')->default('new'); // new, under_review, approved, rejected
            $table->timestamps();
        });

        // 3. Contracts Table
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->string('contract_number')->unique();
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('payment_terms')->default('immediate'); // immediate, monthly_invoice, net_30, custom
            $table->string('status')->default('active'); // draft, pending, active, expired, suspended, cancelled
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // 4. Contract Prices (Special Corporate Service Pricing)
        Schema::create('contract_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contract_id')->constrained('contracts')->onDelete('cascade');
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade');
            $table->decimal('custom_price', 10, 2);
            $table->timestamps();

            $table->unique(['contract_id', 'service_id']);
        });

        // 5. Contract Beneficiaries Table
        Schema::create('contract_beneficiaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contract_id')->constrained('contracts')->onDelete('cascade');
            $table->foreignId('patient_id')->constrained('users')->onDelete('cascade');
            $table->string('employee_id_number')->nullable();
            $table->timestamps();

            $table->unique(['contract_id', 'patient_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('contract_beneficiaries');
        Schema::dropIfExists('contract_prices');
        Schema::dropIfExists('contracts');
        Schema::dropIfExists('contract_requests');
        Schema::dropIfExists('companies');
    }
};
