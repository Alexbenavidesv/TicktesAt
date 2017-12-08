<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Limite_ticket extends Model
{
    protected $table='limite_ticket';

    protected $fillable=[
        'por_confirmar', 'pendientes','id_empresa',
    ];
}
