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
        ];
    }
}
