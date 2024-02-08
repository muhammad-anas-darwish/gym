<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Http\Requests\StoreFoodRequest;
use App\Http\Requests\UpdateFoodRequest;

class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $foods = Food::all();
        return response()->json($foods);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFoodRequest $request)
    {
        $data = $request->validated();

        // store
        Food::create($data);

        return response()->json(['message', 'Food added.'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Food $food)
    {
        return response()->json($food);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFoodRequest $request, Food $food)
    {
        $data = $request->validated();

        $food->update($data);

        return response()->json(['message' => 'Food updated.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Food $food)
    {
        // delete
        $food->delete();

        return response()->json(['message' => 'Records deleted.'], 204);
    }
}
