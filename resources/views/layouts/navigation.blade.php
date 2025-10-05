{{-- Ce conteneur s'assure que le menu utilise toute la hauteur de la barre latérale --}}
<div class="flex flex-col h-full bg-white border-r border-gray-200">
    <!-- Logo -->
    <div class="p-4 border-b border-gray-200 flex justify-center">
        <a href="{{ route('dashboard') }}">
            <img src="{{ asset('images/breizhair_logo_nav.png') }}" alt="Logo Breizh Air" class="h-16 w-auto">
        </a>
    </div>

    <!-- Liens de Navigation -->
    <nav class="flex-grow p-4 space-y-1 overflow-y-auto">
        <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
            Tableau de Bord
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('flights.index')" :active="request()->routeIs('flights.index')">
            Rapports de vol
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('routes.index')" :active="request()->routeIs('routes.index')">
            Nos Lignes
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('events.index')" :active="request()->routeIs('events.index')">
            Événements
        </x-responsive-nav-link>
    </nav>

    <!-- Liens d'Administration (visibles uniquement par les admins) -->
    @if(Auth::check() && Auth::user()->role == 'admin')
        {{-- On pré-calcule les nombres pour les notifications --}}
        @php
            $pendingFlightsCount = \App\Models\Flight::where('status', 'En attente')->count();
            $currentAirac = getCurrentAiracIdentifier();
            $routesToValidateCount = \App\Models\Route::where('validated_airac', '!=', $currentAirac)
                                        ->orWhereNull('validated_airac')
                                        ->count();
        @endphp
        <div class="p-4 space-y-1 border-t border-gray-200">
            <h3 class="px-2 mb-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Administration</h3>
            
            <x-responsive-nav-link :href="route('flights.validation.index')" :active="request()->routeIs('flights.validation.*')">
                <div class="flex justify-between items-center w-full">
                    <span>Validation des Vols</span>
                    @if($pendingFlightsCount > 0)
                        <span class="badge badge-warning text-white">{{ $pendingFlightsCount }}</span>
                    @endif
                </div>
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('pilots.index')" :active="request()->routeIs('pilots.*')">
                Gestion des Pilotes
            </x-responsive-nav-link>
            
            {{-- 👇 MODIFICATION ICI : Ajout du badge de notification pour les lignes 👇 --}}
            <x-responsive-nav-link :href="route('admin.routes.index')" :active="request()->routeIs('admin.routes.*')">
                <div class="flex justify-between items-center w-full">
                    <span>Gestion des Lignes</span>
                    @if($routesToValidateCount > 0)
                        <span class="badge badge-warning text-white">{{ $routesToValidateCount }}</span>
                    @endif
                </div>
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('questions.index')" :active="request()->routeIs('questions.*')">
                Gestion du Test
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.events.index')" :active="request()->routeIs('admin.events.*')">
                Gestion des Événements
            </x-responsive-nav-link>
            {{-- <x-responsive-nav-link :href="route('admin.logs.index')" :active="request()->routeIs('admin.logs.index')">
                Journal d'Activité
            </x-responsive-nav-link> --}}
        </div>
    @endif

    <!-- Informations Utilisateur en bas -->
    <div class="p-4 border-t border-gray-200 text-center mt-auto">
        <div class="font-medium text-base text-gray-800 mb-2">{{ Auth::user()->name }}</div>
        
        <a href="{{ url('/') }}" class="block text-sm text-gray-500 hover:text-gray-700 underline mb-2">
            Retour au site
        </a>

        <form method="POST" action="{{ route('logout') }}" class="mt-1">
            @csrf
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); this.closest('form').submit();"
               class="text-sm text-gray-500 hover:text-gray-700 underline">
                Se déconnecter
            </a>
        </form>
    </div>
</div>

