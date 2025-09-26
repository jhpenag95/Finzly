<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Saldoinicial extends Model
{
    //
    protected $table = 'saldoinicial'; //esta linea es para especificar la tabla a la que se va a hacer referencia
    protected $primaryKey = 'id_ingresos'; //esta linea es para especificar la llave primaria de la tabla
    public $incrementing = false; //esta linea especifica que la clave primaria NO es auto-incremental
    protected $keyType = 'string'; //esta linea especifica que la clave primaria es de tipo string

    public $timestamps = false; //esta linea es para especificar si la tabla tiene campos de fecha de creacion y actualizacion

    protected $fillable = ['id_ingresos', 'descripcion', 'fecha_registro', 'monto', 'id_usuario', 'id_conpsaldo']; //esta linea es para especificar los campos que se pueden llenar con datos

    //esta función es para relacionar la tabla saldo_inicial con la tabla concepto_saldo_inicial
    public function concepto(){
        return $this->hasOne(ConceptoSaldoInicial::class, 'id_conpsaldo', 'id_conpsaldo');
    }


}
