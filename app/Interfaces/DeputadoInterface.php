<?php

namespace App\Interfaces;

use Illuminate\Pagination\LengthAwarePaginator;

interface DeputadoInterface
{
    public function importarDeputados(): void;
    public function listarDeputados(int $perPage = 10): LengthAwarePaginator;
    public function buscarCustosDeputados(string $name, int $perPage = 10): LengthAwarePaginator;
}
