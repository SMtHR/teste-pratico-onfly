<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegistrarRequest extends FormRequest
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
            'usuario' => 'required|string|max:255|unique:usuarios,usuario',
            'email' => 'required|string|email|max:255|unique:usuarios,email',
            'role' => 'nullable|string|in:admin,user',
            'password' => 'required|string|min:8|confirmed',
        ];
    }
}
