<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. Lab Samples Table (Unique Visit Code & Tracking)
        Schema::create('lab_samples', function (Blueprint $table) {
            $table->id();
            $table->string('visit_code')->unique(); // e.g. VIS-2026-000104
            $table->foreignId('patient_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('booking_id')->nullable()->constrained('bookings')->onDelete('set null');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('contract_id')->nullable();
            $table->foreignId('assigned_staff_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('sample_status')->default('registered'); // registered, assigned, sample_collected, sent_to_lab, received_by_lab, processing, result_ready, cancelled
            $table->timestamp('collected_at')->nullable();
            $table->timestamp('received_at')->nullable();
            $table->timestamp('result_ready_at')->nullable();
            $table->timestamps();
        });

        // 2. Secure Medical Reports Table (PDF Uploads & Verification)
        Schema::create('medical_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lab_sample_id')->nullable()->constrained('lab_samples')->onDelete('cascade');
            $table->foreignId('patient_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('booking_id')->nullable()->constrained('bookings')->onDelete('set null');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->string('visit_code')->nullable();
            $table->string('file_path');
            $table->string('file_name');
            $table->unsignedBigInteger('file_size')->default(0);
            $table->string('mime_type')->default('application/pdf');
            $table->foreignId('uploaded_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('uploaded_at')->useCurrent();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('medical_reports');
        Schema::dropIfExists('lab_samples');
    }
};
