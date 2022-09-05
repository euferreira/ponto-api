<?php

namespace App\Http\Domain\Auth;

use App\Http\Domain\Auth\Contracts\IAuthRepository;
use App\Http\Domain\Auth\Contracts\IAuthUsecase;

class AuthUsecase implements IAuthUsecase
{
    private IAuthRepository $authRepository;

    public function __construct(IAuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function create(array $params): array
    {
        return $this->authRepository->create($params);
    }
}
