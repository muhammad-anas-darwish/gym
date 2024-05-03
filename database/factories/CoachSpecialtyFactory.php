<?php

namespace Database\Factories;

use App\Models\Coach;
use App\Models\Specialty;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CoachSpecialty>
 */
class CoachSpecialtyFactory extends Factory
{
    public static $paris = [];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $coachIds = Coach::pluck('id')->toArray();
        $specialtyIds = Specialty::pluck('id')->toArray();
        $coachId = null;
        $specialtyId = null;

        do {
            $coachId = $this->faker->randomElement($coachIds);
            $specialtyId = $this->faker->randomElement($specialtyIds);
            $found = false;

            foreach (self::$paris as $pair) {
                if ($pair[0] == $coachId && $pair[1] == $specialtyId) {
                    $found = true;
                    break;
                }
            }
        } while ($found);
        array_push(self::$paris, array($coachId, $specialtyId));

        return [
            'coach_id' => $coachId,
            'specialty_id' => $specialtyId,
        ];
    }
}
