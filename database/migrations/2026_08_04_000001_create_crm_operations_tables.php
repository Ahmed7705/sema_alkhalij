<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. Staff Profiles Table
        if (!Schema::hasTable('staff_profiles')) {
            Schema::create('staff_profiles', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->string('staff_type')->default('doctor'); // doctor, nurse, physio, lab_tech
                $table->string('specialty')->nullable();
                $table->string('license_number')->nullable();
                $table->string('job_title')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        // 2. Add Patient Identification fields to users table
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'identification_type')) {
                $table->string('identification_type')->nullable()->after('email'); // saudi_id, iqama, border_no, gcc_id
            }
            if (!Schema::hasColumn('users', 'identification_number')) {
                $table->string('identification_number')->nullable()->after('identification_type');
            }
            if (!Schema::hasColumn('users', 'company_id')) {
                $table->unsignedBigInteger('company_id')->nullable()->after('role');
            }
        });

        // 3. Add Service Assignment & Workflow fields to bookings table
        Schema::table('bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('bookings', 'assigned_provider_id')) {
                $table->foreignId('assigned_provider_id')->nullable()->constrained('users')->onDelete('set null')->after('service_id');
            }
            if (!Schema::hasColumn('bookings', 'assigned_by')) {
                $table->foreignId('assigned_by')->nullable()->constrained('users')->onDelete('set null')->after('assigned_provider_id');
            }
            if (!Schema::hasColumn('bookings', 'assigned_at')) {
                $table->timestamp('assigned_at')->nullable()->after('assigned_by');
            }
            if (!Schema::hasColumn('bookings', 'accepted_at')) {
                $table->timestamp('accepted_at')->nullable()->after('assigned_at');
            }
            if (!Schema::hasColumn('bookings', 'started_at')) {
                $table->timestamp('started_at')->nullable()->after('accepted_at');
            }
            if (!Schema::hasColumn('bookings', 'completed_at')) {
                $table->timestamp('completed_at')->nullable()->after('started_at');
            }
            if (!Schema::hasColumn('bookings', 'verified_at')) {
                $table->timestamp('verified_at')->nullable()->after('completed_at');
            }
            if (!Schema::hasColumn('bookings', 'verified_by')) {
                $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null')->after('verified_at');
            }
            if (!Schema::hasColumn('bookings', 'patient_name')) {
                $table->string('patient_name')->nullable()->after('user_id');
            }
            if (!Schema::hasColumn('bookings', 'identification_type')) {
                $table->string('identification_type')->nullable()->after('patient_name');
            }
            if (!Schema::hasColumn('bookings', 'identification_number')) {
                $table->string('identification_number')->nullable()->after('identification_type');
            }
            if (!Schema::hasColumn('bookings', 'company_id')) {
                $table->unsignedBigInteger('company_id')->nullable()->after('user_id');
            }
            if (!Schema::hasColumn('bookings', 'contract_id')) {
                $table->unsignedBigInteger('contract_id')->nullable()->after('company_id');
            }
        });
    }

    public function down()
    {
        Schema::dropIfExists('staff_profiles');
    }
};
