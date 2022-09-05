<?php

namespace App\Http\Infra\Configuracoes;

interface IConfiguracaoDatasource
{
    public function getByUser(): ?array;
}
