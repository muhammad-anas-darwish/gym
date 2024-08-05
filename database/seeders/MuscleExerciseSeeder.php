<?php

namespace Database\Seeders;

use App\Models\Exercise;
use App\Models\Muscle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MuscleExerciseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Muscle::factory()
            ->has(Exercise::factory(rand(2, 4)))
            ->count(10)
            ->create();
    }
}
