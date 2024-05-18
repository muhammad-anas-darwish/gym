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
        Schema::create('coach_trainee', function (Blueprint $table) {
            $table->foreignId('coach_id')->constrained(table: 'users')->cascadeOnDelete();
            $table->foreignId('trainee_id')->constrained(table: 'users')->cascadeOnDelete();
            $table->primary(['coach_id', 'trainee_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coach_trainee');
    }
};
