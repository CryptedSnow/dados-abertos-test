<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\{Deputado, Despesa};
use App\Http\Resources\{DeputadoResource, DespesaResource};
use App\Jobs\DeputadoJobs;

class DeputadoController extends Controller
{
    public function iniciarImportacao()
    {
        DeputadoJobs::dispatch();
        return response()->json(['DeputadoJobs está sendo executado, verifique o arquivo laravel.log para visualizar o status.'], 202, [], JSON_UNESCAPED_UNICODE);
    }

    public function listarDeputados()
    {
        $deputados = Deputado::orderby('id')->paginate(10);
        if ($deputados->isEmpty()) {
            return response()->json(['message' => 'Deputados não encontrados.'], 404);
        }
        return DeputadoResource::collection($deputados);
    }

    public function buscarDespesasDeputado(Request $request)
    {
        $nome = $request->input('nome');
        if (!$nome) {
            return response()->json(['message' => "O nome do(a) deputado(a) está vazio."], 404);
        }
        $despesasDeputados = Despesa::whereHas('deputados', function ($query) use ($nome) {
            $query->where('nome', 'LIKE', '%' . $nome . '%');
        })->with('deputados')->paginate(10);
        if ($despesasDeputados->isEmpty()) {
            return response()->json(['message' => "Não foram encontradas despesas do(a) deputado(a) $nome."], 404);
        }
        return DespesaResource::collection($despesasDeputados);
    }

}
