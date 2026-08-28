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
        Schema::create('projet_finances', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('projet_id')
                ->nullable();
            $table->decimal('montant_finance', 15, 2);
            $table->bigInteger('partenaire_id')->nullable();
            $table->unsignedSmallInteger('annee')->nullable();
            $table->boolean('mise_en_avant')->default(false);
            $table->integer('etat')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projet_finances');
    }
};
