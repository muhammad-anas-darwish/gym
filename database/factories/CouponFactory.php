<?php

namespace Database\Factories;

use App\Enums\CouponDuration;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Coupon>
 */
class CouponFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'percent_off' => $this->faker->numberBetween(1, 100),
            'duration' => $this->faker->randomElement(array_column(CouponDuration::cases(), 'value')),
            'duration_in_months' => $this->faker->duration === CouponDuration::REPEATING->value ? $this->faker->numberBetween(1, 10) : null,
            'max_redemptions' => $this->faker->numberBetween(1, 200), 
            'redeem_by' => $this->faker->dateTimeBetween('now', '+10 days')->format('Y-m-d H:i:s'),
        ];
    }
}
