<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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
        ->join('empresa', 'users.id_empresa', 'empresa.id')
    	->select('ticket.id', 'respuesta.id AS idresp', 'respuesta.descripcion', 'respuesta.fecha', 'respuesta.tipo', 'respuesta.evidencia1', 'ticket.estado', 'respuesta.evidencia2', 'respuesta.evidencia3', 'respuesta.id AS resp','consultores.id AS consultor', 'users.name AS nomusuario', 'users.telefono', 'empresa.nombre AS empresa', 'respuesta.respuestanv', 'ticket.id_user AS iduser')
    	->get();

    	$estado =  $respuesta[0]->estado;
        $idconsultor = $respuesta[0]->consultor;
        $iduser = $respuesta[0]->iduser;
    	//dd($estado);

    	return view('respuesta', compact('respuesta', 'estado', 'idconsultor', 'iduser'));
    }

    public function guardarRespuesta(Request $request){
        $respuesta = new Respuesta();
        $fecha = date("Y/m/d H:i:s");

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
        $respuesta->respuestanv = $request->respunv;

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

        if ($request->reasignar==1) {
            $ticket->prioridad = NULL;
            $ticket->id_consultor = 1;
            $ticket->tipo = 'Sin asignar';
        }

        $ticket->save();

        return back()->withInput();
    }

    public function descargar($archivo){
        $url = public_path().'/imgEvidencia/'.$archivo;
        if (file_exists($url)){
            return response()->download($url);
        }
        abort(404);
    }


    public function editar(Request $request){
        $idrespuesta = $request->idrespu;
        $respuesta = Respuesta::findOrFail($idrespuesta);
        //dd($idrespuesta);
        $respuesta->descripcion = $request->respuupdt;
        $respuesta->respuestanv = $request->respuupdtnv;

        if ($request->evidenciaedit) {
            $img = $request->file('evidenciaedit');
            //dd($img);
            $file_rout = time().'_'.$img->getClientOriginalName();//hora de unix
            $img->move(public_path().'/imgEvidencia/', $file_rout);
            $respuesta->evidencia1 = $file_rout;
        }
        $respuesta->save();
        return back()->withInput();
    }
}
