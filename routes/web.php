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

Route::get('/', [HomeController::class, 'index']);
Route::get('/calendario', [CalendarioController::class, 'calendario']);
Route::get('/categorias', [CategoriasController::class, 'categorias']);

// Rutas para saldo inicial
Route::get('/saldo_inicial', [SaldoInicialController::class, 'saldo_inicial']);
Route::get('/saldo_inicial/consulta', [SaldoInicialController::class, 'index']);
Route::post('/saldo_inicial/registrar', [SaldoInicialController::class, 'store']);

// Rutas para conceptos de saldo inicial
Route::get('/ConceptoSaldoInicial/concepto', [ConceptoSaldoInicialController::class, 'index']);
Route::post('/ConceptoSaldoInicial/concepto', [ConceptoSaldoInicialController::class, 'store']);

Route::get('/pagos', [PagosController::class, 'pagos']);
Route::get('/reportes', [ReporteController::class, 'reportes']);
Route::get('/perfil', [PerfilController::class, 'perfil']);
