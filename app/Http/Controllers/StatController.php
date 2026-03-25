<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Paiement;
use App\Models\Burger;
use App\Models\Categorie;
use Carbon\Carbon;

class StatController extends Controller
{
    public function index()
    {
        // Commandes par mois (12 derniers mois)
        $commandesParMois = [];
        $labels = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $labels[] = $date->translatedFormat('M Y');
            $commandesParMois[] = Commande::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }

        // Produits par catégorie
        $categories = Categorie::withCount('burgers')->get();
        $catLabels  = $categories->pluck('nom')->toArray();
        $catData    = $categories->pluck('burgers_count')->toArray();

        // Recettes par mois
        $recettesParMois = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $recettesParMois[] = Paiement::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->sum('montant');
        }

        return view('gestionnaire.stats', compact(
            'labels',
            'commandesParMois',
            'catLabels',
            'catData',
            'recettesParMois'
        ));
    }
}
