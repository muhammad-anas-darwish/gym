<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Http\Requests\StoreExerciseRequest;
use App\Http\Requests\UpdateExerciseRequest;

class ExerciseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $exercises = Exercise::all();
        // TODO don't return all columns && add filter
        return response()->json($exercises);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExerciseRequest $request)
    {
        $data = $request->validated();

        $data['exercise_photo_path'] = $request->file('image')->store('image');

        Exercise::create($data);

        return response()->json(['message' => 'Exercise added.'], 201);
    }

     /**
     * Display the specified resource.
     */
    public function show(Exercise $exercise)
    {
        return response()->json($exercise);
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
