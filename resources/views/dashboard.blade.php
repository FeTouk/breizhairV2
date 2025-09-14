<x-app-layout>
    {{-- 
        On utilise Alpine.js pour gérer l'affichage du popup de bienvenue.
        La variable est initialisée en fonction de la présence d'un message flash de la session.
    --}}
    <div x-data="{ showWelcomePopup: {{ session('test_passed') ? 'true' : 'false' }} }">
        
        {{-- Contenu principal du tableau de bord --}}
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

                {{-- Bloc 1: Titre de la page --}}
                <div class="bg-white p-6 rounded-lg shadow-md text-center">
                    <h1 class="text-3xl font-bold text-gray-800">Espace pilote</h1>
                    <p class="text-lg text-gray-600 mt-1">Gérez votre carrière chez Breizh'Air.</p>
                </div>

                {{-- Bloc 2: Grille de statistiques --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    
                    {{-- Callsign --}}
                    <div class="bg-white p-6 rounded-lg shadow-md text-center">
                        <p class="text-3xl font-mono font-bold text-[#17A4F6]">{{ Auth::user()->callsign ?? 'N/A' }}</p>
                        <p class="text-sm text-gray-500 mt-1">Indicatif de vol</p>
                    </div>

                    {{-- Grade --}}
                    <div class="bg-white p-6 rounded-lg shadow-md text-center">
                        @php
                            $gradesData = [
                                'Apprenti pilote' => 'apprenti_pilote.png',
                                'Pilote' => 'pilote.png',
                                'Officier pilote de ligne' => 'officier_pilote_de_ligne.png',
                                'Commandant de bord' => 'commandant_de_bord.png',
                                'Pilote d\'élite' => 'pilote_elite.png',
                            ];
                            $currentGrade = Auth::user()->grade;
                            $gradeImage = $gradesData[$currentGrade] ?? 'default.png'; 
                        @endphp
                        
                        <img src="{{ asset('images/' . $gradeImage) }}" alt="Insigne de {{ $currentGrade }}" class="h-12 w-auto mx-auto mb-2">
                        <p class="text-sm text-gray-500 mt-1">Grade</p>
                    </div>
                    
                    {{-- Aéroport actuel --}}
                    <div class="bg-white p-6 rounded-lg shadow-md text-center">
                        <p class="text-3xl font-mono font-bold text-gray-800">{{ Auth::user()->current_airport }}</p>
                        <p class="text-sm text-gray-500 mt-1">Aéroport actuel</p>
                    </div>

                    {{-- SkyCoins --}}
                    <div class="bg-white p-6 rounded-lg shadow-md text-center">
                        <p class="text-3xl font-bold text-yellow-500">{{ number_format(Auth::user()->skycoins, 0, ',', ' ') }}</p>
                        <p class="text-sm text-gray-500 mt-1">SkyCoins</p>
                    </div>

                    {{-- Vols effectués --}}
                    <div class="bg-white p-6 rounded-lg shadow-md text-center">
                        <p class="text-3xl font-bold text-gray-800">{{ Auth::user()->total_flights }}</p>
                        <p class="text-sm text-gray-500 mt-1">Vols effectués</p>
                    </div>

                    {{-- Heures de vol --}}
                    <div class="bg-white p-6 rounded-lg shadow-md text-center">
                        {{-- 👇 MODIFICATION ICI 👇 --}}
                        <p class="text-3xl font-bold text-gray-800">{{ Auth::user()->formatted_flight_hours }}</p>
                        <p class="text-sm text-gray-500 mt-1">Heures de vol</p>
                    </div>

                    {{-- Nautiques parcourus --}}
                    <div class="bg-white p-6 rounded-lg shadow-md text-center">
                        <p class="text-3xl font-bold text-gray-800">{{ number_format(Auth::user()->total_nautical_miles, 0, ',', ' ') }}</p>
                        <p class="text-sm text-gray-500 mt-1">Nautiques parcourus</p>
                    </div>

                    {{-- Mini-bloc vide --}}
                    <div class="bg-white p-6 rounded-lg shadow-md h-24 text-center"></div>
                </div>

                {{-- Bloc 3: Actualités et Discord --}}
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow-md">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Actualités de la compagnie</h3>
                        <p class="text-gray-600">Les dernières actualités seront bientôt disponibles ici.</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md">
                         <h3 class="text-xl font-bold text-gray-800 mb-4">Rejoignez-nous sur Discord</h3>
                         <div class="w-full h-48 bg-gray-200 rounded-md flex items-center justify-center">
                            <p class="text-gray-500">Intégration Discord à venir</p>
                         </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- Popup de Bienvenue (Modal) --}}
        <div x-show="showWelcomePopup" 
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" 
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" 
             class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50" 
             style="display: none;">
            
            <div @click.away="showWelcomePopup = false" class="bg-white rounded-lg shadow-2xl w-full max-w-lg p-8 text-center">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Félicitations, Pilote !</h2>
                <p class="text-lg text-gray-600">
                    Vous avez brillamment réussi votre test d'entrée avec un score de 
                    <span class="font-bold text-green-600">{{ session('score') }}/20</span>.
                </p>
                <p class="mt-4 text-gray-600">
                    Bienvenue officiellement chez Breizh'Air. Votre indicatif de vol personnel est :
                </p>
                <div class="my-6 p-3 bg-gray-100 rounded-md border border-gray-200">
                    <p class="text-2xl font-mono font-bold text-gray-900 tracking-widest">{{ session('callsign') }}</p>
                </div>
                <p class="text-sm text-gray-500">
                    Notez-le précieusement, il vous servira pour tous vos vols avec la compagnie.
                </p>
                <button @click="showWelcomePopup = false" class="mt-8 bg-[#17A4F6] hover:bg-[#138fd9] text-white font-bold py-2 px-6 rounded-lg transition duration-300">
                    Commencer à voler
                </button>
            </div>
        </div>

    </div>
</x-app-layout>

