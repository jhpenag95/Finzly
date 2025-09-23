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
        Schema::create('conceptosaldo_init', function (Blueprint $table) {
            $table->string('id_conpsaldo', 36)->primary();
            $table->dateTime('fecha_registro');
            $table->string('status', 20)->default('activo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conceptosaldo_init');
    }
};