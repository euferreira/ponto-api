<?php

namespace App\Http\Infra\Usuarios\Datasource;

use App\Http\Infra\Usuarios\IUserDatasource;
use App\Models\User;

class UserDatasource implements IUserDatasource
{
    public function create(array $params): array
    {
        $created = User::create($params);
        return $created->toArray();
    }

    public function findByEmail(array $params): ?array
    {
        $user = User::where('email', $params['email'])->first();
        return $user != null ? $user->toArray() : null;
    }

    public function findByEmailAndPassword(array $params): ?array
    {
        $user = User::where('email', $params['email'])
            ->where('password', md5($params['password']))
            ->first();
        return $user != null ? $user->toArray() : null;
    }
}
