<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            "name"=> "sometimes|string|max:255",
           "email"=>["sometimes","email",Rule::unique('users', 'email')->ignore($this->user()->id),],
           "current_password"=> "required_with:password|current_password",
           "password"=> "sometimes|string|min:8|confirmed",

        ];
    }

    public function messages(): array
{
    return [
        'name.string' => 'Le nom doit être une chaîne de caractères.',
        'name.max' => 'Le nom ne doit pas dépasser 255 caractères.',

        'email.email' => 'L’adresse e-mail doit être valide.',
        'email.unique' => 'Cette adresse e-mail est déjà utilisée.',

        'current_password.required_with' => 'Le mot de passe actuel est requis pour modifier le mot de passe.',
        'current_password.current_password' => 'Le mot de passe actuel est incorrect.',

        'password.string' => 'Le mot de passe doit être une chaîne de caractères.',
        'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
        'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
    ];
}

}
