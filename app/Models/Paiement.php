<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    protected $fillable = ['commande_id', 'montant', 'mode', 'paye_le'];

    // Un paiement appartient à une commande
    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }
}
