<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Temas extends Model
{
    protected $table='temas';

    protected $fillable=[
        'nombre_tema', 'manual','id_modulo',
    ];
}
