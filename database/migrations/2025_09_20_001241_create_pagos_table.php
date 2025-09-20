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
        Schema::create('pagos', function (Blueprint $table) {
            $table->string('id_pagos', 36)->primary();
            $table->string('nombre_pg', 255);
            $table->decimal('monto_pg', 10, 2);
            $table->date('fecha_pg');
            $table->string('repetcion_pg', 255);
            $table->dateTime('fecha_creacion');
            $table->dateTime('fecha_actualizacion');

            $table->unsignedBigInteger('id_usuario');
            $table->foreign('id_usuario')->references('id')->on('users');
            $table->string('id_met_pag', 36);
            $table->foreign('id_met_pag')->references('id_met_pag')->on('metodopago');
            $table->string('id_estado_pg', 36);
            $table->foreign('id_estado_pg')->references('id_estado_pg')->on('estatuspago');
            $table->string('id_categoria', 36);
            $table->foreign('id_categoria')->references('id_categoria')->on('categorias');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
