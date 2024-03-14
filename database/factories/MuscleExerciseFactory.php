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
    public static $paris = [];


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $muscleIds = Muscle::pluck('id')->toArray();
        $exerciseIds = Exercise::pluck('id')->toArray();
        $muscleId = null;
        $exerciseId = null;

        do {
            $muscleId = $this->faker->randomElement($muscleIds);
            $exerciseId = $this->faker->randomElement($exerciseIds);
            $found = false;

            foreach (self::$paris as $pair) {
                if ($pair[0] == $muscleId && $pair[1] == $exerciseId) {
                    $found = true;
                    break;
                }
            }
        } while ($found);
        array_push(self::$paris, array($muscleId, $exerciseId));

        return [
            'muscle_id' => $muscleId,
            'exercise_id' => $exerciseId,
        ];
    }
}
