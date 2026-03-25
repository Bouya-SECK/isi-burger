<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Categorie;
use App\Models\Burger;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Créer le gestionnaire
        User::create([
            'name'     => 'Gestionnaire',
            'email'    => 'gestionnaire@isiburger.com',
            'password' => bcrypt('password'),
            'role'     => 'gestionnaire',
        ]);

        // Créer un client test
        User::create([
            'name'     => 'Client Test',
            'email'    => 'client@isiburger.com',
            'password' => bcrypt('password'),
            'role'     => 'client',
        ]);

        // Créer des catégories
        $classic  = Categorie::create(['nom' => 'Classic']);
        $spicy    = Categorie::create(['nom' => 'Spicy']);
        $veggie   = Categorie::create(['nom' => 'Veggie']);

        // Créer des burgers
        Burger::create([
            'categorie_id' => $classic->id,
            'nom'          => 'ISI Classic',
            'prix'         => 2500,
            'description'  => 'Le burger classique avec steak, salade, tomate et sauce maison.',
            'stock'        => 20,
            'actif'        => true,
        ]);

        Burger::create([
            'categorie_id' => $spicy->id,
            'nom'          => 'ISI Spicy',
            'prix'         => 3000,
            'description'  => 'Pour les amateurs de piment, avec sauce piquante et jalapeños.',
            'stock'        => 15,
            'actif'        => true,
        ]);

        Burger::create([
            'categorie_id' => $veggie->id,
            'nom'          => 'ISI Veggie',
            'prix'         => 2000,
            'description'  => 'Galette végétale, avocat frais et légumes croquants.',
            'stock'        => 0,
            'actif'        => true,
        ]);
    }
}
