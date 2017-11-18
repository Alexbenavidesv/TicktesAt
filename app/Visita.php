<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visita extends Model
{
    protected $table='visitas';

    protected $fillable=[
        'tipo', 'lugar', 'fecha', 'id_empresas', 'id_consultor'
    ];
}
