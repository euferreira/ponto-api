<?php

namespace App\Http\Domain\Ponto\Entity;

use DateTime;
use Exception;

class PontoEntity
{
    private array $configuracao;

    public function __construct(array $configuracao)
    {
        $this->configuracao = $configuracao;
    }

    /**
     * @throws Exception
     */
    public function hydrateToUpdate(array $data, array $recente): ?array
    {
        if (!empty($recente[0])) {
            $objeto = $this->verificaNulidade($recente[0], $data);
            $objeto['id'] = $recente[0]['id'];
            $horaExtra = $this->verificaHoraExtra($objeto, $recente[0]);
            if ($horaExtra) {
                $objeto['hora_extra'] = $horaExtra;
            }
            return $objeto;
        }
        return null;
    }

    /**
     * @throws Exception
     */
    private function verificaNulidade(array &$recente, array $data): array
    {
        $registro = new DateTime($data['registro'], new \DateTimeZone('America/Sao_Paulo'));
        if (empty($recente['entrada1'])) {
            $param['entrada1'] = $registro;
            return $param;
        }

        if (empty($recente['saida1'])) {
            $param['saida1'] = $registro;
            return $param;
        }
        if (empty($recente['entrada2'])) {
            $param['entrada2'] = $registro;
            return $param;
        }
        if (empty($recente['saida2'])) {
            $param['saida2'] = $registro;
            return $param;
        }

        throw new Exception('Você não pode registrar duas batidas seguidas');
    }

    public function previsaoSaida(array $data): string
    {
        $cargaHoraria = null;
        switch (array_key_first($data)) {
            case 'entrada1':
                $cargaHoraria = $this->configuracao['cargaHoraria'];
                break;

            case 'saida1':
                $cargaHoraria = "07:00:00";
                break;

            case 'entrada2':
                $cargaHoraria = "05:00:00";
                break;

            case 'saida2':
                return "";
        }

        /**
         * @var DateTime $dataFormatada
         */
        $dataFormatada = $data[array_key_first($data)]->format('Y-m-d H:i:s');
        list($h, $m, $s) = explode(':', $cargaHoraria);
        return date('Y-m-d H:i:s', strtotime($dataFormatada) + $s + ($m * 60) + ($h * 3600));
    }

    public function verificaHoraExtra(array $data, array $recente): ?string
    {
        //TODO - Implementar
        return null;
    }
}
