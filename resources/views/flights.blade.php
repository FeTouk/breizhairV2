<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mes Vols') }}
        </h2>
    </x-slot>

    {{-- On initialise Alpine.js avec une fonction dédiée pour gérer la logique du formulaire --}}
    <div class="py-12" x-data="flightReportForm()">
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
                    {{-- Le bouton appelle maintenant la fonction d'initialisation d'Alpine.js --}}
                    <button @click="openModalAndFetchFlights()" class="btn btn-primary">
                        Envoyer un rapport de vol libre
                    </button>
                    <a href="#" class="btn">
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
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $flight->formatted_duration }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($flight->status == 'Validé')
                                            <span class="badge badge-success text-white">Validé</span>
                                        @elseif ($flight->status == 'En attente')
                                            <span class="badge badge-warning text-white">En attente</span>
                                        @else
                                            <span class="badge badge-error text-white">Refusé</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="#" class="text-indigo-600 hover:text-indigo-900">Voir plus</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                        Vous n'avez pas encore enregistré de vol.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- MODAL (POPUP) POUR LE RAPPORT DE VOL (VERSION SIMPLIFIÉE) --}}
        <div class="modal" :class="{'modal-open': openModal}">
            <div class="modal-box w-11/12 max-w-lg">
                <h2 class="font-bold text-lg mb-4">Rapport de Vol Libre</h2>
                
                <div x-show="apiMessage" class="alert mb-4" :class="{ 'alert-info': !apiError, 'alert-warning': apiError }">
                    <div x-text="apiMessage"></div>
                </div>

                <form action="{{ route('flight-report.store') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div x-show="recentFlights.length > 0">
                            <label class="label"><span class="label-text">Importer un vol récent</span></label>
                            <select @change="selectFlight($event.target.value)" class="select select-bordered w-full">
                                <option value="">Remplir manuellement</option>
                                <template x-for="flight in recentFlights" :key="flight.id">
                                    <option :value="flight.id" x-text="`${flight.departure} -> ${flight.arrival} (${flight.callsign})`"></option>
                                </template>
                            </select>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="label"><span class="label-text">Départ (OACI)</span></label>
                                <input type="text" name="departure_icao" required x-model="formData.departure" class="input input-bordered w-full uppercase">
                            </div>
                            <div>
                                <label class="label"><span class="label-text">Arrivée (OACI)</span></label>
                                <input type="text" name="arrival_icao" required x-model="formData.arrival" class="input input-bordered w-full uppercase">
                            </div>
                        </div>
                        
                        <div>
                            <label class="label"><span class="label-text">Commentaire (facultatif)</span></label>
                            <textarea name="comments" id="comments" rows="3" class="textarea textarea-bordered w-full"></textarea>
                        </div>
                        <div class="flex items-center space-x-4">
                            <label class="label cursor-pointer"><input type="checkbox" name="is_breizhair_event" value="1" class="checkbox checkbox-primary" /> <span class="label-text ml-2">Evènement Breizh'Air</span></label>
                            <label class="label cursor-pointer"><input type="checkbox" name="is_ivao_event" value="1" class="checkbox checkbox-primary" /> <span class="label-text ml-2">Evènement IVAO</span></label>
                        </div>
                    </div>
                    <div class="modal-action">
                        <button type="button" @click="openModal = false" class="btn">Annuler</button>
                        <button type="submit" class="btn btn-primary">Envoyer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Script Alpine.js pour la logique du formulaire (VERSION SIMPLIFIÉE) --}}
    <script>
        function flightReportForm() {
            return {
                openModal: false,
                apiMessage: null,
                apiError: false,
                recentFlights: [],
                formData: {
                    departure: '', 
                    arrival: '',
                },
                openModalAndFetchFlights() {
                    this.openModal = true;
                    this.apiMessage = 'Recherche de vos vols récents...';
                    this.apiError = false;
                    this.recentFlights = [];
                    this.resetForm();

                    fetch('{{ route("api.ivao.recent-flights") }}')
                        .then(response => response.json())
                        .then(data => {
                            if (data.error) {
                                this.apiMessage = data.error + ' Veuillez remplir le formulaire manuellement.';
                                this.apiError = true;
                            } else {
                                this.apiMessage = data.message;
                                this.recentFlights = data.flights;
                                this.apiError = (this.recentFlights.length === 0);
                                if(this.apiError && !data.error) {
                                    this.apiMessage += ' Veuillez remplir le formulaire manuellement.';
                                }
                            }
                        })
                        .catch(() => {
                            this.apiMessage = 'Erreur de communication avec l\'API. Veuillez remplir le formulaire manuellement.';
                            this.apiError = true;
                        });
                },
                selectFlight(flightId) {
                    if (!flightId) {
                        this.resetForm();
                        return;
                    }
                    const selected = this.recentFlights.find(f => f.id == flightId);
                    if (selected) {
                        this.formData.departure = selected.departure;
                        this.formData.arrival = selected.arrival;
                    }
                },
                resetForm() {
                    this.formData = { departure: '', arrival: '' };
                }
            }
        }
        document.addEventListener('alpine:init', () => {
            Alpine.data('flightReportForm', flightReportForm);
        });
    </script>
</x-app-layout>

