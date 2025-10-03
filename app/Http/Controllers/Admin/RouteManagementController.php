<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Route as FlightRoute;
use Illuminate\Http\Request;

class RouteManagementController extends Controller
{
    /**
     * Affiche la liste de toutes les lignes.
     */
    public function index()
    {
        // On trie par ID car 'flight_number' n'existe plus
        $routes = FlightRoute::orderBy('id')->get();
        // On récupère l'identifiant du cycle AIRAC en cours pour l'affichage
        $currentAirac = getCurrentAiracIdentifier();
        return view('admin.routes.index', compact('routes', 'currentAirac'));
    }

    /**
     * Affiche le formulaire de création d'une nouvelle ligne.
     */
    public function create()
    {
        // On récupère la liste des cycles AIRAC pour le menu déroulant
        $airacCycles = getAiracData();
        return view('admin.routes.create', compact('airacCycles'));
    }

    /**
     * Sauvegarde une nouvelle ligne dans la base de données.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'aircraft_type' => 'nullable|string',
            'line_type' => 'required|string',
            'departure_icao' => 'required|string|size:4|uppercase',
            'arrival_icao' => 'required|string|size:4|uppercase',
            'route_string' => 'nullable|string',
            'validated_airac' => 'nullable|string',
            'remarks' => 'nullable|string',
        ]);

        FlightRoute::create($validated);
        return redirect()->route('admin.routes.index')->with('success', 'La ligne a été créée avec succès.');
    }

    /**
     * Affiche le formulaire pour modifier une ligne existante.
     */
    public function edit(FlightRoute $route)
    {
        // On passe les données de la route ET la liste des cycles AIRAC à la vue
        $airacCycles = getAiracData();
        return view('admin.routes.edit', compact('route', 'airacCycles'));
    }

    /**
     * Met à jour une ligne existante dans la base de données.
     */
    public function update(Request $request, FlightRoute $route)
    {
        $validated = $request->validate([
            'aircraft_type' => 'nullable|string',
            'line_type' => 'required|string',
            'departure_icao' => 'required|string|size:4|uppercase',
            'arrival_icao' => 'required|string|size:4|uppercase',
            'route_string' => 'nullable|string',
            'validated_airac' => 'nullable|string',
            'remarks' => 'nullable|string',
        ]);

        $route->update($validated);
        return redirect()->route('admin.routes.index')->with('success', 'La ligne a été mise à jour avec succès.');
    }

    /**
     * Supprime une ligne de la base de données.
     */
    public function destroy(FlightRoute $route)
    {
        $route->delete();
        return redirect()->route('admin.routes.index')->with('success', 'La ligne a été supprimée avec succès.');
    }
}

