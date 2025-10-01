<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommandeRequest extends FormRequest
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
            'nom_client' => 'required|string|max:255',
            'email_client' => 'required|email|max:255',
            'telephone_client' => 'required|string|min:10|max:20',
            'adresse_client' => 'required|string',
            'notes' => 'nullable|string',
            'articles' => 'required|array|min:1',
            'articles.*.produit_id' => 'required|uuid|exists:produits,id',
            'articles.*.quantite' => 'required|integer|min:1|max:100',
            'articles.*.type' => 'required|in:location,achat',
        ];
    }

      public function messages(): array
    {
        return [
            'nom_client.required' => 'Le nom est requis.',
            'nom_client.max' => 'Le nom ne peut pas dépasser 255 caractères.',

            'email_client.required' => 'L\'email est requis.',
            'email_client.email' => 'L\'email doit être une adresse valide.',
            'email_client.max' => 'L\'email ne peut pas dépasser 255 caractères.',

            'telephone_client.required' => 'Le téléphone est requis.',
            'telephone_client.min' => 'Le téléphone est invalide.',
            'telephone_client.max' => 'Le téléphone ne peut pas dépasser 20 caractères.',

            'adresse_client.required' => 'L\'adresse est requise.',

            'articles.required' => 'Au moins un article est requis.',
            'articles.min' => 'Au moins un article est requis.',

            'articles.*.produit_id.required' => 'L\'ID du produit est requis.',
            'articles.*.produit_id.exists' => 'Le produit spécifié n\'existe pas.',

            'articles.*.quantite.required' => 'La quantité est requise.',
            'articles.*.quantite.integer' => 'La quantité doit être un nombre entier.',
            'articles.*.quantite.min' => 'La quantité doit être au moins 1.',
            'articles.*.quantite.max' => 'La quantité ne peut pas dépasser 100.',

            'articles.*.type.required' => 'Le type (location/achat) est requis.',
            'articles.*.type.in' => 'Le type doit être soit "location" soit "achat".',
        ];
    }
}
