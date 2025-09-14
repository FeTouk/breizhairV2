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
        Schema::table('flights', function (Blueprint $table) {
            // Ajoute une colonne pour stocker l'ID de l'admin validateur
            $table->foreignId('validated_by')->nullable()->constrained('users')->after('flight_duration');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('flights', function (Blueprint $table) {
            $table->dropForeign(['validated_by']);
            $table->dropColumn('validated_by');
        });
    }
};