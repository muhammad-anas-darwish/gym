<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MuscleExercise>
 */
class MuscleExerciseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'muscle_id' => $this->faker->numberBetween(1,5),
            'exercise_id' => $this->faker->numberBetween(1,5),
        ];
    }
}
