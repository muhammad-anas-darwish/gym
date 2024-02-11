<?php

namespace App\Http\Controllers;

use App\Models\MuscleExercise;
use App\Http\Requests\StoreMuscleExerciseRequest;

class MuscleExerciseController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMuscleExerciseRequest $request)
    {
        $data = $request->validated();

        // store
        MuscleExercise::create($data);

        return response()->json(['message' => 'Muscle exercise added.'], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MuscleExercise $muscleExercise)
    {
        // delete
        $muscleExercise->delete();

        return response()->json(['message' => 'Records deleted.'], 204);
    }
}
