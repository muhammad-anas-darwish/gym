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
use App\Models\UserExercise;
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
        Coach::factory(20)->create();

        User::factory(20)->create(['user_role' => 'trainee'])->each(function ($trainee) {
            $trainee->coaches()->attach(
                Coach::inRandomOrder()->limit(rand(1, 3))->pluck('user_id')
            );
        });

        Muscle::factory(10)->create();

        Exercise::factory(20)->create()->each(function ($exercise) {
            $exercise->muscles()->attach(
                Muscle::inRandomOrder()->limit(rand(1,3))->pluck('id')
            );
        });

        Food::factory(16)->create();

        Category::factory(16)->create();

        Package::factory(3)->create();

        // Chat::factory(20)->create()->each(function ($chat) {
        //     $chat->users()->attach(
        //         User::inRandomOrder()->limit(rand(3,10))->pluck('id')
        //     );
        // });
        
        Group::factory(20)->create();

        Chat::factory(40)->create([
            'is_direct' => true,
        ])->each(function ($chat) {
            $chat->users()->attach(
                User::inRandomOrder()->limit(2)->pluck('id'), 
            );
        });

        Advice::factory(40)->create();

        Article::factory(20)->create();

        Meal::factory(40)->create()->each(function ($meal) {
            $meal->foods()->attach(
                Food::inRandomOrder()->limit(rand(2,4))->pluck('id'), 
                ['amount' => rand(1, 5) . '00 G']
            );
        });

        // Video::factory(10)->create();

        TrainingSession::factory(10)->create();

        UserExercise::factory(50)->create();

        Report::factory(40)->create();

        UserInformation::factory(30)->create();

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
