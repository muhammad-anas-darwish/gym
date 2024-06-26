<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVideoRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:64'],
            'description' => ['required', 'string', 'max:1024'],
            'thumbnail_photo' => ['sometimes', 'image', 'mimes:jpg,png,jpeg,gif', 'max:2048'],
            'video' => ['required', 'file', 'mimes:mp4,avi,mov,wmv'],
        ];
    }
}
