<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PilotManagementController extends Controller
{
    /**
     * Affiche la liste de tous les pilotes.
     */
    public function index()
    {
        // On récupère tous les utilisateurs, sauf l'admin actuellement connecté
        $pilots = User::where('id', '!=', auth()->id())->get();
        return view('admin.pilots.index', ['pilots' => $pilots]);
    }

    /**
     * Affiche le formulaire pour modifier un pilote.
     */
    public function edit(User $pilot)
    {
        return view('admin.pilots.edit', ['pilot' => $pilot]);
    }

    /**
     * Met à jour les informations d'un pilote dans la base de données.
     */
    public function update(Request $request, User $pilot)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'callsign' => 'required|string|max:255|unique:users,callsign,' . $pilot->id,
            'role' => 'required|in:user,admin',
            'status' => 'required|in:pending,active,inactive',
            'grade' => 'required|string',
            'skycoins' => 'required|integer',
        ]);

        $pilot->first_name = $validated['first_name'];
        $pilot->last_name = $validated['last_name'];
        $pilot->callsign = $validated['callsign'];
        $pilot->role = $validated['role'];
        $pilot->status = $validated['status'];
        $pilot->grade = $validated['grade'];
        $pilot->skycoins = $validated['skycoins'];
        
        $isSaved = $pilot->save();

        dd($isSaved, $pilot); // Debugging line

        if ($isSaved) {
            return redirect()->route('pilots.index')->with('success', 'Le profil du pilote a été mis à jour avec succès.');
        } else {
            return redirect()->route('pilots.edit', $pilot)->with('error', 'La mise à jour a échoué. Un événement système a peut-être annulé l\'opération.');
        }
    }

    /**
     * Supprime un pilote de la base de données.
     */
    public function destroy(User $pilot)
    {
        $pilot->delete();

        return redirect()->route('pilots.index')->with('success', 'Le pilote a été supprimé avec succès.');
    }

    public function updateSkycoins(Request $request, User $pilot)
    {
        $validated = $request->validate([
            'operation' => 'required|in:add,subtract,set',
            'amount' => 'required|integer|min:0',
        ]);

        $amount = (int)$validated['amount'];

        switch ($validated['operation']) {
            case 'add':
                $pilot->skycoins += $amount;
                break;
            case 'subtract':
                $pilot->skycoins -= $amount;
                break;
            case 'set':
                $pilot->skycoins = $amount;
                break;
        }

        $isSaved = $pilot->save();

        if ($isSaved) {
            return redirect()->route('pilots.edit', $pilot)->with('success', 'Les SkyCoins ont été mis à jour.');
        } else {
            return redirect()->route('pilots.edit', $pilot)->with('error', 'La mise à jour des SkyCoins a échoué (opération annulée).');
        }
    }
}
