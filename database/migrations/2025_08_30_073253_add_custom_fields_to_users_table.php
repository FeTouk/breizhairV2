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
                $table->renameColumn('name', 'first_name'); // On renomme 'name' en 'first_name' (Prénom)
                $table->string('last_name')->after('first_name'); // On ajoute 'last_name' (Nom)
                $table->string('ivao_vid')->unique()->after('last_name'); // On ajoute le VID IVAO (unique)
                $table->string('discord')->nullable()->after('ivao_vid'); // On ajoute le Discord (optionnel)
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::table('users', function (Blueprint $table) {
                $table->renameColumn('first_name', 'name');
                $table->dropColumn(['last_name', 'ivao_vid', 'discord']);
            });
        }
    };
    
