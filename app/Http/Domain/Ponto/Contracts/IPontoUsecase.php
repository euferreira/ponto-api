<?php

namespace App\Http\Domain\Ponto\Contracts;

interface IPontoUsecase
{
    public function create(array $params): array;
}
