<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Filters\Filter;
use App\Http\Requests\PromoteToAdminRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    /**
     * Get all admins
     */
    public function getAdmins()
    {
        $admins = User::where('user_role', UserRole::ADMIN)
            ->get(['id','name', 'gender', 'created_at']);

        return response()->json($admins);
    }

    /**
     * Get all trainees
     */
    public function getTrainees(Request $request)
    {
        $trainees = User::query();

        $filter = new Filter($trainees);
        $filter
            ->search(['name' => $request->query('name')])
            ->where('user_role', UserRole::TRAINEE)
            ->where('gender', $request->query('gender'))
            ->where('id', $request['user_id'])
            ->orderBy(['created_at'], $request->query('sort_by'));

        $trainees = $trainees->select(['id', 'name', 'email', 'phone', 'gender', 'created_at'])
            ->get();

        return response()->json($trainees);
    }

    /**
     * Display the specified trainee.
     */
    public function getTrainee(User $user)
    {
        // Validate user role
        $validator = Validator::make(['user_role' => $user['user_role']->value], [
            'user_role' => ['required', 'in:' . UserRole::TRAINEE->value],
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->getMessages();
            return response()->json(['errors' => $errors], 403);
        }

        $userData = $user->toArray();

        $coachesData = $user->coaches->map(function ($coach) {
            return [
                'id' => $coach->id,
                'name' => $coach->name,
                'specialties' => $coach->coach->specialties->map(function ($specialty) {
                    return [
                        'id' => $specialty->id,
                        'name' => $specialty->name,
                    ];
                })
            ];
        });

        $userData['coaches'] = $coachesData;

        return response()->json($userData);
    }

    /**
     * get all coaches for the trainee user
     */
    public function getMyCoaches()
    {
        $coaches = Auth::user()->coaches;

        return response()->json($coaches);
    }

    /**
     * get all coaches for the trainee user
     */
    public function getTraineeCoaches(User $user)
    {
        $coaches = $user->coaches;

        return response()->json($coaches);
    }

    /**
     * get all coaches for the trainee user by id
     */
    public function getTraineeCoachesById(User $user)
    {
        return response()->json($user->coaches);
    }

    /**
     * get all trainees for the coach user
     */
    public function getCoachTrainees()
    {
        $trainees = User::find(Auth::id())->trainees;

        return response()->json($trainees);
    }

    /**
     * get all trainees for the coach user by id
     */
    public function getCoachTraineesById(User $user)
    {
        return response()->json($user->trainees);
    }

    /**
     * get trainees who do not have coaches
     */
    public function getCoachlessTrainees()
    {
        $trainees = User::select('id', 'name', 'gender')
            ->whereDoesntHave('coaches')
            ->get();

        return response()->json($trainees);
    }

    /**
     * Promote User To Admin
     */
    public function promoteToAdmin(PromoteToAdminRequest $request)
    {
        $user = User::findOrFail($request['user_id']);

        $user->update(['user_role' => UserRole::ADMIN]);

        return response()->json(['message' => 'User promoted to admin successfully']);
    }
}
