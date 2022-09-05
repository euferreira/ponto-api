<?php

namespace App\Http\Infra\Token\Repository;

use App\Http\Domain\Token\Contracts\ITokenRepository;
use App\Http\Infra\Token\ITokenDatasource;

class TokenRepository implements ITokenRepository
{
    private ITokenDatasource $tokenDatasource;

    public function __construct(ITokenDatasource $tokenDatasource)
    {
        $this->tokenDatasource = $tokenDatasource;
    }

    public function buildToken(array $payload, $expiresIn = 2): string
    {
        if (empty($payload)) {
            throw new \InvalidArgumentException('Payload is empty', 400);
        }
        $payload['exp'] = time() + (60 * 60 * 24 * $expiresIn);
        $payload['iat'] = time();
        return $this->tokenDatasource->buildToken($payload);
    }
}
