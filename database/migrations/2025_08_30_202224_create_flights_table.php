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
        Schema::create('flights', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Lien vers l'utilisateur
            
            // --- Champs remplis par le pilote ---
            $table->string('departure_icao', 4); // OACI Départ
            $table->string('arrival_icao', 4);   // OACI Arrivée
            $table->date('flight_date');         // Date du vol
            $table->text('comments')->nullable(); // Commentaire du pilote
            $table->boolean('is_breizhair_event')->default(false); // Case "Evenement Breizh'Air"
            $table->boolean('is_ivao_event')->default(false);      // Case "evenement IVAO"
            $table->string('status')->default('En attente'); // Statut : En attente, Validé, Refusé

            // --- Champs remplis par les admins lors de la validation ---
            $table->unsignedInteger('nautical_miles')->nullable();
            $table->time('departure_time')->nullable();
            $table->time('arrival_time')->nullable();
            $table->string('flight_time')->nullable(); // ex: "1h 35m"
            $table->foreignId('validator_id')->nullable()->constrained('users')->onDelete('set null'); // Lien vers l'admin validateur
            $table->text('admin_remarks')->nullable(); // Remarques de l'admin

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flights');
    }
};

