<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeputadoController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('iniciar-importacao', [DeputadoController::class, 'iniciarImportacao']);
Route::get('listar-deputados', [DeputadoController::class, 'listarDeputados']);
Route::get('buscar-deputado', [DeputadoController::class, 'buscarDeputado']);
Route::get('listar-despesas', [DeputadoController::class, 'listarDespesas']);
Route::get('buscar-despesas-deputado', [DeputadoController::class, 'buscarDespesasDeputado']);
