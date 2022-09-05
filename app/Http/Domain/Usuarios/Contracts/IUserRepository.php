<?php

namespace App\Http\Domain\Usuarios\Contracts;

interface IUserRepository
{
    public function create(array $params): array;
}
