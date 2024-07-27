<?php

namespace App\Http\Requests;

use App\Models\Chat;
use App\Models\UserChat;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class JoinGroupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'chat_id' => [
                'required',
                'integer',
                'exists:chats,id', // Ensure the chat exists
                function ($attribute, $value, $fail) {
                    $chat = Chat::find($value);
                    if ($chat && $chat->is_direct) {
                        $fail('The selected chat is not a group.');
                    }

                    $userChatExists = UserChat::where('chat_id', $value)
                        ->where('user_id', Auth::id())->exists();
                    if ($userChatExists) {
                        $fail('You are already in this group');
                    }  
                },
            ],
        ];
    }
}
