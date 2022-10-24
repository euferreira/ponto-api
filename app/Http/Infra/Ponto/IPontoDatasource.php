<?php

namespace App\Http\Infra\Ponto;

interface IPontoDatasource
{
    public function create(array $data): array;

    public function obterBatidaRecente(): ?array;

    public function update(array $data): ?array;

    public function obterBatidaHoje(array $param): ?array;
}
