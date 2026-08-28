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
        Schema::create('manifestations', function (Blueprint $table) {
            $table->id();

            $table->string('nom');
            $table->string('prenom')->nullable();
            $table->string('email')->nullable();
            $table->tinyInteger('type_organisation')->nullable();
            $table->string('telephone')->nullable();
            $table->bigInteger('guichet_id')->nullable();
            $table->bigInteger('domaine_interet_id')->nullable();
            $table->text('message')->nullable();
            $table->string('document_manifestation')->nullable();
            $table->tinyInteger('statut_manifestation')->nullable();
            $table->integer('etat')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manifestations');
    }
};
