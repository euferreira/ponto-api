<?php

namespace App\Http\Domain\Configuracoes\Contracts;

interface IConfiguracaoRepository
{
    public function getByUser(): array;
}
