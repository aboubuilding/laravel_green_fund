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
        Schema::create('soumission_historiques', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('soumission_id')
                ->nullable();
            $table->tinyInteger('statut_soumission');
            $table->text('commentaire')->nullable();
            $table->bigInteger('auteur_id')->nullable();

            $table->timestamp('date_action')->useCurrent();
            $table->integer('etat')->default(1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soumission_historiques');
    }
};
