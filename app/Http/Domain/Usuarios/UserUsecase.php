<?php

namespace App\Http\Domain\Usuarios;

use App\Http\Domain\Usuarios\Contracts\IUserRepository;
use App\Http\Domain\Usuarios\Contracts\IUserUsecase;

class UserUsecase implements IUserUsecase
{
    private IUserRepository $repository;

    public function __construct(IUserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(array $params): array
    {
        return $this->repository->create($params);
    }
}
