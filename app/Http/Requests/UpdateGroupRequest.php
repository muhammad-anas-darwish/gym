<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGroupRequest extends FormRequest
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
            'name' => ['sometimes', 'string', 'max:128'],
            'slug' => ['sometimes', 'string', 'max:250', 'unique:groups,slug,' . $this->route('group')->id],
            'description' => ['nullable', 'string', 'max:512'],
            'group_photo' => ['sometimes', 'image', 'mimes:jpg,png,jpeg,gif', 'max:2048'],
        ];
    }
}
