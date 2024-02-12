<?php

use App\Http\Controllers\AdviceController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\MealController;
use App\Http\Controllers\MealFoodController;
use App\Http\Controllers\MuscleController;
use App\Http\Controllers\MuscleExerciseController;
use App\Http\Controllers\PackageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('muscles', MuscleController::class)->only(['index', 'store', 'update', 'destroy']);
Route::apiResource('exercises', ExerciseController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
Route::apiResource('foods', FoodController::class)->only(['index', 'show', 'store', 'update', 'destroy']);
Route::apiResource('categories', CategoryController::class)->only(['index', 'store', 'update', 'destroy']);
Route::apiResource('packages', PackageController::class)->only(['index', 'store', 'show','update', 'destroy']);
Route::apiResource('chats', ChatController::class)->only(['index', 'store', 'show','update', 'destroy']);
Route::apiResource('muscle_exercise', MuscleExerciseController::class)->only(['store', 'destroy']);
Route::apiResource('advices', AdviceController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
Route::apiResource('articles', ArticleController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
Route::apiResource('meals', MealController::class)->only(['store', 'update', 'destroy']);
Route::get('/meals/my', [MealController::class, 'getUserMeals'])->name('meals.getUserMeals');
Route::get('/meals/{userId}', [MealController::class, 'getMealsOfUser'])->name('meals.getMealOfUser'); // TODO validate userId
Route::apiResource('meal_food', MealFoodController::class)->only(['store', 'update', 'destroy']);
Route::get('/meal_food/{mealId}', [MealFoodController::class, 'getFoods'])->name('meals.getFoods'); // TODO validate mealId
