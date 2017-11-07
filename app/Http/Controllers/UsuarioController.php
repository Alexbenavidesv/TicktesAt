<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Empresa;

use Illuminate\Support\Facades\Validator;

class UsuarioController extends Controller
{
    public function listarUsuarios(){
        $users = User::join('empresa', 'users.id_empresa', 'empresa.id')
        ->join('role_users', 'users.id', 'role_users.id_users')
        ->join('roles', 'role_users.id_rol', 'roles.id')
        ->select('users.name', 'users.correo', 'empresa.nombre AS empresa', 'roles.nombre AS rol')
        ->get();
        //dd($users);
        $empresa = Empresa::all();

        return view("usuarios", compact('users', 'empresa'));
    }

    public function create(Request $request){
        if($request->isMethod('post')) {
            Validator::make($request->all(), [
                'nombre' => 'required',
                'email' => 'required|unique:users',
                'correo' => 'required|email',
                'empresa' => 'required',
            ], [
                'nombre.required' => 'Debes ingresar el nombre',
                'email.required' => 'Debes ingresar la cedula',
                'email.unique' => 'Ya existe la identificación',
                'correo.required' => 'Debes ingresar un correo',
                'correo.email' => 'Ingresa un correo valido',
                'telefono.min' => 'Ingresa un telefono valido',
                'empresa.required' => 'Debes escoger una empresa',

            ])->validate();

            $usuario= new User();
            $usuario->name=$request->nombre;
            $usuario->email=$request->email;
            $usuario->password=bcrypt($request->email);
            $usuario->correo=$request->correo;
            $usuario->id_empresa=$request->empresa;
            $usuario->save();

            return "OK";

        }
    }
}
