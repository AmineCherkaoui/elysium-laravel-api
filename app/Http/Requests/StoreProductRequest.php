<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\Enum;
use App\Enums\ProductCategory;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nom' => 'required|string|max:255',
            'fabricant' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => ['required', new Enum(ProductCategory::class)],
            'image' => 'nullable|image',
            'resolutionX' => 'nullable|integer|min:1',
            'resolutionY' => 'nullable|integer|min:1',
            'taillePouces' => 'nullable|numeric|min:1',
            'luminositeNits' => 'nullable|integer|min:1',
            'tauxRafraichissementHz' => 'nullable|integer|min:1',
            'puissanceWatts' => 'nullable|numeric|min:0',
            'prixLocation' => 'nullable|numeric|min:0',
            'prixVente' => 'nullable|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'nom.required' => 'Le nom du produit est requis.',
            'fabricant.required' => 'Le fabricant est requis.',
            'description.required' => 'La description est requise.',
            'category.required' => 'La catégorie est requise.',
            'category.enum' => 'Catégorie invalide.',
            'image.image' => 'Le fichier doit être une image.',
            'image.mimes' => 'Format d’image non supporté. Utilisez JPG ou PNG.',
            'image.max' => 'L’image ne doit pas dépasser 2 Mo.',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'error' => 'Champs requis manquants ou invalides.',
            'details' => $validator->errors(),
            'code' => 'VALIDATION_ERROR'
        ], 422));
    }
}

