@extends('layouts.main')

@section('title', 'Qui sommes nous ?')

@section('content')
    <div class="bg-white rounded-lg shadow-xl p-8 lg:p-12">
        
        <h1 class="text-3xl lg:text-4xl font-bold text-gray-800 mb-8 text-center">
            Qui sommes nous ?
        </h1>
        </br>
        {{-- 👇 MODIFICATION ICI : ajout de "space-y-8" 👇 --}}
        <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed text-justify space-y-8">
            <p>
                Bienvenue chez Breizh'Air, votre compagnie aérienne virtuelle basée à Brest en Bretagne. Chez Breizh'Air, nous avons une passion commune : l'aviation. Nous sommes une communauté de pilotes virtuels passionnés, réunis autour de notre amour pour les vols et les voyages.
            </p>
            <p>
                Notre compagnie opère sur le réseau IVAO, qui est le réseau le plus important pour les vols virtuels dans le monde. Nous proposons des vols réalistes et immersifs sur différentes destinations, que vous pouvez choisir selon vos préférences.
            </p>
            <p>
                Notre compagnie s'engage à fournir un environnement amical et encourageant pour les pilotes passionnés. Nous sommes convaincus que la passion pour le vol est la clé du succès, et nous encourageons nos membres à échanger des idées, des conseils et des techniques pour améliorer leur expérience de vol.
            </p>
            <p>
                Nous sommes fiers de notre base à Brest en Bretagne, qui offre un environnement de vol unique. Nous sommes convaincus que les pilotes passionnés trouveront chez nous une compagnie exceptionnelle et conviviale pour leur passion.
            </p>
            <p>
                Rejoignez-nous aujourd'hui chez Breizh'Air, et découvrez une compagnie aérienne où la passion pour le vol est au cœur de tout ce que nous faisons !
            </p>
        </div>

        {{-- Signature alignée à droite --}}
        <div class="mt-12 text-right">
            <p class="text-lg font-bold text-gray-600">Edwyn Chatelin</p>
            <p class="text-md italic text-gray-500">Fondateur</p>
        </div>

    </div>
@endsection