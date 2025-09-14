<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mes Vols') }}
        </h2>
    </x-slot>

    {{-- On initialise Alpine.js pour gérer le popup, les données du formulaire et les messages de l'API --}}
    <div class="py-12" x-data="{ openModal: false, formData: { departure: '', arrival: '', date: '', route: '', departure_time: '', arrival_time: '' }, apiMessage: null }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            {{-- Bloc Titre et Description --}}
            <div class="bg-white rounded-lg shadow-xl p-8 lg:p-12 text-center">
                <h1 class="text-3xl lg:text-4xl font-bold text-gray-800 mb-4">
                    Gérez vos vols
                </h1>
                <p class="text-gray-600">
                    Gérez vos vols libres et lignes dans la compagnie.
                </p>
                <p class="mt-2 text-sm text-gray-500">
                    Pour un meilleur tracking de la VA par IVAO, pensez à inscrire <code class="bg-gray-200 text-red-600 font-mono p-1 rounded">IVAOVA/BZH</code> dans l'item 18 (Remarques) de votre plan de vol.
                </p>
                <div class="mt-6 flex flex-col sm:flex-row gap-4 justify-center">
                    <button 
                        @click="
                            openModal = true;
                            apiMessage = 'Recherche de votre dernier vol...';
                            formData = { departure: '', arrival: '', date: '', route: '', departure_time: '', arrival_time: '' }; // On réinitialise le formulaire
                            fetch('{{ route('api.ivao.last-flight') }}')
                                .then(response => response.json())
                                .then(data => {
                                    if (data.error) {
                                        apiMessage = data.error + ' Veuillez remplir le formulaire manuellement.';
                                    } else {
                                        apiMessage = 'Dernier vol trouvé et pré-rempli !';
                                        formData.departure = data.departure;
                                        formData.arrival = data.arrival;
                                        formData.date = data.date;
                                        formData.route = data.route;
                                        formData.departure_time = data.departure_time;
                                        formData.arrival_time = data.arrival_time;
                                    }
                                });"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300 text-center">
                        Envoyer un rapport de vol libre
                    </button>
                    <a href="#" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300 text-center">
                        Envoyer un rapport de ligne
                    </a>
                </div>
            </div>

            {{-- Bloc des Statistiques Pilote --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-lg shadow-md text-center">
                    <p class="text-3xl font-bold text-gray-800">{{ $user->formatted_flight_hours }}</p>
                    <p class="text-sm text-gray-500 mt-1">Heures de vol</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md text-center">
                    <p class="text-3xl font-bold text-gray-800">{{ $user->total_flights ?? 0 }}</p>
                    <p class="text-sm text-gray-500 mt-1">Vols effectués</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md text-center">
                    <p class="text-3xl font-bold text-gray-800">{{ number_format($user->total_nautical_miles ?? 0, 0, ',', ' ') }}</p>
                    <p class="text-sm text-gray-500 mt-1">Nautiques parcourus</p>
                </div>
            </div>

            {{-- Tableau des derniers vols --}}
            <div class="bg-white rounded-lg shadow-xl p-8 lg:p-12">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Mes 10 derniers vols</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Départ</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Arrivée</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Distance (NM)</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Temps de vol</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($flights as $flight)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ \Carbon\Carbon::parse($flight->flight_date)->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-mono">{{ $flight->departure_icao }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-mono">{{ $flight->arrival_icao }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $flight->nautical_miles }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $flight->formatted_duration }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($flight->status == 'Validé')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Validé</span>
                                        @elseif ($flight->status == 'En attente')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">En attente</span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Refusé</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="#" class="text-indigo-600 hover:text-indigo-900">Voir plus</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                        Vous n'avez pas encore enregistré de vol.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- MODAL (POPUP) POUR LE RAPPORT DE VOL --}}
        <div x-show="openModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50" style="display: none;">
            <div @click.away="openModal = false" class="bg-white rounded-lg shadow-2xl w-full max-w-2xl p-8 relative">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Rapport de Vol Libre</h2>
                
                <div x-show="apiMessage"
                     :class="{ 
                         'bg-blue-100 text-blue-800': apiMessage && !apiMessage.includes('manuellement'), 
                         'bg-yellow-100 text-yellow-800': apiMessage && apiMessage.includes('manuellement') 
                     }"
                     class="p-4 rounded-md text-sm mb-4" 
                     x-text="apiMessage">
                </div>

                <form action="{{ route('flight-report.store') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="departure_icao" class="block text-sm font-medium text-gray-700">Départ (OACI)</label>
                                <input type="text" name="departure_icao" id="departure_icao" x-model="formData.departure" required maxlength="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm uppercase">
                            </div>
                            <div>
                                <label for="arrival_icao" class="block text-sm font-medium text-gray-700">Arrivée (OACI)</label>
                                <input type="text" name="arrival_icao" id="arrival_icao" x-model="formData.arrival" required maxlength="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm uppercase">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="departure_time" class="block text-sm font-medium text-gray-700">Heure de départ (HH:MM)</label>
                                <input type="time" name="departure_time" id="departure_time" x-model="formData.departure_time" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                            <div>
                                <label for="arrival_time" class="block text-sm font-medium text-gray-700">Heure d'arrivée (HH:MM)</label>
                                <input type="time" name="arrival_time" id="arrival_time" x-model="formData.arrival_time" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                        </div>
                        <div>
                            <label for="flight_date" class="block text-sm font-medium text-gray-700">Date du vol</label>
                            <input type="date" name="flight_date" id="flight_date" x-model="formData.date" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        <div>
                            <label for="route" class="block text-sm font-medium text-gray-700">Route du plan de vol (facultatif)</label>
                            <textarea name="route" id="route" x-model="formData.route" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm font-mono uppercase"></textarea>
                        </div>
                        <div>
                            <label for="comments" class="block text-sm font-medium text-gray-700">Commentaire (facultatif)</label>
                            <textarea name="comments" id="comments" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center">
                                <input id="is_breizhair_event" name="is_breizhair_event" type="checkbox" value="1" class="h-4 w-4 rounded border-gray-300 text-blue-600">
                                <label for="is_breizhair_event" class="ml-2 block text-sm text-gray-900">Evènement Breizh'Air</label>
                            </div>
                            <div class="flex items-center">
                                <input id="is_ivao_event" name="is_ivao_event" type="checkbox" value="1" class="h-4 w-4 rounded border-gray-300 text-blue-600">
                                <label for="is_ivao_event" class="ml-2 block text-sm text-gray-900">Evènement IVAO</label>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end gap-4">
                        <button type="button" @click="openModal = false" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-lg">Annuler</button>
                        <button type="submit" class="bg-[#17A4F6] hover:bg-[#138fd9] text-white font-bold py-2 px-4 rounded-lg">Envoyer le rapport</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

