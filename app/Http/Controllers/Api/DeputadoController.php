<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\{JsonResponse, Request};
use App\Http\Controllers\Controller;
use App\Http\Resources\{DeputadoResource, DespesaResource};
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Repositories\Contracts\DeputadoRepositoryInterface;
use Symfony\Component\HttpFoundation\Response;

class DeputadoController extends Controller
{
    public function __construct(protected DeputadoRepositoryInterface $deputadoRepositoryInterface) {}

    public function iniciarImportacao()
    {
        $this->deputadoRepositoryInterface->importarDeputados();

        return response()->json([
            'message' => 'DeputadoJobs está sendo executado, verifique o arquivo laravel.log para visualizar o status.',
        ], 202, [], JSON_UNESCAPED_UNICODE);
    }

    public function listarDeputados(): AnonymousResourceCollection | JsonResponse
    {
        $deputados = $this->deputadoRepositoryInterface->getAllPaginated(10);

        if ($deputados->isEmpty()) {
            return response()->json([
                'message' => 'Deputados não encontrados.'
            ], Response::HTTP_NOT_FOUND);
        }

        return DeputadoResource::collection($deputados);
    }

    public function buscarDespesasDeputado(Request $request): AnonymousResourceCollection | JsonResponse
    {
        $nomeDeputado = $request->input('nome');

        if (!$nomeDeputado) {
            return response()->json([
                'message' => 'O nome do(a) deputado(a) está vazio.'
            ], Response::HTTP_NOT_FOUND);
        }

        $despesasDeputados = $this->deputadoRepositoryInterface->searchCustosDeputados($nomeDeputado);

        if ($despesasDeputados->isEmpty()) {
            return response()->json([
                'message' => "Não foram encontradas despesas do(a) deputado(a) {$nomeDeputado}."
            ], Response::HTTP_NOT_FOUND);
        }

        return DespesaResource::collection($despesasDeputados);
    }

}
