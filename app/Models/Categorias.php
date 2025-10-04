<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categorias extends Model
{
   
    protected $table = 'categorias';
    protected $primaryKey = 'id_categoria';
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = [
        'id_categoria',
        'nombre_cat',
        'color_cat',
        'icono_cat',
        'estatus_cat',
        'created_at',
        'updated_at',
    ];
}
