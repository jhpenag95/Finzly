<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaldoInicialHistorico extends Model
{
    protected $table = 'saldoinicial_historico';
    protected $primaryKey = 'id_movimiento';
    public $timestamps = false;
    protected $keyType = 'string';

    protected $fillable = ['id_movimiento', 'id_saldo', 'id_conpsaldo', 'monto_anterior', 'monto', 'descripcion', 'fecha_registro', 'tipo_movimiento'];

    public function conceptoSaldoInicial()
    {
        return $this->belongsTo(ConceptoSaldoInicial::class, 'id_conpsaldo', 'id_conpsaldo');
    }
}
