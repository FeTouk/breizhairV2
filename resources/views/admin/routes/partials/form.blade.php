<form action="{{ isset($route) ? route('admin.routes.update', $route) : route('admin.routes.store') }}" method="POST">
    @csrf
    @if(isset($route))
        @method('PUT')
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <div>
            <label for="aircraft_type" class="block text-sm font-medium text-gray-700">Type d'appareil</label>
            <select name="aircraft_type" id="aircraft_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                <option value="">Sélectionnez un type</option>
                <option value="Local" @selected(old('aircraft_type', $route->aircraft_type ?? '') == 'Local')>Local</option>
                <option value="Régional" @selected(old('aircraft_type', $route->aircraft_type ?? '') == 'Régional')>Régional</option>
                <option value="Moyen courrier" @selected(old('aircraft_type', $route->aircraft_type ?? '') == 'Moyen courrier')>Moyen courrier</option>
                <option value="Long courrier" @selected(old('aircraft_type', $route->aircraft_type ?? '') == 'Long courrier')>Long courrier</option>
            </select>
        </div>
        <div>
            <label for="line_type" class="block text-sm font-medium text-gray-700">Type de ligne</label>
            <select name="line_type" id="line_type" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                <option value="">Sélectionnez un type</option>
                <option value="Régulière" @selected(old('line_type', $route->line_type ?? '') == 'Régulière')>Régulière</option>
                <option value="Saisonnière" @selected(old('line_type', $route->line_type ?? '') == 'Saisonnière')>Saisonnière</option>
                <option value="Evenement" @selected(old('line_type', $route->line_type ?? '') == 'Evenement')>Événement</option>
                <option value="Temporaire" @selected(old('line_type', $route->line_type ?? '') == 'Temporaire')>Temporaire</option>
            </select>
        </div>

        <div>
            <label for="departure_icao" class="block text-sm font-medium text-gray-700">Départ (OACI)</label>
            <input type="text" name="departure_icao" id="departure_icao" value="{{ old('departure_icao', $route->departure_icao ?? '') }}" required maxlength="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm uppercase">
        </div>
        <div>
            <label for="arrival_icao" class="block text-sm font-medium text-gray-700">Arrivée (OACI)</label>
            <input type="text" name="arrival_icao" id="arrival_icao" value="{{ old('arrival_icao', $route->arrival_icao ?? '') }}" required maxlength="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm uppercase">
        </div>

        <div class="md:col-span-2">
            <label for="route_string" class="block text-sm font-medium text-gray-700">Route</label>
            <textarea name="route_string" id="route_string" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm font-mono uppercase">{{ old('route_string', $route->route_string ?? '') }}</textarea>
        </div>
        
        <div class="md:col-span-2">
            <label for="validated_airac" class="block text-sm font-medium text-gray-700">Validité IFPS (AIRAC)</label>
            <select name="validated_airac" id="validated_airac" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                <option value="">Non validé</option>
                @foreach($airacCycles as $cycle)
                    <option value="{{ $cycle['identifier'] }}" @selected(old('validated_airac', $route->validated_airac ?? '') == $cycle['identifier'])>
                        {{ $cycle['identifier'] }} (Actif jusqu'au {{ $cycle['end_date'] }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="md:col-span-2">
            <label for="remarks" class="block text-sm font-medium text-gray-700">Remarques</label>
            <textarea name="remarks" id="remarks" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('remarks', $route->remarks ?? '') }}</textarea>
        </div>
    </div>

    <div class="mt-8 flex justify-end gap-4">
        <a href="{{ route('admin.routes.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-lg">Annuler</a>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">
            {{ isset($route) ? 'Mettre à jour' : 'Créer la ligne' }}
        </button>
    </div>
</form>

