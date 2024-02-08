<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Http\Requests\StoreChatRequest;
use App\Http\Requests\UpdateChatRequest;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $chats = Chat::select(['title', 'chat_photo_path'])->paginate(20);

        return response()->json($chats);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreChatRequest $request)
    {
        $data = $request->validated();
        $data['is_private'] = true;

        // store
        Chat::create($data);

        return response()->json(['message' => 'Chat added.'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Chat $chat)
    {
        return response()->json($chat);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateChatRequest $request, Chat $chat)
    {
        $data = $request->validated();

        // update
        if(!$chat['is_private'])
            $chat->update($data);

        return response()->json('Chat updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chat $chat)
    {
        // delete
        if(!$chat['is_private'])
            $chat->delete();

        return response()->json('Records deleted.');
    }
}
