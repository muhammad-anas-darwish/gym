<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Coach;
use App\Models\User;
use App\Models\UserInformation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create coaches
        $coaches = Coach::factory(20)->create(); 

        // create trainees
        User::factory(60)
            ->create(['user_role' => UserRole::TRAINEE->value])
            ->each(function ($trainee) use ($coaches) { 
                $trainee->coaches()->attach(
                    $coaches->random(rand(1, 3)),
                );
                UserInformation::factory(rand(1, 6))->create([
                    'user_id' => $trainee->id,
                ]);
            });

        // create admins
        User::factory(5)->create(['user_role' => UserRole::ADMIN->value]);
    }
}
