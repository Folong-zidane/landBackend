<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // Vérifie si l'utilisateur est authentifié et s'il est un administrateur
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }

        // Si l'utilisateur n'est pas un administrateur, renvoie une erreur 403
        return response()->json(['error' => 'Forbidden'], 403);
    }
}
