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

        $apiKey = config('services.ivao.api_key');
        if (!$apiKey) {
            Log::error('IVAO API Key is not configured in .env file.');
            return response()->json(['error' => 'La clé d\'API IVAO n\'est pas configurée.'], 500);
        }

        $vid = $user->ivao_vid;
        $sessionsApiUrl = "https://api.ivao.aero/v2/tracker/sessions?page=1&userId={$vid}";

        try {
            $response = Http::withoutVerifying()
                            ->withHeaders(['apiKey' => $apiKey])
                            ->get($sessionsApiUrl);

            if ($response->failed()) {
                Log::error('IVAO Sessions API call failed.', ['vid' => $vid, 'status_code' => $response->status(), 'response_body' => $response->body()]);
                return response()->json(['error' => 'Impossible de contacter l\'API des sessions IVAO.'], 500);
            }

            // 👇 CORRECTION 1 : On récupère les données depuis la clé "items" 👇
            $sessions = $response->json()['items'] ?? [];
            Log::info('IVAO Sessions API Response for VID ' . $vid, $sessions);

            if (empty($sessions)) {
                return response()->json(['error' => 'Aucune session de vol récente n\'a été trouvée.'], 404);
            }

            // On filtre les sessions pour ne garder que celles avec un plan de vol valide
            $validSessions = collect($sessions)->filter(function ($session) {
                // 👇 CORRECTION 2 : On vérifie si le tableau "flightPlans" n'est pas vide 👇
                return !empty($session['flightPlans']) && !empty($session['flightPlans'][0]['departureId']) && !empty($session['flightPlans'][0]['arrivalId']);
            });

            if ($validSessions->isEmpty()) {
                return response()->json(['error' => 'Aucun de vos vols récents ne contenait de plan de vol valide.'], 404);
            }

            // On formate les données pour qu'elles soient faciles à utiliser
            $formattedFlights = $validSessions->map(function ($session) {
                // 👇 CORRECTION 3 : On prend le premier plan de vol du tableau 👇
                $flightplan = $session['flightPlans'][0];
                $departureTimestamp = $session['createdAt'] ?? null;
                $arrivalTimestamp = $session['completedAt'] ?? null;

                return [
                    'id' => $session['id'],
                    'callsign' => $session['callsign'] ?? 'N/A',
                    'departure' => $flightplan['departureId'],
                    'arrival' => $flightplan['arrivalId'],
                    'departure_time' => $departureTimestamp ? Carbon::parse($departureTimestamp)->format('H:i') : '',
                    'arrival_time' => $arrivalTimestamp ? Carbon::parse($arrivalTimestamp)->format('H:i') : '',
                    'flight_date' => $departureTimestamp ? Carbon::parse($departureTimestamp)->format('Y-m-d') : '',
                    'route' => $flightplan['route'] ?? '',
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

