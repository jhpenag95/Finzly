<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Metodopago extends Model
{
    protected $table = 'metodopago';
    protected $primaryKey = 'id_met_pago';
    public $incrementing = false; // Si la clave primaria no es auto-incremental
    protected $keyType = 'string'; // Tipo de la clave primaria
    public $timestamps = false; // Si no tienes columnas created_at y updated_at

    protected $fillable = [
        'id_met_pag',
        'nombre_mp',
        'estatus_mp',
        'created_at',
        'updated_at',
    ];
}
