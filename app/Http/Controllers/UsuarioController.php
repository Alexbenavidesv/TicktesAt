<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Empresa;

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
}
