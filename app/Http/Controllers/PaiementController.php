<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commande;
use App\Models\Paiement;

class PaiementController extends Controller
{
    public function store(Request $request, $commande)
    {
        $commande = Commande::findOrFail($commande);

        // Vérifier qu'elle n'est pas déjà payée
        if ($commande->paiement) {
            return back()->with('error', 'Cette commande est déjà payée !');
        }

        $request->validate([
            'montant' => 'required|numeric|min:0',
        ]);

        // Créer le paiement
        Paiement::create([
            'commande_id' => $commande->id,
            'montant'     => $request->montant,
            'mode'        => 'especes',
            'paye_le'     => now(),
        ]);

        // Mettre à jour le statut
        $commande->update([
            'statut'   => 'payee',
            'payee_le' => now(),
        ]);

        return back()->with('success', 'Paiement enregistré avec succès !');
    }
}
