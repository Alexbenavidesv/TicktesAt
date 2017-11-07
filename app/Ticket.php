<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table='ticket';

    protected $fillable=[
        'id_user', 'prioridad', 'id_consultor', 'fecha','estado'
    ];
}
