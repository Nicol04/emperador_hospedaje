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
        Schema::create('caracteristicas_alquiladas', function (Blueprint $table) {
            $table->integer('idalquiler')->unique('idalquiler');
            $table->integer('idcaracteristica')->index('idcaracteristica');

            $table->unique(['idalquiler', 'idcaracteristica'], 'idhabitacion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('caracteristicas_alquiladas');
    }
};
