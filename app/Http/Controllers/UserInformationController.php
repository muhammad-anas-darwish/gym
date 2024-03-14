<?php

namespace App\Http\Controllers;

use App\Models\UserInformation;
use App\Http\Requests\StoreUserInformationRequest;
use Illuminate\Support\Facades\Auth;

class UserInformationController extends Controller
{
    /**
     * Display a listing of the resource for coach.
     */
    public function getUserInformationForCoach(int $user_id)
    {
        $userInformation = UserInformation::where('user_id', $user_id)->get();

        return response()->json($userInformation);
    }

    /**
     * Display a listing of the resource.
     */
    public function getUserInformationForUser()
    {
        $userInformation = UserInformation::where('user_id', Auth::id())->get();

        return response()->json($userInformation);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserInformationRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();

        UserInformation::create($data);

        return response()->json(['message' => 'User information added.'], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserInformation $userInformation)
    {
        $userInformation->delete();

        return response()->json(['message' => 'Records deleted.'], 204);
    }
}
