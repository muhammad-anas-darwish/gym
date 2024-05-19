<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVideoRequest extends FormRequest
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
            'title' => ['filled', 'string', 'max:64'],
            'description' => ['filled', 'string', 'max:1024'],
            'thumbnail_photo' => ['sometimes', 'image', 'mimes:jpg,png,jpeg', 'max:2048'],
            'video' => ['sometimes', 'file', 'mimes:mp4,avi,mov,wmv'],
        ];
    }
}
