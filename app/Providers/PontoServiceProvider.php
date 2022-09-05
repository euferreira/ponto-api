<?php

namespace App\Providers;

use App\Http\Domain\Configuracoes\Contracts\IConfiguracaoRepository;
use App\Http\Domain\Ponto\Contracts\IPontoRepository;
use App\Http\Domain\Ponto\Contracts\IPontoUsecase;
use App\Http\Domain\Ponto\PontoUsecase;
use App\Http\Infra\Configuracoes\Datasource\ConfiguracaoDatasource;
use App\Http\Infra\Configuracoes\IConfiguracaoDatasource;
use App\Http\Infra\Configuracoes\Repositories\ConfiguracaoRepository;
use App\Http\Infra\Ponto\Datasource\PontoDatasouce;
use App\Http\Infra\Ponto\IPontoDatasource;
use App\Http\Infra\Ponto\Repositories\PontoRepository;
use Illuminate\Support\ServiceProvider;

class PontoServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(IPontoUsecase::class, PontoUsecase::class);
        $this->app->bind(IPontoRepository::class, PontoRepository::class);
        $this->app->bind(IPontoDatasource::class, PontoDatasouce::class);

        $this->app->bind(IConfiguracaoRepository::class, ConfiguracaoRepository::class);
        $this->app->bind(IConfiguracaoDatasource::class, ConfiguracaoDatasource::class);
    }
}
