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
            $table->string('nombre', 255);
            $table->text('descripcion')->nullable();
            $table->dateTime('fecha_registro');
            $table->decimal('monto', 10, 2);
            $table->string('status', 20)->default('activo');
            $table->unsignedBigInteger('id_usuario');
            $table->foreign('id_usuario')->references('id')->on('users');
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
