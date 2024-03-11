<?php

namespace Database\Factories;

use App\Models\Food;
use App\Models\Meal;
use App\Models\MealFood;
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
        $foodId = null;
        $mealId = null;
        do {
            $foodId = $this->faker->randomElement($foodIds);
            $mealId = $this->faker->randomElement($mealIds);
        } while (MealFood::where('food_id', $foodId)->where('meal_id', $mealId)->exists());

        return [
            'food_id' => $foodId,
            'meal_id' => $mealId,
            'amount' => $this->faker->numberBetween(1, 5) . '00 G',
        ];
    }
}
