<?php

namespace App\Http\Domain\Ponto;

use App\Http\Domain\Configuracoes\Contracts\IConfiguracaoRepository;
use App\Http\Domain\Ponto\Contracts\IPontoRepository;
use App\Http\Domain\Ponto\Contracts\IPontoUsecase;
use App\Http\Domain\Ponto\Entity\PontoEntity;
use DateTime;

class PontoUsecase implements IPontoUsecase
{
    private IPontoRepository $repository;
    private IConfiguracaoRepository $configuracaoRepository;

    public function __construct(IPontoRepository $repository, IConfiguracaoRepository $configuracaoRepository)
    {
        $this->repository = $repository;
        $this->configuracaoRepository = $configuracaoRepository;
    }

    public function create(array $params): array
    {
        if (!$this->repository->isValidDatetime($params['registro'])) {
            abort(400, 'Data inválida');
        }

        $configuracao = $this->configuracaoRepository->getByUser();
        if (empty($configuracao)) {
            abort(404, 'Configuração não encontrada');
        }

        $batidaRecente = $this->repository->obterBatidaRecente($params);
        $ponto = new PontoEntity($configuracao);

        if ($batidaRecente) {
            return $this->repository->update($params, $batidaRecente, $configuracao);
        }

        $create = $this->repository->create($params);
        $previsaoSaida = $ponto->previsaoSaida($create);

        return [
            'create' => $create,
            'previsaoSaida' => $previsaoSaida
        ];
    }
}
