<?php

namespace Database\Factories;

use App\Models\Food;
use App\Models\Meal;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MealFood>
 */
class MealFoodFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'food_id' => $this->faker->randomElement(Food::pluck('id')),
            'meal_id' => $this->faker->randomElement(Meal::pluck('id')),
            'amount' => $this->faker->numberBetween(1, 5) . '00 G',
        ];
    }
}
