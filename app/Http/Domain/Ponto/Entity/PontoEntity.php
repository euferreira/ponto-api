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
    public function hydrateToUpdate(array $data, ?array $batidaRecente): ?array
    {
        if (!empty($batidaRecente)) {
            $retorno = $this->verificaNulidade($batidaRecente, $data);
            $retorno['id'] = $batidaRecente['id'];
            if (!is_null($batidaRecente['saida2'])) {
                $horaExtra = $this->verificaHoraExtra($retorno, $batidaRecente);
                if ($horaExtra) {
                    $retorno['hora_extra'] = $horaExtra;
                }
            }
            return $retorno;
        }
        return null;
    }

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
        switch (array_key_first($data)) {
            case 'entrada1':
            case 'saida1':
                $cargaHoraria = $this->configuracao['cargaHoraria'];
                break;

            case 'entrada2':
                $cargaHoraria = "05:00:00";
                break;

            default:
                $cargaHoraria = "00:00:00";
                break;
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
        $previsaoSaida = $this->previsaoSaida(['entrada2' => new DateTime($recente['entrada2'])]);
        $diferenca = strtotime($data['saida2']->format('Y-m-d H:i:s')) - strtotime($previsaoSaida);
        if ($diferenca > 0) {
            return date('H:i:s', $diferenca);
        }
        return null;
    }
}
