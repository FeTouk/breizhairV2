<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Modifier le profil de {{ $pilot->first_name }} {{ $pilot->last_name }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ modalOpen: false }">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    <form action="{{ route('pilots.update', $pilot) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Infos Personnelles --}}
                            <div>
                                <label for="first_name" class="block text-sm font-medium text-gray-700">Prénom</label>
                                <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $pilot->first_name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                            <div>
                                <label for="last_name" class="block text-sm font-medium text-gray-700">Nom</label>
                                <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $pilot->last_name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                            <div>
                                <label for="callsign" class="block text-sm font-medium text-gray-700">Callsign</label>
                                <input type="text" name="callsign" id="callsign" value="{{ old('callsign', $pilot->callsign) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                            <div>
                                <label for="role" class="block text-sm font-medium text-gray-700">Rôle</label>
                                <select name="role" id="role" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    <option value="user" @selected($pilot->role == 'user')>Pilote</option>
                                    <option value="admin" @selected($pilot->role == 'admin')>Admin</option>
                                </select>
                            </div>
                             <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Statut</label>
                                <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    <option value="pending" @selected($pilot->status == 'pending')>En attente (test non passé)</option>
                                    <option value="active" @selected($pilot->status == 'active')>Actif</option>
                                    <option value="inactive" @selected($pilot->status == 'inactive')>Inactif</option>
                                </select>
                            </div>
                             <div>
                                <label for="grade" class="block text-sm font-medium text-gray-700">Grade</label>
                                <input type="text" name="grade" id="grade" value="{{ old('grade', $pilot->grade) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>

                            {{-- Statistiques --}}
                            <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6 border-t pt-6">
                                <div>
                                    <label for="skycoins" class="block text-sm font-medium text-gray-700">SkyCoins</label>
                                    <input type="number" id="skycoins" value="{{ old('skycoins', $pilot->skycoins) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100" disabled>
                                    <button type="button" @click.prevent="modalOpen = true" class="mt-2 text-sm text-blue-600 hover:text-blue-800">Faire une opération</button>
                                </div>
                            </div>
                        </div>
                        <div class="mt-8 flex justify-end">
                            <a href="{{ route('pilots.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-lg mr-4">Annuler</a>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">
                                Mettre à jour le profil
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Modal --}}
        <div x-show="modalOpen" @keydown.escape.window="modalOpen = false" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" x-cloak>
            <div @click.away="modalOpen = false" class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Opération sur les SkyCoins</h3>
                <form action="{{ route('pilots.skycoins.update', $pilot) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <p class="mb-4 text-gray-900">Solde actuel : <strong>{{ number_format($pilot->skycoins) }}</strong> SkyCoins</p>
                    <div>
                        <label for="amount" class="block text-sm font-medium text-gray-700">Montant</label>
                        <input type="number" name="amount" id="amount" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required min="0">
                    </div>
                    <div class="mt-6 flex justify-between items-center space-x-2">
                        <button type="submit" name="operation" value="subtract" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg">Retirer</button>
                        <button type="submit" name="operation" value="add" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg">Ajouter</button>
                        <button type="submit" name="operation" value="set" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">Définir</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</x-app-layout>