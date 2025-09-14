<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($question) ? 'Modifier la Question' : 'Ajouter une Question' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ isset($question) ? route('questions.update', $question) : route('questions.store') }}" method="POST">
                        @csrf
                        @if(isset($question))
                            @method('PUT')
                        @endif

                        <div class="space-y-6">
                            {{-- Question --}}
                            <div>
                                <label for="question" class="block text-sm font-medium text-gray-700">Texte de la question</label>
                                <input type="text" name="question" id="question" value="{{ old('question', $question->question ?? '') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>

                            {{-- Choix 1 --}}
                            <div>
                                <label for="choix_1" class="block text-sm font-medium text-gray-700">Choix de réponse 1</label>
                                <input type="text" name="choix_1" id="choix_1" value="{{ old('choix_1', $question->choix_1 ?? '') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>

                            {{-- Choix 2 --}}
                            <div>
                                <label for="choix_2" class="block text-sm font-medium text-gray-700">Choix de réponse 2</label>
                                <input type="text" name="choix_2" id="choix_2" value="{{ old('choix_2', $question->choix_2 ?? '') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>

                            {{-- Choix 3 --}}
                            <div>
                                <label for="choix_3" class="block text-sm font-medium text-gray-700">Choix de réponse 3</label>
                                <input type="text" name="choix_3" id="choix_3" value="{{ old('choix_3', $question->choix_3 ?? '') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>

                            {{-- Réponse Correcte --}}
                            <div>
                                <label for="reponse_correcte" class="block text-sm font-medium text-gray-700">Numéro de la réponse correcte</label>
                                <select name="reponse_correcte" id="reponse_correcte" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    <option value="1" @selected(old('reponse_correcte', $question->reponse_correcte ?? '') == 1)>Choix 1</option>
                                    <option value="2" @selected(old('reponse_correcte', $question->reponse_correcte ?? '') == 2)>Choix 2</option>
                                    <option value="3" @selected(old('reponse_correcte', $question->reponse_correcte ?? '') == 3)>Choix 3</option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-8 text-right">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                {{ isset($question) ? 'Mettre à jour' : 'Enregistrer' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>