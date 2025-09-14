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
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->string('departure_icao', 4);
                $table->string('arrival_icao', 4);
                $table->date('flight_date');
                $table->text('comments')->nullable();
                $table->text('route')->nullable();
                $table->time('departure_time')->nullable();
                $table->time('arrival_time')->nullable();
                $table->boolean('is_breizhair_event')->default(false);
                $table->boolean('is_ivao_event')->default(false);
                $table->string('status')->default('En attente');
                $table->integer('nautical_miles')->nullable();
                $table->integer('flight_duration')->nullable(); // En minutes
                $table->foreignId('validated_by')->nullable()->constrained('users');
                $table->text('validation_comments')->nullable();
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
    