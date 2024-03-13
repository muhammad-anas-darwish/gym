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
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TrainingSessionController;
use App\Http\Controllers\UserChatController;
use App\Http\Controllers\UserExerciseController;
use App\Http\Controllers\VideoController;
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
Route::get('/chats/members/{chatId}', [ChatController::class, 'getMembers'])->name('chats.getMembers')->whereNumber('chatId');
Route::get('/chats/get_user_chats', [ChatController::class, 'getUserChats'])->name('chats.getUserChats');
Route::post('/chats/private', [ChatController::class, 'storePrivateChat'])->name('chats.storePrivateChat');
Route::apiResource('chats', ChatController::class)->only(['index', 'show','update', 'destroy']);
Route::post('/groups', [ChatController::class, 'storeGroup'])->name('chats.storeGroup');
Route::apiResource('muscle_exercise', MuscleExerciseController::class)->only(['store', 'destroy']);
Route::get('/advices/get_random/', [AdviceController::class, 'getRandomAdvice'])->name('advices.getRandomAdvice');
Route::apiResource('advices', AdviceController::class)->only(['index', 'store', 'update', 'destroy']);
Route::apiResource('articles', ArticleController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
Route::apiResource('meals', MealController::class)->only(['store', 'update', 'destroy']);
Route::get('/meals/my', [MealController::class, 'getUserMeals'])->name('meals.getUserMeals');
Route::get('/meals/{userId}', [MealController::class, 'getMealsOfUser'])->name('meals.getMealOfUser')->whereNumber('userId');
Route::apiResource('meal_food', MealFoodController::class)->only(['store', 'update', 'destroy']);
Route::get('/meal_food/{mealId}', [MealFoodController::class, 'getFoods'])->name('meals.getFoods')->whereNumber('mealId');
Route::apiResource('videos', VideoController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
Route::apiResource('user_exercise', UserExerciseController::class)->only(['store', 'update', 'destroy']);
Route::get('/user_exercise/my', [UserExerciseController::class, 'getExercises'])->name('user_exercise.getExercises');
Route::get('/user_exercise/{userId}', [UserExerciseController::class, 'getUserExercises'])->name('user_exercise.getUserExercises')->whereNumber('userId');
Route::apiResource('user_chat', UserChatController::class)->only(['store', 'destroy']);
Route::apiResource('training_sessions', TrainingSessionController::class)->only(['index', 'store', 'update', 'destroy']);
Route::apiResource('reports', ReportController::class)->only(['index', 'store', 'show', 'destroy']);
Route::get('/reports/mark_as_read/{report}', [ReportController::class, 'markAsRead'])->name('reports.markAsRead');
