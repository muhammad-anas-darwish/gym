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
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chat_id')->constrained(table: 'chats')->cascadeOnDelete();
            $table->string('name', 128);
            $table->string('slug', 256)->unique();
            $table->tinyText('description')->nullable();
            $table->boolean('is_private')->default(false);
            $table->string('chat_photo_path', 2048)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groups');
    }
};
