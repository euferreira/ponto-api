<?php

namespace App\Http\Infra\Usuarios;

interface IUserDatasource
{
    public function create(array $params): array;

    public function findByEmail(array $params): ?array;

    public function findByEmailAndPassword(array $params): ?array;
}
