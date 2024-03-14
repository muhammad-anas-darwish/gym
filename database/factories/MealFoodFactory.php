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
    public static $paris = [];

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
            $found = false;

            foreach (self::$paris as $pair) {
                if ($pair[0] == $foodId && $pair[1] == $mealId) {
                    $found = true;
                    break;
                }
            }
        } while ($found);
        array_push(self::$paris, array($foodId, $mealId));

        return [
            'food_id' => $foodId,
            'meal_id' => $mealId,
            'amount' => $this->faker->numberBetween(1, 5) . '00 G',
        ];
    }
}
