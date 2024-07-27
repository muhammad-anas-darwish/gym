<?php

namespace App\Http\Requests;

use App\Enums\UserChatRole;
use App\Models\Chat;
use Illuminate\Foundation\Http\FormRequest;

class AddMembersToGroupRequest extends FormRequest
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
    public function rules()
    {
        return [
            'chat_id' => ['required', 'exists:chats,id'],
            'user_ids' => ['required', 'array'],
            'user_ids.*' => ['exists:users,id'],
            'role' => ['sometimes', 'in:' . UserChatRole::ADMIN->value . ',' . UserChatRole::MEMBER->value],
        ];
    }

    protected function prepareForValidation()
    {
        $chat = Chat::find($this->chat_id); // if chat is direct raise error 

        if ($chat && $chat->is_direct) {
            $this->merge([
                'is_direct_error' => true
            ]);
        }
     
        $this->merge([ // add default value to role 
            'role' => $this->role ?? UserChatRole::MEMBER->value,
        ]);
    }

    public function messages()
    {
        return [
            'is_direct_error' => 'Cannot add members to a direct chat.',
        ];
    }
}
