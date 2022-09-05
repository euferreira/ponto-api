<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfiguracoesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('configuracoes')->insert([
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime(),
            'cargaHoraria' => '08:00:00',
            'cargaHorariaSextaFeira' => '08:00:00',
            'usuario_id' => 1,
        ]);
    }
}
