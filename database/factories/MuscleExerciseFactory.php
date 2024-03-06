<?php

namespace Database\Factories;

use App\Models\Exercise;
use App\Models\Muscle;
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
            'muscle_id' => $this->faker->randomElement(Muscle::pluck('id')),
            'exercise_id' => $this->faker->randomElement(Exercise::pluck('id')),
        ];
    }
}
