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
                // On change les colonnes pour qu'elles acceptent des nombres signés (positifs et négatifs)
                $table->bigInteger('total_flight_hours')->signed()->change();
                $table->bigInteger('total_nautical_miles')->signed()->change();
                $table->integer('skycoins')->signed()->change();
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::table('users', function (Blueprint $table) {
                // On remet les colonnes en non-signé si on annule la migration
                $table->bigInteger('total_flight_hours')->unsigned()->change();
                $table->bigInteger('total_nautical_miles')->unsigned()->change();
                $table->integer('skycoins')->unsigned()->change();
            });
        }
};