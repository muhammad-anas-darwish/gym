<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Food;
use App\Models\Meal;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $foods = Food::pluck('id');
        $traineeUsers = User::where('user_role', UserRole::TRAINEE->value)->pluck('id')->toArray();

        Meal::factory()->count(40)->create([
            'user_id' => $traineeUsers[array_rand($traineeUsers)],
        ])->each(function ($meal) use ($foods) {
            $meal->foods()->attach(
                $foods->shuffle()->take(rand(3, 7)),
                ['amount' => rand(1, 5) . '00 G']
            );
        });
    }
}
