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
        Schema::create('vehicules', function (Blueprint $table) {
            $table->id();
            $table->string('immatriculation')->unique();
            $table->string('marque');
            $table->string('modele');
            $table->string('couleur')->nullable();
            $table->smallInteger('annee')->nullable();
            $table->integer('kilometrage')->nullable();
            $table->string('carrosserie')->nullable();
            $table->string('energie')->nullable();
            $table->string('boite')->nullable();
            $table->smallInteger('nombre_portes')->nullable();
            $table->smallInteger('nombre_places')->nullable();
            $table->decimal('prix_journalier', 8, 2)->nullable();
            $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicules');
    }
};
