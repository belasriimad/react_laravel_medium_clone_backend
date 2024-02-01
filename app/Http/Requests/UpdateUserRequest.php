<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.request()->user()->id,
            'bio' => 'max:255',
            'image' => 'image|mimes:png,jpg,jpeg|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'image.max' => 'The image size must not be greater than 2MB.'
        ];
    }
}
