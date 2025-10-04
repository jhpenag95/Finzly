<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pagos extends Model
{
    
    protected $table = 'pagos';
    protected $primaryKey = 'id_pagos';
    public $timestamps = false;
    protected $fillable = [
        'id_pagos',
        'nombre_pg',
        'categoria_pg',
        'monto_pg',
        'fecha_pg',
        'repetcion_pg',
        'fecha_creacion',
        'id_usuario',
        'id_met_pag',
        'id_estado_pg',
        'id_categoria',
        'created_at',
        'updated_at',
    ];
}
