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
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->unsignedBiginteger('filiere_id');
            $table->foreign('filiere_id')->references('id')->on('filieres');
            $table->unsignedBigInteger('semestre_id');
            $table->foreign('semestre_id')->references('id')->on('semestres');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modules');
    }
};
