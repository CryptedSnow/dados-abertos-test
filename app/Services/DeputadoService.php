<?php

namespace App\Services;

use App\Interfaces\DeputadoInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\{Deputado, Despesa};
use App\Jobs\DeputadoJobs;

class DeputadoService implements DeputadoInterface
{
    public function importarDeputados(): void
    {
        DeputadoJobs::dispatch();
    }

    public function listarDeputados(int $perPage = 10): LengthAwarePaginator
    {
        return Deputado::paginate($perPage);
    }

    public function buscarCustosDeputados(string $name, int $perPage = 10): LengthAwarePaginator
    {
        return Despesa::whereHas('deputados', function ($query) use ($name) {
            $query->where('nome', 'LIKE', "%{$name}%");
        })->with('deputados')->paginate($perPage);
    }

}
