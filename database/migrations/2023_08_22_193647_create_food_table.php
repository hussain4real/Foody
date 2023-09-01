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
        Schema::create('food', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('description');
            $table->string('cost_price')->nullable();
            $table->string('selling_price')->nullable();
            $table->dateTime('purchase_date')->nullable();
            $table->dateTime('manufactured_date')->nullable();
            $table->dateTime('expiry_date')->nullable();
            $table->string('quantity')->nullable();
            $table->string('type')->default(\App\Enums\FoodTypeEnum::FOOD->value);
            $table->string('status')->default(\App\Enums\FoodStatusEnum::AVAILABLE->value);
            $table->boolean('for_sale')->default(false);

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('food');
    }
};
