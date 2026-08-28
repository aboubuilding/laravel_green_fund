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
        Schema::create('griefs', function (Blueprint $table) {
            $table->id();

            $table->string('nom');
            $table->string('email')->nullable();
            $table->string('telephone')->nullable();
            $table->foreignId('projet_concerne_id')->nullable()
                ->constrained('projets')->nullOnDelete();
            $table->text('description');
            $table->enum('statut', ['nouveau', 'en_cours', 'resolu'])
                ->default('nouveau');
            $table->text('reponse')->nullable();

            $table->integer('etat')->default(1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('griefs');
    }
};
