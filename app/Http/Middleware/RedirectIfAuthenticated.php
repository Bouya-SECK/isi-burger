<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {

                // Redirection selon le rôle
                if (Auth::user()->role === 'gestionnaire') {
                    return redirect('/gestionnaire/dashboard');
                }

                return redirect('/client/catalogue');
            }
        }

        return $next($request);
    }
}
