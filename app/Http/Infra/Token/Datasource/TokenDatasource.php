<?php

namespace App\Http\Infra\Token\Datasource;

use App\Http\Infra\Token\ITokenDatasource;
use Firebase\JWT\JWT;

class TokenDatasource implements ITokenDatasource
{
    public function buildToken(array $payload): string
    {
        return JWT::encode($payload, env('JWT_SECRET'), 'HS256');
    }
}
