<?php

namespace App\Http\Controllers;

use App\Models\UserChat;
use App\Http\Requests\StoreUserChatRequest;
use App\Http\Requests\UpdateUserChatRequest;

class UserChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserChatRequest $request)
    {
        $data = $request->validated();

        UserChat::create($data);

        return response()->json(['message' => 'User added to chat.'], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserChat $userChat)
    {
        $userChat->delete();

        return response()->json(['message' => 'Records deleted.'], 204);
    }
}
