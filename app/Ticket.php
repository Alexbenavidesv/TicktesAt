<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table='ticket';

    protected $fillable=[
        'id_user', 'prioridad','tipo' ,'id_consultor', 'area','modulo','estado'
    ];

    public function scopePrioridad($query,$prioridad){

        if ($prioridad != null) {
            return $query->whereIn('ticket.prioridad', $prioridad);
        }
    }

    public function scopeConsultor($query,$consultor){
        if ($consultor != null) {
            return $query->whereIn('ticket.id_consultor', $consultor);
        }
    }

    public function scopeEstado($query,$estado){
        if ($estado != null) {
            return $query->whereIn('ticket.estado', $estado);
        }
    }

    public function scopeEmpresa($query,$empresa){
        if ($empresa != null) {
            return $query->whereIn('empresa.id', $empresa);
        }
    }

    public function scopeTipo($query,$tipo){
        if ($tipo != null) {
            return $query->whereIn('ticket.tipo', $tipo);
        }
    }

    public function scopeNumero($query,$numero){
        if (trim($numero) != "") {
            return $query->where('ticket.id',$numero);
        }
    }

    public function scopeModulo($query,$modulos){
        if ($modulos != null) {
            return $query->whereIn('ticket.modulo', $modulos);
        }
    }

    public function scopeRango($query, $fechas){
        if ($fechas != null) {



            $f1 = explode('/', $fechas[0]);
            $f2 = explode('/', $fechas[1]);


            $fecha1 = $f1[2] . '-' . $f1[0] . '-' . $f1[1] . ' 00:00:00';
            $fecha2 = $f2[2] . '-' . $f2[0] . '-' . $f2[1] . ' 23:59:59';

            return $query->whereBetween('respuesta.fecha', [$fecha1,$fecha2]);

        }
    }

}
