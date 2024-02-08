<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Http\Requests\StoreExerciseRequest;
use App\Http\Requests\UpdateExerciseRequest;
use Mockery\CountValidator\Exception;

class ExerciseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $exercises = Exercise::all();
        return response()->json($exercises);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExerciseRequest $request)
    {
        $data = $request->validated();

        // store
        Exercise::create($data);

        return response()->json(['message' => 'Exercise added.'], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExerciseRequest $request, Exercise $exercise)
    {
        $data = $request->validated();

        // update
        $exercise->update($data);

        return response()->json(['message' => 'Exercise updated.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Exercise $exercise)
    {
        // delete
        $exercise->delete();

        return response()->json(['message' => 'Records deleted.'], 204);
    }
}
