<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ponto extends Model
{
    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $fillable = [
        'entrada1', 'usuario_id',
    ];

    protected $table = 'pontos';
    protected $primaryKey = 'id';
    protected $dateFormat = 'Y-m-d H:i:s';
}
