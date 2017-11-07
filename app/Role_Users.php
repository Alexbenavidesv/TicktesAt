<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role_Users extends Model
{
    protected $table='role_users';

    protected $fillable=[
        'id_users', 'id_rol'
    ];
}
