<?php

namespace App\Http\Controllers;

use App\Models\MealFood;
use App\Http\Requests\StoreMealFoodRequest;
use App\Http\Requests\UpdateMealFoodRequest;

class MealFoodController extends Controller
{
    /**
     * Display a listing of the meal food.
     */
    public function getFoods(int $mealId)
    {
        $mealFood = MealFood::where('meal_id', $mealId)
            ->with('meal:id,name,day', 'food:id,name')
            ->select('id', 'meal_id', 'food_id', 'amount')
            ->get();

        return response()->json($mealFood);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMealFoodRequest $request)
    {
        $data = $request->validated();

        MealFood::create($data);

        return response()->json(['message' => 'Meal food added.'], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMealFoodRequest $request, MealFood $mealFood)
    {
        $data = $request->validated();

        $mealFood->update($data);

        return response()->json(['message' => 'Meal food updated.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MealFood $mealFood)
    {
        $mealFood->delete();

        return response()->json(['message' => 'Records deleted.'], 204);
    }
}
