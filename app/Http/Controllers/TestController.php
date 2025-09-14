<?php

namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{
    public function show()
    {
        $questions = Test::inRandomOrder()->limit(10)->get();
        return view('test.qcm', ['questions' => $questions]);
    }

    public function verify(Request $request)
    {
        $score = 0;
        $reponses = $request->input('reponses');

        if (is_null($reponses)) {
            return back()->withErrors(['message' => 'Vous devez répondre à au moins une question pour valider le test.']);
        }

        $questionIds = array_keys($reponses);
        $questionsCorrectes = Test::whereIn('id', $questionIds)->pluck('reponse_correcte', 'id');

        foreach ($reponses as $questionId => $reponseUtilisateur) {
            if (isset($questionsCorrectes[$questionId]) && $questionsCorrectes[$questionId] == $reponseUtilisateur) {
                $score += 2;
            }
        }

        $user = Auth::user();

        if ($score >= 16) {
            // Génération de l'indicatif de vol
            $firstNameInitial = strtoupper(substr($user->first_name, 0, 1));
            $lastNameInitial = strtoupper(substr($user->last_name, 0, 1));
            $randomNumber = rand(10, 99);
            $callsign = 'BZH' . $randomNumber . $firstNameInitial . $lastNameInitial;
            
            // Mise à jour de l'utilisateur avec son nouveau statut et son indicatif
            $user->status = 'active';
            $user->callsign = $callsign;
            $user->save();

            // Redirection vers le tableau de bord avec les informations pour le popup
            return redirect()->route('dashboard')->with([
                'test_passed' => true,
                'score' => $score,
                'callsign' => $callsign
            ]);
        
        } else {
            // L'utilisateur a échoué, on le déconnecte et on supprime son compte
            Auth::logout();
            $user->delete();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/')->with('error', 'Votre score est insuffisant. Votre inscription a été annulée. Vous pouvez vous réinscrire pour retenter.');
        }
    }
}

