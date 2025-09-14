<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mon Profil Pilote') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Bloc d'en-tête de la page --}}
            <div class="bg-white p-6 rounded-lg shadow-md text-center">
                <h1 class="text-3xl font-bold text-gray-800">Mon profil</h1>
                <p class="text-lg text-gray-600 mt-1">Retrouvez toutes les informations de votre profil.</p>
            </div>

            {{-- Bloc principal des informations du profil --}}
            <div class="bg-white p-8 rounded-lg shadow-md">
                <div class="flex flex-col md:flex-row gap-8">
                    
                    {{-- Colonne de gauche : Informations textuelles --}}
                    <div class="w-full md:w-2/3">
                        @php
                            $firstName = Auth::user()->first_name;
                            $lastNameInitial = Auth::user()->last_name ? strtoupper(substr(Auth::user()->last_name, 0, 1)) . '.' : '';
                        @endphp
                        <h2 class="text-2xl font-bold text-gray-800 mb-6 pb-2 border-b">{{ $firstName }} {{ $lastNameInitial }} - {{ Auth::user()->callsign }}</h2>
                        
                        <dl class="divide-y divide-gray-200">
                            {{-- Chaque div est maintenant une grille pour aligner le libellé et la valeur --}}
                            <div class="py-4 grid grid-cols-1 sm:grid-cols-3 gap-4 items-center">
                                <dt class="font-medium text-gray-500">Adresse Mail :</dt>
                                <dd class="sm:col-span-2 text-gray-900">{{ Auth::user()->email }}</dd>
                            </div>
                            <div class="py-4 grid grid-cols-1 sm:grid-cols-3 gap-4 items-center">
                                <dt class="font-medium text-gray-500">IVAO VID :</dt>
                                <dd class="sm:col-span-2 text-gray-900">{{ Auth::user()->ivao_vid }}</dd>
                            </div>
                            <div class="py-4 grid grid-cols-1 sm:grid-cols-3 gap-4 items-center">
                                <dt class="font-medium text-gray-500">Nombre de vols :</dt>
                                <dd class="sm:col-span-2 text-gray-900">{{ Auth::user()->total_flights }}</dd>
                            </div>
                            <div class="py-4 grid grid-cols-1 sm:grid-cols-3 gap-4 items-center">
                                <dt class="font-medium text-gray-500">Heures de vol :</dt>
                                <dd class="sm:col-span-2 text-gray-900">{{ Auth::user()->total_flight_hours }}</dd>
                            </div>
                            <div class="py-4 grid grid-cols-1 sm:grid-cols-3 gap-4 items-center">
                                <dt class="font-medium text-gray-500">Nautiques parcourus :</dt>
                                <dd class="sm:col-span-2 text-gray-900">{{ number_format(Auth::user()->total_nautical_miles, 0, ',', ' ') }}</dd>
                            </div>
                             <div class="py-4 grid grid-cols-1 sm:grid-cols-3 gap-4 items-center">
                                <dt class="font-medium text-gray-500">Position actuelle :</dt>
                                <dd class="sm:col-span-2 text-gray-900">{{ Auth::user()->current_airport }}</dd>
                            </div>
                             <div class="py-4 grid grid-cols-1 sm:grid-cols-3 gap-4 items-center">
                                <dt class="font-medium text-gray-500">SkyCoins :</dt>
                                <dd class="sm:col-span-2 text-gray-900">{{ number_format(Auth::user()->skycoins, 0, ',', ' ') }}</dd>
                            </div>
                            <div class="py-4 grid grid-cols-1 sm:grid-cols-3 gap-4 items-center">
                                <dt class="font-medium text-gray-500">Rôle :</dt>
                                <dd class="sm:col-span-2 text-gray-900 capitalize">{{ Auth::user()->role }}</dd>
                            </div>
                            <div class="py-4 grid grid-cols-1 sm:grid-cols-3 gap-4 items-center">
                                <dt class="font-medium text-gray-500">Date d'inscription :</dt>
                                <dd class="sm:col-span-2 text-gray-900">{{ Auth::user()->created_at->format('d/m/Y') }}</dd>
                            </div>
                        </dl>
                    </div>

                    {{-- Colonne de droite : Grade, Badges, etc. --}}
                    <div class="w-full md:w-1/3 space-y-6">
                        {{-- Grade --}}
                        <div>
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
                            <h3 class="text-lg font-semibold text-gray-800">Grade : {{ $currentGrade }}</h3>
                            <div class="mt-2 p-2 bg-gray-100 rounded-lg inline-block">
                                <img src="{{ asset('images/' . $gradeImage) }}" alt="Insigne de {{ $currentGrade }}" class="h-24 w-auto">
                            </div>
                        </div>

                        {{-- Badges --}}
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Mes Badges</h3>
                            <div class="mt-2 p-4 bg-gray-100 rounded-lg min-h-[8rem]">
                                <p class="text-sm text-gray-500">Vos badges s'afficheront ici.</p>
                            </div>
                        </div>
                        
                        {{-- Événements --}}
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Mes Événements</h3>
                            <div class="mt-2 p-4 bg-gray-100 rounded-lg min-h-[8rem]">
                                <p class="text-sm text-gray-500">Votre participation aux événements sera listée ici.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Séparateur et formulaires de modification --}}
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

