<?php

namespace App\Http\Infra\Auth\Repositories;

use App\Http\Domain\Auth\Contracts\IAuthRepository;
use App\Http\Domain\Token\Contracts\ITokenRepository;
use App\Http\Infra\Auth\IAuthDatasource;

class AuthRepository implements IAuthRepository
{
    private IAuthDatasource $datasource;
    private ITokenRepository $tokenRepository;

    public function __construct(IAuthDatasource $datasource, ITokenRepository $tokenRepository)
    {
        $this->datasource = $datasource;
        $this->tokenRepository = $tokenRepository;
    }

    public function create(array $params): array
    {
        $user = $this->datasource->create($params);
        $payload = [
            'id' => $user['id'],
            'email' => $user['email'],
        ];
        $token = $this->tokenRepository->buildToken($payload);

        return [
            'token' => $token,
        ];
    }
}
