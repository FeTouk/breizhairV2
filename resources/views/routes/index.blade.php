<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nos Lignes
        </h2>
    </x-slot>

    {{-- On initialise Alpine.js pour gérer l'ouverture du modal et la route sélectionnée --}}
    <div class="py-12" x-data="{ openModal: false, selectedRoute: null }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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
                                            {{ getAirportName($route->departure_icao) }} &rarr; {{ getAirportName($route->arrival_icao) }}
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
                                                    Non validé pour le cycle actuel
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
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">Aucune ligne n'est disponible pour le moment.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL (POPUP) POUR LES DÉTAILS DE LA LIGNE --}}
        <div x-show="openModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 flex items-center justify-center p-4 z-50" style="display: none;">
            <div class="fixed inset-0"></div>
            
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

