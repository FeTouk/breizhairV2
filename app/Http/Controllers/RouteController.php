<?php

namespace App\Http\Controllers;

use App\Models\Route as FlightRoute;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    /**
     * Affiche la liste des lignes de la compagnie pour les pilotes.
     */
    public function index(Request $request)
    {
        $query = FlightRoute::query();
        $currentAirac = getCurrentAiracIdentifier();

        // Filtre par type de ligne
        if ($request->filled('line_type')) {
            $query->where('line_type', $request->line_type);
        }

        // Filtre par type d'appareil
        if ($request->filled('aircraft_type')) {
            $query->where('aircraft_type', $request->aircraft_type);
        }

        // Filtre par statut AIRAC
        if ($request->filled('airac_status')) {
            if ($request->airac_status === 'valid') {
                $query->where('validated_airac', $currentAirac);
            } elseif ($request->airac_status === 'expired') {
                $query->where(function ($q) use ($currentAirac) {
                    $q->where('validated_airac', '!=', $currentAirac)
                      ->orWhereNull('validated_airac');
                });
            }
        }

        // Filtre par ICAO de départ ou d'arrivée
        if ($request->filled('icao')) {
            $icao = strtoupper($request->icao);
            $query->where(function ($q) use ($icao) {
                $q->where('departure_icao', 'LIKE', "%{$icao}%")
                  ->orWhere('arrival_icao', 'LIKE', "%{$icao}%");
            });
        }

        $routes = $query->orderBy('id')->get();
        
        // On récupère les listes uniques pour les filtres
        $lineTypes = FlightRoute::distinct()->pluck('line_type')->sort();
        $aircraftTypes = FlightRoute::distinct()->whereNotNull('aircraft_type')->pluck('aircraft_type')->sort();
        
        // On passe les routes et le cycle actuel à la vue
        return view('routes.index', compact('routes', 'currentAirac', 'lineTypes', 'aircraftTypes'));
    }
}

