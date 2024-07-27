<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Models\Chat;
use App\Models\UserChat;
use App\Services\ChatServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use League\Config\Exception\ValidationException;

class ChatController extends Controller
{
    public function __construct(private readonly ChatServiceInterface $chatService) 
    {
    }

    /**
     * Display a listing of the chat members
     */
    function getMembers(int $chatId)
    {
        $userChat = UserChat::where('chat_id', $chatId)
            ->select('id', 'user_id', 'role')
            ->with('user:id,name,user_role')
            ->paginate(20)
            ->makeHidden(['user_id']);

        return response()->json($userChat);
    }

    /**
     * Show all groups to which the user belongs
     */
    function getUserChats()
    {
        // TODO : Change user id (1) to Auth::id()
        $chats = $this->chatService->getUserChats(1);

        return response()->json($chats);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {   
        $chats = Chat::filter(function ($filter) use ($request) {
            $filter->searchHas('group', 'name', $request->query('q'))
            ->where('is_direct', $request->query('is_direct'))
            ->whereHas('group', 'is_private', $request->query('is_private'));
        });
        
        $chats = $chats->with('group:id,chat_id,name,slug,is_private,chat_photo_path');
        $chats = $chats->select(['id', 'is_direct'])->paginate(20);

        return response()->json($chats);
    }

    /**
     * Display the specified resource.
     */
    public function show(Chat $chat)
    {
        $data = [
            'chat_id' => $chat->id,
            'is_direct' => $chat->is_direct,
        ];
        if ($chat->is_direct) {
            $chat->load('users:name');
            $data['name'] = "{$chat->users[0]->name} & {$chat->users[1]->name}";
        }
        else {
            $chat->load('group:chat_id,name,is_private');
            $data['name'] = "{$chat->group->name}";
        }
        return response()->json($data);
    }
    
    public function getChat(Chat $chat)
    {
        $userIsExist = $chat->users()->where('user_id', Auth::id())->exists();

        if ($chat->is_direct) { // return other user if chat is direct
            $chat->load(['users' => function($query) {
                $query->where('user_id', '!=', Auth::id())->select('name', 'username');
            }]);
        }
        else {
            $chat->load('group');
        }
        
        if (!$userIsExist && ($chat->is_direct || $chat->group->is_private)) {
            throw new CustomException('You do not have permissions to access this chat.', 403);
        }

        return response()->json($chat);
    }
}
