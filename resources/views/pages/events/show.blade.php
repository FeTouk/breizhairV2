@extends('layouts.main')

@section('title', $event->title)

@section('content')
    <div class="bg-white rounded-lg shadow-xl p-8 lg:p-12">
        
        {{-- Image principale --}}
        {{-- MODIFICATION ICI : On limite la hauteur et on centre l'image --}}
        <img src="{{ $event->image ? asset('storage/' . $event->image) : 'https://placehold.co/1200x500/374151/E5E7EB?text=Breizh\'Air' }}" alt="Image pour {{ $event->title }}" class="w-auto max-h-[400px] mx-auto rounded-lg mb-8">
        
        {{-- Méta-informations --}}
        <div class="mb-6 text-sm text-gray-500">
            <span>Publié le {{ $event->created_at->format('d/m/Y') }} par {{ $event->author->first_name }}</span>
            <span class="mx-2">|</span>
            <span>Événement prévu le <strong>{{ $event->event_date->format('d/m/Y à H:i') }}</strong></span>
        </div>
        
        {{-- Titre --}}
        <h1 class="text-4xl lg:text-5xl font-extrabold text-gray-900 mb-8">
            {{ $event->title }}
        </h1>
        
        {{-- Contenu de l'événement, stylisé avec "prose" --}}
        <div class="prose prose-lg max-w-none text-justify">
            {!! nl2br(e($event->content)) !!}
        </div>
    </div>
@endsection

