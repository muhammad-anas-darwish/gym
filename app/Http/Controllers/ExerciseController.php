<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Http\Requests\StoreExerciseRequest;
use App\Http\Requests\UpdateExerciseRequest;
use Illuminate\Http\Request;

class ExerciseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $exercises = Exercise::query();

        if ($request->query('name'))
            $exercises = $exercises->where('name', 'LIKE', '%'.$request->query('name').'%');
        if ($request->query('muscle_id'))
            $exercises->filterByMuscle($request->query('muscle_id'));

        return response()->json($exercises->get(['id', 'name', 'exercise_photo_path']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExerciseRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('exercise_photo'))
            $data['exercise_photo_path'] = $request->file('exercise_photo')->store('/images/exercises', ['disk' => 'public']);

        Exercise::create($data);

        return response()->json(['message' => 'Exercise added.'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Exercise $exercise)
    {
        return response()->json($exercise->load('muscles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExerciseRequest $request, Exercise $exercise)
    {
        $data = $request->validated();

        if ($request->hasFile('exercise_photo'))
            $data['exercise_photo_path'] = $request->file('exercise_photo')->store('/images/exercises', ['disk' => 'public']);

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
