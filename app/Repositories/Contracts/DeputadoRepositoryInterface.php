<?php

namespace App\Repositories\Contracts;

use Illuminate\Pagination\LengthAwarePaginator;

interface DeputadoRepositoryInterface
{
    public function getAllPaginated(int $perPage = 10): LengthAwarePaginator;
    public function searchCustosDeputados(string $name, int $perPage = 10): LengthAwarePaginator;
}
