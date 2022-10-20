<?php

namespace App\Http\Domain\Ponto\Contracts;

interface IPontoRepository
{
    public function create(array $params): array;

    public function obterBatidaRecente(array $data): ?array;

    public function update(array $params, array $batidaRecente, array $configuracao): array;

    public function isValidDatetime(string $dateTime): bool;
}
