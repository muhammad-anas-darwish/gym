<?php

namespace App\Http\Controllers;

use App\Http\Requests\DestroyCoachUserRequest;
use App\Models\CoachUser;
use App\Http\Requests\StoreCoachUserRequest;

class CoachUserController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCoachUserRequest $request)
    {
        $data = $request->validated();

        CoachUser::create($data);

        return response()->json(['message' => 'user connected with coach.'], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyCoachUser(DestroyCoachUserRequest $request)
    {
        $data = $request->validated();

        CoachUser::where('user_id', $data['user_id'])->where('coach_id', $data['coach_id'])->delete();

        return response()->json(['message' => 'Records deleted.'], 204);
    }
}
