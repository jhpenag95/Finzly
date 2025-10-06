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
        Schema::create('saldoinicial_historico', function (Blueprint $table) {
            $table->string('id_movimiento', 36)->primary();
            $table->string('id_saldo', 36);
            $table->decimal('monto_anterior', 10, 2);
            $table->decimal('monto', 10, 2);
            $table->string('descripcion', 255);
            $table->dateTime('fecha_registro');
            $table->string('id_conpsaldo', 36);
            $table->unsignedBigInteger('id_usuario');
            $table->string('tipo_movimiento', 20)->default('ingreso'); // ingreso o egreso
            $table->string('status', 20)->default('Activo');
            $table->timestamps();
            
            $table->foreign('id_saldo')->references('id_ingresos')->on('saldoinicial');
            $table->foreign('id_conpsaldo')->references('id_conpsaldo')->on('conceptosaldo_init');
            $table->foreign('id_usuario')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saldoinicial_historico');
    }
};
