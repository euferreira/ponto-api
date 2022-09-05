<?php

namespace App\Http\Infra\Ponto\Repositories;

use App\Http\Domain\Ponto\Contracts\IPontoRepository;
use App\Http\Domain\Ponto\Entity\PontoEntity;
use App\Http\Infra\Ponto\IPontoDatasource;
use Exception;

class PontoRepository implements IPontoRepository
{
    private IPontoDatasource $datasource;

    public function __construct(IPontoDatasource $pontoDatasource)
    {
        $this->datasource = $pontoDatasource;
    }

    /**
     * @throws Exception
     */
    public function create(array $data, array $configuracao): array
    {
        $batidaRecente = $this->obterBatidaRecente($data);
        $ponto = new PontoEntity($configuracao);
        $objeto = $ponto->hydrateToUpdate($data, $batidaRecente);

        if ($batidaRecente) {
            $update = $this->update($objeto);
            $previsaoSaida = $ponto->previsaoSaida($objeto);
            return [
                'isUpdated' => $update,
                'previsaoSaida' => $previsaoSaida
            ];
        }

        $create = $this->datasource->create($data);
        $previsaoSaida = $ponto->previsaoSaida($create);
        return [
            'create' => $create,
            'previsaoSaida' => $previsaoSaida
        ];
    }

    public function obterBatidaRecente(array $data): ?array
    {
        return $this->datasource->obterBatidaRecente();
    }

    public function update(array $data): array
    {
        return $this->datasource->update($data);
    }
}
