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
        $foodIds = Food::pluck('id')->toArray();
        $mealIds = Meal::pluck('id')->toArray();

        return [
            'food_id' => $this->faker->randomElement($foodIds),
            'meal_id' => $this->faker->randomElement($mealIds),
            'amount' => $this->faker->numberBetween(1, 5) . '00 G',
        ];
    }
}
