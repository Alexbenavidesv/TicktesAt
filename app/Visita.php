<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visita extends Model
{
    protected $table='visitas';

    protected $fillable=[
        'tipo', 'lugar', 'fecha', 'fechainicio', 'fechafin', 'duracion', 'id_empresa', 'motivovisita', 'recoleccion', 'cliente', 'telefono', 'satisfaccion', 'id_consultor', 'id_modulo', 'estado'
    ];
}
