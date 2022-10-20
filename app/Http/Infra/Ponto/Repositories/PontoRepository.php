<?php

namespace App\Http\Infra\Ponto\Repositories;

use App\Http\Domain\Ponto\Contracts\IPontoRepository;
use App\Http\Domain\Ponto\Entity\PontoEntity;
use App\Http\Infra\Ponto\IPontoDatasource;
use DateTime;
use Exception;

class PontoRepository implements IPontoRepository
{
    private IPontoDatasource $datasource;

    public function __construct(IPontoDatasource $pontoDatasource)
    {
        $this->datasource = $pontoDatasource;
    }

    public function create(array $params): array
    {
        $create = $this->datasource->create($params);
        if ($create['entrada1'] instanceof DateTime) {
            $create['entrada1'] = new DateTime($create['entrada1']->format('Y-m-d H:i:s'));
        }
        return $create;
    }

    public function obterBatidaRecente(array $data): ?array
    {
        return $this->datasource->obterBatidaRecente();
    }

    public function update(array $params, array $batidaRecente, array $configuracao): array
    {
        $ponto = new PontoEntity($configuracao);
        $result = $ponto->hydrateToUpdate($params, $batidaRecente);
        $previsaoSaida = $ponto->previsaoSaida($result);
        $update = $this->datasource->update($result);

        if ($update) {
            return [
                'previsaoSaida' => $previsaoSaida,
            ];
        }
        return [];
    }

    public function isValidDatetime(string $dateTime): bool
    {
        $dateTime = DateTime::createFromFormat('Y-m-d H:i:s', $dateTime);
        return $dateTime && $dateTime->format('Y-m-d H:i:s') === $dateTime->format('Y-m-d H:i:s');
    }
}
