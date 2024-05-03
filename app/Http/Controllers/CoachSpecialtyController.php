<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCoachSpecialtyRequest;
use App\Models\CoachSpecialty;

class CoachSpecialtyController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCoachSpecialtyRequest $request)
    {
        $data = $request->validated();

        CoachSpecialty::create($data);

        return response()->json(['message' => 'Coach specialty added.'], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CoachSpecialty $coachSpecialty)
    {
        $coachSpecialty->delete();

        return response()->json(['message' => 'Records deleted.'], 204);
    }
}
