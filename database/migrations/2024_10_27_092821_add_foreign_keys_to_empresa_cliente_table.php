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
        Schema::table('empresa_cliente', function (Blueprint $table) {
            $table->foreign(['idAlquiler'], 'empresa_cliente_ibfk_1')->references(['idAlquiler'])->on('alquiler')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['idEmpresa'], 'empresa_cliente_ibfk_2')->references(['idOrganizacion'])->on('organizaciones')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('empresa_cliente', function (Blueprint $table) {
            $table->dropForeign('empresa_cliente_ibfk_1');
            $table->dropForeign('empresa_cliente_ibfk_2');
        });
    }
};
