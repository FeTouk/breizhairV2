<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Créer une nouvelle ligne
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    {{-- On colle directement le code du formulaire ici, au lieu de @include --}}
                    
                    <form action="{{ route('admin.routes.store') }}" method="POST"
                          x-data="{
                              departure: '{{ old('departure_icao', '') }}'.toUpperCase(),
                              arrival: '{{ old('arrival_icao', '') }}'.toUpperCase(),
                              routeString: '{{ old('route_string', '') }}'.toUpperCase()
                          }">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            {{-- Menus déroulants : Type d'appareil et Type de ligne --}}
                            <div>
                                <label for="aircraft_type" class="block text-sm font-medium text-gray-700">Type d'appareil</label>
                                <select name="aircraft_type" id="aircraft_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Sélectionnez un type</option>
                                    <option value="Local" @selected(old('aircraft_type') == 'Local')>Local</option>
                                    <option value="Régional" @selected(old('aircraft_type') == 'Régional')>Régional</option>
                                    <option value="Moyen courrier" @selected(old('aircraft_type') == 'Moyen courrier')>Moyen courrier</option>
                                    <option value="Long courrier" @selected(old('aircraft_type') == 'Long courrier')>Long courrier</option>
                                </select>
                            </div>
                            <div>
                                <label for="line_type" class="block text-sm font-medium text-gray-700">Type de ligne</label>
                                <select name="line_type" id="line_type" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Sélectionnez un type</option>
                                    <option value="Régulière" @selected(old('line_type') == 'Régulière')>Régulière</option>
                                    <option value="Saisonnière" @selected(old('line_type') == 'Saisonnière')>Saisonnière</option>
                                    <option value="Evenement" @selected(old('line_type') == 'Evenement')>Événement</option>
                                    <option value="Temporaire" @selected(old('line_type') == 'Temporaire')>Temporaire</option>
                                </select>
                            </div>

                            {{-- Champs Départ et Arrivée liés à Alpine.js --}}
                            <div>
                                <label for="departure_icao" class="block text-sm font-medium text-gray-700">Départ (OACI)</label>
                                <input type="text" name="departure_icao" id="departure_icao" x-model="departure" required maxlength="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm uppercase">
                            </div>
                            <div>
                                <label for="arrival_icao" class="block text-sm font-medium text-gray-700">Arrivée (OACI)</label>
                                <input type="text" name="arrival_icao" id="arrival_icao" x-model="arrival" required maxlength="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm uppercase">
                            </div>

                            {{-- Champ Route lié à Alpine.js --}}
                            <div class="md:col-span-2">
                                <label for="route_string" class="block text-sm font-medium text-gray-700">Route</label>
                                <textarea name="route_string" id="route_string" x-model="routeString" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm font-mono uppercase">{{ old('route_string', '') }}</textarea>
                            </div>
                            
                            {{-- Les champs Distance et Durée ont été supprimés --}}
                            
                            <div class="md:col-span-2">
                                <label for="remarks" class="block text-sm font-medium text-gray-700">Remarques</label>
                                <textarea name="remarks" id="remarks" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('remarks', '') }}</textarea>
                            </div>
                        </div>

                        <div class="mt-8 flex justify-end gap-4">
                            <a href="{{ route('admin.routes.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-lg">Annuler</a>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">
                                Créer la ligne
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

