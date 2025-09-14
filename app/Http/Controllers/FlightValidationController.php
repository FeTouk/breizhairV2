<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon; // On importe Carbon pour la gestion du temps
use Illuminate\Support\Facades\Auth;

class FlightValidationController extends Controller
{
    public function index()
    {
        $flights = Flight::where('status', 'En attente')->with('user')->latest()->get();
        return view('admin.flights.index', ['flights' => $flights]);
    }

    public function show(Flight $flight)
    {
        return view('admin.flights.show', ['flight' => $flight]);
    }

    public function update(Request $request, Flight $flight)
    {
        if ($request->input('decision') === 'reject') {
            $flight->update([
                'status' => 'Refusé',
                'validated_by' => Auth::id(),
                'validation_comments' => $request->validation_comments,
            ]);
            return redirect()->route('flights.validation.index')->with('success', 'Le rapport de vol a été refusé.');
        }

        // Si la décision est d'accepter
        $validated = $request->validate([
            'nautical_miles' => 'required|integer|min:0',
            'departure_time' => 'required|date_format:H:i',
            'arrival_time' => 'required|date_format:H:i', // On ne peut plus valider "after" directement
            'validation_comments' => 'nullable|string',
        ]);

        // Mise à jour du rapport de vol
        $flight->update([
            'status' => 'Validé',
            'nautical_miles' => $validated['nautical_miles'],
            'departure_time' => $validated['departure_time'],
            'arrival_time' => $validated['arrival_time'],
            'validated_by' => Auth::id(),
            'validation_comments' => $validated['validation_comments'],
        ]);

        // Incrémentation des statistiques du pilote
        $pilot = $flight->user;
        $pilot->increment('total_flights');
        $pilot->increment('total_nautical_miles', $validated['nautical_miles']);
        $pilot->increment('total_flight_hours', $flight->flight_duration); // On ajoute les minutes au total

        return redirect()->route('flights.validation.index')->with('success', 'Le rapport de vol a été validé avec succès !');
    }
}

