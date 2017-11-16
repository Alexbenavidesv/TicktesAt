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
        if (trim($prioridad) != "") {
            return $query->where('ticket.prioridad', $prioridad);
        }
    }

    public function scopeConsultor($query,$consultor){
        if (trim($consultor) != "") {
            return $query->where('ticket.id_consultor', $consultor);
        }
    }

    public function scopeEstado($query,$estado){
        if (trim($estado) != "") {
            return $query->where('ticket.estado', $estado);
        }
    }

    public function scopeEmpresa($query,$empresa){
        if (trim($empresa) != "") {
            return $query->where('empresa.id',$empresa);
        }
    }

    public function scopeTipo($query,$tipo){
        if (trim($tipo) != "") {
            return $query->where('ticket.tipo',$tipo);
        }
    }
}
