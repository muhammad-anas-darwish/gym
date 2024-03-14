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
    public static $paris = [];

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
            $found = false;

            foreach (self::$paris as $pair) {
                if ($pair[0] == $userId && $pair[1] == $chatId) {
                    $found = true;
                    break;
                }
            }
        } while ($found);
        array_push(self::$paris, array($userId, $chatId));

        return [
            'user_id' => $userId,
            'chat_id' => $chatId,
        ];
    }
}
