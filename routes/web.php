<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\BurgerController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StatController;

// Page d'accueil → login
Route::get('/', function () {
    return redirect('/login');
});

// Auth
Route::get('/login',  [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout',[AuthenticatedSessionController::class, 'destroy'])->name('logout');


require __DIR__.'/auth.php';

// ****************** GESTIONNAIRE ************************
Route::middleware(['auth', 'role:gestionnaire'])->prefix('gestionnaire')->name('gestionnaire.')->group(function ()
{

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('burgers', BurgerController::class);

    Route::get('/commandes', [CommandeController::class, 'indexGestionnaire'])->name('commandes.index');

    Route::get('/commandes/{commande}', [CommandeController::class, 'show'])->name('commandes.show');

    Route::patch('/commandes/{commande}/statut', [CommandeController::class, 'updateStatut'])->name('commandes.statut');

    Route::patch('/commandes/{commande}/annuler', [CommandeController::class, 'annuler'])->name('commandes.annuler');

    Route::delete('/commandes/{commande}', [CommandeController::class, 'supprimer'])->name('commandes.supprimer');

    Route::post('/paiements/{commande}', [PaiementController::class, 'store'])->name('paiements.store');

    Route::get('/stats', [StatController::class, 'index'])->name('stats');
});



// ********************** CLIENT ***********************
Route::middleware(['auth', 'role:client'])->prefix('client')->name('client.')->group(function ()
{

    Route::get('/catalogue', [BurgerController::class, 'catalogue'])->name('catalogue');

    Route::get('/burgers/{burger}', [BurgerController::class, 'detail'])->name('burgers.detail');

    Route::get('/commandes', [CommandeController::class, 'indexClient'])->name('commandes.index');

    Route::post('/commandes', [CommandeController::class, 'store'])->name('commandes.store');

    Route::get('/commandes/{commande}', [CommandeController::class, 'showClient'])->name('commandes.show');

    Route::patch('/commandes/{commande}/annuler', [CommandeController::class, 'annulerClient'])->name('commandes.annuler');

});
