<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Modulos extends Model
{
    protected $table='modulos';

    protected $fillable=[
        'nombre',
    ];

    public function scopeNombre($query,$nombre){
        if (trim($nombre) != "") {
            return $query->where('modulos.nombre','like','%'.$nombre.'%');
        }
    }

}
