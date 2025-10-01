<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Str;

class Commande extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'numero_commande',
        'nom_client',
        'email_client',
        'telephone_client',
        'adresse_client',
        'status',
        'montant_total',
        'notes',
    ];

    protected $casts = [
        'montant_total' => 'decimal:2',
    ];

    public function articlesCommande()
    {
        return $this->hasMany(ArticleCommande::class, 'commande_id');
    }


    public static function genererNumeroCommande($length = 6)
    {
        do {
            $randomString = Str::upper(Str::random($length));
            $numeroCommande = 'C-' . $randomString;
        } while (self::where('numero_commande', $numeroCommande)->exists());

        return $numeroCommande;
    }



}
