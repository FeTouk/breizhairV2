<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'ivao_vid',
        'discord',
        'email',
        'password',
        'role',
        'status',
        'callsign',
        'grade',
        'current_airport',
        'skycoins',
        'total_flight_hours',
        'total_flights',
        'total_nautical_miles',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Définit la relation : un utilisateur peut avoir plusieurs vols.
     */
    public function flights(): HasMany
    {
        return $this->hasMany(Flight::class);
    }

    /**
     * Vérifie si l'utilisateur a le rôle d'administrateur.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Accessor pour formater le total des heures de vol.
     * Sera accessible via $user->formatted_flight_hours
     */
    public function getFormattedFlightHoursAttribute(): string
    {
        $totalMinutes = $this->total_flight_hours;
        if ($totalMinutes === null || $totalMinutes <= 0) {
            return '00:00';
        }
        $hours = floor($totalMinutes / 60);
        $minutes = $totalMinutes % 60;

        return sprintf('%02d:%02d', $hours, $minutes);
    }
}

