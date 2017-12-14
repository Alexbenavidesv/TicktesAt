<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visita extends Model
{
    protected $table='visitas';

    protected $fillable=[
        'tipo', 'lugar', 'fecha', 'fechainicio', 'fechafin', 'duracion', 'id_empresa', 'motivovisita', 'recoleccion', 'cliente', 'telefono', 'satisfaccion', 'id_consultor', 'id_contrato', 'id_modulo', 'estado'
    ];

    public function scopeConsultor($query,$consultor){

        if ($consultor != null) {
            return $query->whereIn('visitas.id_consultor', $consultor);
        }
    }


    public function scopeRango($query, $fechas){

        if ($fechas != null) {
            if ($fechas[0] != '' && $fechas[1] != '') {
                $f1 = explode('/', $fechas[0]);
                $f2 = explode('/', $fechas[1]);


                $fecha1 = $f1[2] . '-' . $f1[0] . '-' . $f1[1] . ' 00:00:00';
                $fecha2 = $f2[2] . '-' . $f2[0] . '-' . $f2[1] . ' 23:59:59';
                return $query->whereBetween('visitas.fecha', [$fecha1, $fecha2]);
            }
        }
    }
}
