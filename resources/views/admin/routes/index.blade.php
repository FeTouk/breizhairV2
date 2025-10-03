<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Gestion des Lignes de la Compagnie
        </h2>
    </x-slot>

    {{-- On initialise Alpine.js avec les données pour les deux modaux --}}
    <div class="py-12" x-data="validationModal({ routes: {{ $routesToValidate->toJson() }} })">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="alert alert-success shadow-lg mb-4">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <div class="flex flex-col sm:flex-row justify-between items-center mb-4 gap-4">
                <div class="flex items-center gap-2">
                    {{-- Bouton pour ouvrir le modal de filtre --}}
                    <button @click="openFilterModal = true" class="btn btn-info btn-sm text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-2.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" /></svg>
                        Filtrer
                    </button>
                    {{-- NOUVEAU BOUTON : Vérifier les routes --}}
                    <button @click="startValidation" class="btn btn-warning btn-sm" x-show="routes.length > 0">
                        Vérifier les routes
                        <span class="badge badge-error ml-2" x-text="routes.length"></span>
                    </button>
                </div>
                
                <a href="{{ route('admin.routes.create') }}" class="btn btn-primary btn-sm">
                    Créer une nouvelle ligne
                </a>
            </div>
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        {{-- TABLEAU COMPLET RESTAURÉ --}}
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ligne</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type de Ligne</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type d'Appareil</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Validité AIRAC</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($routes as $route)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">
                                            {{ getAirportName($route->departure_icao) }} &rarr; {{ getAirportName($route->arrival_icao) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $route->line_type }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $route->aircraft_type ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($route->validated_airac === $currentAirac)
                                                <span class="badge badge-success text-white">Valide</span>
                                            @else
                                                <span class="badge badge-error text-white">Expiré</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('admin.routes.edit', $route) }}" class="text-indigo-600 hover:text-indigo-900">Modifier</a>
                                            <form action="{{ route('admin.routes.destroy', $route) }}" method="POST" class="inline-block ml-4" onsubmit="return confirm('Êtes-vous sûr ?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Supprimer</button>
                                            </form>
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
                
                <form method="GET" action="{{ route('admin.routes.index') }}">
                    <div class="space-y-4">
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
                        <a href="{{ route('admin.routes.index') }}" class="btn btn-ghost">Réinitialiser</a>
                        <button type="submit" class="btn btn-info text-white">Appliquer</button>
                        <button type="button" @click="openFilterModal = false" class="btn">Fermer</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- MODAL POUR LA VALIDATION DES ROUTES --}}
        <div class="modal" :class="{'modal-open': validationOpen}">
            <div class="modal-box w-11/12 max-w-2xl relative"> {{-- Ajout de "relative" pour positionner la croix --}}
                {{-- 👇 NOUVEAU BOUTON DE FERMETURE (CROIX) 👇 --}}
                <button @click="validationOpen = false" class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>

                <template x-if="currentRoute">
                    <div>
                        <h3 class="font-bold text-lg" x-text="`Vérification : ${currentRoute.departure_icao} → ${currentRoute.arrival_icao}`"></h3>
                        <p class="py-4 text-sm">Vérifiez la validité de la route ci-dessous pour le cycle AIRAC actuel.</p>
                        
                        <div class="form-control">
                            <label class="label"><span class="label-text">Plan de vol Eurocontrol (à copier)</span></label>
                            <div class="flex gap-2">
                                <textarea readonly x-text="generateFpl()" class="textarea textarea-bordered w-full h-32 font-mono text-xs"></textarea>
                                <button @click="copyToClipboard(generateFpl())" class="btn btn-square btn-sm" title="Copier">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" /></svg>
                                </button>
                            </div>
                            <span x-show="copied" class="text-xs text-success mt-1" x-transition>Copié !</span>
                        </div>

                        {{-- 👇 NOUVEAU LIEN VERS EUROCONTROL 👇 --}}
                        <div class="mt-4 text-xs">
                            <a href="https://www.public.nm.eurocontrol.int/PUBPORTAL/gateway/spec/index.html" target="_blank" rel="noopener noreferrer" class="link link-info">
                                Ouvrir le validateur Eurocontrol (IFPS)
                            </a>
                        </div>

                        <div class="modal-action justify-between mt-6">
                            <div>
                                <button @click="handleAction('invalidate')" class="btn btn-error btn-sm">Dévalider la route</button>
                            </div>
                            <div class="space-x-2">
                                <button @click="handleAction('postpone')" class="btn btn-ghost btn-sm">Mettre en attente</button>
                                <button @click="handleAction('validate')" class="btn btn-success btn-sm">Valider la route</button>
                            </div>
                        </div>
                    </div>
                </template>
                <div x-show="!currentRoute" class="text-center py-8">
                    <p class="text-lg font-semibold">Toutes les routes ont été vérifiées !</p>
                    <button @click="closeAndReload()" class="btn btn-primary btn-sm mt-4">Terminer et rafraîchir</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Script Alpine.js pour la logique du modal de validation --}}
    <script>
    function validationModal(config) {
        return {
            routes: config.routes,
            validationOpen: false,
            openFilterModal: false, // Ajout pour gérer les deux modaux
            currentIndex: 0,
            currentRoute: null,
            copied: false,
            startValidation() {
                this.currentIndex = 0;
                if (this.routes.length > 0) {
                    this.currentRoute = this.routes[0];
                    this.validationOpen = true;
                }
            },
            nextRoute() {
                this.currentIndex++;
                if (this.currentIndex < this.routes.length) {
                    this.currentRoute = this.routes[this.currentIndex];
                } else {
                    this.currentRoute = null; // Indique la fin de la validation
                }
            },
            async handleAction(action) {
                if (!this.currentRoute) return;

                const routeId = this.currentRoute.id;
                
                if (action !== 'postpone') {
                    await fetch(`/admin/routes/${routeId}/airac`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ action: action })
                    });
                }
                
                this.nextRoute();
            },
            generateFpl() {
                if (!this.currentRoute) return '';
                const callsignSuffix = '{{ substr(Auth::user()->callsign, -4) ?? 'TEST' }}';
                const dateOfFlight = new Date().toISOString().slice(2, 10).replace(/-/g, '');
                return `(FPL-BZH${callsignSuffix}-IS\n-A320/M-SDE3FGIRWY/LB1\n-${this.currentRoute.departure_icao}2200\n-N0420F180 ${this.currentRoute.route_string}\n-${this.currentRoute.arrival_icao}0055 EGHQ\n-PBN/A1B1C1D1O1S2 DOF/${dateOfFlight} REG/FLFRB RMK/IVAOVA/BZH)`;
            },
            copyToClipboard(text) {
                navigator.clipboard.writeText(text.replace(/\n/g, ' ')).then(() => {
                    this.copied = true;
                    setTimeout(() => this.copied = false, 2000);
                });
            },
            closeAndReload() {
                this.validationOpen = false;
                window.location.reload();
            }
        }
    }
    document.addEventListener('alpine:init', () => {
        Alpine.data('validationModal', validationModal);
    });
    </script>
</x-app-layout>

