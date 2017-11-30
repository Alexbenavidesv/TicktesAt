<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Modulo_contrato extends Model
{
    protected $table='modulo_contrato';

    protected $fillable=[
        'horas', 'id_contrato', 'id_modulo','tipo_pago'
    ];
}
