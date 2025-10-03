<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Route as FlightRoute;
use Illuminate\Http\Request;

class RouteManagementController extends Controller
{
    /**
     * Affiche la liste des lignes de la compagnie, potentiellement filtrée.
     */
    public function index(Request $request)
    {
        $query = FlightRoute::query();
        $currentAirac = getCurrentAiracIdentifier();

        if ($request->filled('line_type')) {
            $query->where('line_type', $request->line_type);
        }
        if ($request->filled('aircraft_type')) {
            $query->where('aircraft_type', $request->aircraft_type);
        }
        if ($request->filled('airac_status')) {
            if ($request->airac_status === 'valid') {
                $query->where('validated_airac', $currentAirac);
            } elseif ($request->airac_status === 'expired') {
                $query->where(function ($q) use ($currentAirac) {
                    $q->where('validated_airac', '!=', $currentAirac)->orWhereNull('validated_airac');
                });
            }
        }
        
        $routes = $query->orderBy('id')->get();
        
        // On récupère spécifiquement la liste des routes qui ne sont pas à jour pour le modal
        $routesToValidate = FlightRoute::where('validated_airac', '!=', $currentAirac)
            ->orWhereNull('validated_airac')
            ->get();

        $lineTypes = ['Régulière', 'Saisonnière', 'Evenement', 'Temporaire'];
        $aircraftTypes = ['Local', 'Régional', 'Moyen courrier', 'Long courrier'];

        return view('admin.routes.index', compact('routes', 'currentAirac', 'lineTypes', 'aircraftTypes', 'routesToValidate'));
    }

    /**
     * Affiche le formulaire de création d'une nouvelle ligne.
     */
    public function create()
    {
        $airacCycles = getAiracData();
        return view('admin.routes.create', compact('airacCycles'));
    }

    /**
     * Sauvegarde une nouvelle ligne dans la base de données.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'line_type' => 'required|string',
            'aircraft_type' => 'nullable|string',
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
        $airacCycles = getAiracData();
        return view('admin.routes.edit', compact('route', 'airacCycles'));
    }

    /**
     * Met à jour une ligne existante dans la base de données.
     */
    public function update(Request $request, FlightRoute $route)
    {
        $validated = $request->validate([
            'line_type' => 'required|string',
            'aircraft_type' => 'nullable|string',
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

    /**
     * Met à jour le statut AIRAC d'une route via une requête AJAX depuis le modal.
     */
    public function updateAirac(Request $request, FlightRoute $route)
    {
        $validated = $request->validate([
            'action' => 'required|in:validate,invalidate',
        ]);

        if ($validated['action'] === 'validate') {
            $route->update(['validated_airac' => getCurrentAiracIdentifier()]);
        } elseif ($validated['action'] === 'invalidate') {
            $route->update(['validated_airac' => null]);
        }

        return response()->json(['success' => true, 'message' => 'Statut de la route mis à jour.']);
    }
}

