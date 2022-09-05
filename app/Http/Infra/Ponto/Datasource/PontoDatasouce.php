<?php

namespace App\Http\Infra\Ponto\Datasource;

use App\Http\Infra\Ponto\IPontoDatasource;
use App\Models\Ponto;
use Illuminate\Support\Facades\DB;

class PontoDatasouce implements IPontoDatasource
{
    public function create(array $data): array
    {
        $result = Ponto::create([
            'entrada1' => new \DateTime($data['registro'], new \DateTimeZone('America/Sao_Paulo')),
            'saida1' => null,
            'entrada2' => null,
            'saida2' => null,
            'usuario_id' => auth()->user()->getAuthIdentifier(),
            'hora_extra' => null,
        ]);
        return $result != null ? $result->toArray() : [];
    }

    public function obterBatidaRecente(): ?array
    {
        $last = DB::select("SELECT * FROM ponto.pontos
         WHERE usuario_id = :usuario_id
         AND DATE(created_at) = DATE(NOW())
         AND saida2 IS NULL
         ORDER BY created_at DESC LIMIT 1", ['usuario_id' => auth()->user()->getAuthIdentifier()]);
        $last = json_decode(json_encode($last), true);

        return $last ?? null;
    }

    public function update(array $data): ?array
    {
        $update = Ponto::where('id', $data['id'])->where('usuario_id', auth()->user()->getAuthIdentifier())->update($data);
        return [
            'update' => $update > 0,
        ];
    }
}
