<?php

namespace App\Http\Infra\Auth\Datasource;

use App\Http\Infra\Auth\IAuthDatasource;
use App\Http\Infra\Usuarios\IUserDatasource;

class AuthDatasource implements IAuthDatasource
{
    private IUserDatasource $userDatasource;

    public function __construct(IUserDatasource $userDatasource)
    {
        $this->userDatasource = $userDatasource;
    }

    public function create(array $params): array
    {
        $user = $this->userDatasource->findByEmailAndPassword($params);
        if (!$user) {
            abort(400, 'Usuário não encontrado');
        }
        return $user;
    }
}
