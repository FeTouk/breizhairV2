<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Créer un nouvel événement
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    {{-- 
                        On inclut le formulaire partiel.
                        Comme nous ne passons pas de variable $event, le formulaire saura qu'il est en mode "création".
                    --}}
                    @include('admin.events.partials.form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

