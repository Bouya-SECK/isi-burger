<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role'];

    protected $hidden = ['password', 'remember_token'];

    // Un user peut avoir plusieurs commandes
    public function commandes()
    {
        return $this->hasMany(Commande::class);
    }

    public function isGestionnaire()
    {
        return $this->role === 'gestionnaire';
    }

    public function isClient()
    {
        return $this->role === 'client';
    }
}
