<?php
// app/Models/Produit.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Produit extends Model
{
    use HasFactory, HasUuids;

    protected $table = "produits";
    protected $fillable = [
        'nom',
        'slug',
        'fabricant',
        'description',
        'imageUrl',
        'resolutionX',
        'resolutionY',
        'taillePouces',
        'luminositeNits',
        'tauxRafraichissementHz',
        'puissanceWatts',
        'prixLocation',
        'prixVente',
        'category',
    ];

    protected $casts = [
        'taillePouces' => 'float',
        'puissanceWatts' => 'float',
        'prixLocation' => 'float',
        'prixVente' => 'float',
        'resolutionX' => 'integer',
        'resolutionY' => 'integer',
        'luminositeNits' => 'integer',
        'tauxRafraichissementHz' => 'integer',
    ];

    public function articlesCommande()
    {
        return $this->hasMany(ArticleCommande::class, 'produit_id');
    }

    public function obtenirPrix($type)
    {
        return $type === 'location' ? $this->prixLocation : $this->prixVente;
    }
}
