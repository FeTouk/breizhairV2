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
        Schema::table('users', function (Blueprint $table) {
            $table->string('grade')->default('Apprenti pilote')->after('callsign');
            $table->string('current_airport')->nullable()->default('LFRP')->after('grade'); // LFRP = Lorient
            $table->unsignedInteger('skycoins')->default(0)->after('current_airport');
            $table->unsignedInteger('total_flight_hours')->default(0)->after('skycoins');
            $table->unsignedInteger('total_flights')->default(0)->after('total_flight_hours');
            $table->unsignedInteger('total_nautical_miles')->default(0)->after('total_flights');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'grade',
                'current_airport',
                'skycoins',
                'total_flight_hours',
                'total_flights',
                'total_nautical_miles',
            ]);
        });
    }
};

