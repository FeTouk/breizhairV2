<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;

class IvaoApiController extends Controller
{
    /**
     * Récupère les informations du dernier vol d'un utilisateur depuis l'API d'IVAO.
     */
    public function getLastFlight()
    {
        $user = Auth::user();
        // On vérifie que l'utilisateur a bien un VID et un Callsign enregistrés
        if (!$user || !$user->ivao_vid || !$user->callsign) {
            return response()->json(['error' => 'VID IVAO ou Callsign non trouvé sur votre profil.'], 404);
        }

        $vid = $user->ivao_vid;
        $callsign = $user->callsign;
        $whazzupUrl = 'https://api.ivao.aero/v2/tracker/whazzup';

        try {
            $apiKey = config('services.ivao.api_key');
            $response = Http::withHeaders(array_filter(['apiKey' => $apiKey]))->get($whazzupUrl);

            if ($response->failed()) {
                return response()->json(['error' => 'Impossible de contacter l\'API IVAO pour le moment.'], 500);
            }

            $pilots = $response->json()['clients']['pilots'] ?? [];

            // On filtre la liste de tous les pilotes en ligne pour trouver :
            // 1. Ceux qui correspondent au VID de notre utilisateur.
            // 2. Parmi ceux-là, celui qui utilise l'indicatif de la compagnie.
            $userFlight = collect($pilots)
                ->where('userId', $vid)
                ->where('callsign', $callsign)
                ->first(); // On prend le premier (et seul) résultat

            if (!$userFlight) {
                return response()->json(['error' => 'Aucun vol récent avec votre indicatif BZH trouvé sur le réseau.'], 404);
            }

            $flightPlan = $userFlight['flightPlan'] ?? [];
            
            // On formate l'heure de départ prévue (ex: "1830" -> "18:30")
            $departureTime = isset($flightPlan['departureTime']) ? substr_replace($flightPlan['departureTime'], ':', 2, 0) : '';

            // On renvoie les données formatées au formulaire
            return response()->json([
                'departure' => $flightPlan['departureId'] ?? '',
                'arrival' => $flightPlan['arrivalId'] ?? '',
                'date' => Carbon::parse($userFlight['lastTrack']['date'])->format('Y-m-d'),
                'route' => $flightPlan['route'] ?? '',
                'departure_time' => $departureTime,
                // L'API ne fournit pas l'heure d'arrivée réelle, le pilote devra la remplir.
                'arrival_time' => '', 
            ]);

        } catch (\Exception $e) {
            // En cas d\'erreur inattendue (ex: format de l\'API qui change)
            return response()->json(['error' => 'Erreur lors de la récupération des données de vol.'], 500);
        }
    }

    public function testIvaoVid($vid)
    {
        $whazzupUrl = 'https://api.ivao.aero/v2/tracker/whazzup';

        try {
            $apiKey = config('services.ivao.api_key');
            $response = Http::withHeaders(array_filter(['apiKey' => $apiKey]))->get($whazzupUrl);

            if ($response->failed()) {
                return response()->json(['error' => 'Impossible de contacter l\'API IVAO pour le moment.'], 500);
            }

            $pilots = $response->json()['clients']['pilots'] ?? [];

            $userFlight = collect($pilots)
                ->where('userId', $vid)
                ->first();

            if (!$userFlight) {
                return response()->json(['error' => 'Aucun vol trouvé pour ce VID sur le réseau.'], 404);
            }

            return response()->json([
                'vid' => $userFlight['userId'],
                'callsign' => $userFlight['callsign'],
                'departure' => $userFlight['flightPlan']['departureId'] ?? '',
                'arrival' => $userFlight['flightPlan']['arrivalId'] ?? '',
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur lors de la récupération des données de vol.', 'message' => $e->getMessage()], 500);
        }
    }
}
