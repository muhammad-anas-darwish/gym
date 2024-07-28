<?php

namespace App\Http\Controllers;

use App\Enums\UserChatRole;
use App\Http\Requests\AddMembersToGroupRequest;
use App\Http\Requests\ChangeUserChatRoleRequest;
use App\Http\Requests\JoinGroupRequest;
use App\Http\Requests\LeaveGroupRequest;
use App\Http\Requests\RemoveUserFromGroupRequest;
use App\Models\Group;
use App\Http\Requests\StoreGroupRequest;
use App\Http\Requests\UpdateGroupRequest;
use App\Models\Chat;
use App\Models\UserChat;
use App\Services\ChatServiceInterface;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    public function __construct(private readonly ChatServiceInterface $chatService) 
    { }

    public function getPublicGroups() 
    {
        $groups = Group::select('id', 'chat_id', 'name', 'slug')
            ->where('is_private', 0)
            ->paginate(20);

        return response()->json($groups);
    }

    public function addMembers(AddMembersToGroupRequest $request)
    {
        $data = $request->validated();
        
        $chat = Chat::find($data['chat_id']);
        $chat->users()->syncWithPivotValues($data['user_ids'], ['role' => $data['role']], false);

        return response()->json(['message' => 'Members added successfully.'], 201);
    }

    public function joinGroup(JoinGroupRequest $request)
    {
        $data = $request->validated();

        $data['user_id'] = Auth::id();
        UserChat::create($data);

        return response()->json(['message' => 'You are now a member of the group.'], 201);
    }

    public function leaveGroup(LeaveGroupRequest $request)
    {
        $data = $request->validated();

        $chat = Chat::find($data['chat_id']);
        $userChat = UserChat::where('chat_id', $data['chat_id'])->where('user_id', Auth::id())->first();

        if ($userChat->role === UserChatRole::OWNER) { // If the owner leaves, the chat will be deleted.
            $this->chatService->destroyChat($chat);
            return response()->json(['message' => 'The group has been deleted.'], 204);
        }
        
        $userChat->delete();

        return response()->json(['message' => 'You have left the group successfully.'], 200);
    }

    public function createGroup(StoreGroupRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('group_photo')) // save image if it exists
            $data['chat_photo_path'] = $request->file('group_photo')->store('/images/chats', ['disk' => 'public']);

        $chat = Chat::create([
            'is_direct' => false,
            'chat_type' => $data['chat_type'],
        ]);
        
        $data['chat_id'] = $chat->id;
        $data['slug'] = $data['name'];
        Group::create($data);

        // set owner to the group
        $chat->users()->attach(Auth::id(), ['role' => UserChatRole::OWNER->value]);
        
        return response()->json(['message' => 'Group added.'], 201);
    }

    public function update(UpdateGroupRequest $request, Group $group)
    {
        $data = $request->validated();

        if ($request->hasFile('group_photo')) { // save image if it exists
            $data['chat_photo_path'] = $request->file('group_photo')->store('/images/chats', ['disk' => 'public']);
        }
        $group->update($data);

        return response()->json(['message' => 'Group updated.']);
    }

    public function changeUserChatRole(ChangeUserChatRoleRequest $request)
    {
        $data = $request->validated();

        UserChat::where('chat_id', $data['chat_id'])
            ->where('user_id', $data['user_id'])
            ->update(['role' => $data['role']]);

        return response()->json(['message' => 'user chat role updated.']);
    }

    public function removeUser(RemoveUserFromGroupRequest $request)
    {
        $data = $request->validated();

        UserChat::where('chat_id', $data['chat_id'])
            ->where('user_id', $data['user_id'])
            ->delete();

        return response()->json(['message' => 'User removed from group.'], 204);
    }
}
