<?php

namespace App\Http\Requests;

use App\Enums\UserChatRole;
use App\Models\UserChat;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class RemoveUserFromGroupRequest extends FormRequest
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
            'chat_id' => ['required', 'exists:chats,id'],
            'user_id' => [
                'required',
                'exists:users,id',
                function ($attribute, $value, $fail) {
                    if ($value === Auth::id()) {
                        $fail('You cannot remove yourself from the group.');
                    }

                    $userChat = UserChat::where('user_id', $value)
                        ->where('chat_id', $this->chat_id)
                        ->exists();
                        
                    if (!$userChat) {
                        $fail('This user already is not a member of this group.');
                    }
                }
            ],
        ];
    }
}
