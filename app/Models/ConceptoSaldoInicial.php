<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConceptoSaldoInicial extends Model
{
    use HasFactory; // Esta línea se utiliza para habilitar la funcionalidad de fábrica para la prueba y siembra de modelos.

  
    protected $table = 'conceptosaldo_init'; //esta linea es para especificar la tabla a la que se va a hacer referencia
    protected $primaryKey = 'id_conpsaldo'; //esta linea es para especificar la llave primaria de la tabla
    protected $keyType = 'string'; //esta linea especifica que la clave primaria es de tipo string
    public $incrementing = false; //esta linea especifica que la clave primaria NO es auto-incremental
    public $timestamps = false; //esta linea es para especificar si la tabla tiene campos de fecha de creacion y actualizacion

   
    protected $fillable = ['id_conpsaldo', 'concepto', 'fecha_registro']; //esta linea es para especificar los campos que se pueden llenar con datos
    
    
}
