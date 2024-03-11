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

            $table->unsignedBiginteger('user_id');
            $table->unsignedBiginteger('chat_id');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('chat_id')->references('id')->on('chats')->onDelete('cascade');

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
