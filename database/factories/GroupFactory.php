<?php

namespace Database\Factories;

use App\Enums\ChatType;
use App\Enums\UserChatRole;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Group>
 */
class GroupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $chat = Chat::create([
            'is_direct' => false,
        ]);

        $isPrivate = rand(0, 1);

        if ($isPrivate) {
            $chat->users()->attach( // add admins 
                User::inRandomOrder()->limit(rand(2,5))->pluck('id'),
                ['role' => UserChatRole::ADMIN->value]
            );
        }
        else {
            $chat->update(['chat_type' => $this->faker->randomElement(array_column(ChatType::cases(), 'value'))]);
            $chat->users()->attach( // add owner
                User::inRandomOrder()->limit(1)->pluck('id'),
                ['role' => UserChatRole::OWNER->value]
            );
            $chat->users()->attach( // add admins 
                User::inRandomOrder()->limit(rand(0,3))->pluck('id'),
                ['role' => UserChatRole::ADMIN->value]
            );
            $chat->users()->attach( // add members 
                User::inRandomOrder()->limit(rand(2, 16))->pluck('id')
            );    
        }
        
        return [
            'chat_id' => $chat->id,
            'name' => $this->faker->name, 
            'slug' => $this->faker->slug(3), 
            'description' => $this->faker->text(), 
            'chat_photo_path' => $this->faker->image(),
            'is_private' => $isPrivate,
        ];
    }
}
