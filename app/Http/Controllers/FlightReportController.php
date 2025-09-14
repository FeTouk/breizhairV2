<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class FlightReportController extends Controller
{
    /**
     * Valide et stocke un nouveau rapport de vol dans la base de données.
     */
    public function store(Request $request)
    {
        // 1. Validation des données du formulaire, incluant les nouveaux champs
        $validatedData = $request->validate([
            'departure_icao' => 'required|string|alpha|size:4',
            'arrival_icao' => 'required|string|alpha|size:4',
            'flight_date' => 'required|date',
            'departure_time' => 'required|date_format:H:i',
            'arrival_time' => 'required|date_format:H:i',
            'route' => 'nullable|string',
            'comments' => 'nullable|string',
            'is_breizhair_event' => 'nullable|boolean',
            'is_ivao_event' => 'nullable|boolean',
        ]);

        // 2. Calcul du temps de vol
        $departureTime = Carbon::parse($validatedData['departure_time']);
        $arrivalTime = Carbon::parse($validatedData['arrival_time']);

        if ($arrivalTime->lessThan($departureTime)) {
            $arrivalTime->addDay();
        }
        $durationInMinutes = $arrivalTime->diffInMinutes($departureTime);

        // 3. Création du rapport de vol dans la base de données
        Flight::create([
            'user_id' => Auth::id(),
            'departure_icao' => strtoupper($validatedData['departure_icao']),
            'arrival_icao' => strtoupper($validatedData['arrival_icao']),
            'flight_date' => $validatedData['flight_date'],
            'departure_time' => $validatedData['departure_time'], // On sauvegarde l'heure de départ
            'arrival_time' => $validatedData['arrival_time'], // On sauvegarde l'heure d'arrivée
            'flight_duration' => $durationInMinutes,
            'route' => $validatedData['route'], // On sauvegarde la route
            'comments' => $validatedData['comments'],
            'is_breizhair_event' => $request->has('is_breizhair_event'),
            'is_ivao_event' => $request->has('is_ivao_event'),
            'status' => 'En attente',
        ]);

        // 4. Redirection vers la page "Mes vols" avec un message de succès
        return redirect()->route('flights.index')->with('success', 'Votre rapport de vol a bien été envoyé et est en attente de validation.');
    }
}

