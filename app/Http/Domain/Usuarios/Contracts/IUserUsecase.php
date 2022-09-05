<?php

namespace App\Http\Domain\Usuarios\Contracts;

interface IUserUsecase
{
    public function create(array $params): array;
}
