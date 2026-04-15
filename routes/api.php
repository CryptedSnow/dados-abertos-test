<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DeputadoController;

Route::controller(DeputadoController::class)->group(function () {
    Route::get('iniciar-importacao', 'iniciarImportacao');
    Route::get('listar-deputados', 'listarDeputados');
    Route::get('buscar-despesas-deputado', 'buscarDespesasDeputado');
});
