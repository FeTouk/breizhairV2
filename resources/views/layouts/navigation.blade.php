<div class="flex flex-col h-full bg-white border-r border-gray-200">
    <!-- Logo -->
    <div class="p-4 border-b border-gray-200 flex justify-center">
        <a href="{{ route('dashboard') }}">
            <img src="{{ asset('images/breizhair_logo_nav.png') }}" alt="Logo Breizh Air" class="h-16 w-auto">
        </a>
    </div>

    <!-- Navigation Links -->
    <nav class="flex-grow px-4 py-6 space-y-1">
        <a href="{{ route('dashboard') }}" class="underline-effect {{ request()->routeIs('dashboard') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">
            Tableau de bord
        </a>
        <a href="{{ route('profile.edit') }}" class="underline-effect {{ request()->routeIs('profile.edit') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">
            Profil
        </a>
        <a href="{{ route('flights.index') }}" class="underline-effect {{ request()->routeIs('flights.index') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">
            Mes vols
        </a>
        {{-- Lien vers la page des lignes pour les pilotes --}}
        <a href="{{ route('routes.index') }}" class="underline-effect {{ request()->routeIs('routes.index') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">
            Nos Lignes
        </a>
        <a href="#" class="underline-effect text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
            Flotte
        </a>
        <a href="#" class="underline-effect text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
            Carrière
        </a>
        <a href="#" class="underline-effect text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
            Formation
        </a>
        
        {{-- SECTION ADMINISTRATION (VISIBLE UNIQUEMENT PAR LES ADMINS) --}}
        @if (Auth::check() && Auth::user()->role == 'admin')
            <div class="pt-4">
                <h3 class="px-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Administration</h3>
                <div class="mt-1 space-y-1">
                    <a href="{{ route('questions.index') }}" class="underline-effect {{ request()->routeIs('questions.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                        Gérer le QCM
                    </a>
                    <a href="{{ route('flights.validation.index') }}" class="underline-effect {{ request()->routeIs('flights.validation.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                        Valider les Vols
                    </a>
                    <a href="{{ route('pilots.index') }}" class="underline-effect {{ request()->routeIs('pilots.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                        Gestion des pilotes
                    </a>
                    <a href="{{ route('admin.events.index') }}" class="underline-effect {{ request()->routeIs('admin.events.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                        Gestion des Événements
                    </a>
                    {{-- Lien vers la gestion des lignes pour les admins --}}
                    <a href="{{ route('admin.routes.index') }}" class="underline-effect {{ request()->routeIs('admin.routes.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                        Gestion des Lignes
                    </a>
                </div>
            </div>
        @endif
    </nav>

    <!-- User Info and Site Link at the bottom -->
    <div class="p-4 border-t border-gray-200 text-center">
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

