<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Ticket;
use App\Respuesta;
use App\User;
use App\Empresa;
use App\Consultor;

class RespuestasController extends Controller
{
    public function verRespuestas($id){
    	$respuesta = Ticket::where('ticket.id', $id)
    	->join('respuesta', 'ticket.id', 'respuesta.id_ticket')
    	->join('consultores', 'ticket.id_consultor', 'consultores.id')
    	->join('users', 'ticket.id_user', 'users.id')
    	->select('ticket.id', 'respuesta.descripcion', 'respuesta.fecha', 'respuesta.tipo', 'respuesta.evidencia1', 'ticket.estado', 'respuesta.evidencia2', 'respuesta.evidencia3', 'respuesta.id AS resp')
    	->get();

    	$estado =  $respuesta[0]->estado;
    	//dd($estado);

    	return view('respuesta', compact('respuesta', 'estado'));
    }

    public function guardarRespuesta(Request $request){
        $respuesta = new Respuesta();
        $fecha = date("Y/m/d");

        $tipo = '';
        if ($request->finalizado == 'NO') {
        	$tipo = 'SEGUIMIENTO';
        }else{
        	$tipo = 'CIERRE';
        }

        $respuesta->descripcion = $request->respu;
        $respuesta->id_ticket = $request->idticket;
        $respuesta->fecha = $fecha;
        $respuesta->tipo = $tipo;

        if ($request->evidencia) {
        	$img = $request->file('evidencia');
			$file_rout = time().'_'.$img->getClientOriginalName();//hora de unix
	        $img->move(public_path().'/imgEvidencia/', $file_rout);
        	$respuesta->evidencia1 = $file_rout;
        }

        $respuesta->save();

        $ticket = Ticket::find($request->idticket);
        //dd($ticket);
        if ($tipo=='CIERRE') {
        	$ticket->estado = 1;
        }
        $ticket->save();

        return back()->withInput();
    }
}
