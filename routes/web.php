<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CalendarioController;
use App\Http\Controllers\CategoriasController;
use App\Http\Controllers\PagosController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\SaldoInicialController;
use App\Http\Controllers\ConceptoSaldoInicialController;
use App\Http\Controllers\SaldoInicialHistoricoControlador;
use App\Http\Controllers\MetodopagoController;

Route::get('/', [HomeController::class, 'index']);
Route::get('/calendario', [CalendarioController::class, 'calendario']);

// Rutas para categorias
Route::get('/categorias', [CategoriasController::class, 'categorias']);
Route::post('/categorias/registrar', [CategoriasController::class, 'store']);
Route::get('/categorias/obtener', [CategoriasController::class, 'index']);
Route::post('/categorias/editar', [CategoriasController::class, 'update']);
Route::delete('/categorias/eliminar', [CategoriasController::class, 'destroy']);

// Rutas para saldo inicial
Route::get('/saldo_inicial', [SaldoInicialController::class, 'saldo_inicial']);
Route::get('/saldo_inicial/consulta', [SaldoInicialController::class, 'index']);
Route::get('/saldo_inicial/conceptos', [ConceptoSaldoInicialController::class, 'index_concepto']);
Route::get('/saldo_inicial/total', [SaldoInicialController::class, 'total']);
Route::get('/saldo_inicial/totales', [SaldoInicialController::class, 'totalsAllConcepts']);
Route::post('/saldo_inicial/registrar', [SaldoInicialController::class, 'store']);
Route::delete('/saldo_inicial/eliminar/{id}', [SaldoInicialController::class, 'destroy']);

// Rutas para historial de saldo inicial
Route::get('/saldo_inicial_historico/historial/buscar/{id}', [SaldoInicialHistoricoControlador::class, 'historyByConcepto']);
Route::delete('/saldo_inicial_historico/historial/eliminar/{id}', [SaldoInicialHistoricoControlador::class, 'destroy']);
Route::get('/saldo_inicial_historico/historial/total/{id}', [SaldoInicialHistoricoControlador::class, 'totalByHistorial']);


// Rutas para conceptos de saldo inicial
Route::get('/ConceptoSaldoInicial/concepto', [ConceptoSaldoInicialController::class, 'index']);
Route::get('/ConceptoSaldoInicial/concepto/{id}', [ConceptoSaldoInicialController::class, 'show']);
Route::post('/ConceptoSaldoInicial/concepto', [ConceptoSaldoInicialController::class, 'store']);
Route::put('/ConceptoSaldoInicial/concepto/actualizar/{id}', [ConceptoSaldoInicialController::class, 'update']);
Route::delete('/ConceptoSaldoInicial/concepto/eliminar/{id}', [ConceptoSaldoInicialController::class, 'destroy']);

// Rutas para métodos de pago
Route::get('/metodos_pago', [MetodopagoController::class, 'metodos_pago']);
Route::post('/metodos_pago/registrar', [MetodopagoController::class, 'store']);
Route::get('/metodos_pago/obtener', [MetodopagoController::class, 'index']);
Route::post('/metodos_pago/editar', [MetodopagoController::class, 'update']);
Route::delete('/metodos_pago/eliminar', [MetodopagoController::class, 'destroy']);

// Rutas para pagos
Route::get('/pagos', [PagosController::class, 'pagos']);
Route::get('/pagos/consulta/categorias', [PagosController::class, 'index_categorias']);
Route::post('/pagos/registrar', [PagosController::class, 'store']);


Route::get('/reportes', [ReporteController::class, 'reportes']);
Route::get('/perfil', [PerfilController::class, 'perfil']);
