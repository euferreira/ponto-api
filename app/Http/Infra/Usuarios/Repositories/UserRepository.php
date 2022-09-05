<?php

namespace App\Http\Infra\Usuarios\Repositories;

use App\Http\Domain\Usuarios\Contracts\IUserRepository;
use App\Http\Infra\Usuarios\IUserDatasource;

class UserRepository implements IUserRepository
{
    private IUserDatasource $datasource;

    public function __construct(IUserDatasource $datasource)
    {
        $this->datasource = $datasource;
    }

    public function create(array $params): array
    {
        $hasUser = $this->datasource->findByEmail($params);
        if ($hasUser) {
            abort(400, 'E-mail já cadastrado');
        }
        $params['password'] = md5($params['password']);
        return $this->datasource->create($params);
    }
}
