<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FlightReportController extends Controller
{
    /**
     * Valide et stocke un nouveau rapport de vol dans la base de données.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'departure_icao' => 'required|string|alpha|size:4',
            'arrival_icao' => 'required|string|alpha|size:4',
            'comments' => 'nullable|string',
            'is_breizhair_event' => 'nullable|boolean',
            'is_ivao_event' => 'nullable|boolean',
        ]);

        Flight::create([
            'user_id' => Auth::id(),
            'departure_icao' => strtoupper($validatedData['departure_icao']),
            'arrival_icao' => strtoupper($validatedData['arrival_icao']),
            'comments' => $validatedData['comments'],
            'is_breizhair_event' => $request->has('is_breizhair_event'),
            'is_ivao_event' => $request->has('is_ivao_event'),
            'status' => 'En attente',
            // On définit la date du vol à la date du jour par défaut
            'flight_date' => now(), 
        ]);

        return redirect()->route('flights.index')->with('success', 'Votre rapport de vol a bien été envoyé et est en attente de validation.');
    }
}

