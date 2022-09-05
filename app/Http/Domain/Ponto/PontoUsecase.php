<?php

namespace App\Http\Domain\Ponto;

use App\Http\Domain\Configuracoes\Contracts\IConfiguracaoRepository;
use App\Http\Domain\Ponto\Contracts\IPontoRepository;
use App\Http\Domain\Ponto\Contracts\IPontoUsecase;

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
            throw new \InvalidArgumentException('O campo registro deve ser um datetime', 404);
        }

        $configuracao = $this->configuracaoRepository->getByUser();
        if (empty($configuracao)) {
            throw new \InvalidArgumentException('Você não possui configurações de horário definidas.', 404);
        }

        return $this->repository->create($params, $configuracao);
    }

    private function isValidDateTime(string $dateTime): bool
    {
        $dateTime = \DateTime::createFromFormat('Y-m-d H:i:s', $dateTime);
        return $dateTime && $dateTime->format('Y-m-d H:i:s') === $dateTime->format('Y-m-d H:i:s');
    }
}
