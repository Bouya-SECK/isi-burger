<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommandeItem extends Model
{
    protected $fillable = ['commande_id', 'burger_id', 'quantite', 'prix_unitaire'];

    // Un item appartient à une commande
    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }

    // Un item correspond à un burger
    public function burger()
    {
        return $this->belongsTo(Burger::class);
    }

    // Sous-total de cet item
    public function sousTotal()
    {
        return $this->quantite * $this->prix_unitaire;
    }
}
