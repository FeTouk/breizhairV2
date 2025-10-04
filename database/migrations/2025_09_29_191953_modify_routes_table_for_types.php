<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('routes', function (Blueprint $table) {
            // On supprime l'ancienne colonne 'flight_number' seulement si elle existe
            if (Schema::hasColumn('routes', 'flight_number')) {
                $table->dropColumn('flight_number');
            }

            // On ajoute la nouvelle colonne 'line_type' après 'arrival_icao' seulement si elle n'existe pas déjà
            if (!Schema::hasColumn('routes', 'line_type')) {
                $table->string('line_type')->after('arrival_icao');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('routes', function (Blueprint $table) {
            // On recrée la colonne 'flight_number' si on annule la migration et si elle n'existe pas déjà
            if (!Schema::hasColumn('routes', 'flight_number')) {
                $table->string('flight_number', 10)->unique()->after('id');
            }
            
            // Et on supprime 'line_type' si elle existe
            if (Schema::hasColumn('routes', 'line_type')) {
                $table->dropColumn('line_type');
            }
        });
    }
};