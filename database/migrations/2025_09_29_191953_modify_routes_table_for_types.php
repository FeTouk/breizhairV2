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
            // On supprime l'ancienne colonne 'flight_number'
            $table->dropColumn('flight_number');

            // On ajoute la nouvelle colonne 'line_type' après 'arrival_icao'
            $table->string('line_type')->after('arrival_icao');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('routes', function (Blueprint $table) {
            // On recrée la colonne 'flight_number' si on annule la migration
            $table->string('flight_number', 10)->unique()->after('id');
            
            // Et on supprime 'line_type'
            $table->dropColumn('line_type');
        });
    }
};