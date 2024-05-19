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
        Schema::create('meal_food', function (Blueprint $table) {
            $table->id();

            $table->foreignId('food_id')->constrained(table: 'foods')->cascadeOnDelete();
            $table->foreignId('meal_id')->constrained(table: 'meals')->cascadeOnDelete();
            $table->string('amount', 64);

            $table->unique(['food_id', 'meal_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meal_food');
    }
};
