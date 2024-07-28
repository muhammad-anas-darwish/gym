<?php

namespace App\Http\Requests;

use App\Enums\UserChatRole;
use App\Models\UserChat;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ChangeUserChatRoleRequest extends FormRequest
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
                    $userChat = UserChat::where('user_id', $value)
                        ->where('chat_id', $this->chat_id)
                        ->exists();
                        
                    if ($value === Auth::id()) {
                        $fail('You cannot change your role.');
                    }
                        
                    if (!$userChat) {
                        $fail('This user is not a member of this group.');
                    }
                }
            ],
            'role' => ['required', 'in:' . UserChatRole::ADMIN->value . ',' . UserChatRole::MEMBER->value],
        ];
    }
}
