<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SkyVectorApiController extends Controller
{
    public function getDistance(Request $request)
    {
        $request->validate([
            'departure' => 'required|string|size:4',
            'arrival' => 'required|string|size:4',
            'route' => 'nullable|string',
        ]);

        $fpl = trim($request->departure . ' ' . $request->route . ' ' . $request->arrival);
        $skyVectorUrl = 'https://skyvector.com/?fpl=' . urlencode($fpl);

        try {
            $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36'
            ])->get($skyVectorUrl);

            if ($response->failed()) {
                return response()->json(['error' => 'Impossible de contacter SkyVector.'], 500);
            }

            $htmlBody = $response->body();

            // 👇 MODIFICATION ICI : Nouvelle expression régulière plus robuste 👇
            // Elle cherche "Dist:" dans une cellule de tableau, suivi d'une autre cellule contenant la distance.
            preg_match('/>Dist:\s*<\/td>\s*<td>\s*([\d\.]+)\s*NM</', $htmlBody, $matches);

            if (isset($matches[1])) {
                return response()->json(['distance' => round((float)$matches[1])]);
            }
            
            // Si la distance n'est toujours pas trouvée, on logue la réponse pour le débogage.
            Log::error('SkyVector API: Distance pattern not found in response.', ['url' => $skyVectorUrl, 'response_body' => $htmlBody]);

            return response()->json(['error' => 'Distance non trouvée. Vérifiez les OACI et la route.'], 404);

        } catch (\Exception $e) {
            Log::error('SkyVector API: Exception caught.', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'Erreur lors de la communication avec SkyVector.'], 500);
        }
    }
}

