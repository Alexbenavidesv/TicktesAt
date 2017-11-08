<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\User;

class CambiarPasswordController extends Controller
{
    public function cambiarPassword(){

        return view('cambiarpassword');
    }




    public function password(Request $req){
        Validator::make($req->all(),
            [
                'pass1' => 'required|min:8|max:15|string',
                'pass2' => 'required|same:pass1'
            ],
            [
                'pass1.required' => 'Debes ingresar tu nueva contraseña',
                'pass1.min' => 'La nueva contraseña debe ser de minimo 8 caracteres',
                'pass1.max' => 'La contraseña nueva puede ser de maximo 15 caracteres',
                'pass1.string' => 'La contraseña solo puede ser alfanumerica',
                'pass2.required' => 'Debes confirmar tu nueva contraseña',
                'pass2.same' => 'Las contraseñas deben coincidir',
            ]
        )->validate();

        $usuario = Auth::user()->id;

        $user =  User::find($usuario);

        $user->password = bcrypt($req->pass1);

        $user->sesion = 1;
        $user->save();

        return "OK";
    }


    public function cancelarPassword(){
        $usuario = Auth::user()->id;

        $user =  User::find($usuario);
        $user->sesion = 1;
        $user->save();

     return "OK";
    }



    public function cambiarPassView(){
        return view('cambiarcontrasena');
    }

    public function validarCambio(Request $request){
        Validator::make($request->all(),
            [
                'pactual' => 'required',
                'pass1' => 'required|min:8|max:15|string',
                'pass2' => 'same:pass1'
            ],
            [
                'pactual.required' => 'Debes ingresar tu contraseña actual',
                'pass1.required' => 'Debes ingresar tu nueva contraseña',
                'pass1.min' => 'La nueva contraseña debe ser de minimo 8 caracteres',
                'pass1.max' => 'La contraseña nueva puede ser de maximo 15 caracteres',
                'pass1.string' => 'La contraseña solo puede ser alfanumerica',
                'pass2.same' => 'Las contraseñas nuevas deben coincidir',
            ]
        )->validate();

        $pass = Auth::user()->password;
        $user = Auth::user()->id;

        if (Hash::check($request->pactual, $pass)) {
            $usuario =  User::find($user);
            $usuario->password = bcrypt($request->pass1);
            $usuario->save();

            return 'ok';
        }else{
            return 'error';
        }
    }
}
