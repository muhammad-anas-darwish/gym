<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Advice;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::pluck('id')->toArray();
        $coachUsers = User::where('user_role', UserRole::COACH->value)->pluck('id')->toArray();

        Advice::factory(40)->create([
            'category_id' => $categories[array_rand($categories)],
        ]);

        Article::factory(20)->create([
            'category_id' => $categories[array_rand($categories)],
            'user_id' => $coachUsers[array_rand($coachUsers)],
        ]);

        // Video::factory(10)->create();
    }
}
