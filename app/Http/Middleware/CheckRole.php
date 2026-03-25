<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role)
    {
        /*
         * Vérifie si l'utilisateur est connecté et a le bon rôle
         * Role : il est soit gestionnaire ou client
         */
        if (!auth()->check() || auth()->user()->role !== $role) {
            abort(403, 'Accès non autorisé.');
        }

        return $next($request);
    }
}
