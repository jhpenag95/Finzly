<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstatusPago extends Model
{
    protected $table = 'estatuspago';
    protected $primaryKey = 'id_est';
    public $timestamps = false;
    protected $keyType = 'string';
    
    protected $fillable = [
        'id_est',
        'nombre_est',
        'descripcion_est',
        'created_at',
        'updated_at',
    ];
}
