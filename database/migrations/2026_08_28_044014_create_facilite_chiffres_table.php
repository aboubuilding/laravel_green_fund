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
        Schema::create('facilite_chiffres', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('facilite_id')
                ->nullable();
            $table->string('valeur');
            $table->string('libelle');

            $table->integer('etat')->default(1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facilite_chiffres');
    }
};
