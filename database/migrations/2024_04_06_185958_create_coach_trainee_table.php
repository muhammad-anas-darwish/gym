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
            $table->unsignedBigInteger('coach_id');
            $table->unsignedBigInteger('trainee_id');
            $table->timestamps();

            $table->foreign('coach_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('trainee_id')->references('id')->on('users')->onDelete('cascade');

            $table->primary(['coach_id', 'trainee_id']);
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
