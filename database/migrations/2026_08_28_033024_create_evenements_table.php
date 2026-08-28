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
        Schema::create('evenements', function (Blueprint $table) {
            $table->id();

            $table->string('titre');
            $table->text('description')->nullable();
            $table->date('date_evenement')->nullable();
            $table->string('lieu')->nullable();
            $table->tinyInteger('type_evenement')->nullable();
            $table->string('image')->nullable();

            $table->integer('etat')->default(1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evenements');
    }
};
