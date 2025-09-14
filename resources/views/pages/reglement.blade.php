@extends('layouts.main')

@section('title', 'Règlement Intérieur')

@section('content')
    <div class="bg-white rounded-lg shadow-xl p-8 lg:p-12">
        
        {{-- En-tête du document --}}
        <div class="text-center mb-12">
            <img src="{{ asset('images/breizhair_logo_nav.png') }}" alt="Logo Breizh'Air" class="mx-auto h-20 w-auto mb-4">
            <h1 class="text-4xl font-bold text-gray-900">Règlement de la compagnie</h1>
            <p class="text-sm text-gray-500 mt-2">Dernière mise à jour : {{ date('d/m/Y') }}</p>
        </div>

        {{-- Contenu du règlement --}}
        <div class="prose max-w-none text-gray-700 leading-relaxed text-justify">

            <h2 class="text-3xl font-extrabold text-gray-900 mb-4">Préambule</h2>
            <p class="mb-4">
                Breizh'Air est une compagnie aérienne virtuelle évoluant sur le réseau <a href="https://ivao.fr/fr" target="_blank" rel="noopener noreferrer">IVAO</a> offrant à ses membres l'opportunité de voler et de partager leur passion pour l'aviation. Les membres de Breizh'Air doivent se conformer à toutes les règles et réglementations établies par la compagnie ainsi que par le réseau IVAO.
            </p>

            <h2 class="text-3xl font-extrabold text-gray-900 mb-4 mt-8">Article 1 - Inscription</h2>
            <h3 class="text-2xl font-bold text-gray-800 mb-2 mt-6">1.1 - Test d'entrée</h3>
            <p class="mb-4">
                Toute personne souhaitant rejoindre la compagnie Breizh'Air doit remplir le <a href="/inscription">formulaire d'inscription</a> et passer un test sous forme de QCM de 10 questions pour évaluer ses connaissances aéronautiques. En cas d'échec, des entretiens et un délai могут être imposés avant de pouvoir retenter le test.
            </p>
            <h3 class="text-2xl font-bold text-gray-800 mb-2 mt-6">1.2 - Formulaire d'inscription</h3>
            <p class="mb-4">
                L'adhésion est ouverte à tous et les membres doivent accepter les règlements de la compagnie et du réseau IVAO, en fournissant des informations exactes et complètes.
            </p>

            <h2 class="text-3xl font-extrabold text-gray-900 mb-4 mt-8">Article 2 - Vols</h2>
            <h3 class="text-2xl font-bold text-gray-800 mb-2 mt-6">2.1 - Activité</h3>
            <p class="mb-4">
                Un pilote doit voler au minimum une fois sur une période de 3 mois avec son callsign Breizh'Air, sauf durant la période estivale, sous peine d'expulsion.
            </p>
            <h3 class="text-2xl font-bold text-gray-800 mb-2 mt-6">2.2 - Règles de vol chez Breizh'Air</h3>
            <p class="mb-4">
                Les vols doivent être effectués sur le réseau IVAO et enregistrés par le tracker officiel. Les vols avec d'autres compagnies ne comptent pas pour les heures de vol Breizh'Air.
            </p>
            <h4 class="text-xl font-bold text-gray-700 mb-2 mt-4">2.2.1 - Rapport de vol</h4>
            <p class="mb-4">
                Un rapport de vol doit être déposé dans l'espace pilote dans les 7 jours suivant le vol pour comptabiliser les heures et les milles nautiques. Ce rapport doit contenir des informations précises comme la date de départ, les codes OACI des aéroports et toute communication avec le contrôle aérien.
            </p>
            <h4 class="text-xl font-bold text-gray-700 mb-2 mt-4">2.2.2 - Validation d'un rapport</h4>
            <p class="mb-4">
                Un rapport peut être refusé ou faire l'objet d'un avertissement en cas de non-conformité avec les règles. Des erreurs telles qu'un écart d'altitude important, une déconnexion prolongée, le non-respect des limitations de vitesse, ou l'utilisation d'une route non valide peuvent entraîner des sanctions.
            </p>

            <h2 class="text-3xl font-extrabold text-gray-900 mb-4 mt-8">Article 3 - Activités</h2>
            <h3 class="text-2xl font-bold text-gray-800 mb-2 mt-6">3.1 - Minimas d'activité</h3>
            <p class="mb-4">
                Tout pilote doit effectuer au minimum 1 vol tous les 3 mois, hors période estivale, sous peine d'exclusion.
            </p>
            <h3 class="text-2xl font-bold text-gray-800 mb-2 mt-6">3.2 - Evènements</h3>
            <p class="mb-4">
                La compagnie organise des événements et encourage les membres à y participer. Les membres peuvent également proposer des événements avec l'approbation du pôle événementiel.
            </p>
            <h3 class="text-2xl font-bold text-gray-800 mb-2 mt-6">3.3 - Grades</h3>
            <p class="mb-4">
                Les pilotes peuvent être promus en fonction de leurs heures de vol, selon le barème suivant :
            </p>
            
            <div class="overflow-x-auto mb-8">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-3 px-4 border border-gray-300 text-gray-700 font-bold">Grade</th>
                            <th class="py-3 px-4 border border-gray-300 text-gray-700 font-bold">Heures de vol requises</th>
                            <th class="py-3 px-4 border border-gray-300 text-gray-700 font-bold w-[40%]">Insigne</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="py-2 px-4 border border-gray-300 align-middle">Apprenti pilote</td>
                            <td class="py-2 px-4 border border-gray-300 align-middle">Attribué aux nouveaux pilotes inscrits dans la compagnie.	</td>
                            <td class="py-2 px-4 border border-gray-300 align-middle text-center">
                                <img src="{{ asset('images/apprenti_pilote.png') }}" alt="Insigne Apprenti pilote" class="w-[20%] h-auto inline-block">
                            </td>
                        </tr>
                        <tr>
                            <td class="py-2 px-4 border border-gray-300 align-middle">Pilote</td>
                            <td class="py-2 px-4 border border-gray-300 align-middle">Attribué aux pilotes ayant 50 heures de vol dans la compagnie.</td>
                            <td class="py-2 px-4 border border-gray-300 align-middle text-center">
                                <img src="{{ asset('images/pilote.png') }}" alt="Insigne Pilote" class="w-[20%] h-auto inline-block">
                            </td>
                        </tr>
                        <tr>
                            <td class="py-2 px-4 border border-gray-300 align-middle">Officier pilote de ligne</td>
                            <td class="py-2 px-4 border border-gray-300 align-middle">Attribué aux pilotes ayant 200 heures de vol dans la compagnie.</td>
                            <td class="py-2 px-4 border border-gray-300 align-middle text-center">
                                <img src="{{ asset('images/officier_pilote_de_ligne.png') }}" alt="Insigne Officier pilote de ligne" class="w-[20%] h-auto inline-block">
                            </td>
                        </tr>
                        <tr>
                            <td class="py-2 px-4 border border-gray-300 align-middle">Commandant de bord</td>
                            <td class="py-2 px-4 border border-gray-300 align-middle">Attribué aux pilotes ayant 200 heures de vol dans la compagnie.</td>
                            <td class="py-2 px-4 border border-gray-300 align-middle text-center">
                                <img src="{{ asset('images/commandant_de_bord.png') }}" alt="Insigne Commandant de bord" class="w-[20%] h-auto inline-block">
                            </td>
                        </tr>
                        <tr>
                            <td class="py-2 px-4 border border-gray-300 align-middle">Pilote d'élite</td>
                            <td class="py-2 px-4 border border-gray-300 align-middle">Attribué aux pilotes ayant 200 heures de vol dans la compagnie.</td>
                            <td class="py-2 px-4 border border-gray-300 align-middle text-center">
                                <img src="{{ asset('images/pilote_elite.png') }}" alt="Insigne Pilote d'élite" class="w-[20%] h-auto inline-block">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <h2 class="text-3xl font-extrabold text-gray-900 mb-4 mt-8">Article 4 - Communication</h2>
            <h3 class="text-2xl font-bold text-gray-800 mb-2 mt-6">4.1 - Discord</h3>
            <p class="mb-4">
                Les membres sont encouragés à communiquer via le Discord de la compagnie en respectant les autres.
            </p>
            <h3 class="text-2xl font-bold text-gray-800 mb-2 mt-6">4.2 - Autres réseaux</h3>
            <p class="mb-4">
                Les pilotes peuvent publier ou streamer leur activité avec Breizh'Air à condition de respecter les règles d'IVAO et de la compagnie.
            </p>
        </div>
    </div>
@endsection