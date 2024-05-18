<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Http\Requests\StoreMealRequest;
use App\Http\Requests\UpdateMealRequest;
use Illuminate\Support\Facades\Auth;

class MealController extends Controller
{
    /**
     * Display a listing of the user meals.
     */
    public function getUserMeals()
    {
        $meals = Meal::where('user_id', Auth::id())->get(['id', 'name', 'day']);

        return response()->json($meals);
    }

    /**
     * Display a listing of the user meals for admin.
     */
    public function getMealsOfUser(int $userId)
    {
        $meals = Meal::where('user_id', $userId)->get(['id', 'name', 'day']);

        return response()->json($meals);
    }

    /**
     * Display a listing of the foods with mealId.
     */
    public function getFoods(Meal $meal)
    {
        $meal = $meal->load(['foods', 'foods.food']);
        $mealData = $meal->toArray();

        $mealData['foods'] = $meal->foods->map(function ($food) {
            return [
                'id' => $food->id, // meal_food Id
                'amount' => $food->amount,
                'created_at' => $food->created_at,
                'updated_at' => $food->updated_at,
                'food_id' => $food->food->id,
                'name' => $food->food->name,
                'description' => $food->food->description,
            ];
        });

        return response()->json($mealData);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMealRequest $request)
    {
        $data = $request->validated();

        Meal::create($data);

        return response()->json(['message' => 'Meal added.'], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMealRequest $request, Meal $meal)
    {
        $data = $request->validated();

        $meal->update($data);

        return response()->json(['message' => 'Meal updated.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Meal $meal)
    {
        $meal->delete();

        return response()->json(['message' => 'Records deleted.'], 204);
    }
}
