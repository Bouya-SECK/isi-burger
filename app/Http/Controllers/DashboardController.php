<?php
namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Burger;
use App\Models\Paiement;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // Commandes en cours aujourd'hui
        $commandesEnCours = Commande::whereDate('created_at', $today)
            ->whereIn('statut', ['en_attente', 'en_preparation'])
            ->count();

        // Commandes validées aujourd'hui (prête ou payée)
        $commandesValidees = Commande::whereDate('created_at', $today)
            ->whereIn('statut', ['prete', 'payee'])
            ->count();

        // Recettes du jour
        $recetteJour = Paiement::whereDate('created_at', $today)
            ->sum('montant');

        // Total burgers actifs
        $totalBurgers = Burger::where('actif', true)->count();

        // Dernières commandes
        $dernieresCommandes = Commande::with('user')
            ->latest()
            ->take(8)
            ->get();

        return view('gestionnaire.dashboard', compact(
            'commandesEnCours',
            'commandesValidees',
            'recetteJour',
            'totalBurgers',
            'dernieresCommandes'
        ));
    }
}
