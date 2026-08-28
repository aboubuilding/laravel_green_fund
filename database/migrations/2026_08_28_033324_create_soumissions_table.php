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
        Schema::create('soumissions', function (Blueprint $table) {
            $table->id();

            $table->string('numero_soumission')->unique();
            $table->tinyInteger('type_porteur')->nullable();
            $table->string('porteur_nom');
            $table->string('porteur_fonction');
            $table->string('porteur_email');
            $table->string('qualite_signature')->nullable();

            $table->date('date_demarrage')->nullable();
            $table->date('fait_projet')->nullable();
            $table->date('date_signature')->nullable();


            $table->longText('resume_projet')->nullable();
            $table->longText('lien_projet')->nullable();
            $table->longText('objet_projet')->nullable();
            $table->longText('theorie_projet')->nullable();
            $table->longText('problematique_projet')->nullable();
            $table->longText('implication_collectivite')->nullable();
            $table->string('porteur_telephone')->nullable();
            $table->bigInteger('guichet_id')->nullable();
            $table->tinyInteger('duree_envisagee')->nullable();
            $table->string('titre_projet');
            $table->tinyInteger('nombre_beneficiaire')->nullable();
            $table->tinyInteger('beneficiaire_indirect')->nullable();
            $table->bigInteger('region_id')->nullable();
            $table->bigInteger('prefecture_id')->nullable();
            $table->bigInteger('commune_id')->nullable();
            $table->decimal('montant_sollicite', 15, 2)->nullable();
            $table->decimal('cout_global', 15, 2)->nullable();

            $table->tinyInteger('statut_soumission')->nullable();

            $table->string('doc_statut')->nullable();
            $table->string('attestation_fiscal')->nullable();
            $table->string('autre_document')->nullable();
            $table->string('doc_budget')->nullable();

            $table->integer('etat')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soumissions');
    }
};
