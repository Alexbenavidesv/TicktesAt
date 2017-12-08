<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visitado extends Model
{
    protected $table='visitados';

    protected $fillable=[
        'nombre', 'cargo', 'telefono', 'id_visita'
    ];
}
