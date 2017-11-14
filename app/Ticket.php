<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table='ticket';

    protected $fillable=[
        'id_user', 'prioridad', 'id_consultor', 'fecha','estado'
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
}
