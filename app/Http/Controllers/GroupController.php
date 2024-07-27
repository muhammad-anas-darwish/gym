<?php

namespace App\Http\Controllers;

use App\Enums\UserChatRole;
use App\Http\Requests\AddMembersToGroupRequest;
use App\Http\Requests\JoinGroupRequest;
use App\Models\Group;
use App\Http\Requests\StoreGroupRequest;
use App\Http\Requests\UpdateGroupRequest;
use App\Models\Chat;
use App\Models\UserChat;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
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
        $chat->users()->attach(Auth::id(), ['role' => UserChatRole::ADMIN->value]);
        
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
}
