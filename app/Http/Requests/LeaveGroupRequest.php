<?php

namespace App\Http\Requests;

use App\Models\Chat;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class LeaveGroupRequest extends FormRequest
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
                'exists:chats,id',
                function ($attribute, $value, $fail) {
                    $chat = Chat::find($value);

                    if (!$chat || !$chat->users()->where('user_id', Auth::id())->exists()) {
                        $fail('You are not a member of this group.');
                    }
                },
            ],
        ];
    }
}
