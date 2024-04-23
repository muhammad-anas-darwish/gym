<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CoachUser>
 */
class CoachUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userIds = User::pluck('id')->toArray();
        $coachIds = User::where('is_coach', true)->pluck('id')->toArray();

        $userId = $this->faker->randomElement(array_diff($userIds, $coachIds));
        $coachId = $this->faker->randomElement($coachIds);

        return [
            'user_id' => $userId,
            'coach_id' => $coachId,
        ];
    }
}
