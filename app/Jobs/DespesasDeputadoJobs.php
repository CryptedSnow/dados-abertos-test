<?php

namespace App\Jobs;

use App\Models\{Despesa, Deputado};
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\{Http, Log};
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\{InteractsWithQueue, SerializesModels};
use Illuminate\Foundation\Bus\Dispatchable;

class DespesasDeputadoJobs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $deputadoId;

    public function __construct(int $deputadoId)
    {
        $this->deputadoId = $deputadoId;
    }

    public function handle(): void
    {
        $deputado = Deputado::find($this->deputadoId);

        if (!$deputado) {
            Log::warning("Deputado não encontrado: ID {$this->deputadoId}");
            return;
        }

        $pagina = 1;

        do {
            $response = Http::get("https://dadosabertos.camara.leg.br/api/v2/deputados/{$deputado->camara_id}/despesas", [
                'pagina' => $pagina,
                'itens' => 100,
                'ordem' => 'ASC',
            ]);

            $dados = $response->json();
            $despesas = $dados['dados'] ?? [];

            Log::info("Página {$pagina}: {$deputado->nome} tem " . count($despesas) . " despesas.");

            foreach ($despesas as $key) {
                try {
                    Despesa::create([
                        'deputado_id' => $deputado->id,
                        'tipo_despesa' => $key['tipoDespesa'] ?? '',
                        'valor' => $key['valorDocumento'] ?? 0,
                        'fornecedor' => $key['nomeFornecedor'] ?? '',
                        'data_documento' => $key['dataDocumento'] ?? null,
                        'url_documento' => $key['urlDocumento'] ?? null,
                    ]);
                } catch (\Exception $e) {
                    Log::error('Erro ao salvar despesa', [
                        'mensagem' => $e->getMessage(),
                        'dados' => $key,
                    ]);
                }
            }

            $pagina++;
            $proximaPagina = collect($dados['links'] ?? [])->firstWhere('rel', 'next');
        } while ($proximaPagina);
    }
}
