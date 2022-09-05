<?php

namespace App\Providers;

use App\Http\Domain\Usuarios\Contracts\IUserRepository;
use App\Http\Domain\Usuarios\Contracts\IUserUsecase;
use App\Http\Domain\Usuarios\UserUsecase;
use App\Http\Infra\Usuarios\Datasource\UserDatasource;
use App\Http\Infra\Usuarios\IUserDatasource;
use App\Http\Infra\Usuarios\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(IUserUsecase::class, UserUsecase::class);
        $this->app->bind(IUserRepository::class, UserRepository::class);
        $this->app->bind(IUserDatasource::class, UserDatasource::class);
    }
}
