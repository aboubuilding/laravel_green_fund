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
        Schema::create('mot_cordonnateurs', function (Blueprint $table) {
            $table->id();

            $table->string('nom');
            $table->string('fonction');
            $table->string('photo')->nullable();
            $table->text('citation')->nullable();
            $table->longText('contenu');
            $table->integer('etat')->default(1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mot_cordonnateurs');
    }
};
