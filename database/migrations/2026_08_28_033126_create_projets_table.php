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
        Schema::create('projets', function (Blueprint $table) {
            $table->id();

            $table->string('titre');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->bigInteger('region_id')->nullable();
            $table->bigInteger('prefecture_id')->nullable();
            $table->bigInteger('commune_id')->nullable();

            $table->tinyInteger('statut_projet')->nullable();
            $table->bigInteger('type_projet_id')->nullable();
            $table->decimal('budget', 15, 2)->nullable();
            $table->date('date_debut')->nullable();
            $table->date('date_fin')->nullable();

            $table->integer('etat')->default(1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projets');
    }
};
