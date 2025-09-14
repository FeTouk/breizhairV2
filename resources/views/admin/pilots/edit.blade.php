<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Modifier le profil de {{ $pilot->first_name }} {{ $pilot->last_name }}
        </h2>
    </x-slot>

    <div class="py-12">
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
                                    <input type="number" name="skycoins" id="skycoins" value="{{ old('skycoins', $pilot->skycoins) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
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
    </div>
</x-app-layout>
