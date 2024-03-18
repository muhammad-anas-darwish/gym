<?php

namespace App\Http\Controllers;

use App\Filters\Filter;
use App\Models\Chat;
use App\Models\UserChat;
use App\Http\Requests\StoreChatRequest;
use App\Http\Requests\StoreGroupRequest;
use App\Http\Requests\UpdateChatRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Display a listing of the chat members
     */
    function getMembers(int $chatId)
    {
        $userChat = UserChat::where('chat_id', $chatId)
            ->select('user_id')
            ->with('user:id,name,profile_photo_path,is_admin,is_coach')
            ->paginate(20)
            ->makeHidden(['user_id']);

        return response()->json($userChat);
    }

    /**
     * Display a listing of the chat members
     */
    function getUserChats()
    {
        $chats = Chat::whereHas('users', function ($query) {
            $query->where('user_id', Auth::id());
        })->get(['id', 'title', 'is_private', 'chat_photo_path', 'created_at']);

        return response()->json($chats);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $chats = Chat::query();

        $filter = new Filter($chats);
        $filter->search(['title' => $request->query('q')])
            ->where('is_private', $request->query('is_private'));

        $chats = $chats->select(['id', 'title', 'chat_photo_path', 'is_private'])->paginate(20);

        return response()->json($chats);
    }

    /**
     * Store a newly created resource in storage (private chat).
     */
    public function storePrivateChat(StoreChatRequest $request)
    {
        $data = $request->validated();

        $chat = Chat::create(['is_private' => true]);

        // add users to chat
        UserChat::create(['user_id' => $data['user1_id'], 'chat_id' => $chat['id']]);
        UserChat::create(['user_id' => $data['user2_id'], 'chat_id' => $chat['id']]);

        return response()->json(['message' => 'Chat added.'], 201);
    }

    /**
     * Store a newly created resource in storage (public chat).
     */
    public function storeGroup(StoreGroupRequest $request)
    {
        $data = $request->validated();
        $data['is_private'] = false;
        if ($request->hasFile('group_photo'))
            $data['chat_photo_path'] = $request->file('group_photo')->store('/images/chats', ['disk' => 'public']);

        Chat::create($data);

        return response()->json(['message' => 'Group added.'], 201);
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

        if(!$chat['is_private']) {
            if ($request->hasFile('chat_photo'))
                $data['chat_photo_path'] = $request->file('chat_photo')->store('/images/chats', ['disk' => 'public']);

            $chat->update($data);
        }

        return response()->json(['message' => 'Chat updated.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chat $chat)
    {
        if(!$chat['is_private'])
            $chat->delete();

        return response()->json(['message' => 'Records deleted.'], 204);
    }
}
