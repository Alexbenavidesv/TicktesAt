<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contratos extends Model
{
    protected $table='contrato';

    protected $fillable=[
        'tipo', 'totalhoras', 'id_empresa', 'estado'
    ];

    public function scopeEmpresa($query,$empresa){

        if ($empresa != null) {
            return $query->whereIn('contrato.id_empresa', $empresa);
        }
    }

    public function scopeTipo($query,$tipo){
        if (trim($tipo)!="") {
            return $query->where('contrato.tipo', $tipo);
        }
    }
}
