<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;

    protected $fillable = [
        'nome', 'email', 'password'
    ];

    protected $hidden = [
        'password', 'created_at', 'updated_at'
    ];

    protected $table = 'usuario';
    protected $primaryKey = 'id';
    protected $dateFormat = 'Y-m-d H:i:s';
}
