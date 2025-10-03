    <?php

    if (!function_exists('getAiracData')) {
        /**
         * Calcule et retourne les informations sur les cycles AIRAC actuels et futurs.
         * @param int $numberOfCycles Le nombre de cycles futurs à générer.
         * @return array Un tableau contenant le cycle actuel et les cycles futurs.
         */
        function getAiracData(int $numberOfCycles = 6): array
        {
            $airacBaseDate = new \DateTime('2000-01-27', new \DateTimeZone('UTC'));
            $now = new \DateTime('now', new \DateTimeZone('UTC'));
            
            $diffDays = $now->diff($airacBaseDate)->days;
            $currentCycleIndex = floor($diffDays / 28);

            $cycles = [];
            
            for ($i = 0; $i < $numberOfCycles; $i++) {
                $cycleIndex = $currentCycleIndex + $i;
                $startDate = clone $airacBaseDate;
                $startDate->modify('+' . ($cycleIndex * 28) . ' days');
                
                $endDate = clone $startDate;
                $endDate->modify('+27 days');

                $year = $startDate->format('y');
                $cycleNumberInYear = floor(($startDate->format('z')) / 28) + 1;
                $airacIdentifier = sprintf('%s%02d', $year, $cycleNumberInYear);

                $isCurrent = ($i === 0);

                $cycles[$airacIdentifier] = [
                    'identifier' => $airacIdentifier,
                    'start_date' => $startDate->format('d M Y'),
                    'end_date' => $endDate->format('d M Y'),
                    'is_current' => $isCurrent,
                ];
            }

            return $cycles;
        }
    }

    if (!function_exists('getCurrentAiracIdentifier')) {
        /**
         * Retourne uniquement l'identifiant du cycle AIRAC en cours.
         * @return string
         */
        function getCurrentAiracIdentifier(): string
        {
            $airacData = getAiracData(1);
            return array_key_first($airacData);
        }
    }
    
