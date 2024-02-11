<?php

namespace App\Http\Controllers;

use App\Models\Advice;
use App\Http\Requests\StoreAdviceRequest;
use App\Http\Requests\UpdateAdviceRequest;

class AdviceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $advices = Advice::paginate(20);

        return response()->json($advices);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdviceRequest $request)
    {
        $data = $request->validated();

        Advice::create($data);

        return response()->json(['message' => 'Advice added.'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Advice $advice)
    {
        // TODO get random record from database
        return response()->json($advice);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdviceRequest $request, Advice $advice)
    {
        $data = $request->validated();

        $advice->update($data);

        return response()->json(['message' => 'Advice updated.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Advice $advice)
    {
        $advice->delete();

        return response()->json(['message' => 'Records deleted.'], 204);
    }
}
