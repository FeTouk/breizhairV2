<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // On utilise le chemin complet de la façade Auth
use Symfony\Component\HttpFoundation\Response;

class CheckIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Si l'utilisateur est connecté ET que son rôle est 'admin'
        if (Auth::check() && Auth::user()->role == 'admin') {
            // On le laisse passer
            return $next($request);
        }

        // Sinon, on bloque l'accès avec une erreur 403 (Accès non autorisé)
        abort(403, 'Accès non autorisé.');
    }
}