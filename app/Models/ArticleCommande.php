<?php
// app/Models/ArticleCommande.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ArticleCommande extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'articles_commande';

    protected $fillable = [
        'commande_id',
        'produit_id',
        'quantite',
        'type',
        'prix_unitaire',
        'prix_total',
    ];

    protected $casts = [
        'prix_unitaire' => 'decimal:2',
        'prix_total' => 'decimal:2',
        'quantite' => 'integer',
    ];

    public function commande()
    {
        return $this->belongsTo(Commande::class, 'commande_id');
    }

    public function produit()
    {
        return $this->belongsTo(Produit::class, 'produit_id');
    }


}
