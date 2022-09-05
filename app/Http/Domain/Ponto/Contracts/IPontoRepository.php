<?php

namespace App\Http\Domain\Ponto\Contracts;

interface IPontoRepository
{
    public function create(array $data, array $configuracao): array;

    public function obterBatidaRecente(array $data): ?array;

    public function update(array $data): array;
}
