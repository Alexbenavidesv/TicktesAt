<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contratos extends Model
{
    protected $table='contrato';

    protected $fillable=[
        'tipo', 'totalhoras', 'id_empresa', 'estado'
    ];
}
