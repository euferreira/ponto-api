<?php

namespace App\Http\Infra\Configuracoes\Repositories;

use App\Http\Domain\Configuracoes\Contracts\IConfiguracaoRepository;
use App\Http\Infra\Configuracoes\IConfiguracaoDatasource;

class ConfiguracaoRepository implements IConfiguracaoRepository
{
    private IConfiguracaoDatasource $datasource;

    public function __construct(IConfiguracaoDatasource $datasource)
    {
        $this->datasource = $datasource;
    }

    public function getByUser(): array
    {
        $result = $this->datasource->getByUser();
        return $result ?? [];
    }
}
