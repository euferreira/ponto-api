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
        $value = DB::table('ponto.pontos')
            ->select()
            ->where('usuario_id', "=", auth()->user()->getAuthIdentifier())
            ->whereDate("created_at", "=", date('Y-m-d'))
            ->whereNull("saida2")
            ->orderBy("created_at", "desc")
            ->limit(1)
            ->get()
            ->first();
        return $value != null ? json_decode(json_encode($value), true) : null;
    }

    public function update(array $data): ?array
    {
        $update = Ponto::where('id', $data['id'])
            ->where('usuario_id', auth()->user()->getAuthIdentifier())
            ->update($data);
        return [
            'update' => $update > 0,
        ];
    }
}
