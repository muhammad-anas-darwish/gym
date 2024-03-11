<?php

namespace App\Http\Controllers;

use App\Models\TrainingSession;
use App\Http\Requests\StoreTrainingSessionRequest;
use App\Http\Requests\UpdateTrainingSessionRequest;

class TrainingSessionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $trainingSessions = TrainingSession::all();

        return response()->json($trainingSessions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTrainingSessionRequest $request)
    {
        $data = $request->validated();

        TrainingSession::create($data);

        return response()->json(['message' => 'Training Session added.'], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTrainingSessionRequest $request, TrainingSession $trainingSession)
    {
        $data = $request->validated();

        $trainingSession->update($data);

        return response()->json(['message' => 'Training Session updated.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TrainingSession $trainingSession)
    {
        $trainingSession->delete();

        return response()->json(['message' => 'Record deleted.'], 204);
    }
}
