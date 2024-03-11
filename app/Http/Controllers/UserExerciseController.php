<?php

namespace App\Http\Controllers;

use App\Models\UserExercise;
use App\Http\Requests\StoreUserExerciseRequest;
use App\Http\Requests\UpdateUserExerciseRequest;
use Illuminate\Support\Facades\Auth;

class UserExerciseController extends Controller
{
    /**
     * Display a listing of the user exercises.
     */
    public function getExercises()
    {
        $userExercises = UserExercise::where('user_id', Auth::id())
            ->with('muscle', 'exercise')
            ->orderBy('order')
            ->get()
            ->groupBy('trainingSession.title');

        return response()->json($userExercises);
    }

    /**
     * Display a listing of the user exercises for coach.
     */
    public function getUserExercises(int $userId)
    {
        $userExercises = UserExercise::where('user_id', $userId)
            ->with('muscle', 'exercise')
            ->orderBy('order')
            ->get()
            ->groupBy('trainingSession.title');

        return response()->json($userExercises);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserExerciseRequest $request)
    {
        $data = $request->validated();

        UserExercise::create($data);

        return response()->json(['message' => 'User Exercise added.'], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserExerciseRequest $request, UserExercise $userExercise)
    {
        $data = $request->validated();

        $userExercise->update($data);

        return response()->json(['message' => 'User Exercise updated.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserExercise $userExercise)
    {
        $userExercise->delete();

        return response()->json(['message' => 'Records deleted.'], 204);
    }
}
