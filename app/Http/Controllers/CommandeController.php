<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommandeRequest;
use App\Http\Resources\CommandeResource;
use App\Models\Commande;
use App\Models\Produit;
use App\Traits\ApiResponses;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Log;

class CommandeController extends Controller
{
    use ApiResponses;
    public function index(Request $request)
    {
        $query = Commande::query();


        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nom_client', 'like', "%{$search}%")
                  ->orWhere('numero_commande', 'like', "%{$search}%")
                  ->orWhere('email_client', 'like', "%{$search}%");
            });
        }


        $commandes = $query->latest()->get();


         return $this->success('Liste des commandes récupérée avec succès.', $commandes);
    }

    use ApiResponses;
    public function show($numero)
    {
        $commande = Commande::with(['articlesCommande.produit'])->where('numero_commande', $numero)->first();

        if (!$commande) {
             return $this->error("Commande non trouvé.",404);

        }

         return $this->success('Commande récupérée avec succès.', new CommandeResource($commande));

    }

    use ApiResponses;
    public function store(StoreCommandeRequest $request)
    {

        try {
            DB::beginTransaction();
            $commande = Commande::create([
                'numero_commande' => Commande::genererNumeroCommande(),
                'nom_client' => $request->nom_client,
                'email_client' => $request->email_client,
                'telephone_client' => $request->telephone_client,
                'adresse_client' => $request->adresse_client,
                'notes' => $request->notes,
                'montant_total' => 0,
            ]);

            $montantTotal = 0;




            foreach ($request->articles as $articleData) {
    $produit = Produit::findOrFail($articleData['produit_id']);
    $prixUnitaire = $produit->obtenirPrix($articleData['type']);

    if (!$prixUnitaire) {
        return $this->error("Prix non disponible pour le produit '{$produit->nom}' en {$articleData['type']}", 400);
    }


    $prixTotal = $prixUnitaire * $articleData['quantite'];

    if ($articleData['type'] === 'location') {
        $dateDebut = Carbon::parse($articleData['date_debut']);
        $dateFin = Carbon::parse($articleData['date_fin']);


       $nombreJours = $dateFin->diffInDays($dateDebut,true) + 1;

        $prixTotal *= $nombreJours;
    }

    $montantTotal += $prixTotal;

    $commande->articlesCommande()->create([
        'produit_id' => $articleData['produit_id'],
        'quantite' => $articleData['quantite'],
        'type' => $articleData['type'],
        'prix_unitaire' => $prixUnitaire,
        'prix_total' => $prixTotal,
        'date_debut' => $articleData['date_debut'] ?? null,
        'date_fin' => $articleData['date_fin'] ?? null,
    ]);
}



            $commande->update(['montant_total' => $montantTotal]);

            DB::commit();



            return $this->success('Commande '.$commande->numero_commande.' créée avec succès.', $commande,201);



        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error('Erreur lors de la création de la commande.',500);
        }
    }

use ApiResponses;
    public function updateStatus(Request $request, $numero)
    {
        $request->validate([
            'status' => 'required|in:en_attente,confirmee,en_traitement,livree,annulee'
        ], [
            'status.required' => 'Le status est requis.',
            'status.in' => 'Le status doit être : en_attente, confirmee, en_traitement, terminee, ou annulee.'
        ]);

         $commande = Commande::where('numero_commande', $numero)->first();

        if (!$commande) {
             return $this->error("Commande non trouvé.",404);

        }

        $ancienStatus = $commande->status;
        $commande->update(['status' => $request->status]);

        return $this->success("Status de la commande mis à jour.");
    }

    use ApiResponses;
    public function destroy($numero)
    {
      $commande = Commande::where('numero_commande', $numero)->first();

        if (!$commande) {
             return $this->error("Commande non trouvé.",404);

        }
        $numeroCommande = $commande->numero_commande;
        $commande->delete();
        return $this->success("Commande {$numeroCommande} supprimée avec succès.");
    }



}
