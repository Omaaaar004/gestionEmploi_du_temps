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
        Schema::create('seances', function (Blueprint $table) {
            $table->id();
            $table->string('jour');
            $table->time('heure_deb');
            $table->time('heure_fin');
            $table->unsignedBigInteger('prof_id');
            $table->foreign('prof_id')->references('id')->on('profs');
            $table->unsignedBigInteger('filiere_id');
            $table->foreign('filiere_id')->references('id')->on('filieres');
            $table->unsignedBigInteger('semestre_id');
            $table->foreign('semestre_id')->references('id')->on('semestres');
            $table->unsignedBigInteger('module_id');
            $table->foreign('module_id')->references('id')->on('modules');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seances');
    }
};
