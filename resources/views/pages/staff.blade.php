@extends('layouts.main')

@section('title', 'Notre Staff')

@section('content')
    <div class="bg-white rounded-lg shadow-xl p-8 lg:p-12">
        
        {{-- ======================================================== --}}
        {{-- PARTIE 1 : CONSEIL D'ADMINISTRATION --}}
        {{-- ======================================================== --}}
        <div>
            <h1 class="text-3xl lg:text-4xl font-bold text-gray-800 mb-6 text-center">
                Le Staff
            </h1>
            <h2 class="text-xl lg:text-2xl font-semibold text-gray-600 mb-12 text-center">
                Conseil d'administration
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 justify-items-center">
                {{-- Membre 1 --}}
                <div class="flex flex-col items-center text-center">
                    <img class="w-32 h-32 rounded-full object-cover mb-4 shadow-lg" src="{{ asset('images/aymericd.jpg') }}" alt="Photo de Aymeric D.">
                    <p class="text-lg font-semibold text-gray-900">Aymeric D.</p>
                    <p class="text-md text-gray-700">CEO</p>
                    <a href="mailto:ceo@breizhair.fr" class="text-blue-600 hover:underline">ceo@breizhair.fr</a>
                </div>
                {{-- Membre 2 --}}
                <div class="flex flex-col items-center text-center">
                    <img class="w-32 h-32 rounded-full object-cover mb-4 shadow-lg" src="{{ asset('images/raphaell.jpg') }}" alt="Photo de Raphael L.">
                    <p class="text-lg font-semibold text-gray-900">Raphael L.</p>
                    <p class="text-md text-gray-700">Pôle pilote</p>
                    <a href="mailto:pilote@breizhair.fr" class="text-blue-600 hover:underline">pilote@breizhair.fr</a>
                </div>
                {{-- Membre 3 --}}
                <div class="flex flex-col items-center text-center">
                    <img class="w-32 h-32 rounded-full object-cover mb-4 shadow-lg" src="{{ asset('images/aymericd.jpg') }}" alt="Photo de Aymeric D.">
                    <p class="text-lg font-semibold text-gray-900">Aymeric D.</p>
                    <p class="text-md text-gray-700">Pôle événements</p>
                    <a href="mailto:evenement@breizhair.fr" class="text-blue-600 hover:underline">evenement@breizhair.fr</a>
                </div>
                {{-- Membre 4 --}}
                <div class="flex flex-col items-center text-center">
                    <img class="w-32 h-32 rounded-full object-cover mb-4 shadow-lg" src="{{ asset('images/enzol.jpg') }}" alt="Photo de Enzo L.">
                    <p class="text-lg font-semibold text-gray-900">Enzo L.</p>
                    <p class="text-md text-gray-700">Pôle formation</p>
                    <a href="mailto:formation@breizhair.fr" class="text-blue-600 hover:underline">formation@breizhair.fr</a>
                </div>
            </div>
        </div>

        {{-- Séparateur --}}
        <hr class="my-16 border-gray-200">

        {{-- ======================================================== --}}
        {{-- PARTIE 2 : PÔLES DE LA COMPAGNIE --}}
        {{-- ======================================================== --}}
        <div x-data="{ openModal: false, selectedPole: null }">
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-800 mb-6 text-center">
                Pôles de la compagnie
            </h2>
            <p class="text-xl text-gray-600 mb-12 text-center max-w-3xl mx-auto">
                Afin de vous proposer les meilleurs services au sein de Breizh'air, notre staff est divisé en 3 pôles.
            </p>

            {{-- Grille des 3 pôles --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                {{-- Pôle Pilote --}}
                <div class="bg-gray-50 p-6 rounded-lg shadow-md flex flex-col">
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Pôle Pilote</h3>
                    <p class="text-gray-600 flex-grow">Ce pôle accompagnera les pilotes tout au long de leur expérience chez Breizh'air. Ce sont également eux qui créeront et gèreront les lignes de la compagnie, sans oublier de vous proposer de belles routes valides IFPS !</p>
                    <button @click="openModal = true; selectedPole = { 
                        title: 'Pôle Pilote', 
                        description: `
                            <p class='mb-4'>Ce pôle est tout d'abord en charge des lignes de la compagnie. Ils créent et gèrent ces lignes, sans oublier de vous proposer de belles routes valides IFPS !</p>
                            <p class='mb-4'>Ce pôle est également en charge de la validation des rapports de vols, ils sauront vous donner les meilleurs conseils pour améliorer vos vols. Ils s'assurent que les vols Breizh'air se déroulent en toute sécurité et respectent les procédures.</p>
                            <p>Enfin, que serait une compagnie sans relations humaines ? Le pôle pilote s'attachera à répondre aux moindres de vos questions , et vous accompagnera pour vous offrir la meilleure expérience possible avec Breizh'air !</p>
                        `,
                        members: [
                            { name: 'Raphael L.', role: 'Responsable Pôle Pilote' },
                            { name: 'Membre B', role: 'Membre' },
                        ] 
                    }" 
                    class="mt-4 bg-[#17A4F6] hover:bg-[#138fd9] text-white font-bold py-2 px-4 rounded transition duration-300 self-start">
                        En savoir plus
                    </button>
                </div>
                {{-- Pôle Événements --}}
                <div class="bg-gray-50 p-6 rounded-lg shadow-md flex flex-col">
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Pôle Événements</h3>
                    <p class="text-gray-600 flex-grow">Car une compagnie sans animations est une compagnie morte, le pôle évènement vous garantira de ne jamais vous ennuyer ! Entre tours de compagnie(VFR ou IFR), évènement ponctuel ou vol groupé, Breizh'air saura vous occuper !</p>
                    <button @click="openModal = true; selectedPole = { 
                        title: 'Pôle Événements', 
                        description: `
                            <p class='mb-4'>Le pôle évènements est en charge de l'organisation des évènements et animations qui font vivre Breizh'air.</p>
                            <p class='mb-4'>Ce pôle est en charge de la création des différents tours qui vous feront découvrir la Bretagne et le monde entier!</p>
                            <p class='mb-4'>Ce pôle est également en charge des diverses animations que propose la compagnie, comme les vols groupés, ou encore les missions, vols spéciaux à accomplir dans une période de temps donnée.</p>
                            <p>Enfin, ce pole gère les succès et badges que vous pourrez obtenir tout au long de votre expérience chez Breizh'air.</p>
                        `,
                        members: [
                            { name: 'Aymeric D.', role: 'Responsable Pôle Événements' },
                            { name: 'Membre C', role: 'Membre' },
                        ] 
                    }" 
                    class="mt-4 bg-[#17A4F6] hover:bg-[#138fd9] text-white font-bold py-2 px-4 rounded transition duration-300 self-start">
                        En savoir plus
                    </button>
                </div>
                {{-- Pôle Formation --}}
                <div class="bg-gray-50 p-6 rounded-lg shadow-md flex flex-col">
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Pôle Formation</h3>
                    <p class="text-gray-600 flex-grow">Vous voulez découvrir le vol ou vous perfectionner ? Le pôle formation aura à coeur de vous faire progresser dans le monde de la simulation de vol ! Profitez des conseils de pilotes aguerris ou participez a des conférences sur un sujet particulier, tout sera fait pour vous faire progresser !</p>
                    <button @click="openModal = true; selectedPole = { 
                        title: 'Pôle Formation', 
                        description: `
                            <p class='mb-4'>Le pôle formation a à coeur de faire progresser chaque pilote chez Breizh\'air.</p>
                            <p class='mb-4'>Ce pôle a comme première mission de mettre en place et de gérer le test théorique d'entrée dans la compagnie. Ils gèrent les questions du QCM, mais aussi l'entretien avec les pilotes en cas d'échec, car chez Breizh\'air, tout le monde a le droit à une seconde chance.</p>
                            <p class='mb-4'>Ce pôle a également en charge la formation continue des pilotes avec des conférences ou des trainings.</p>
                            <p>Leurs mots-clés sont bienveillances et progression, afin que chaque pilote s'épanouisse chez Breizh'air.</p>
                        `,
                        members: [
                            { name: 'Enzo L.', role: 'Responsable Pôle Formation' },
                            { name: 'Membre D', role: 'Membre' },
                        ] 
                    }" 
                    class="mt-4 bg-[#17A4F6] hover:bg-[#138fd9] text-white font-bold py-2 px-4 rounded transition duration-300 self-start">
                        En savoir plus
                    </button>
                </div>
            </div>

            {{-- Modal (fenêtre qui s'ouvre) avec fond transparent --}}
            <div x-show="openModal" 
                 x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" 
                 x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" 
                 class="fixed inset-0 flex items-center justify-center p-4 z-50" 
                 style="display: none;">
                
                <div @click.away="openModal = false" class="bg-white rounded-lg shadow-2xl w-full max-w-4xl p-8 relative">
                    <button @click="openModal = false" class="absolute top-4 right-4 text-gray-500 hover:text-gray-800">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8" x-show="selectedPole">
                        <div class="md:col-span-2">
                            <h3 class="text-3xl font-bold text-gray-800 mb-4" x-text="selectedPole?.title"></h3>
                            <div class="text-gray-600 leading-relaxed" x-html="selectedPole?.description"></div>
                        </div>
                        <div>
                            <h4 class="text-2xl font-bold text-gray-800 mb-4">Membres du pôle</h4>
                            <ul class="space-y-2">
                                <template x-for="member in selectedPole?.members" :key="member.name">
                                    <li>
                                        <p class="font-semibold text-gray-900" x-text="member.name"></p>
                                        <p class="text-sm text-gray-500" x-text="member.role"></p>
                                    </li>
                                </template>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection