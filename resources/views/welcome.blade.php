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
                    <a href="/register" class="btn btn-lg btn-info text-white">
                        Nous rejoindre
                    </a>
                    <a href="/about" class="btn btn-lg btn-outline">
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
                <span class="block text-4xl font-bold text-[#17A4F6]">{{ $activePilots }}</span>
                <span class="block mt-2 text-lg text-gray-600 font-medium">Pilotes actifs</span>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-lg text-center transform transition duration-300 hover:scale-105 hover:shadow-xl">
                <span class="block text-4xl font-bold text-[#17A4F6]">{{ number_format($totalFlights) }}</span>
                <span class="block mt-2 text-lg text-gray-600 font-medium">Vols effectués</span>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-lg text-center transform transition duration-300 hover:scale-105 hover:shadow-xl">
                <span class="block text-4xl font-bold text-[#17A4F6]">{{ number_format($totalFlightHours) }}</span>
                <span class="block mt-2 text-lg text-gray-600 font-medium">Heures de vol</span>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-lg text-center transform transition duration-300 hover:scale-105 hover:shadow-xl">
                <span class="block text-4xl font-bold text-[#17A4F6]">{{ number_format($totalNauticalMiles) }}</span>
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
        <div id="live-map-container" class="w-full h-96 lg:h-[500px] rounded-lg shadow-lg"></div>
    </div>

    {{-- SECTION NOTRE COMPAGNIE --}}
    <div class="mt-16 bg-white rounded-lg shadow-xl overflow-hidden">
        <div class="flex flex-col md:flex-row items-center">
            <div class="w-full md:w-1/2">
                <img src="{{ asset('images/BZH_rade.png') }}" alt="Vue d'un cockpit d'avion" class="w-full h-full object-cover">
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
                <img src="{{ asset('images/BHZ_golden_low.png') }}" alt="Paysage côtier de Bretagne" class="w-full h-full object-cover">
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
                    <a href="/register" class="btn btn-lg btn-info text-white">
                        Nous rejoindre
                    </a>
                </div>
            </div>
        </div>
    </div>

<style>
    .leaflet-info-message {
        padding: 6px 12px;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif;
        font-size: 1rem;
        background: white;
        background: rgba(255,255,255,0.9);
        box-shadow: 0 0 15px rgba(0,0,0,0.2);
        border-radius: 5px;
        color: #333;
    }
</style>
<style>
    .leaflet-info-message {
        padding: 6px 12px;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif;
        font-size: 1rem;
        background: white;
        background: rgba(255,255,255,0.9);
        box-shadow: 0 0 15px rgba(0,0,0,0.2);
        border-radius: 5px;
        color: #333;
    }
</style>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        try {
            if (typeof L === 'undefined') {
                const mapContainer = document.getElementById('live-map-container');
                mapContainer.innerHTML = '<p style="color: red;">Erreur: La librairie Leaflet n\'a pas pu être chargée.</p>';
                return;
            }

            const map = L.map('live-map-container').setView([48.117266, -1.677792], 6);

            L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>'
            }).addTo(map);

            // Add home base marker for Brest Airport
            const brestAirportCoords = [48.447, -4.418];
            const homeIcon = L.divIcon({
                html: `<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 24 24\" fill=\"currentColor\" style=\"width:2rem; height:2rem; color: #9CDBFF;\">
                        <path d=\"M11.47 3.84a.75.75 0 011.06 0l8.69 8.69a.75.75 0 101.06-1.06l-8.689-8.69a2.25 2.25 0 00-3.182 0L2.41 11.47a.75.75 0 101.06 1.06l8-8z" />
                        <path d=\"M12 5.432l8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 01-.75-.75v-4.5a.75.75 0 00-.75-.75h-3a.75.75 0 00-.75.75V21a.75.75 0 01-.75.75H5.625a1.875 1.875 0 01-1.875-1.875v-6.198a2.29 2.29 0 00.091-.086L12 5.43z" />
                    </svg>`,
                className: '',
                iconSize: [32, 32],
                iconAnchor: [16, 32]
            });

            const homeMarker = L.marker(brestAirportCoords, {
                icon: homeIcon,
                zIndexOffset: 1000
            }).addTo(map);

            homeMarker.bindPopup('<b>Breizh\'Air Hub</b><br>Aéroport de Brest-Bretagne (LFRB)');

            const flightsLayer = L.layerGroup().addTo(map);
            let infoMessageControl = null;

            function showInfoMessage(message) {
                if (!infoMessageControl) {
                    infoMessageControl = L.control({ position: 'bottomright' });
                    infoMessageControl.onAdd = function (map) {
                        const div = L.DomUtil.create('div', 'leaflet-info-message');
                        div.innerHTML = message;
                        return div;
                    };
                    infoMessageControl.addTo(map);
                } else {
                    infoMessageControl.getContainer().innerHTML = message;
                }
            }

            function hideInfoMessage() {
                if (infoMessageControl) {
                    infoMessageControl.remove();
                    infoMessageControl = null;
                }
            }

            async function fetchAndDisplayFlights() {
                try {
                    const response = await fetch('https://api.ivao.aero/v2/tracker/whazzup');
                    if (!response.ok) {
                        throw new Error(`API Error: ${response.status}`);
                    }
                    const data = await response.json();
                    
                    flightsLayer.clearLayers();

                    const bzhFlights = data.clients.pilots.filter(pilot => pilot.callsign.startsWith('BZH'));

                    if (bzhFlights.length === 0) {
                        showInfoMessage('Aucun vol Breizh\'Air en cours pour le moment.');
                    } else {
                        hideInfoMessage();
                    }

                    bzhFlights.forEach(flight => {
                        const lastTrack = flight.lastTrack;
                        if (lastTrack && typeof lastTrack.latitude === 'number' && typeof lastTrack.longitude === 'number') {
                            const icon = L.divIcon({
                                html: `<svg xmlns=\"http://www.w3.org/2000/svg\" class=\"h-8 w-8 text-blue-600\" fill=\"currentColor\" viewBox=\"0 0 20 20\" style=\"transform: rotate(${lastTrack.heading}deg);\">
                                           <path d=\"M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                                       </svg>`, 
                                className: '',
                                iconSize: [32, 32],
                                iconAnchor: [16, 16]
                            });

                            const marker = L.marker([lastTrack.latitude, lastTrack.longitude], {
                                icon: icon
                            }).addTo(flightsLayer);

                            marker.bindPopup(
                                `<div class=\"font-sans\">
                                    <div class=\"font-bold text-lg\">${flight.callsign}</div>
                                    <div class=\"text-sm text-gray-600\">${flight.flightPlan.departureId} &rarr; ${flight.flightPlan.arrivalId}</div>
                                    <hr class=\"my-1\">
                                    <div><b>Altitude:</b> ${lastTrack.altitude} ft</div>
                                    <div><b>Speed:</b> ${lastTrack.groundSpeed} kts</div>
                                    <div><b>Aircraft:</b> ${flight.flightPlan.aircraftId}</div>
                                </div>`
                            );
                        }
                    });
                } catch (error) {
                    console.error('Error fetching or displaying IVAO flight data:', error);
                    flightsLayer.clearLayers();
                    showInfoMessage('Impossible de charger les données des vols.');
                }
            }

            fetchAndDisplayFlights();
            setInterval(fetchAndDisplayFlights, 10000);

        } catch (e) {
            console.error('Error initializing map:', e);
            const mapContainer = document.getElementById('live-map-container');
            if (mapContainer) {
                mapContainer.innerHTML = `<p style=\"color: red;\">Erreur lors de l\'initialisation de la carte: ${e.message}</p>`;
            }
        }
    });
</script>

@endsection