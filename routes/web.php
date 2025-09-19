<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CalendarioController;
use App\Http\Controllers\CategoriasController;
use App\Http\Controllers\PagosController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\SaldoInicialController;

Route::get('/', [HomeController::class, 'index']);
Route::get('/calendario', [CalendarioController::class, 'calendario']);
Route::get('/categorias', [CategoriasController::class, 'categorias']);
Route::get('/saldo_inicial', [SaldoInicialController::class, 'saldo_inicial']);
Route::get('/pagos', [PagosController::class, 'pagos']);
Route::get('/reportes', [ReporteController::class, 'reportes']);
Route::get('/perfil', [PerfilController::class, 'perfil']);
