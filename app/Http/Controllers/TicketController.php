<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ticket;

class TicketController extends Controller
{
    public function index(){
    	return view("inicio");
    }

    public function nuevoTicket(){
    	Validator::make($req->all(),
            [
                'descripcion' => 'required|string',
                'evidencia1' => 'required'
            ],
            [
                'descripcion.required' => 'Usted debe ingresar una descripción',
                'descripcion.string' => 'La descripcion solo puede ser alfanumerica',
                'evidencia1.required' => 'Debe ingresar por lo menos la primera evidencia'
            ]
        )->validate();

        $usuario = Auth::user()->id;
        $fecha = date("Y/m/d");

        $ticket = new Ticket();

        $ticket->id_user = $usuario;
        $ticket->fecha = $fecha;
        $ticket->save();

        return 'ok';
    }
}
