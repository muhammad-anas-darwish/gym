<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Enums\UserChatRole;
use App\Models\Advice;
use App\Models\Article;
use App\Models\Category;
use App\Models\Chat;
use App\Models\Coach;
use App\Models\Exercise;
use App\Models\Food;
use App\Models\Group;
use App\Models\Meal;
use App\Models\Muscle;
use App\Models\Package;
use App\Models\Report;
use App\Models\Specialty;
use App\Models\TrainingSession;
use App\Models\User;
use App\Models\UserInformation;
use App\Models\Video;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Category::factory(16)->create();
        Food::factory(16)->create();
        // Package::factory(3)->create();

        $this->call([
            UserSeeder::class,
            MuscleExerciseSeeder::class,
            MediaSeeder::class,
            MealSeeder::class,
            TrainingSeeder::class,
        ]);

        // Chat::factory(20)->create()->each(function ($chat) {
        //     $chat->users()->attach(
        //         User::inRandomOrder()->limit(rand(3,10))->pluck('id')
        //     );
        // });
        
        // Group::factory(20)->create();

        // Chat::factory(40)->create([
        //     'is_direct' => true,
        // ])->each(function ($chat) {
        //     $chat->users()->attach(
        //         User::inRandomOrder()->limit(2)->pluck('id'), 
        //     );
        // });

        Report::factory(40)->create();

        Specialty::factory(5)->create()->each(function ($specialty) {
            $specialty->coaches()->attach(
                Coach::inRandomOrder()->limit(rand(1, 10))->pluck('id')
            );
        });

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
