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
        Schema::create('membres', function (Blueprint $table) {
            $table->id();

            $table->string('nom');
            $table->string('poste');
            $table->bigInteger('equipe_id')->nullable();
            $table->string('photo')->nullable();
            $table->text('bio')->nullable();
            $table->unsignedInteger('ordre')->default(0);

            $table->integer('etat')->default(1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('membres');
    }
};
