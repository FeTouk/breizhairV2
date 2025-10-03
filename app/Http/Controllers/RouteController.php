<?php

namespace App\Http\Controllers;

use App\Models\Route as FlightRoute;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    /**
     * Affiche la liste des lignes de la compagnie pour les pilotes.
     */
    public function index()
    {
        $routes = FlightRoute::orderBy('id')->get();
        
        // On récupère l'identifiant du cycle AIRAC en cours pour l'affichage
        $currentAirac = getCurrentAiracIdentifier();
        
        // On passe les routes et le cycle actuel à la vue
        return view('routes.index', compact('routes', 'currentAirac'));
    }
}

