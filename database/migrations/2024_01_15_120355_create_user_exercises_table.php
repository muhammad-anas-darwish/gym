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
        Schema::create('user_exercises', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained(table: 'users')->cascadeOnDelete();
            $table->foreignId('muscle_id')->constrained(table: 'muscles')->cascadeOnDelete();
            $table->foreignId('exercise_id')->constrained(table: 'exercises')->cascadeOnDelete();
            $table->foreignId('training_session_id')->constrained(table: 'training_sessions')->cascadeOnDelete();

            $table->smallInteger('sets')->default(3);
            $table->string('reps', 128);
            $table->smallInteger('order')->nullable();
            $table->string('note')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_exercises');
    }
};
