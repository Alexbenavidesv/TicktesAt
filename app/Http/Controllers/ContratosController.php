<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Modulos;
use App\Temas;

class ContratosController extends Controller
{
    public function lista(){
        return view('contratos');
    }

    public function crear(){
        return "Nuevo contrato";
    }

    public function modulos(){

        $modulos=Modulos::all();
        $temas=Temas::all();

        return view('modulos',compact('modulos','temas'));
    }
}
