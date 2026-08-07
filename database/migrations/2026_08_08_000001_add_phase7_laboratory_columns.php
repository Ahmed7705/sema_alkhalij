<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('lab_samples', function (Blueprint $table) {
            if (!Schema::hasColumn('lab_samples', 'sent_to_lab_at')) {
                $table->timestamp('sent_to_lab_at')->nullable()->after('collected_at');
            }
            if (!Schema::hasColumn('lab_samples', 'processing_at')) {
                $table->timestamp('processing_at')->nullable()->after('received_at');
            }
            if (!Schema::hasColumn('lab_samples', 'report_uploaded_at')) {
                $table->timestamp('report_uploaded_at')->nullable()->after('result_ready_at');
            }
            if (!Schema::hasColumn('lab_samples', 'delivered_at')) {
                $table->timestamp('delivered_at')->nullable()->after('report_uploaded_at');
            }
            if (!Schema::hasColumn('lab_samples', 'notes')) {
                $table->text('notes')->nullable()->after('delivered_at');
            }
        });

        if (!Schema::hasTable('medical_report_versions')) {
            Schema::create('medical_report_versions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('medical_report_id')->constrained('medical_reports')->onDelete('cascade');
                $table->string('file_path');
                $table->string('file_name');
                $table->unsignedBigInteger('file_size')->default(0);
                $table->string('mime_type')->default('application/pdf');
                $table->foreignId('uploaded_by')->constrained('users')->onDelete('cascade');
                $table->foreignId('replaced_by')->nullable()->constrained('users')->onDelete('set null');
                $table->string('reason')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('medical_report_versions');

        Schema::table('lab_samples', function (Blueprint $table) {
            $columns = ['sent_to_lab_at', 'processing_at', 'report_uploaded_at', 'delivered_at', 'notes'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('lab_samples', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
