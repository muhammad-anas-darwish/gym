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
        Schema::create('muscle_exercise', function (Blueprint $table) {
            $table->id();

            $table->foreignId('muscle_id')->constrained(table: 'muscles')->cascadeOnDelete();
            $table->foreignId('exercise_id')->constrained(table: 'exercises')->cascadeOnDelete();

            $table->unique(['muscle_id', 'exercise_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('muscle_exercise');
    }
};
