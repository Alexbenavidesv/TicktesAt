<?php

namespace App\Http\Controllers;

use App\Roles;
use App\Role_Users;
use Illuminate\Http\Request;
use App\User;
use App\Empresa;
use App\Consultor;

use Illuminate\Support\Facades\Validator;

class UsuarioController extends Controller
{
    public function listarUsuarios(){
        $users = User::where('users.id','!=',1)
            ->where('users.id','!=',2)
       -> join('empresa', 'users.id_empresa', 'empresa.id')
        ->join('roles', 'users.id_rol', 'roles.id')
        ->select('users.id','users.name','users.email', 'users.correo','empresa.id AS id_empresa', 'empresa.nombre AS empresa','roles.id AS id_rol', 'roles.nombre AS rol')
        ->get();
        //dd($users);
        $empresa = Empresa::all();
        $roles = Roles::all();

        return view("usuarios", compact('users', 'empresa','roles'));
    }

    public function create(Request $request){
        if($request->isMethod('post')) {
            Validator::make($request->all(), [
                'nombre' => 'required',
                'email' => 'required|unique:users',
                'correo' => 'required|email',
                'empresa' => 'required',
                'rol' => 'required',
            ], [
                'nombre.required' => 'Debes ingresar el nombre',
                'email.required' => 'Debes ingresar la cedula',
                'email.unique' => 'Ya existe la identificación',
                'correo.required' => 'Debes ingresar un correo',
                'correo.email' => 'Ingresa un correo valido',
                'telefono.min' => 'Ingresa un telefono valido',
                'empresa.required' => 'Debes escoger una empresa',
                'rol.required' => 'Debes escoger una rol',

            ])->validate();

            $usuario= new User();
            $usuario->name=$request->nombre;
            $usuario->email=$request->email;
            $usuario->password=bcrypt($request->email);
            $usuario->correo=$request->correo;
            $usuario->id_empresa=$request->empresa;
            $usuario->id_rol=$request->rol;
            $usuario->save();
            
            $id_usuario=User::max('id');

            if($request->rol==3) {
                $consultor = new Consultor();
                $consultor->id = $id_usuario;
                $consultor->nombre = $request->nombre;
                $consultor->save();
            }

            return "OK";

        }
    }

    public function editar(Request $request){
        if($request->isMethod('post')) {
            Validator::make($request->all(), [
                'nombre' => 'required',
                'email' => 'required|unique:users,id,'.$request->id_user,
                'correo' => 'required|email',
                'empresa' => 'required',
                'rol' => 'required',
            ], [
                'nombre.required' => 'Debes ingresar el nombre',
                'email.required' => 'Debes ingresar la cedula',
                'email.unique' => 'Ya existe la identificación',
                'correo.required' => 'Debes ingresar un correo',
                'correo.email' => 'Ingresa un correo valido',
                'telefono.min' => 'Ingresa un telefono valido',
                'empresa.required' => 'Debes escoger una empresa',
                'rol.required' => 'Debes escoger una rol',

            ])->validate();


            $usuario= User::find($request->id_user);
            $usuario->name=$request->nombre;
            $usuario->email=$request->email;
            $usuario->correo=$request->correo;
            $usuario->id_empresa=$request->empresa;
            $usuario->id_rol=$request->rol;
            $usuario->save();

            if($request->rol==3) {
                $consultor = Consultor::find($request->id_user);
                $consultor->nombre = $request->nombre;
                $consultor->save();
            }

          return $request->id_user;

        }
    }
}
