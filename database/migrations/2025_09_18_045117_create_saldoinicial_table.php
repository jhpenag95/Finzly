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
        Schema::create('saldoinicial', function (Blueprint $table) {
            $table->string('id_ingresos', 36)->primary();
            $table->string('descripcion', 255);
            $table->dateTime('fecha_registro');
            $table->decimal('monto', 10, 2);
            $table->string('status', 20)->default('Activo');
            $table->unsignedBigInteger('id_usuario');
            $table->string('id_conpsaldo', 36);
            $table->foreign('id_usuario')->references('id')->on('users');
            $table->foreign('id_conpsaldo')->references('id_conpsaldo')->on('conceptosaldo_init');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saldoinicial');
    }
};
