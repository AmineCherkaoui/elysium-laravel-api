<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\Enum;
use App\Enums\ProductCategory;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nom' => 'sometimes|string|max:255',
            'fabricant' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'category' => ['sometimes', new Enum(ProductCategory::class)],
            'image' => 'sometimes|image|max:2048',
            'resolutionX' => 'sometimes|integer|min:1',
            'resolutionY' => 'sometimes|integer|min:1',
            'taillePouces' => 'sometimes|numeric|min:1',
            'luminositeNits' => 'sometimes|integer|min:1',
            'tauxRafraichissementHz' => 'sometimes|integer|min:1',
            'puissanceWatts' => 'sometimes|numeric|min:0',
            'prixLocation' => 'sometimes|numeric|min:0',
            'prixVente' => 'sometimes|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'nom.string' => 'Le nom doit être une chaîne de caractères.',
            'fabricant.string' => 'Le fabricant doit être une chaîne de caractères.',
            'description.string' => 'La description doit être une chaîne de caractères.',
            'category.enum' => 'Catégorie invalide.',
            'image.image' => 'Le fichier doit être une image.',
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
