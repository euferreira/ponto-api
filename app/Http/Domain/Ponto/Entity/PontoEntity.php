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
            $registro = $this->mountRegister($batidaRecente, $data);
            $registro['id'] = $batidaRecente['id'];
            return $registro;
        }
        throw new Exception('Não foi possível atualizar o registro');
    }

    /**
     * @throws Exception
     */
    private function mountRegister(array $recente, array $data): ?array
    {
        $registro = new DateTime($data['registro'], new \DateTimeZone('America/Sao_Paulo'));
        $isOlder = $this->isOlderThan(new DateTime($recente['entrada1']), $registro);

        if (empty($recente['entrada1'])) {
            $param['entrada1'] = $registro;
            return $param;
        }

        if (empty($recente['saida1'])) {
            $sameDay = $this->isSameDay(new DateTime($recente['entrada1']), $registro);
            if (!$sameDay && !$isOlder) {
                $param['saida1'] = $registro;

                $diff = $this->getDiff(new DateTime($recente['entrada1'], new \DateTimeZone('America/Sao_Paulo')), $registro);
                if ($diff >= 8) {
                    $previsaoSaida = $this->previsaoSaida(['entrada1' => new DateTime($recente['entrada1'])]);
                    $previsaoSaida = new DateTime($previsaoSaida, new \DateTimeZone('America/Sao_Paulo'));
                    $previsaoSaida->add(new \DateInterval('PT1H'));
                    $diferenca = strtotime($param['saida1']->format('Y-m-d H:i:s')) - strtotime($previsaoSaida->format('Y-m-d H:i:s'));
                    $param['hora_extra'] = gmdate('H:i:s', $diferenca);
                }
                return $param;
            }
            abort(400, 'Ponto não pode ser registrado em dias diferentes');
        }

        if (empty($recente['entrada2'])) {
            $sameDay = $this->isSameDay(new DateTime($recente['saida1']), $registro);
            if (!$sameDay && !$isOlder) {
                $param['entrada2'] = $registro;
                $diff = $this->getDiff(new DateTime($recente['saida1'], new \DateTimeZone('America/Sao_Paulo')), $registro, "H:i:s");
                $param['intervalo'] = $diff->format('%H:%I:%S');
                return $param;
            }
            abort(400, 'Ponto não pode ser registrado em dias diferentes');
        }

        if (empty($recente['saida2'])) {
            $sameDay = $this->isSameDay(new DateTime($recente['entrada2']), $registro);
            if (!$sameDay && !$isOlder) {
                $param['saida2'] = $registro;
                $horaExtra = $this->verificaHoraExtra($param, $recente);
                if ($horaExtra) {
                    $param['hora_extra'] = $horaExtra;
                }
                return $param;
            }
            abort(400, 'Ponto não pode ser registrado em dias diferentes');
        }

        return null;
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

    private function isSameDay(DateTime $entrada1, DateTime $registro): bool
    {
        return $entrada1->format('Y-m-d H:i:s') === $registro->format('Y-m-d H:i:s');
    }

    private function isOlderThan(DateTime $createdAt, DateTime $registro): bool
    {
        return $createdAt->format('Y-m-d') > $registro->format('Y-m-d');
    }

    private function getDiff(DateTime $entrada1, DateTime $registro, $result = 'hours')
    {
        switch ($result) {
            case 'hours':
                return $entrada1->diff($registro)->h;

            default:
                return $entrada1->diff($registro);
        }
    }
}
