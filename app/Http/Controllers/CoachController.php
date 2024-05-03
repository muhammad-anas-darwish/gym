<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Filters\Filter;
use App\Models\Coach;
use App\Http\Requests\StoreCoachRequest;
use App\Http\Requests\UpdateCoachRequest;
use App\Models\User;
use Illuminate\Http\Request;

class CoachController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $coaches = Coach::query()
            ->select(['id', 'user_id' ,'description'])
            ->with([
                'user' => function($query) {
                    $query->withCount('trainees');
                },
                'user:id,name,gender',
                'specialties:id,name'
            ]);

        $filter = new Filter($coaches);
        $filter->whereHas('specialties', 'specialty_id', $request->query('specialty_id'));
        $coaches = $coaches->get();

        return response()->json($coaches);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCoachRequest $request)
    {
        $data = $request->validated();

        User::find($data['user_id'])
            ->update(['user_role' => UserRole::COACH]);

        Coach::create($data);

        return response()->json(['message' => 'The user has been promoted from trainee to coach.'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Coach $coach)
    {
        $coach = $coach->load([
            'user' => function($query) {
                $query->withCount('trainees');
            },
            'user:id,name,gender',
            'specialties:id,name'
        ]);

        return response()->json($coach);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCoachRequest $request, Coach $coach)
    {
        $data = $request->validated();

        $coach->update($data);

        return response()->json(['message' => 'Coach updated.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Coach $coach)
    {
        //
    }
}
