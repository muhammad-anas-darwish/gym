<?php

namespace App\Http\Controllers;

use App\Models\Specialty;
use App\Http\Requests\StoreSpecialtyRequest;
use App\Http\Requests\UpdateSpecialtyRequest;

class SpecialtyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $specialties = Specialty::all();

        return response()->json($specialties);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSpecialtyRequest $request)
    {
        $data = $request->validated();

        Specialty::create($data);

        return response()->json(['message' => 'Specialty added.'], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSpecialtyRequest $request, Specialty $specialty)
    {
        $data = $request->validated();

        $specialty->update($data);

        return response()->json(['message' => 'Specialty updated.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Specialty $specialty)
    {
        $specialty->delete();

        return response()->json(['message' => 'Record deleted.'], 204);
    }
}
