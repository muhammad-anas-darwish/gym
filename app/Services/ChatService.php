<?php

namespace App\Services;

use App\Models\Chat;
use App\Models\User;
use App\Models\UserChat;
use Illuminate\Support\Collection;

class ChatService implements ChatServiceInterface
{
    /**
     * Get all user's direct chats
     */
    private function getUserDirectChats(User $user): Collection
    {        
        $chats = $user->chats()->where('is_direct', true)->get(['chats.id']);
        $chatData = $chats->map(function ($chat) use ($user) {
            $otherUser = $chat->users()->where('user_id', '!=', $user->id)->first();
            return [
                'chat_id' => $chat->id,
                'is_direct' => 1,
                'name' => $otherUser->username,
                'photo_path' => $otherUser->profile_photo_url,
            ];
        });

        return $chatData;
    }

    private function getUserGroupChats(User $user): Collection
    {
        $groups = $user->chats()->where('is_direct', false)->with('group')->get();
        $groupData = $groups->map(function ($group) {
            return [
                'chat_id' => $group->id,
                'is_direct' => 0,
                'name' => $group->group->name,
                'photo_path' => $group->group->chat_photo_path,
            ];
        });

        return $groupData;
    }

    public function getUserChats(int $userId): Collection
    {
        $user = User::find($userId);
        return $this->getUserDirectChats($user)->merge($this->getUserGroupChats($user));
    }
}
