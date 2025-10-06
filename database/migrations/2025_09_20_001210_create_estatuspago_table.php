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
        Schema::create('estatuspago', function (Blueprint $table) {
            $table->string('id_estado_pg', 36)->primary();
            $table->string('nombre_sp', 255);
            $table->string('estatus_sp', 20)->default('Activo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estatuspago');
    }
};
