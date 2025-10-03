<x-app-layout>
    <x-slot name="header">
        {{-- On affiche un titre clair en utilisant les codes OACI --}}
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Modifier la ligne : {{ $route->departure_icao }} &rarr; {{ $route->arrival_icao }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    {{-- On inclut le formulaire partiel en lui passant les données de la route --}}
                    @include('admin.routes.partials.form', ['route' => $route])
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

