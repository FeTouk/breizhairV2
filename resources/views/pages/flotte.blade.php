@extends('layouts.main')

@section('title', 'En Construction')

@section('content')
    {{-- 
        On utilise Flexbox pour centrer le contenu verticalement et horizontalement.
        min-h-[60vh] assure que le contenu est bien au milieu de la page,
        même s'il y a peu de texte.
    --}}
    <div class="flex flex-col items-center justify-center text-center min-h-[60vh]">

        <div class="text-6xl mb-4">🚧</div>

        <h1 class="text-4xl font-bold text-gray-800">Bientôt disponible</h1>

        <p class="text-xl text-gray-600 mt-2">
            La page que vous demandez est actuellement en cours de construction.
        </p>
        
        <p class="mt-4 text-gray-600">
            Nous travaillons dur pour la finaliser. Merci de votre patience !<br>
            C'est l'heure d'aller manger une crêpe à Plonéis en attendant.
        </p>

        {{-- Voici le nouveau bouton, stylisé avec les mêmes classes que celui du header --}}
        <a href="/" class="mt-8 bg-[#17A4F6] hover:bg-[#138fd9] text-white font-bold py-2 px-4 rounded transition duration-300">
            Retour à l'accueil
        </a>

    </div>
@endsection