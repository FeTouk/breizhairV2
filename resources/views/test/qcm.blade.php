@extends('layouts.main')

@section('title', 'Test d\'entrée')

@section('content')
<div class="bg-white rounded-lg shadow-xl p-8 lg:p-12 max-w-4xl mx-auto">
    <div class="text-center">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">Test d'entrée</h1>
        <p class="text-gray-600">Votre demande d'inscription a bien été prise en compte.</p>
        <p class="text-gray-600">Vous devez passer le test d'entrée de la compagnie. Ce test de 10 questions générées aléatoirement va nous permettre d'évaluer vos connaissances.</p>
        <p class="text-gray-600 mb-4">Chaque question vaut 2 points. Pour réussir le test, vous devez avoir une note supérieure ou égale à 16/20.</p>
        <div class="bg-red-100 text-red-700 p-2 rounded-md mb-8">
            <p class="font-bold">Ne pas actualiser cette page !</p>
        </div>
    </div>

    {{-- ======================================================== --}}
    {{-- BLOC POUR AFFICHER LES ERREURS --}}
    {{-- ======================================================== --}}
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
            <strong class="font-bold">Attention !</strong>
            <span class="block sm:inline">{{ $errors->first() }}</span>
        </div>
    @endif

    <form action="{{ route('test.verify') }}" method="POST">
        @csrf
        
        @foreach ($questions as $index => $question)
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">{{ $index + 1 }}. {{ $question->question }} ?</h2>
                <div class="space-y-3">
                    <div class="flex items-center">
                        <input id="q{{ $question->id }}_1" name="reponses[{{ $question->id }}]" type="radio" value="1" required class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300">
                        <label for="q{{ $question->id }}_1" class="ml-3 block text-sm font-medium text-gray-700">{{ $question->choix_1 }}</label>
                    </div>
                    <div class="flex items-center">
                        <input id="q{{ $question->id }}_2" name="reponses[{{ $question->id }}]" type="radio" value="2" required class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300">
                        <label for="q{{ $question->id }}_2" class="ml-3 block text-sm font-medium text-gray-700">{{ $question->choix_2 }}</label>
                    </div>
                    <div class="flex items-center">
                        <input id="q{{ $question->id }}_3" name="reponses[{{ $question->id }}]" type="radio" value="3" required class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300">
                        <label for="q{{ $question->id }}_3" class="ml-3 block text-sm font-medium text-gray-700">{{ $question->choix_3 }}</label>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="text-center mt-8">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300">
                Valider mes réponses
            </button>
        </div>
    </form>
</div>
@endsection