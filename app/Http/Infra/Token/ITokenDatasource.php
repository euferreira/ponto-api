<?php

namespace App\Http\Infra\Token;

interface ITokenDatasource
{
    public function buildToken(array $payload): string;
}
