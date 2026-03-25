<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    protected $fillable = ['nom'];

    // Une catégorie a plusieurs burgers
    public function burgers()
    {
        return $this->hasMany(Burger::class);
    }
}
