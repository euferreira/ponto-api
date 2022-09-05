<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configuracoes extends Model
{
    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $fillable = [
        'cargaHoraria', 'cargaHorariaSextaFeira',
    ];

    protected $table = 'configuracoes';
    protected $primaryKey = 'id';
    protected $dateFormat = 'Y-m-d H:i:s';
}
