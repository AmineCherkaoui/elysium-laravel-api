<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommandeResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
         return [
            'id' => $this->id,
            'numero_commande' => $this->numero_commande,
            'nom_client' => $this->nom_client,
            'email_client' => $this->email_client,
            'telephone_client' => $this->telephone_client,
            'adresse_client' => $this->adresse_client,
            'status' => $this->status,
            'montant_total' => (float) $this->montant_total,
            'notes' => $this->notes,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'articles_commande' => ArticleCommandeResource::collection($this->whenLoaded('articlesCommande')),
        ];
    }
}
