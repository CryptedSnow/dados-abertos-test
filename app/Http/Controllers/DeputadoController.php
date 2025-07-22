<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Deputado;
use App\Models\Despesa;
use App\Http\Resources\DeputadoResource;
use App\Http\Resources\DespesaResource;
use App\Jobs\DeputadoJobs;

class DeputadoController extends Controller
{
    public function iniciarImportacao()
    {
        DeputadoJobs::dispatch();
        return response()->json([
            'mensagem' => 'DeputadoJobs está sendo executado, verifique o arquivo laravel.log para visualizar o status.',
        ]);
    }

    public function listarDeputados()
    {
        $deputados = Deputado::all();
        if ($deputados->isEmpty()) {
            return response()->json(['message' => 'Deputados não encontrados.'], 404);
        }
        return DeputadoResource::collection($deputados);
    }

    public function buscarDeputado(Request $request)
    {
        $nome = $request->input('nome');
        if (!$nome) {
            return response()->json(['message' => "O nome do(a) deputado(a) está vazio."], 404);
        }
        $deputados = Deputado::where('nome', 'ILIKE', '%' . $nome . '%')->get();
        if ($deputados->isEmpty()) {
            return response()->json(['message' => "Deputado(a) $nome não foi encontrado(a)."], 404);
        }
        return DeputadoResource::collection($deputados);
    }

    public function listarDespesas()
    {
        $despesas = Despesa::paginate(100);
        if ($despesas->isEmpty()) {
            return response()->json(['message' => 'Despesas não encontradas.'], 404);
        }
        return DespesaResource::collection($despesas);
    }

    public function buscarDespesasDeputado(Request $request)
    {
        $nome = $request->input('nome');
        if (!$nome) {
            return response()->json(['message' => "O nome do(a) deputado(a) está vazio."], 404);
        }
        $despesas_deputados = Despesa::whereHas('deputados', function ($query) use ($nome) {
            $query->where('nome', 'ILIKE', '%' . $nome . '%');
        })->with('deputados')->get();
        if ($despesas_deputados->isEmpty()) {
            return response()->json(['message' => "Deputado(a) $nome não foi encontrado(a) para verificar as despesas."], 404);
        }
        return DespesaResource::collection($despesas_deputados);
    }

}
