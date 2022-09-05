<?php

namespace App\Providers;

use App\Http\Domain\Auth\AuthUsecase;
use App\Http\Domain\Auth\Contracts\IAuthRepository;
use App\Http\Domain\Auth\Contracts\IAuthUsecase;
use App\Http\Domain\Token\Contracts\ITokenRepository;
use App\Http\Infra\Auth\Datasource\AuthDatasource;
use App\Http\Infra\Auth\IAuthDatasource;
use App\Http\Infra\Auth\Repositories\AuthRepository;
use App\Http\Infra\Token\Datasource\TokenDatasource;
use App\Http\Infra\Token\ITokenDatasource;
use App\Http\Infra\Token\Repository\TokenRepository;
use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind(IAuthUsecase::class, AuthUsecase::class);
        $this->app->bind(IAuthRepository::class, AuthRepository::class);
        $this->app->bind(IAuthDatasource::class, AuthDatasource::class);
        $this->app->bind(ITokenRepository::class, TokenRepository::class);
        $this->app->bind(ITokenDatasource::class, TokenDatasource::class);
    }

    public function boot()
    {
        $this->app['auth']->viaRequest('api', function ($request) {
            $bearer = str_replace('Bearer ', '', $request->header('Authorization'));
            $data = JWT::decode($bearer, new Key(env('JWT_SECRET'), 'HS256'));
            $user = User::find($data->id);
            if (!empty($user)) {
                return $user;
            }
            return null;
        });
    }
}
