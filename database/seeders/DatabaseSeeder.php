<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Advice;
use App\Models\Article;
use App\Models\Category;
use App\Models\Chat;
use App\Models\CoachUser;
use App\Models\Exercise;
use App\Models\Food;
use App\Models\Meal;
use App\Models\MealFood;
use App\Models\Muscle;
use App\Models\MuscleExercise;
use App\Models\Package;
use App\Models\Report;
use App\Models\TrainingSession;
use App\Models\User;
use App\Models\UserChat;
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
        User::factory(20)->create(['user_role' => 'trainee']);
        User::factory(20)->create(['user_role' => 'coach']);

        Muscle::factory(10)->create();

        Exercise::factory(16)->create();

        Food::factory(16)->create();

        Category::factory(16)->create();

        Package::factory(3)->create();

        Chat::factory(20)->create();

        MuscleExercise::factory(6)->create();

        Advice::factory(40)->create();

        Article::factory(20)->create();

        Meal::factory(40)->create();

        MealFood::factory(80)->create();

        // Video::factory(10)->create();

        UserChat::factory(60)->create();

        TrainingSession::factory(10)->create();

        UserExercise::factory(50)->create();

        Report::factory(40)->create();

        UserInformation::factory(30)->create();

        CoachUser::factory(25)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
