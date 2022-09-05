<?php

namespace App\Http\Infra\Configuracoes\Datasource;

use App\Http\Infra\Configuracoes\IConfiguracaoDatasource;
use App\Models\Configuracoes;

class ConfiguracaoDatasource implements IConfiguracaoDatasource
{
    public function getByUser(): ?array
    {
        return Configuracoes::where('usuario_id', auth()->user()->getAuthIdentifier())
            ->get()
            ->first()
            ->toArray();
    }
}
