<nav class="bg-white shadow-md" x-data="{ open: false }">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center h-20">
            
            <a href="/">
                <img src="{{ asset('images/breizhair_logo_nav.png') }}" alt="Logo Breizh Air" class="h-16">
            </a>

            {{-- Liens du menu pour grand écran (desktop) --}}
            <div class="hidden lg:flex items-center space-x-4">
                {{-- 👇 On s'assure que la classe "underline-effect" est bien présente sur chaque lien 👇 --}}
                <a class="underline-effect px-3 py-2 {{ Request::is('/') ? 'active' : '' }}" href="/">Accueil</a>
                
                <div class="relative" x-data="{ dropdownOpen: false }">
                    <a @click="dropdownOpen = !dropdownOpen" @click.away="dropdownOpen = false" class="underline-effect dropdown-toggle px-3 py-2 flex items-center {{ Request::is('about', 'reglement', 'flotte', 'badges') ? 'active' : '' }}" href="#">
                        <span>La compagnie</span>
                        <svg class="w-4 h-4 ml-1 transition-transform duration-200" :class="{'rotate-180': dropdownOpen}" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                    <div x-show="dropdownOpen" x-transition class="absolute right-0 mt-2 py-2 w-48 bg-white rounded-md shadow-xl z-20">
                        <a href="/about" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Qui sommes nous ?</a>
                        <a href="/reglement" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Règlement</a>
                        <a href="/flotte" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Notre Flotte</a>
                        <a href="/badges" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Badges</a>
                    </div>
                </div>

                <a class="underline-effect px-3 py-2 {{ Request::is('evenements*') ? 'active' : '' }}" href="{{ route('events.index') }}">Evènements</a>
                
                <div class="relative" x-data="{ dropdownOpen: false }">
                    <a @click="dropdownOpen = !dropdownOpen" @click.away="dropdownOpen = false" class="underline-effect dropdown-toggle px-3 py-2 flex items-center {{ Request::is('staff', 'pilotes') ? 'active' : '' }}" href="#">
                        <span>Pilotes</span>
                        <svg class="w-4 h-4 ml-1 transition-transform duration-200" :class="{'rotate-180': dropdownOpen}" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                    <div x-show="dropdownOpen" x-transition class="absolute right-0 mt-2 py-2 w-48 bg-white rounded-md shadow-xl z-20">
                        <a href="/staff" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Le staff</a>
                        <a href="/pilotes" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Les pilotes</a>
                    </div>
                </div>

                <a class="underline-effect px-3 py-2 {{ Request::is('contact') ? 'active' : '' }}" href="/contact">Contact</a>
                
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-info text-white">Mon Espace Pilote</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-info text-white">Espace Pilote</a>
                @endauth
                
                <div class="ml-4">
                    <a href="{{ url('language/en') }}" class="h-10 w-10 flex items-center justify-center rounded-full overflow-hidden transition duration-300 hover:ring-2 hover:ring-offset-2 hover:ring-[#17A4F6]" title="Switch to English">
                        <img src="https://breizhair.fr/img/En_Flag.svg" alt="English Flag" class="h-full w-full object-cover">
                    </a>
                </div>
            </div>

            <div class="lg:hidden">
                <button @click="open = !open" class="text-gray-700 focus:outline-none" aria-label="Ouvrir le menu">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" /></svg>
                </button>
            </div>
        </div>

        {{-- ... (Le reste du menu mobile ne change pas) ... --}}
    </div>
</nav>