<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table='ticket';

    protected $fillable=[
        'id_user', 'prioridad','tipo' ,'id_consultor', 'area','estado'
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
}
