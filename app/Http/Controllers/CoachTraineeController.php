<?php

namespace App\Http\Controllers;

use App\Models\CoachTrainee;
use App\Http\Requests\StoreCoachTraineeRequest;
use App\Models\User;

class CoachTraineeController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCoachTraineeRequest $request)
    {
        $data = $request->validated();

        CoachTrainee::create($data);

        return response()->json(['message' => 'Trainee connected with coach.'], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyCoachTrainee(User $trainee, User $coach)
    {
        if (!$coach->trainees->contains($trainee)) {
            return response()->json(['message' => 'Relationship not found.'], 404);
        }

        $coach->trainees()->detach($trainee);

        return response()->json(['message' => 'Relationship deleted.'], 204);
    }
}
