<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Affiche la page du formulaire de contact.
     * C'est cette méthode qui est appelée par votre route GET /contact.
     */
    public function create()
    {
        return view('pages.contact');
    }

    /**
     * Traite les données soumises par le formulaire de contact.
     * C'est cette méthode qui est appelée par votre route POST /contact.
     */
    public function store(Request $request)
    {
        // Pour l'instant, nous allons simplement afficher les données
        // que nous recevons pour vérifier que tout le circuit fonctionne.
        
        $data = $request->all(); // Récupère toutes les données du formulaire

        // C'est un outil de débogage de Laravel qui signifie "Dump and Die".
        // Il affiche le contenu d'une variable puis arrête l'exécution.
        // Vous le retirerez plus tard.
        dd($data);

        // --- ÉTAPE SUIVANTE (POUR LE FUTUR) ---
        // Plus tard, ici, vous ajouterez le code pour envoyer un e-mail
        // ou enregistrer le message dans la base de données.
        // Par exemple :
        // Mail::to('votre.email@test.com')->send(new ContactMail($data));
        //
        // return redirect()->back()->with('success', 'Votre message a bien été envoyé !');
    }
}