<?php

use App\Http\Controllers\AdviceController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CoachController;
use App\Http\Controllers\CoachSpecialtyController;
use App\Http\Controllers\CoachTraineeController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\MealController;
use App\Http\Controllers\MealFoodController;
use App\Http\Controllers\MuscleController;
use App\Http\Controllers\MuscleExerciseController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SpecialtyController;
use App\Http\Controllers\TrainingSessionController;
use App\Http\Controllers\UserChatController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserExerciseController;
use App\Http\Controllers\UserInformationController;
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
Route::get('/chats/get-user-chats', [ChatController::class, 'getUserChats'])->name('chats.getUserChats');
Route::delete('/chats/{chat}', [ChatController::class, 'deleteGroup'])->name('chats.deleteGroup');
Route::apiResource('chats', ChatController::class)->only(['index', 'show']);
Route::get('/chats/show/{chat}', [ChatController::class, 'getChat'])->name('chats.getChat');
Route::apiResource('muscle-exercise', MuscleExerciseController::class)->only(['store', 'destroy']);
Route::get('/advices/get-random/', [AdviceController::class, 'getRandomAdvice'])->name('advices.getRandomAdvice');
Route::apiResource('advices', AdviceController::class)->only(['index', 'store', 'update', 'destroy']);
Route::apiResource('articles', ArticleController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
Route::apiResource('meals', MealController::class)->only(['store', 'update', 'destroy']);
Route::get('/meals/my', [MealController::class, 'getUserMeals'])->name('meals.getUserMeals');
Route::get('/meals/user/{userId}', [MealController::class, 'getMealsOfUser'])->name('meals.getMealOfUser')->whereNumber('userId');
Route::get('/meals/{meal}', [MealController::class, 'getFoods'])->name('meals.getFoods');
Route::apiResource('meal-food', MealFoodController::class)->only(['store', 'update', 'destroy']);
Route::apiResource('videos', VideoController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
Route::apiResource('user-exercise', UserExerciseController::class)->only(['store', 'update', 'destroy']);
Route::get('/user-exercise/my', [UserExerciseController::class, 'getExercises'])->name('user-exercise.getExercises');
Route::get('/user-exercise/{userId}', [UserExerciseController::class, 'getUserExercises'])->name('user-exercise.getUserExercises')->whereNumber('userId');
Route::apiResource('user-chat', UserChatController::class)->only(['store', 'destroy']);
Route::apiResource('training-sessions', TrainingSessionController::class)->only(['index', 'store', 'update', 'destroy']);
Route::apiResource('reports', ReportController::class)->only(['index', 'store', 'show', 'destroy']);
Route::get('/reports/mark-as-read/{report}', [ReportController::class, 'markAsRead'])->name('reports.markAsRead');
Route::apiResource('user-information', UserInformationController::class)->only(['store', 'destroy']);
Route::get('/user-information/{userId}', [UserInformationController::class, 'getUserInformationForCoach'])->name('user-information.getUserInformationForCoach')->whereNumber('userId');
Route::get('/user-information', [UserInformationController::class, 'getUserInformationForUser'])->name('user-information.getUserInformationForUser');

Route::get('/users/admins', [UserController::class, 'getAdmins'])->name('users.getAdmins');
Route::get('/users/trainees', [UserController::class, 'getTrainees'])->name('users.getTrainees');
Route::get('/users/trainees/{user}', [UserController::class, 'getTrainee'])->name('users.getTrainee');
Route::get('/users/my/coaches', [UserController::class, 'getMyCoaches'])->name('users.getMyCoaches');
Route::get('/users/{user}/coaches', [UserController::class, 'getTraineeCoaches'])->name('users.getTraineeCoaches');

Route::get('/users/get-trainee-coaches/{user}', [UserController::class, 'getTraineeCoachesById'])->name('users.getTraineeCoachesById');
Route::get('/users/my-trainees', [UserController::class, 'getCoachTrainees'])->name('users.getCoachTrainees');
Route::get('/users/get-coach-trainees/{user}', [UserController::class, 'getCoachTraineesById'])->name('users.getCoachTraineesById');
Route::get('/users/coachless-trainees', [UserController::class, 'getCoachlessTrainees'])->name('users.getCoachlessTrainees');
Route::put('/users/promote-to-admin', [UserController::class, 'promoteToAdmin'])->name('users.promoteToAdmin');

Route::apiResource('coach-trainee', CoachTraineeController::class)->only(['store']);
Route::delete('coach-trainee/trainee/{trainee}/coach/{coach}', [CoachTraineeController::class, 'destroyCoachTrainee'])->name('coach-trainee.destroy');

Route::apiResource('specialties', SpecialtyController::class)->only(['index', 'store', 'update', 'destroy']);

Route::apiResource('coach-specialty', CoachSpecialtyController::class)->only(['store', 'destroy']);

Route::apiResource('coaches', CoachController::class)->only(['index', 'store', 'show', 'update']);

Route::get('/groups/get-public-groups', [GroupController::class, 'getPublicGroups'])->name('groups.getPublicGroups');
Route::post('/groups', [GroupController::class, 'createGroup'])->name('groups.createGroup');
Route::post('/groups/add-members', [GroupController::class, 'addMembers'])->name('groups.addMembers');
Route::post('/groups/join', [GroupController::class, 'joinGroup'])->name('groups.joinGroup');
Route::post('/groups/leave', [GroupController::class, 'leaveGroup'])->name('groups.leaveGroup');
Route::patch('/groups/change-user-chat-role', [GroupController::class, 'changeUserChatRole'])->name('groups.changeUserChatRole');
Route::delete('/groups/remove-user', [GroupController::class, 'removeUser'])->name('groups.removeUser');
Route::apiResource('groups', GroupController::class)->only(['update']);