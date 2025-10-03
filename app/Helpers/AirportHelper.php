<?php

// app/Helpers/AirportHelper.php

if (!function_exists('getAirportName')) {
    /**
     * Traduit un code OACI en nom d'aéroport complet.
     *
     * @param string $icao Le code OACI de 4 lettres.
     * @return string Le nom complet de l'aéroport ou le code OACI si non trouvé.
     */
    function getAirportName(string $icao): string
    {
        $icao = strtoupper($icao);

        // Dictionnaire étendu des aéroports européens
        static $airports = [
            // France (Liste étendue)
            'LFAB' => 'Dieppe - Saint-Aubin',
            'LFAE' => 'Eu - Mers - Le Tréport',
            'LFAG' => 'Péronne - Saint-Quentin',
            'LFAI' => 'Nangis - Les Loges',
            'LFAJ' => 'Argentan',
            'LFAK' => 'Dunkerque - Les Moëres',
            'LFAL' => 'La Flèche - Thorée-les-Pins',
            'LFAM' => 'Berck-sur-Mer',
            'LFAQ' => 'Bray',
            'LFAT' => 'Le Touquet-Côte d\'Opale',
            'LFAU' => 'Vauville',
            'LFAV' => 'Valenciennes - Denain',
            'LFAX' => 'Mortagne-au-Perche',
            'LFAY' => 'Amiens - Glisy',
            'LFBA' => 'Agen-La Garenne',
            'LFBC' => 'Cazaux',
            'LFBD' => 'Bordeaux-Mérignac',
            'LFBE' => 'Bergerac-Dordogne-Périgord',
            'LFBG' => 'Cognac-Châteaubernard',
            'LFBH' => 'La Rochelle-Île de Ré',
            'LFBI' => 'Poitiers-Biard',
            'LFBM' => 'Mont-de-Marsan',
            'LFBN' => 'Niort - Souché',
            'LFBP' => 'Pau-Pyrénées',
            'LFBR' => 'La Réole - Floudès',
            'LFBT' => 'Tarbes-Lourdes-Pyrénées',
            'LFBV' => 'Brive-Souillac',
            'LFBX' => 'Périgueux-Bassillac',
            'LFBZ' => 'Biarritz-Pays Basque',
            'LFCA' => 'Châtellerault - Targé',
            'LFCB' => 'Bagnères-de-Luchon',
            'LFCC' => 'Cahors - Lalbenque',
            'LFCD' => 'Andernos-les-Bains',
            'LFCH' => 'Arcachon - La Teste-de-Buch',
            'LFCI' => 'Albi - Le Séquestre',
            'LFCK' => 'Castres-Mazamet',
            'LFCL' => 'Toulouse-Lasbordes',
            'LFCR' => 'Rodez-Aveyron',
            'LFCU' => 'Ussel - Thalamy',
            'LFCW' => 'Villeneuve-sur-Lot',
            'LFCY' => 'Royan - Médis',
            'LFCZ' => 'Mimizan',
            'LFDB' => 'Montluçon - Guéret',
            'LFDC' => 'Montendre - Marcillac',
            'LFDH' => 'Auch-Gers',
            'LFDJ' => 'Pamiers - Les Pujols',
            'LFDM' => 'Marmande - Virazeil',
            'LFDN' => 'Rochefort - Saint-Agnant',
            'LFDU' => 'Les Mureaux',
            'LFEA' => 'Belle-Île',
            'LFEC' => 'Ouessant',
            'LFED' => 'Pontivy',
            'LFEH' => 'Aubigny-sur-Nère',
            'LFEI' => 'Briare - Châtillon',
            'LFEQ' => 'Quiberon',
            'LFER' => 'Redon - Bains-sur-Oust',
            'LFES' => 'Guiscriff - Scaër',
            'LFEY' => 'Île d\'Yeu',
            'LFFI' => 'Ancenis',
            'LFFN' => 'Brioude - Beaumont',
            'LFFQ' => 'La Roche-sur-Yon - Les Ajoncs',
            'LFGA' => 'Colmar-Houssen',
            'LFGF' => 'Vesoul-Frotey',
            'LFGJ' => 'Dole-Jura',
            'LFGS' => 'Longuyon - Villette',
            'LFGW' => 'Verdun - Sommedieue',
            'LFJL' => 'Metz-Nancy-Lorraine',
            'LFJR' => 'Angers-Loire',
            'LFKB' => 'Bastia-Poretta',
            'LFKC' => 'Calvi-Sainte-Catherine',
            'LFKF' => 'Figari-Sud Corse',
            'LFKJ' => 'Ajaccio-Napoléon Bonaparte',
            'LFKL' => 'Lyon - Corbas',
            'LFLA' => 'Auxerre-Branches',
            'LFLB' => 'Chambéry-Savoie-Mont-Blanc',
            'LFLC' => 'Clermont-Ferrand-Auvergne',
            'LFLH' => 'Chalon - Champforgeuil',
            'LFLI' => 'Annonay',
            'LFLL' => 'Lyon-Saint Exupéry',
            'LFLM' => 'Mâcon - Charnay',
            'LFLN' => 'Saint-Yan',
            'LFLP' => 'Annecy-Meythet',
            'LFLS' => 'Grenoble-Alpes-Isère',
            'LFLU' => 'Valence-Chabeuil',
            'LFLV' => 'Vichy-Charmeil',
            'LFLW' => 'Aurillac',
            'LFLX' => 'Châteauroux-Déols',
            'LFLY' => 'Lyon-Bron',
            'LFMA' => 'Aix-Les Milles',
            'LFMC' => 'Le Luc - Le Cannet',
            'LFMD' => 'Cannes-Mandelieu',
            'LFMF' => 'Fayence',
            'LFMG' => 'La Montagne Noire',
            'LFMI' => 'Istres-Le Tubé',
            'LFML' => 'Marseille-Provence',
            'LFMN' => 'Nice-Côte d\'Azur',
            'LFMP' => 'Perpignan-Rivesaltes',
            'LFMS' => 'Alès - Deaux',
            'LFMT' => 'Montpellier-Méditerranée',
            'LFNB' => 'Mende - Brenoux',
            'LFOH' => 'Le Havre-Octeville',
            'LFOK' => 'Châlons-Vatry',
            'LFOP' => 'Rouen-Vallée de Seine',
            'LFOQ' => 'Blois - Le Breuil',
            'LFOT' => 'Tours-Val de Loire',
            'LFOZ' => 'Orléans - Saint-Denis-de-l\'Hôtel',
            'LFPB' => 'Paris-Le Bourget',
            'LFPC' => 'Creil',
            'LFPG' => 'Paris-Charles de Gaulle',
            'LFPL' => 'Lognes-Émerainville',
            'LFPM' => 'Melun-Villaroche',
            'LFPN' => 'Toussus-le-Noble',
            'LFPO' => 'Paris-Orly',
            'LFPT' => 'Pontoise-Cormeilles-en-Vexin',
            'LFQB' => 'Troyes-Barberey',
            'LFQG' => 'Nevers-Fourchambault',
            'LFQI' => 'Cambrai-Épinoy',
            'LFQJ' => 'Maubeuge - Élesmes',
            'LFQL' => 'Le-Plessis-Belleville',
            'LFQM' => 'Besançon - La Vèze',
            'LFQO' => 'Lons-le-Saunier - Courlaoux',
            'LFQP' => 'St-Quentin - Roupy',
            'LFQQ' => 'Lille-Lesquin',
            'LFQT' => 'Merville - Calonne',
            'LFQV' => 'Charleville-Mézières',
            'LFQW' => 'Épinal - Dogneville',
            'LFRB' => 'Brest-Bretagne',
            'LFRC' => 'Cherbourg-Manche',
            'LFRD' => 'Dinard-Pleurtuit-Saint-Malo',
            'LFRF' => 'Granville-Mont-Saint-Michel',
            'LFRG' => 'Deauville-Normandie',
            'LFRH' => 'Lorient-Bretagne-Sud',
            'LFRI' => 'La Roche-sur-Yon',
            'LFRK' => 'Caen-Carpiquet',
            'LFRM' => 'Le Mans-Arnage',
            'LFRN' => 'Rennes-Saint-Jacques',
            'LFRO' => 'Lannion-Côte de Granit Rose',
            'LFRQ' => 'Quimper-Bretagne',
            'LFRS' => 'Nantes-Atlantique',
            'LFRT' => 'Saint-Brieuc-Armor',
            'LFRU' => 'Morlaix-Ploujean',
            'LFRV' => 'Vannes-Golfe du Morbihan',
            'LFSB' => 'Bâle-Mulhouse-Fribourg',
            'LFSO' => 'Nancy-Essey',
            'LFST' => 'Strasbourg-Entzheim',
            'LFTF' => 'Cuers-Pierrefeu',
            'LFTW' => 'Nîmes-Garons',
            'LFTZ' => 'La Môle - Saint-Tropez',

            // Royaume-Uni
            'EGLL' => 'Londres-Heathrow',
            'EGKK' => 'Londres-Gatwick',
            'EGSS' => 'Londres-Stansted',
            'EGGW' => 'Londres-Luton',
            'EGLC' => 'Londres-City',
            'EGCC' => 'Manchester',
            'EGBB' => 'Birmingham',
            'EGPH' => 'Édimbourg',
            'EGPF' => 'Glasgow',
            'EGNT' => 'Newcastle',
            'EGNX' => 'East Midlands',
            'EGGD' => 'Bristol',
            'EGHI' => 'Southampton',
            'EGJJ' => 'Jersey',

            // Allemagne
            'EDDF' => 'Francfort-sur-le-Main',
            'EDDM' => 'Munich-Franz Josef Strauss',
            'EDDB' => 'Berlin-Brandebourg',
            'EDDH' => 'Hambourg',
            'EDDL' => 'Düsseldorf',
            'EDDK' => 'Cologne-Bonn',
            'EDDS' => 'Stuttgart',
            'EDDV' => 'Hanovre',
            'EDDP' => 'Leipzig/Halle',

            // Espagne
            'LEMD' => 'Madrid-Barajas Adolfo Suárez',
            'LEBL' => 'Barcelone-El Prat',
            'LEPA' => 'Palma de Majorque',
            'LEMG' => 'Malaga-Costa del Sol',
            'LEAL' => 'Alicante-Elche',
            'GCTS' => 'Tenerife-Sud',
            'GCXO' => 'Tenerife-Nord',
            'LEIB' => 'Ibiza',
            'LEVC' => 'Valence',
            'LEZL' => 'Séville',
            'LEBB' => 'Bilbao',

            // Italie
            'LIRF' => 'Rome-Fiumicino Léonard-de-Vinci',
            'LIRA' => 'Rome-Ciampino',
            'LIMC' => 'Milan-Malpen',
            'LIPZ' => 'Venise-Marco Polo',
            'LIPE' => 'Bologne-Guglielmo Marconi',
            'LIRN' => 'Naples-Capodichino',
            'LICJ' => 'Palerme-Falcone Borsellino',
            'LICC' => 'Catane-Fontanarossa',

            // Pays-Bas
            'EHAM' => 'Amsterdam-Schiphol',
            'EHRD' => 'Rotterdam-La Haye',

            // Belgique
            'EBBR' => 'Bruxelles-National',
            'EBCI' => 'Charleroi-Bruxelles-Sud',

            // Suisse
            'LSZH' => 'Zurich',
            'LSGG' => 'Genève-Cointrin',
            'LFSB' => 'Bâle-Mulhouse (EuroAirport)',

            // Portugal
            'LPPT' => 'Lisbonne-Humberto Delgado',
            'LPPR' => 'Porto-Francisco Sá Carneiro',
            'LPFR' => 'Faro',
            'LPMA' => 'Madère-Cristiano Ronaldo',

            // Irlande
            'EIDW' => 'Dublin',
            'EICK' => 'Cork',

            // Grèce
            'LGAV' => 'Athènes-Elefthérios Venizélos',
            'LGIR' => 'Héraklion-Níkos-Kazantzákis',
            'LGTS' => 'Thessalonique-Makedonía',
            
            // Autriche
            'LOWW' => 'Vienne-Schwechat',

            // Scandinavie
            'EKCH' => 'Copenhague-Kastrup (Danemark)',
            'ESSA' => 'Stockholm-Arlanda (Suède)',
            'ENGM' => 'Oslo-Gardermoen (Norvège)',
            'EFHK' => 'Helsinki-Vantaa (Finlande)',

            // Pologne
            'EPWA' => 'Varsovie-Chopin',
            'EPKK' => 'Cracovie-Jean-Paul II',

            // République Tchèque
            'LKPR' => 'Prague-Václav Havel',
            
            // Hongrie
            'LHBP' => 'Budapest-Ferenc Liszt',
            
            // Roumanie
            'LROP' => 'Bucarest-Henri Coandă',

            // Turquie (partie européenne)
            'LTFM' => 'Istanbul',
        ];

        return $airports[$icao] ?? $icao;
    }
}