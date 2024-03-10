<?php

namespace App\Http\Requests;

use App\Models\Chat;
use App\Models\UserChat;
use Illuminate\Foundation\Http\FormRequest;

class StoreChatRequest extends FormRequest
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
            'user1_id' => ['required', 'exists:users,id', function ($attribute, $value, $fail) {
                $user2_id = $this->input('user2_id');
                $chatId = UserChat::where('user_id', $value)
                    ->whereIn('chat_id', function ($query) use ($user2_id) {
                        $query->select('chat_id')
                            ->from('user_chat')
                            ->where('user_id', $user2_id);
                    })
                    ->whereHas('chat', function ($query) {
                        $query->where('is_private', true);
                    })
                    ->exists();

                if ($chatId) {
                    $fail('The chat with user1_id and user2_id already exists and is private.');
                }
            }],
            'user2_id' => ['required', 'exists:users,id', 'different:user1_id'],
        ];
    }
}
