<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * get all coaches for the trainee user
     */
    public function getTraineeCoaches()
    {
        $coaches = User::find(Auth::id())->coaches;

        return response()->json($coaches);
    }

    /**
     * get all coaches for the trainee user by id
     */
    public function getTraineeCoachesById(User $user)
    {
        return response()->json($user->coaches);
    }

    /**
     * get all trainees for the coach user
     */
    public function getCoachTrainees()
    {
        $trainees = User::find(Auth::id())->trainees;

        return response()->json($trainees);
    }

    /**
     * get all trainees for the coach user by id
     */
    public function getCoachTraineesById(User $user)
    {
        return response()->json($user->trainees);
    }

    /**
     * Get all Coaches
     */
    public function getCoaches()
    {
        $coaches = User::select('id', 'name', 'gender')
            ->where('is_coach', true)
            ->withCount('trainees')
            ->get();

        return response()->json($coaches);
    }

    /**
     * get trainees who do not have coaches
     */
    public function getCoachlessTrainees()
    {
        $trainees = User::select('id', 'name', 'gender')
            ->whereDoesntHave('coaches')
            ->get();

        return response()->json($trainees);
    }
}
