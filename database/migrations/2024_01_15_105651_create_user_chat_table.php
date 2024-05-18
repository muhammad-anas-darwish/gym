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
        Schema::create('user_chat', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained(table: 'users')->cascadeOnDelete();
            $table->foreignId('chat_id')->constrained(table: 'chats')->cascadeOnDelete();

            $table->unique(['user_id', 'chat_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_chat');
    }
};
