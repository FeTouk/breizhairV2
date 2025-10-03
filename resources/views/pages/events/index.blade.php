@extends('layouts.main')

@section('title', 'Nos Événements')

@section('content')
    <div class="bg-white rounded-lg shadow-xl p-8 lg:p-12">
        <h1 class="text-3xl lg:text-4xl font-bold text-gray-800 mb-8 text-center border-b pb-4">
            Nos Événements
        </h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($events as $event)
                {{-- Carte pour chaque événement --}}
                <div class="bg-white rounded-lg shadow-lg overflow-hidden transform transition duration-300 hover:scale-105 hover:shadow-2xl">
                    <a href="{{ route('events.show', $event->slug) }}" class="block">
                        {{-- Cadre pour l'image avec un ratio de 600/350 --}}
                        <div class="w-full aspect-[600/350] bg-gray-100">
                            <img src="{{ $event->image ? asset('storage/' . $event->image) : 'https://placehold.co/600x350/374151/E5E7EB?text=Breizh\'Air' }}" alt="Image pour {{ $event->title }}" class="w-full h-full object-contain">
                        </div>
                        
                        {{-- Contenu texte (date et titre) dans son propre encart --}}
                        <div class="p-4">
                            <p class="text-sm text-gray-500 mb-1">
                                Le {{ $event->event_date->format('d/m/Y') }} à {{ $event->event_date->format('H:i') }}
                            </p>
                            
                            <h2 class="text-xl font-bold text-gray-800 leading-tight truncate">
                                {{ $event->title }}
                            </h2>
                        </div>
                    </a>
                </div>
            @empty
                {{-- Message si aucun événement n'est trouvé --}}
                <div class="md:col-span-2 lg:col-span-3 text-center text-gray-500 py-16">
                    <p>Il n'y a aucun événement à venir pour le moment. Revenez bientôt !</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection

