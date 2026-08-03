<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('label')->default('المنزل'); // المنزل، العمل، الشاليه...
            $table->string('city')->default('الرياض');
            $table->string('district')->nullable(); // الحي
            $table->string('street')->nullable(); // الشارع
            $table->string('building_no')->nullable(); // رقم المبنى
            $table->text('additional_info')->nullable(); // تفاصيل إضافية / المعالم القريبة
            $table->decimal('lat', 10, 7)->nullable();
            $table->decimal('lng', 10, 7)->nullable();
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('addresses');
    }
};
