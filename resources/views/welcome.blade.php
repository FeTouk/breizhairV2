@extends('layouts.main')

@section('title', 'Première VA Bretonne')

@section('content')

    {{-- SECTION HÉROS --}}
    <div class="bg-gray-800 text-white rounded-lg shadow-xl p-8 lg:p-12">
        <div class="flex flex-col lg:flex-row items-center gap-8">
            <div class="flex-1 text-center lg:text-left">
                <h1 class="text-4xl lg:text-5xl font-bold mb-4">
                    Bienvenue chez BREIZH'AIR !
                </h1>
                <p class="text-lg lg:text-xl mb-8 text-gray-300">
                    La compagnie aérienne qui vous emmène à la découverte de la Bretagne et d'autres destinations européennes.
                </p>
                <div class="flex flex-col sm:flex-row justify-center lg:justify-start gap-4">
                    <a href="{{ route('register') }}" class="bg-[#17A4F6] hover:bg-[#138fd9] text-white font-bold py-3 px-6 rounded-lg transition duration-300 transform hover:scale-105">
                        Nous rejoindre
                    </a>
                    <a href="/about" class="bg-transparent border-2 border-white text-white font-bold py-3 px-6 rounded-lg transition duration-300 transform hover:scale-105 hover:bg-white hover:text-gray-800">
                        En savoir plus
                    </a>
                </div>
            </div>
            <div class="flex-1 w-full">
                <div class="relative aspect-video"> 
                    <iframe 
                        class="absolute top-0 left-0 w-full h-full rounded-lg"
                        src="https://www.youtube.com/embed/AzhFLJ9Y370"
                        title="Lecteur de vidéo YouTube" 
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                        allowfullscreen>
                    </iframe>
                </div>
            </div>
        </div>
    </div>

    {{-- SECTION STATISTIQUES --}}
    <div class="mt-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="bg-white p-6 rounded-lg shadow-lg text-center transform transition duration-300 hover:scale-105 hover:shadow-xl">
                <span class="block text-4xl font-bold text-[#17A4F6]">15</span>
                <span class="block mt-2 text-lg text-gray-600 font-medium">Pilotes actifs</span>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-lg text-center transform transition duration-300 hover:scale-105 hover:shadow-xl">
                <span class="block text-4xl font-bold text-[#17A4F6]">1,204</span>
                <span class="block mt-2 text-lg text-gray-600 font-medium">Vols effectués</span>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-lg text-center transform transition duration-300 hover:scale-105 hover:shadow-xl">
                <span class="block text-4xl font-bold text-[#17A4F6]">5,890</span>
                <span class="block mt-2 text-lg text-gray-600 font-medium">Heures de vol</span>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-lg text-center transform transition duration-300 hover:scale-105 hover:shadow-xl">
                <span class="block text-4xl font-bold text-[#17A4F6]">345,678</span>
                <span class="block mt-2 text-lg text-gray-600 font-medium">Nautiques parcourus</span>
            </div>
        </div>
    </div>

    {{-- SECTION PARTENAIRES --}}
    <div class="mt-16">
        <div class="flex justify-center items-center gap-12 flex-wrap">
            <a href="https://ivao.aero" target="_blank" rel="noopener noreferrer" class="transition duration-300 hover:opacity-80" title="Visiter IVAO International">
                <img src="https://breizhair.fr/img/va.png" alt="Logo IVAO" class="max-h-[100px] w-auto">
            </a>
            <a href="https://ivao.fr/fr" target="_blank" rel="noopener noreferrer" class="transition duration-300 hover:opacity-80" title="Visiter IVAO France">
                <img src="https://breizhair.fr/img/official-blue-france.png" alt="Logo IVAO France" class="max-h-[100px] w-auto">
            </a>
        </div>
    </div>

    {{-- SECTION CARTE DES VOLS EN COURS --}}
    <div class="mt-16">
        <h2 class="text-3xl font-bold text-gray-800 text-center mb-8">Vols en cours</h2>
        <div id="live-map-container" class="w-full h-96 lg:h-[500px] bg-gray-200 rounded-lg shadow-lg flex items-center justify-center">
            <div class="text-center text-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 10h.01M15 10h.01M9 14h.01M15 14h.01M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2h1a2 2 0 002-2v-1a2 2 0 012-2h1.945" />
                </svg>
                <p class="mt-4 text-xl font-medium">La carte des vols en direct sera bientôt disponible ici.</p>
            </div>
        </div>
    </div>

    {{-- SECTION NOTRE COMPAGNIE --}}
    <div class="mt-16 bg-white rounded-lg shadow-xl overflow-hidden">
        <div class="flex flex-col md:flex-row items-center">
            <div class="w-full md:w-1/2">
                <img src="https://breizhair.fr/img/photo_2.png" alt="Vue d'un cockpit d'avion" class="w-full h-full object-cover">
            </div>
            <div class="w-full md:w-1/2 p-8 lg:p-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Notre compagnie</h2>
                <p class="text-lg text-gray-600 leading-relaxed">
                    Rejoindre Breizh'Air, c'est s'offrir une expérience unique de voyage aérien virtuel, avec des destinations exclusives et une immersion totale dans l'univers de la Bretagne. Avec notre compagnie aérienne virtuelle, vous pourrez explorer des destinations européennes inédites, tout en profitant d'un service personnalisé et d'une simulation ultra-réaliste de vol.
                </p>
            </div>
        </div>
    </div>
    
    {{-- SECTION LA BRETAGNE (DISPOSITION INVERSE) --}}
    <div class="mt-16 bg-white rounded-lg shadow-xl overflow-hidden">
        <div class="flex flex-col md:flex-row items-center">
            <div class="w-full md:w-1/2 p-8 lg:p-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">La Bretagne</h2>
                <p class="text-lg text-gray-600 leading-relaxed">
                    Chez Breizh'Air, nous sommes fiers de notre identité bretonne et de notre attachement à cette région unique. La Bretagne est une terre d'histoire, de culture et de traditions. Avec Breizh'Air, vous pourrez découvrir la beauté de la Bretagne et voyager depuis cette région vers de nombreuses destinations passionnantes.
                </p>
            </div>
            <div class="w-full md:w-1/2">
                <img src="https://breizhair.fr/img/photo_site_1.png" alt="Paysage côtier de Bretagne" class="w-full h-full object-cover">
            </div>
        </div>
    </div>

    {{-- SECTION APPEL À L'ACTION (CTA) --}}
    <div class="mt-16 bg-[#9CDBFF] rounded-lg shadow-xl">
        <div class="container mx-auto px-6 py-12">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-8">
                <div class="text-center sm:text-left">
                    <h2 class="text-3xl font-bold text-gray-800">Rejoignez nous !</h2>
                    <p class="text-xl text-gray-700 mt-1">(Breton ou non !)</p>
                </div>
                <div class="mt-6 sm:mt-0">
                    {{-- 👇 MODIFICATION ICI 👇 --}}
                    <a href="/rejoindre" class="bg-[#17A4F6] hover:bg-[#138fd9] text-white font-bold py-3 px-6 rounded-lg transition duration-300 transform hover:scale-105 shadow-lg">
                        Nous rejoindre
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection