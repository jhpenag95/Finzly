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

        // Insertar los estados iniciales
        DB::table('estatuspago')->insert([
            [
                'id_estado_pg' => 'ESP' . substr(uniqid(), 0, 8) . rand(10, 99),
                'nombre_sp' => 'PENDIENTE',
                'estatus_sp' => 'Activo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_estado_pg' => 'ESP' . substr(uniqid(), 0, 8) . rand(10, 99),
                'nombre_sp' => 'PAGADO',
                'estatus_sp' => 'Activo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_estado_pg' => 'ESP' . substr(uniqid(), 0, 8) . rand(10, 99),
                'nombre_sp' => 'VENCIDO',
                'estatus_sp' => 'Activo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estatuspago');
    }
};
