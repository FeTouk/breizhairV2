@extends('layouts.main')

@section('title', 'Nos Badges')

@section('content')
    <div class="bg-white rounded-lg shadow-xl p-8 lg:p-12">
        
        <h1 class="text-3xl lg:text-4xl font-bold text-gray-800 mb-8 text-center border-b pb-4">
            Nos Badges
        </h1>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Badge
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Nom
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Description
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">

                    {{-- On utilise une boucle pour générer toutes les lignes du tableau --}}
                    @foreach ($badges as $badge)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <img class="h-12 w-12 object-contain" src="{{ asset('images/' . $badge['image']) }}" alt="Badge {{ $badge['name'] }}">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $badge['name'] }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $badge['description'] }}</td>
                        </tr>
                    @endforeach
                    
                </tbody>
            </table>
        </div>
    </div>
@endsection