<?php

namespace App\Jobs;

use App\Models\Deputado;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\{Http, Log};
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\{InteractsWithQueue, SerializesModels};
use Illuminate\Foundation\Bus\Dispatchable;
use App\Jobs\DespesasDeputadoJobs;

class DeputadoJobs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        $pagina = 1;

        do {
            $response = Http::get("https://dadosabertos.camara.leg.br/api/v2/deputados", [
                'pagina' => $pagina,
                'itens' => 100,
            ]);

            $dados = $response->json();
            $deputados = $dados['dados'] ?? [];

            foreach ($deputados as $key) {
                $deputado = Deputado::updateOrCreate(
                    ['camara_id' => $key['id']],
                    [
                        'nome' => $key['nome'],
                        'partido' => $key['siglaPartido'],
                        'uf' => $key['siglaUf'],
                    ]
                );

                Log::info("Deputado salvo: {$deputado->nome}");

                DespesasDeputadoJobs::dispatch($deputado->id);
            }

            $pagina++;
            $proximaPagina = collect($dados['links'] ?? [])->firstWhere('rel', 'next');
        } while ($proximaPagina);
    }
}
