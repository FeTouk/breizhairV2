<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Flight;
use Illuminate\Support\Carbon;

class RecalculateFlightDurations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flights:recalculate-durations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recalculate flight durations for existing flights, especially to fix negative values.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting recalculation of flight durations...');

        // Fetch flights where duration is negative or simply all non-validated flights
        $flightsToFix = Flight::where('flight_duration', '<', 0)->orWhereNull('flight_duration')->get();
        
        if ($flightsToFix->isEmpty()) {
            $this->info('No flights with negative or NULL duration found to fix.');
            return 0;
        }

        $progressBar = $this->output->createProgressBar($flightsToFix->count());
        $progressBar->start();

        $fixedCount = 0;

        foreach ($flightsToFix as $flight) {
            if ($flight->departure_time && $flight->arrival_time) {
                $departureTime = Carbon::parse($flight->departure_time);
                $arrivalTime = Carbon::parse($flight->arrival_time);

                if ($arrivalTime->lessThan($departureTime)) {
                    $arrivalTime->addDay();
                }

                $newDuration = $arrivalTime->diffInMinutes($departureTime);

                // Update only if the duration changes
                if ($flight->flight_duration !== $newDuration) {
                    $flight->flight_duration = $newDuration;
                    $flight->save();
                    $fixedCount++;
                }
            }
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->info("\nRecalculation complete.");
        $this->info("{$fixedCount} flight(s) were updated.");
        return 0;
    }
}
