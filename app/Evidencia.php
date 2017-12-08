<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evidencia extends Model
{
    protected $table='evidencia';

    protected $fillable=[
        'respvisible', 'respnovisible', 'imagen', 'fecha', 'id_user', 'id_visita',
    ];
}
