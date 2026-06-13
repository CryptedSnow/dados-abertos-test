<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\{JsonResponse, Request};
use App\Interfaces\DeputadoInterface;
use App\Http\Controllers\Controller;
use App\Http\Resources\{DeputadoResource, DespesaResource};
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Attributes as OA;

class DeputadoController extends Controller
{
    public function __construct(private DeputadoInterface $deputadoInterface) {}

    #[OA\Get(
        path: '/iniciar-importacao',
        summary: 'Iniciar importação de deputados',
        tags: ['Jobs'],
        responses: [
            new OA\Response(response: 202, description: 'Importação iniciada com sucesso'),
        ]
    )]
    public function iniciarImportacao()
    {
        $this->deputadoInterface->importarDeputados();

        return response()->json([
            'message' => 'DeputadoJobs está sendo executado, verifique o arquivo laravel.log para visualizar o status.',
        ], 202, [], JSON_UNESCAPED_UNICODE);
    }

    #[OA\Get(
        path: '/listar-deputados',
        summary: 'Listar todos os deputados',
        tags: ['Deputados'],
        responses: [
            new OA\Response(response: 200, description: 'Lista retornada com sucesso'),
            new OA\Response(response: 404, description: 'Nenhum deputado encontrado'),
        ]
    )]
    public function listarDeputados(): AnonymousResourceCollection | JsonResponse
    {
        $deputados = $this->deputadoInterface->listarDeputados(10);

        if ($deputados->isEmpty()) {
            return response()->json([
                'message' => 'Deputados não encontrados.'
            ], Response::HTTP_NOT_FOUND, [], JSON_UNESCAPED_UNICODE);
        }

        return DeputadoResource::collection($deputados);
    }

    #[OA\Get(
        path: '/buscar-despesas-deputado',
        summary: 'Buscar despesas de um deputado pelo nome',
        tags: ['Despesas'],
        parameters: [
            new OA\Parameter(name: 'nome', in: 'query', required: true, schema: new OA\Schema(type: 'string', example: 'Tiririca')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Despesas encontradas'),
            new OA\Response(response: 404, description: 'Nenhuma despesa encontrada'),
        ]
    )]
    public function buscarDespesasDeputado(Request $request): AnonymousResourceCollection | JsonResponse
    {
        $nomeDeputado = $request->input('nome');

        if (!$nomeDeputado) {
            return response()->json([
                'message' => 'O nome do(a) deputado(a) está vazio.'
            ], Response::HTTP_NOT_FOUND, [], JSON_UNESCAPED_UNICODE);
        }

        $despesasDeputados = $this->deputadoInterface->buscarCustosDeputados($nomeDeputado);

        if ($despesasDeputados->isEmpty()) {
            return response()->json([
                'message' => "Não foram encontradas despesas do(a) deputado(a) {$nomeDeputado}."
            ], Response::HTTP_NOT_FOUND, [], JSON_UNESCAPED_UNICODE);
        }

        return DespesaResource::collection($despesasDeputados);
    }

}
