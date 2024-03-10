<?php

namespace App\Http\Controllers;

use App\Models\UserChat;
use App\Http\Requests\StoreUserChatRequest;

class UserChatController extends Controller
{
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
