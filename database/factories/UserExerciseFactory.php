<?php

namespace Database\Factories;

use App\Models\Exercise;
use App\Models\Muscle;
use App\Models\User;
use App\Models\UserExercise;
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
            'user_id' => $this->faker->randomElement(User::pluck('id')),
            'muscle_id' => $this->faker->randomElement(Muscle::pluck('id')),
            'exercise_id' => $this->faker->randomElement(Exercise::pluck('id')),
            'sets' => $this->faker->numberBetween(1, 5),
            'reps' => $this->faker->numberBetween(8, 12),
            'note' => $this->faker->text(64),
            'order' => function (array $attributes) {
                $user_id = $attributes['user_id'];
                $order = $this->faker->numberBetween(1, 10);

                // unique order number for user
                while (UserExercise::where('user_id', $user_id)->where('order', $order)->exists()) {
                    $order = $this->faker->numberBetween(1, 10);
                }

                return $order;
            },
        ];
    }
}
