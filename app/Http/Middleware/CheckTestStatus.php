<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckTestStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // On vérifie si l'utilisateur est connecté et si son statut est 'pending_test'
        if (Auth::check() && Auth::user()->status === 'pending_test') {
            // Si c'est le cas, on le redirige vers la page du test avec un message
            return redirect()->route('test.show')->with('error', 'Vous devez réussir le test d\'entrée pour accéder à l\'espace pilote.');
        }

        // Si son statut est 'active' (ou autre), on le laisse passer
        return $next($request);
    }
}

