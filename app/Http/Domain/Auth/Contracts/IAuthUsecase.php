<?php

namespace App\Http\Domain\Auth\Contracts;

interface IAuthUsecase
{
    public function create(array $params): array;
}
