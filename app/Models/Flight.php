<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class Flight extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'departure_icao',
        'arrival_icao',
        'flight_date',
        'comments',
        'route',
        'departure_time', // Ajouté
        'arrival_time', // Ajouté
        'is_breizhair_event',
        'is_ivao_event',
        'nautical_miles',
        'flight_duration',
        'validated_by',
        'validation_comments',
        'status',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($flight) {
            if ($flight->departure_time && $flight->arrival_time) {
                $departureTime = Carbon::parse($flight->departure_time);
                $arrivalTime = Carbon::parse($flight->arrival_time);

                if ($arrivalTime->lessThan($departureTime)) {
                    $arrivalTime->addDay();
                }

                $flight->flight_duration = abs($arrivalTime->diffInMinutes($departureTime));
            }
        });
    }

    /**
     * Définit la relation : un vol appartient à un utilisateur.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Accessor pour formater la durée d'un vol.
     * Sera accessible via $flight->formatted_duration
     */
    public function getFormattedDurationAttribute(): string
    {
        $totalMinutes = $this->flight_duration;
        if ($totalMinutes === null || $totalMinutes <= 0) {
            return 'N/A';
        }
        $hours = floor($totalMinutes / 60);
        $minutes = $totalMinutes % 60;

        return sprintf('%dh %02dm', $hours, $minutes);
    }
}

