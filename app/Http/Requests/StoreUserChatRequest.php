<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserChatRequest extends FormRequest
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
            'user_id' => ['required', 'exists:users,id'],
            'chat_id' => ['required', 'exists:chats,id', 'unique:user_chat,user_id,',
                Rule::exists('chats', 'id')->where(function ($query) {
                    $query->where('is_private', false);
                })],
            'user_id' => 'unique:user_chat,user_id,NULL,id,chat_id,'.$this->chat_id
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'chat_id.exists' => 'The selected chat is invalid or private.',
        ];
    }
}
