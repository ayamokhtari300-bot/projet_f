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
    Schema::create('missions', function (Blueprint $table) {
        $table->id();

        // infos
        $table->string('type_mission'); //
        $table->text('description')->nullable();
        $table->string('destination');
        // dates
        $table->dateTime('date_aller')->nullable();
        $table->dateTime('date_retour')->nullable();

        // status (workflow)
        $table->enum('status', [
            'en_attente',
            'en_cours',
            'validee',
            'refusee'
        ])->default('en_attente');

        // fichier
        $table->string('fichier')->nullable();

        // relations
        $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // agent li créa
        $table->foreignId('vehicule_id')->nullable()->constrained()->nullOnDelete();

        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('missions');
    }
};
