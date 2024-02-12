<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserExercise>
 */
class UserExerciseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->numberBetween(1, 10),
            'muscle_id' => $this->faker->numberBetween(1, 10),
            'exercise_id' => $this->faker->numberBetween(1, 10),
            'sets' => $this->faker->numberBetween(1, 5),
            'reps' => $this->faker->numberBetween(8, 12),
            'order' => $this->faker->numberBetween(1, 10), // TODO change this to unique number
            'note' => $this->faker->text(64),
        ];
    }
}
