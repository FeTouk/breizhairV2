<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;

    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'line_type',
        'aircraft_type',
        'departure_icao',
        'arrival_icao',
        'route_string',
        'remarks',
        'validated_airac',
    ];
}