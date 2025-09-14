<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Validation du Rapport de Vol N°{{ $flight->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    
                    {{-- On utilise un formulaire qui englobe toute la page de validation --}}
                    <form action="{{ route('flights.validation.update', $flight) }}" method="POST">
                        @csrf
                        @method('PATCH') {{-- On utilise la méthode PATCH pour une mise à jour --}}

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            
                            {{-- COLONNE DE GAUCHE : DÉTAILS SOUMIS --}}
                            <div class="space-y-6">
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Informations du Pilote</h3>
                                    <dl class="mt-4 space-y-2 text-sm">
                                        <div class="flex justify-between">
                                            <dt class="font-semibold text-gray-500">Callsign:</dt>
                                            <dd class="text-gray-800">{{ $flight->user->callsign }}</dd>
                                        </div>
                                        <div class="flex justify-between">
                                            <dt class="font-semibold text-gray-500">Nom:</dt>
                                            <dd class="text-gray-800">{{ $flight->user->first_name }} {{ $flight->user->last_name }}</dd>
                                        </div>
                                        <div class="flex justify-between">
                                            <dt class="font-semibold text-gray-500">VID IVAO:</dt>
                                            <dd class="text-gray-800">{{ $flight->user->ivao_vid }}</dd>
                                        </div>
                                    </dl>
                                </div>
                                
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Détails du Vol Soumis</h3>
                                    <dl class="mt-4 space-y-2 text-sm">
                                        <div class="flex justify-between">
                                            <dt class="font-semibold text-gray-500">Date du vol:</dt>
                                            <dd class="text-gray-800">{{ \Carbon\Carbon::parse($flight->flight_date)->format('d/m/Y') }}</dd>
                                        </div>
                                        <div class="flex justify-between">
                                            <dt class="font-semibold text-gray-500">Départ (OACI):</dt>
                                            <dd class="text-gray-800 font-mono">{{ $flight->departure_icao }}</dd>
                                        </div>
                                        <div class="flex justify-between">
                                            <dt class="font-semibold text-gray-500">Arrivée (OACI):</dt>
                                            <dd class="text-gray-800 font-mono">{{ $flight->arrival_icao }}</dd>
                                        </div>
                                        @if($flight->comments)
                                        <div>
                                            <dt class="font-semibold text-gray-500">Commentaire du pilote:</dt>
                                            <dd class="text-gray-800 mt-1 p-2 bg-gray-50 rounded-md">{{ $flight->comments }}</dd>
                                        </div>
                                        @endif
                                        <div>
                                            <dt class="font-semibold text-gray-500">Type d'évènement:</dt>
                                            <dd class="text-gray-800 mt-1">
                                                @if($flight->is_breizhair_event) <span class="text-blue-600">Breizh'Air</span> @endif
                                                @if($flight->is_ivao_event) <span class="text-blue-600 ml-2">IVAO</span> @endif
                                                @if(!$flight->is_breizhair_event && !$flight->is_ivao_event) <span>Aucun</span> @endif
                                            </dd>
                                        </div>
                                    </dl>
                                </div>
                            </div>

                            {{-- COLONNE DE DROITE : VALIDATION ADMIN --}}
                            <div class="space-y-6 bg-gray-50 p-6 rounded-lg">
                                <div>
                                    <label for="nautical_miles" class="block text-sm font-medium text-gray-700">Nautiques Parcourus</label>
                                    <input type="number" name="nautical_miles" id="nautical_miles" value="{{ old('nautical_miles', $flight->nautical_miles) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2">
                                </div>
                                
                                {{-- 👇 MODIFICATION ICI 👇 --}}
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="departure_time" class="block text-sm font-medium text-gray-700">Heure de départ (HH:MM)</label>
                                        <input type="time" name="departure_time" id="departure_time" value="{{ old('departure_time') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2">
                                    </div>
                                    <div>
                                        <label for="arrival_time" class="block text-sm font-medium text-gray-700">Heure d'arrivée (HH:MM)</label>
                                        <input type="time" name="arrival_time" id="arrival_time" value="{{ old('arrival_time') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2">
                                    </div>
                                </div>
                                
                                {{-- Emplacements pour futures instructions --}}
                                <div class="p-4 border rounded-md bg-yellow-50 text-yellow-800 text-sm">Instruction 1 à venir...</div>
                                <div class="p-4 border rounded-md bg-yellow-50 text-yellow-800 text-sm">Instruction 2 à venir...</div>
                                <div class="p-4 border rounded-md bg-yellow-50 text-yellow-800 text-sm">Instruction 3 à venir...</div>

                                <div>
                                    <label for="validation_comments" class="block text-sm font-medium text-gray-700">Remarques pour le pilote (facultatif)</label>
                                    <textarea name="validation_comments" id="validation_comments" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2">{{ old('validation_comments', $flight->validation_comments) }}</textarea>
                                </div>

                                {{-- Liens externes --}}
                                <div class="border-t pt-4 flex items-center justify-between">
                                    <a href="https://tracker.ivao.aero/?userId={{ $flight->user->ivao_vid }}&from={{ \Carbon\Carbon::parse($flight->flight_date)->format('Y-m-d') }}" target="_blank" class="text-blue-600 hover:underline">Voir tracker IVAO</a>
                                    <a href="https://skyvector.com/?fpl={{ $flight->departure_icao }}%20{{ $flight->route ?? '' }}%20{{ $flight->arrival_icao }}" target="_blank" class="text-blue-600 hover:underline">Voir sur SkyVector</a>
                                </div>
                                
                                {{-- Boutons de décision --}}
                                <div class="flex justify-end gap-4">
                                    <button type="submit" name="decision" value="reject" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg">
                                        Refuser
                                    </button>
                                    <button type="submit" name="decision" value="accept" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg">
                                        Accepter
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

