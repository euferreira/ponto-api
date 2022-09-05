<?php

namespace App\Http\Infra\Auth;

interface IAuthDatasource
{
    public function create(array $params): array;
}
