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
        Schema::create('guichet_projets', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('guichet_id')
                ->nullable();
            $table->bigInteger('projet_id')
                ->nullable();


            $table->integer('etat')->default(1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guichet_projets');
    }
};
