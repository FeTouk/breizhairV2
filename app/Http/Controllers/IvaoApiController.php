<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class IvaoApiController extends Controller
{
    public function getRecentFlights()
    {
        $user = Auth::user();
        if (!$user || !$user->ivao_vid) {
            return response()->json(['error' => 'VID IVAO non trouvé sur votre profil.'], 404);
        }

        // Pour ce test, la clé API est en dur. En production, elle devrait venir de config/services.php
        $apiKey = 'SA9NKSNZMCC9WIB9RC18V5W7H3KOYQTA';
        
        if (empty($apiKey) || $apiKey === 'VOTRE_VRAIE_CLE_API_ICI') {
            Log::error('IVAO API Key is not set directly in the controller for debugging.');
            return response()->json(['error' => 'La clé d\'API de test n\'est pas configurée dans le contrôleur.'], 500);
        }

        $vid = $user->ivao_vid;
        $sessionsApiUrl = "https://api.ivao.aero/v2/tracker/sessions?page=1&userId={$vid}";

        try {
            $response = Http::withoutVerifying()
                            ->withHeaders(['apiKey' => $apiKey])
                            ->get($sessionsApiUrl);

            if ($response->failed()) {
                Log::error('IVAO Sessions API call failed.', [
                    'vid' => $vid,
                    'status_code' => $response->status(),
                    'response_body' => $response->body(),
                ]);
                return response()->json(['error' => 'Impossible de contacter l\'API des sessions IVAO.'], 500);
            }

            $sessions = $response->json() ?? [];

            if (empty($sessions)) {
                return response()->json(['error' => 'Aucune session de vol récente n\'a été trouvée.'], 404);
            }

            // On filtre les sessions pour ne garder que celles avec un plan de vol valide
            $validSessions = collect($sessions)->filter(function ($session) {
                return !empty($session['flightplan']) && !empty($session['flightplan']['departureId']) && !empty($session['flightplan']['arrivalId']);
            });

            if ($validSessions->isEmpty()) {
                return response()->json(['error' => 'Aucun de vos vols récents ne contenait de plan de vol valide.'], 404);
            }

            // On formate les données pour qu'elles soient faciles à utiliser
            $formattedFlights = $validSessions->map(function ($session) {
                $flightplan = $session['flightplan'];
                
                return [
                    'id' => $session['id'],
                    'callsign' => $session['callsign'] ?? 'N/A',
                    // 👇 C'est ici que l'on récupère le code OACI de départ 👇
                    'departure' => $flightplan['departureId'],
                    // 👇 Et ici, celui d'arrivée 👇
                    'arrival' => $flightplan['arrivalId'],
                ];
            })->values();

            return response()->json([
                'message' => "Nous avons trouvé {$formattedFlights->count()} vol(s) récent(s) avec un plan de vol.",
                'flights' => $formattedFlights,
            ]);

        } catch (\Exception $e) {
            Log::error('IVAO Sessions API Exception', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'Erreur lors de la récupération des données des sessions.'], 500);
        }
    }
}

