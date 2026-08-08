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
        Schema::create('webhooks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['incoming', 'outgoing']);
            $table->string('url')->nullable(); // Target URL for outgoing
            $table->string('secret')->nullable(); // HMAC Signing secret
            $table->json('events')->nullable(); // Subscribed events
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('webhook_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('webhook_id')->nullable()->constrained()->cascadeOnDelete();
            $table->enum('type', ['incoming', 'outgoing']);
            $table->string('event');
            $table->string('url')->nullable();
            $table->json('headers')->nullable();
            $table->json('payload')->nullable();
            $table->integer('status_code')->nullable();
            $table->enum('status', ['pending', 'success', 'failed'])->default('pending');
            $table->integer('attempts')->default(1);
            $table->text('error_message')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('webhook_logs');
        Schema::dropIfExists('webhooks');
    }
};
