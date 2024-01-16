<?php

namespace App\Http\Controllers;

use App\Models\Muscle;
use App\Http\Requests\StoreMuscleRequest;
use App\Http\Requests\UpdateMuscleRequest;

class MuscleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $muscles = Muscle::all();
        return response()->json($muscles);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMuscleRequest $request)
    {
        $data = $request->validated();

        // store
        Muscle::create($data);

        return response()->json([
            'message' => 'Muscle added.'
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMuscleRequest $request, Muscle $muscle)
    {
        $data = $request->validated();

        // update
        $muscle->update($data);

        return response()->json(['message' => 'Muscle updated.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Muscle $muscle)
    {
        // delete
        $muscle->delete();

        return response()->json(['message' => 'Records deleted'], 204);
    }
}
