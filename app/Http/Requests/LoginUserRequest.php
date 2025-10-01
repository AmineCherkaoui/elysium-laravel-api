<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginUserRequest extends FormRequest
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
            "email"=> "required|string|email",
            "password"=> "required|string|min:8",
        ];
    }

    public function messages(): array
{
    return [
        'email.required' => "L'adresse e-mail est obligatoire.",
        'email.email' => "L'adresse e-mail doit être une adresse e-mail valide.",

        'password.required' => "Le mot de passe est obligatoire.",
        'password.min' => "Le mot de passe doit contenir au moins 8 caractères.",
    ];
}
}
