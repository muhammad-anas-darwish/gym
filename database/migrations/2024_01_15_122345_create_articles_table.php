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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained(table: 'users')->cascadeOnDelete();
            $table->foreignId('category_id')->constrained(table: 'categories')->cascadeOnDelete();
            $table->string('title', 64);
            $table->text('description')->nullable();
            $table->string('article_photo_path', 2048)->nullable();
            $table->integer('views_count', false, true)->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
