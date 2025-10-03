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

        // Dictionnaire des principaux aéroports européens
        static $airports = [
            // France
            'LFPG' => 'Paris-Charles de Gaulle',
            'LFPO' => 'Paris-Orly',
            'LFMN' => 'Nice-Côte d\'Azur',
            'LFLL' => 'Lyon-Saint Exupéry',
            'LFML' => 'Marseille-Provence',
            'LFBO' => 'Toulouse-Blagnac',
            'LFBD' => 'Bordeaux-Mérignac',
            'LFRS' => 'Nantes-Atlantique',
            'LFRB' => 'Brest-Bretagne',
            'LFRN' => 'Rennes-Saint-Jacques',
            'LFSB' => 'Bâle-Mulhouse-Fribourg',
            'LFRG' => 'Deauville-Normandie',
            'LFQQ' => 'Lille-Lesquin',
            'LFST' => 'Strasbourg-Entzheim',

            // Royaume-Uni
            'EGLL' => 'Londres-Heathrow',
            'EGKK' => 'Londres-Gatwick',
            'EGSS' => 'Londres-Stansted',
            'EGCC' => 'Manchester',
            'EGBB' => 'Birmingham',
            'EGGW' => 'Londres-Luton',

            // Allemagne
            'EDDF' => 'Francfort-sur-le-Main',
            'EDDM' => 'Munich-Franz Josef Strauss',
            'EDDB' => 'Berlin-Brandebourg',
            'EDDH' => 'Hambourg',
            'EDDL' => 'Düsseldorf',

            // Espagne
            'LEMD' => 'Madrid-Barajas',
            'LEBL' => 'Barcelone-El Prat',
            'LEPA' => 'Palma de Majorque',
            'LEMG' => 'Malaga-Costa del Sol',
            'LEIB' => 'Ibiza',

            // Italie
            'LIRF' => 'Rome-Fiumicino',
            'LIMC' => 'Milan-Malpensa',
            'LIPE' => 'Bologne',
            'LIRN' => 'Naples-Capodichino',
            
            // Pays-Bas
            'EHAM' => 'Amsterdam-Schiphol',

            // Belgique
            'EBBR' => 'Bruxelles-National',

            // Suisse
            'LSZH' => 'Zurich',
            'LSGG' => 'Genève-Cointrin',

            // Portugal
            'LPPT' => 'Lisbonne-Humberto Delgado',
            'LPPR' => 'Porto-Francisco Sá Carneiro',

            // Irlande
            'EIDW' => 'Dublin',
            
            // Grèce
            'LGAV' => 'Athènes-Elefthérios Venizélos',

            // Autriche
            'LOWW' => 'Vienne-Schwechat',

            // Scandinavie
            'EKCH' => 'Copenhague-Kastrup',
            'ESSA' => 'Stockholm-Arlanda',
            'ENGM' => 'Oslo-Gardermoen',
        ];

        return $airports[$icao] ?? $icao;
    }
}