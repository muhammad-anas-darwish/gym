<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Http\Requests\StoreMealRequest;
use App\Http\Requests\UpdateMealRequest;
use App\Models\User;
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

    public function getMealsOfUser(int $userId)
    {
        $meals = Meal::where('user_id', $userId)->get(['id', 'name', 'day']);

        return response()->json($meals);
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
