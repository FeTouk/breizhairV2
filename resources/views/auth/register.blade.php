<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Logo -->
        <div class="flex justify-center mb-6">
            <a href="/">
                <img src="{{ asset('images/breizhair_logo_nav.png') }}" alt="Logo Breizh Air" class="h-20 w-auto">
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Prénom -->
            <div>
                <x-input-label for="first_name" value="Prénom" />
                <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="old('first_name')" required autofocus />
                <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
            </div>

            <!-- Nom -->
            <div>
                <x-input-label for="last_name" value="Nom" />
                <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')" required />
                <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
            </div>
        </div>

        <!-- VID IVAO -->
        <div class="mt-4">
            <x-input-label for="ivao_vid" value="VID IVAO" />
            <x-text-input id="ivao_vid" class="block mt-1 w-full" type="text" name="ivao_vid" :value="old('ivao_vid')" required />
            <x-input-error :messages="$errors->get('ivao_vid')" class="mt-2" />
        </div>
        
        <!-- Discord -->
        <div class="mt-4">
            <x-input-label for="discord" value="Discord (facultatif)" />
            <x-text-input id="discord" class="block mt-1 w-full" type="text" name="discord" :value="old('discord')" />
            <x-input-error :messages="$errors->get('discord')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" value="Adresse e-mail" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" value="Mot de passe" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" value="Confirmer le mot de passe" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Terms and Conditions -->
        <div class="mt-4">
            <div class="flex items-center">
                <input id="terms" type="checkbox" name="terms" required class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                <label for="terms" class="ms-2 text-sm text-gray-600">J'ai lu et j'accepte le <a href="{{ url('/reglement') }}" target="_blank" class="underline hover:text-gray-900">règlement de la compagnie</a>.</label>
            </div>
             <x-input-error :messages="$errors->get('terms')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                Déjà inscrit ?
            </a>

            <x-primary-button class="ms-4">
                S'inscrire
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
