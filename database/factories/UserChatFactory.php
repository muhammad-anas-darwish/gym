<?php

namespace Database\Factories;

use App\Models\Chat;
use App\Models\User;
use App\Models\UserChat;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserChat>
 */
class UserChatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userIds = User::pluck('id')->toArray();
        $chatIds = Chat::pluck('id')->toArray();
        $userId = null;
        $chatId = null;

        do {
            $userId = $this->faker->randomElement($userIds);
            $chatId = $this->faker->randomElement($chatIds);
        } while (UserChat::where('user_id', $userId)->where('chat_id', $chatId)->exists());

        return [
            'user_id' => $userId,
            'chat_id' => $chatId,
        ];
    }
}
