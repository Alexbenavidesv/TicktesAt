<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Consultor extends Model
{
    protected $table='consultores';

    protected $fillable=[
        'id', 'nombre'
    ];
}
