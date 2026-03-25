<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Burger extends Model
{
    protected $fillable = ['categorie_id', 'nom', 'prix', 'description', 'image', 'stock', 'actif'];

    /*
     * Un burger appartient à une catégorie
     */
    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

    /*
     * Un burger peut être dans plusieurs items de commande
     */
    public function commandeItems()
    {
        return $this->hasMany(CommandeItem::class);
    }

    /*
     * Vérifie si le burger est disponible
     */
    public function estDisponible()
    {
        return $this->actif && $this->stock > 0;
    }
}
