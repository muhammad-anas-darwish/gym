<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Chat;
use App\Models\Exercise;
use App\Models\Food;
use App\Models\Muscle;
use App\Models\Package;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        Muscle::factory(10)->create();

        Exercise::factory(16)->create();

        Food::factory(16)->create();

        Category::factory(16)->create();

        Package::factory(3)->create();

        Chat::factory(6)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
