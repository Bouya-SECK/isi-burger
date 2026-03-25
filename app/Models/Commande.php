<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    protected $fillable = ['user_id', 'statut', 'total', 'payee_le'];

    // Une commande appartient à un client
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Une commande a plusieurs items
    public function items()
    {
        return $this->hasMany(CommandeItem::class);
    }

    // Une commande a un paiement
    public function paiement()
    {
        return $this->hasOne(Paiement::class);
    }

    // Calcule le total de la commande
    public function calculerTotal()
    {
        $total = $this->items->sum(function ($item) {
            return $item->quantite * $item->prix_unitaire;
        });
        $this->update(['total' => $total]);
        return $total;
    }
}
