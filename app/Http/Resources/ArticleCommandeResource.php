<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleCommandeResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
         return [
            "id"=> $this->id,
            'quantite' => $this->quantite,
            'type' => $this->type,
            'prix_unitaire' => (float) $this->prix_unitaire,
            'prix_total' => (float) $this->prix_total,
            'produit' => $this->whenLoaded('produit', function () {
                return [
                    'slug' => $this->produit->slug,
                    'nom' => $this->produit->nom,
                    'fabricant' => $this->produit->fabricant,
                    'description' => $this->produit->description,
                    'imageUrl' => $this->produit->imageUrl,
                ];
            }),
        ];
    }
}
