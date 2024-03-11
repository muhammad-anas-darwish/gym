<?php

namespace Database\Factories;

use App\Models\Chat;
use App\Models\User;
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

        return [
            'user_id' => $this->faker->randomElement($userIds),
            'chat_id' => $this->faker->randomElement($chatIds),
        ];
    }
}
