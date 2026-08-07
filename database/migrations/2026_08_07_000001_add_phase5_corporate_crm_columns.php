<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. Add fields to companies table
        Schema::table('companies', function (Blueprint $table) {
            if (!Schema::hasColumn('companies', 'company_code')) {
                $table->string('company_code')->unique()->nullable()->after('name');
            }
            if (!Schema::hasColumn('companies', 'contact_person')) {
                $table->string('contact_person')->nullable()->after('cr_number');
            }
            if (!Schema::hasColumn('companies', 'contract_request_id')) {
                $table->unsignedBigInteger('contract_request_id')->nullable()->after('status');
            }
        });

        // 2. Add fields to contract_requests table
        Schema::table('contract_requests', function (Blueprint $table) {
            if (!Schema::hasColumn('contract_requests', 'rejection_reason')) {
                $table->text('rejection_reason')->nullable()->after('status');
            }
            if (!Schema::hasColumn('contract_requests', 'reviewed_by')) {
                $table->unsignedBigInteger('reviewed_by')->nullable()->after('rejection_reason');
            }
            if (!Schema::hasColumn('contract_requests', 'reviewed_at')) {
                $table->timestamp('reviewed_at')->nullable()->after('reviewed_by');
            }
            if (!Schema::hasColumn('contract_requests', 'approved_by')) {
                $table->unsignedBigInteger('approved_by')->nullable()->after('reviewed_at');
            }
            if (!Schema::hasColumn('contract_requests', 'approved_at')) {
                $table->timestamp('approved_at')->nullable()->after('approved_by');
            }
            if (!Schema::hasColumn('contract_requests', 'converted_company_id')) {
                $table->unsignedBigInteger('converted_company_id')->nullable()->after('approved_at');
            }
        });
    }

    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            if (Schema::hasColumn('companies', 'contract_request_id')) {
                $table->dropColumn('contract_request_id');
            }
            if (Schema::hasColumn('companies', 'contact_person')) {
                $table->dropColumn('contact_person');
            }
            if (Schema::hasColumn('companies', 'company_code')) {
                $table->dropColumn('company_code');
            }
        });

        Schema::table('contract_requests', function (Blueprint $table) {
            if (Schema::hasColumn('contract_requests', 'converted_company_id')) {
                $table->dropColumn('converted_company_id');
            }
            if (Schema::hasColumn('contract_requests', 'approved_at')) {
                $table->dropColumn('approved_at');
            }
            if (Schema::hasColumn('contract_requests', 'approved_by')) {
                $table->dropColumn('approved_by');
            }
            if (Schema::hasColumn('contract_requests', 'reviewed_at')) {
                $table->dropColumn('reviewed_at');
            }
            if (Schema::hasColumn('contract_requests', 'reviewed_by')) {
                $table->dropColumn('reviewed_by');
            }
            if (Schema::hasColumn('contract_requests', 'rejection_reason')) {
                $table->dropColumn('rejection_reason');
            }
        });
    }
};
