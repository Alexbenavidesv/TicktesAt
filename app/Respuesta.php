<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Respuesta extends Model
{
    protected $table='respuesta';

    protected $fillable=[
        'descripcion', 'id_ticket', 'fecha', 'tipo','evidencia1','evidencia2','evidencia3'
    ];
}
