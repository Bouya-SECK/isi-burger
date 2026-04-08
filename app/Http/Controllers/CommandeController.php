<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commande;
use App\Models\CommandeItem;
use App\Models\Burger;
use App\Http\Requests\StoreCommandeRequest;
use App\Mail\CommandeConfirmation;
use App\Mail\CommandePrete;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;

class CommandeController extends Controller
{
    // GESTIONNAIRE
    public function indexGestionnaire()
    {
        $commandes = Commande::with('user')
            ->latest()
            ->get();

        return view('gestionnaire.commandes.index', compact('commandes'));
    }

    public function show($id)
    {
        $commande = Commande::with(['user', 'items.burger', 'paiement'])
            ->findOrFail($id);

        return view('gestionnaire.commandes.show', compact('commande'));
    }

    // Changer le statut
    public function updateStatut(Request $request, $id)
    {
        $commande = Commande::with(['user', 'items.burger', 'paiement'])
            ->findOrFail($id);
        $commande->update(['statut' => $request->statut]);

        // Envoyer email + PDF si commande prête
        if ($request->statut === 'prete') {
            $pdf = Pdf::loadView('pdf.facture', compact('commande'));

            Mail::to($commande->user->email)
                ->send((new CommandePrete($commande))
                    ->attachData($pdf->output(), 'facture-'.$commande->id.'.pdf', [
                        'mime' => 'application/pdf',
                    ]));
        }

        return back()->with('success', 'Statut mis à jour avec succès !');
    }

    public function annuler($id)
    {
        $commande = Commande::findOrFail($id);

        // Remettre le stock
        foreach ($commande->items as $item) {
            $item->burger->increment('stock', $item->quantite);
        }

        $commande->update(['statut' => 'annulee']);

        return back()->with('success', 'Commande annulée !');
    }

    public function supprimer($id)
    {
        $commande = Commande::findOrFail($id);

        // On peut supprimer seulement si annulée
        if ($commande->statut !== 'annulee') {
            return back()->with('error', 'Vous ne pouvez supprimer que les commandes annulées !');
        }

        $commande->delete();

        return back()->with('success', 'Commande supprimée définitivement !');
    }

    // CLIENT
    public function indexClient()
    {
        $commandes = Commande::with('items.burger')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('client/commandes/index', compact('commandes'));
    }

    public function store(StoreCommandeRequest $request)
    {
        $burger = Burger::findOrFail($request->burger_id);

        if ($burger->stock < $request->quantite) {
            return back()->with('error', 'Stock insuffisant pour ce burger !');
        }

        $commande = Commande::create([
            'user_id' => auth()->id(),
            'statut'  => 'en_attente',
            'total'   => $burger->prix * $request->quantite,
        ]);

        CommandeItem::create([
            'commande_id'   => $commande->id,
            'burger_id'     => $burger->id,
            'quantite'      => $request->quantite,
            'prix_unitaire' => $burger->prix,
        ]);

        $burger->decrement('stock', $request->quantite);

        Mail::to(auth()->user()->email)
            ->send(new CommandeConfirmation(
                $commande->load('items.burger', 'user')
            ));

        return back()->with('success', 'Commande passée avec succès !');
    }

    public function showClient($id)
    {
        $commande = Commande::with(['items.burger', 'paiement'])
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        return view('client/commandes/show', compact('commande'));
    }


    public function annulerClient($id)
    {
        $commande = Commande::where('user_id', auth()->id())
            ->findOrFail($id);

        // On peut annuler seulement si en attente
        if ($commande->statut !== 'en_attente') {
            return back()->with('error', 'Impossible d\'annuler cette commande !');
        }

        // Remettre le stock
        foreach ($commande->items as $item) {
            $item->burger->increment('stock', $item->quantite);
        }

        $commande->update(['statut' => 'annulee']);

        return back()->with('success', 'Commande annulée avec succès !');
    }
}
