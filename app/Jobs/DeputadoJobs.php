<?php

namespace App\Jobs;

use App\Models\Deputado;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
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

            foreach ($deputados as $d) {
                $deputado = Deputado::updateOrCreate(
                    ['camara_id' => $d['id']],
                    [
                        'nome' => $d['nome'],
                        'partido' => $d['siglaPartido'],
                        'uf' => $d['siglaUf'],
                    ]
                );

                Log::info("Deputado salvo: {$deputado->nome}");

                // Dispatch the despesas job with only the ID
                DespesasDeputadoJobs::dispatch($deputado->id);
            }

            $pagina++;
            $temProxima = collect($dados['links'] ?? [])->firstWhere('rel', 'next');
        } while ($temProxima);
    }
}
