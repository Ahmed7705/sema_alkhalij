<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. Add columns to contracts table if missing
        Schema::table('contracts', function (Blueprint $table) {
            if (!Schema::hasColumn('contracts', 'discount_percentage')) {
                $table->decimal('discount_percentage', 5, 2)->default(0.00)->after('payment_terms');
            }
        });

        // 2. Remove redundant national_id column from users table if present
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'national_id')) {
                $table->dropColumn('national_id');
            }
        });

        // 3. Add patient_id to bookings table if missing
        Schema::table('bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('bookings', 'patient_id')) {
                $table->unsignedBigInteger('patient_id')->nullable()->after('user_id');
            }
        });

        // 4. Add columns to contract_beneficiaries table
        Schema::table('contract_beneficiaries', function (Blueprint $table) {
            if (!Schema::hasColumn('contract_beneficiaries', 'company_id')) {
                $table->unsignedBigInteger('company_id')->nullable()->after('contract_id');
            }
            if (!Schema::hasColumn('contract_beneficiaries', 'name')) {
                $table->string('name')->nullable()->after('patient_id');
            }
            if (!Schema::hasColumn('contract_beneficiaries', 'identification_type')) {
                $table->string('identification_type')->default('saudi_id')->after('name');
            }
            if (!Schema::hasColumn('contract_beneficiaries', 'identification_number')) {
                $table->string('identification_number')->nullable()->after('identification_type');
            }
            if (!Schema::hasColumn('contract_beneficiaries', 'phone')) {
                $table->string('phone')->nullable()->after('identification_number');
            }
            if (!Schema::hasColumn('contract_beneficiaries', 'status')) {
                $table->string('status')->default('active')->after('employee_id_number');
            }
        });
    }

    public function down()
    {
        Schema::table('contracts', function (Blueprint $table) {
            if (Schema::hasColumn('contracts', 'discount_percentage')) {
                $table->dropColumn('discount_percentage');
            }
        });

        Schema::table('bookings', function (Blueprint $table) {
            if (Schema::hasColumn('bookings', 'patient_id')) {
                $table->dropColumn('patient_id');
            }
        });

        Schema::table('contract_beneficiaries', function (Blueprint $table) {
            if (Schema::hasColumn('contract_beneficiaries', 'status')) {
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('contract_beneficiaries', 'phone')) {
                $table->dropColumn('phone');
            }
            if (Schema::hasColumn('contract_beneficiaries', 'identification_number')) {
                $table->dropColumn('identification_number');
            }
            if (Schema::hasColumn('contract_beneficiaries', 'identification_type')) {
                $table->dropColumn('identification_type');
            }
            if (Schema::hasColumn('contract_beneficiaries', 'name')) {
                $table->dropColumn('name');
            }
            if (Schema::hasColumn('contract_beneficiaries', 'company_id')) {
                $table->dropColumn('company_id');
            }
        });
    }
};
