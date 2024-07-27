<?php

namespace App\Http\Controllers;

use App\Models\UserChat;

class UserChatController extends Controller
{
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserChat $userChat)
    {
        if ($userChat->chat->is_direct) {
            return response()->json(['error' => 'Cannot delete user from direct chat.'], 403);
        }

        $userChat->delete();

        return response()->json(['message' => 'Record deleted.'], 204);
    }
}
