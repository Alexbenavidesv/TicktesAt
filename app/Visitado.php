<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visitado extends Model
{
    protected $table='visitados';

    protected $fillable=[
        'nombre', 'identificacion', 'cargo', 'telefono', 'correo', 'observacion', 'id_visita'
    ];
}
