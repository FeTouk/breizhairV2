<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FlightController extends Controller
{
    /**
     * Affiche la page "Mes vols" avec les statistiques du pilote.
     */
    public function index()
    {
        // On récupère l'utilisateur actuellement connecté
        $user = Auth::user();

        // Données d'exemple pour le tableau des vols.
        // Plus tard, vous remplacerez ceci par une vraie requête à la base de données,
        // par exemple : $flights = $user->flights()->latest()->take(10)->get();
        $flights = [
            ['date' => '2025-08-30', 'departure' => 'LFRB', 'arrival' => 'LFRS', 'distance' => 150, 'duration' => '1h 05m', 'validator' => 'Admin', 'status' => 'Validé'],
            ['date' => '2025-08-28', 'departure' => 'LFRB', 'arrival' => 'LFPO', 'distance' => 250, 'duration' => '1h 45m', 'validator' => '-', 'status' => 'En attente'],
            ['date' => '2025-08-25', 'departure' => 'EGLL', 'arrival' => 'LFRB', 'distance' => 300, 'duration' => '2h 10m', 'validator' => 'Admin', 'status' => 'Refusé'],
        ];

        // On renvoie la vue 'flights' en lui passant les variables $user et $flights
        return view('flights', [
            'user' => $user,
            'flights' => $flights,
        ]);
    }
}

