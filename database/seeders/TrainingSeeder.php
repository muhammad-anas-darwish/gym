<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Exercise;
use App\Models\TrainingSession;
use App\Models\User;
use App\Models\UserExercise;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TrainingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $exercises = Exercise::with('muscles')->get()->toArray();
        $trainingSessions = TrainingSession::factory(10)->create()->pluck('id')->toArray();
        $users = User::where('user_role', UserRole::TRAINEE->value);
        
        $users->each(function ($user) use ($exercises, $trainingSessions) {
            for ($i = 0; $i < rand(5, 10); ++$i) {
                $exercise = $exercises[array_rand($exercises)];
                info($trainingSessions);
                $user->exercises()->attach(
                    $exercise['id'],
                    [
                        'muscle_id' => $exercise['muscles'][array_rand($exercise['muscles'])]['id'],
                        'training_session_id' => $trainingSessions[array_rand($trainingSessions)],
                        'sets' => rand(1, 5),
                        'reps' => "10 10 10",
                        'order' => $i + 1,
                    ]
                );
            }
        });
    }
}
