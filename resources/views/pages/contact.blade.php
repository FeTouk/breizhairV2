@extends('layouts.main')

@section('title', 'Contact')

@section('content')
    <div class="bg-white rounded-lg shadow-xl p-8 lg:p-12 max-w-2xl mx-auto">
        
        <h1 class="text-3xl lg:text-4xl font-bold text-gray-800 mb-4 text-center">
            Contactez-nous
        </h1>
        <p class="text-gray-600 text-center mb-8">
            Une question, une suggestion ou un problème ? N'hésitez pas à nous envoyer un message.
        </p>

        <form action="{{ url('/contact') }}" method="POST">
            @csrf {{-- Protection de sécurité Laravel, obligatoire ! --}}

            <div class="space-y-6">
                {{-- Champ Nom --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nom complet</label>
                    <div class="mt-1">
                        <input type="text" name="name" id="name" required class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-3">
                    </div>
                </div>

                {{-- Champ Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Adresse e-mail</label>
                    <div class="mt-1">
                        <input type="email" name="email" id="email" required class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-3">
                    </div>
                </div>

                {{-- Champ Sujet --}}
                <div>
                    <label for="subject" class="block text-sm font-medium text-gray-700">Sujet</label>
                    <div class="mt-1">
                        <input type="text" name="subject" id="subject" required class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-3">
                    </div>
                </div>

                {{-- Champ Message --}}
                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700">Votre message</label>
                    <div class="mt-1">
                        <textarea name="message" id="message" rows="6" required class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-3"></textarea>
                    </div>
                </div>
            </div>

            {{-- Bouton d'envoi --}}
            <div class="mt-8 text-right">
                <button type="submit" class="bg-[#17A4F6] hover:bg-[#138fd9] text-white font-bold py-3 px-6 rounded-lg transition duration-300 transform hover:scale-105">
                    Envoyer le message
                </button>
            </div>
        </form>
    </div>
@endsection