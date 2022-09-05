<?php

namespace App\Http\Domain\Auth\Contracts;

interface IAuthRepository
{
    public function create(array $params): array;
}
