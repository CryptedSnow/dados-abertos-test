<?php

namespace App\Repositories\Eloquent;

use App\Models\{Deputado, Despesa};
use App\Repositories\Contracts\DeputadoRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Jobs\DeputadoJobs;

class DeputadoRepository implements DeputadoRepositoryInterface
{
    public function importarDeputados(): void
    {
        DeputadoJobs::dispatch();
    }

    public function getAllPaginated(int $perPage = 10): LengthAwarePaginator
    {
        return Deputado::paginate($perPage);
    }

    public function searchCustosDeputados(string $name, int $perPage = 10): LengthAwarePaginator
    {
        return Despesa::whereHas('deputados', function ($query) use ($name) {
            $query->where('nome', 'LIKE', "%{$name}%");
        })->with('deputados')->paginate($perPage);
    }

}
