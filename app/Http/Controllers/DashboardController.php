<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Contact;
use App\Models\Produit;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    use ApiResponses;
    public function summary(){

        return $this->success("",[
        'total_commandes' => Commande::count(),
       'commandes_en_attente' => Commande::where('status', 'en_attente')->latest()->get(),
        'revenu_total_mois' => Commande::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)->where('status','livree')
            ->sum('montant_total'),
        'messages_non_lu' => Contact::where('status', false)->latest()->get(),
        'total_produits' => Produit::count(),
        ]);
    }
}
