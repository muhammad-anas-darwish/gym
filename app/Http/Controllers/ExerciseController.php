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
        // $exercises = Exercise::all();

        $exercises = Exercise::query();
        $exercises->when(request()->filled('filter'), function ($query) {
            $filters = explode(',', request('filter'));
            foreach ($filters as $filter) {
                [$criteria, $value] = explode(':', $filter);
                $query->where($criteria, $value);
            }
            return $query;
        });
        // TODO add filter
        return response()->json($exercises->get());
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
        // TODO don't return all fields
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
