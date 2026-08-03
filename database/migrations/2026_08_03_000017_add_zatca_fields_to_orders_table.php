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
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'customer_name')) {
                $table->string('customer_name')->nullable()->after('user_id');
            }
            if (!Schema::hasColumn('orders', 'notes')) {
                $table->text('notes')->nullable()->after('phone');
            }
            if (!Schema::hasColumn('orders', 'zatca_qr')) {
                $table->text('zatca_qr')->nullable()->after('notes');
            }
            if (!Schema::hasColumn('orders', 'zatca_hash')) {
                $table->string('zatca_hash')->nullable()->after('zatca_qr');
            }
        });

        Schema::table('order_items', function (Blueprint $table) {
            if (!Schema::hasColumn('order_items', 'service_id')) {
                $table->foreignId('service_id')->nullable()->constrained('services')->nullOnDelete()->after('product_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['customer_name', 'notes', 'zatca_qr', 'zatca_hash']);
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign(['service_id']);
            $table->dropColumn(['service_id']);
        });
    }
};
