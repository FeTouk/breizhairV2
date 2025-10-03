<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FlightController extends Controller
{
    /**
     * Affiche la page "Mes vols" avec les statistiques et les 10 derniers vols du pilote.
     */
    public function index()
    {
        $user = Auth::user();
        $flights = $user->flights()->latest()->take(10)->get();
        
        return view('flights', ['user' => $user, 'flights' => $flights]);
    }
}

