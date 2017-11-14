<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empresa;

use Illuminate\Support\Facades\Validator;

class EmpresaController extends Controller
{
    public function listarEmpresas(){
        $empresas=Empresa::where('id','!=',1)->get();


        return view("empresas", compact('empresas'));
    }

    public function create(Request $request){
        if($request->isMethod('post')) {
            Validator::make($request->all(), [
                'nombre' => 'required',
                'nit' => 'required|unique:empresa',
            ], [
                'nombre.required' => 'Debes ingresar el nombre',
                'nit.required' => 'Debes ingresar el nit',
                'nit.unique' => 'Ya existe el nit registrado',

            ])->validate();

            $empresa= new Empresa();
            $empresa->nombre=$request->nombre;
            $empresa->nit=$request->nit;
            $empresa->save();

            return "OK";

        }
    }

    public function editar(Request $req){
        Validator::make($req->all(), [
                'nombre' => 'required',
                'nit' => 'required|unique:empresa',
            ], [
                'nombre.required' => 'Debes ingresar el nombre',
                'nit.required' => 'Debes ingresar el nit',
                'nit.unique' => 'Ya existe el nit registrado',

            ])->validate();
        
        return "ok";
    }

}
