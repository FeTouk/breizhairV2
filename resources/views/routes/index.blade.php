<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nos Lignes
        </h2>
    </x-slot>

    {{-- On initialise Alpine.js pour gérer les modaux (détails et filtres) --}}
    <div class="py-12" x-data="{ openModal: false, selectedRoute: null, openFilterModal: false }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Bouton pour ouvrir le modal de filtre --}}
            <div class="flex justify-start mb-4">
                <button @click="openFilterModal = true" class="btn btn-info btn-sm text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-2.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" /></svg>
                    Filtrer
                </button>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ligne</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Appareil Suggéré</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Validité AIRAC</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($routes as $route)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">
                                            <span class="font-bold">{{ $route->departure_icao }}</span> {{ getAirportName($route->departure_icao) }} &rarr; <span class="font-bold">{{ $route->arrival_icao }}</span> {{ getAirportName($route->arrival_icao) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $route->line_type }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $route->aircraft_type ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($route->validated_airac === $currentAirac)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800" title="Validé pour le cycle {{ $currentAirac }}">
                                                    Valide
                                                </span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800" title="Dernière validation : {{ $route->validated_airac ?? 'N/A' }}">
                                                    Vérification requise
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            {{-- On prépare un objet de données complet pour Alpine.js --}}
                                            @php
                                                $routeData = $route->toArray();
                                                $routeData['departure_name'] = getAirportName($route->departure_icao);
                                                $routeData['arrival_name'] = getAirportName($route->arrival_icao);
                                            @endphp
                                            <button @click="openModal = true; selectedRoute = {{ json_encode($routeData) }}" class="text-indigo-600 hover:text-indigo-900">
                                                Détails
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">Aucune ligne ne correspond à vos critères de recherche.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL (POPUP) POUR LES FILTRES --}}
        <div class="modal" :class="{'modal-open': openFilterModal}">
            <div class="modal-box">
                <h3 class="font-bold text-lg mb-4">Filtrer les Lignes</h3>
                
                <form method="GET" action="{{ route('routes.index') }}">
                    <div class="space-y-4">
                        <div>
                            <label class="label"><span class="label-text">OACI Départ / Arrivée</span></label>
                            <input type="text" name="icao" placeholder="Ex: LFRN" class="input input-bordered w-full" value="{{ request('icao') }}">
                        </div>

                        <div>
                            <label class="label"><span class="label-text">Type de ligne</span></label>
                            <select name="line_type" class="select select-bordered w-full">
                                <option value="">Tous les types</option>
                                @foreach($lineTypes as $type)
                                    <option value="{{ $type }}" @selected(request('line_type') == $type)>{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="label"><span class="label-text">Type d'appareil</span></label>
                            <select name="aircraft_type" class="select select-bordered w-full">
                                <option value="">Tous les appareils</option>
                                @foreach($aircraftTypes as $type)
                                    <option value="{{ $type }}" @selected(request('aircraft_type') == $type)>{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div>
                            <label class="label"><span class="label-text">Validité AIRAC</span></label>
                            <select name="airac_status" class="select select-bordered w-full">
                                <option value="">Toutes les validités</option>
                                <option value="valid" @selected(request('airac_status') == 'valid')>Valide</option>
                                <option value="expired" @selected(request('airac_status') == 'expired')>Vérification requise</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="modal-action">
                        <a href="{{ route('routes.index') }}" class="btn btn-ghost">Réinitialiser</a>
                        <button type="submit" class="btn btn-info text-white">Appliquer</button>
                        <button type="button" @click="openFilterModal = false" class="btn">Fermer</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- MODAL (POPUP) POUR LES DÉTAILS DE LA LIGNE --}}
        <div x-show="openModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 flex items-center justify-center p-4 z-50" style="display: none;">
            <div class="fixed inset-0 bg-black bg-opacity-50"></div>
            
            <div @click.away="openModal = false" class="bg-white rounded-lg shadow-2xl w-full max-w-2xl p-8 relative transform transition-all" x-show="openModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                <template x-if="selectedRoute">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-4">
                            Détails de la Ligne
                        </h2>

                        <div class="space-y-4 text-sm">
                            <div class="flex justify-between">
                                <span class="font-semibold text-gray-600">Ligne :</span>
                                <span class="text-gray-800 font-medium" x-text="`${selectedRoute.departure_name} (${selectedRoute.departure_icao}) → ${selectedRoute.arrival_name} (${selectedRoute.arrival_icao})`"></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-semibold text-gray-600">Type de ligne :</span>
                                <span class="text-gray-800" x-text="selectedRoute.line_type"></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-semibold text-gray-600">Appareil Suggéré :</span>
                                <span class="text-gray-800" x-text="selectedRoute.aircraft_type || 'N/A'"></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-semibold text-gray-600">Durée Estimée :</span>
                                <span class="text-gray-800" x-text="selectedRoute.estimated_duration_minutes ? `${selectedRoute.estimated_duration_minutes} min` : 'N/A'"></span>
                            </div>
                            <div x-show="selectedRoute.route_string">
                                <span class="font-semibold text-gray-600">Route :</span>
                                <p class="mt-1 p-2 bg-gray-50 rounded-md font-mono text-xs uppercase" x-text="selectedRoute.route_string"></p>
                            </div>
                             <div x-show="selectedRoute && selectedRoute.remarks && selectedRoute.remarks.trim() !== ''">
                                <span class="font-semibold text-gray-600">Remarques :</span>
                                <p class="mt-1 p-2 bg-gray-50 rounded-md text-xs" x-text="selectedRoute.remarks"></p>
                            </div>
                        </div>

                        <div class="mt-6 pt-4 border-t flex justify-between items-center">
                            <a :href="`https://www.simbrief.com/system/dispatch.php?airline=BZH&fltnum={{ substr(Auth::user()->callsign, -4) }}&orig=${selectedRoute.departure_icao}&dest=${selectedRoute.arrival_icao}&route=${selectedRoute.route_string}&rmk=IVAOVA/BZH`" target="_blank" class="bg-blue-800 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded-lg text-sm">
                                Générer avec SimBrief
                            </a>
                            <button @click="openModal = false" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-lg">Fermer</button>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</x-app-layout>

