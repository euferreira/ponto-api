<?php

namespace App\Http\Domain\Ponto;

use App\Http\Domain\Configuracoes\Contracts\IConfiguracaoRepository;
use App\Http\Domain\Ponto\Contracts\IPontoRepository;
use App\Http\Domain\Ponto\Contracts\IPontoUsecase;
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
        if (!$this->isValidDateTime($params['registro'])) {
            abort(400, 'Data inválida');
        }

        $configuracao = $this->configuracaoRepository->getByUser();
        if (empty($configuracao)) {
            abort(400, 'Configuração não encontrada');
        }

        return $this->repository->create($params, $configuracao);
    }

    private function isValidDateTime(string $dateTime): bool
    {
        $dateTime = DateTime::createFromFormat('Y-m-d H:i:s', $dateTime);
        return $dateTime && $dateTime->format('Y-m-d H:i:s') === $dateTime->format('Y-m-d H:i:s');
    }
}
