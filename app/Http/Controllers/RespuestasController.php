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
    	->select('ticket.id', 'respuesta.id AS idresp', 'respuesta.descripcion', 'respuesta.fecha', 'respuesta.tipo', 'respuesta.evidencia1', 'ticket.estado', 'respuesta.evidencia2', 'respuesta.evidencia3', 'respuesta.id AS resp','consultores.id AS consultor', 'users.name AS nomusuario', 'users.telefono', 'empresa.nombre AS empresa', 'respuesta.respuestanv', 'ticket.id_user AS iduser', 'respuesta.id_userres')
    	->get();

    	$estado =  $respuesta[0]->estado;
        $idconsultor = $respuesta[0]->consultor;
        $iduser = $respuesta[0]->iduser;
    	//dd($estado);
        $usuariorespuesta = array();
        foreach ($respuesta as $res) {
            if ($res->id_userres!=0) {
                $usuariores = User::where('id', $res->id_userres)
                ->select('users.name')
                ->get();

                $usuariorespuesta[]=$usuariores[0]->name;
            }else{
                $usuariorespuesta[]='';
            }
        }

        //dd($usuariorespuesta);

        $consultores=Consultor::where('id','!=',1)->get();

    	return view('respuesta', compact('respuesta', 'estado', 'idconsultor', 'iduser', 'usuariorespuesta','consultores'));
    }

    public function guardarRespuesta(Request $request){
        date_default_timezone_set('America/Bogota');
        $respuesta = new Respuesta();
        $fecha = date("Y/m/d H:i:s");

        $tipo = '';

        //dd($request->finalizado);
        if ($request->finalizado!='' || $request->finalizado!=null) {
            if ($request->finalizado == 'NO') {
            $tipo = 'SEGUIMIENTO';
            }else{
                $tipo = 'CIERRE';
            }
        }
        
        if ($request->estadoresp!='') {
            if ($request->estadoresp == 1) {

                $tipo = 'CIERRE';
            }else{
                $tipo = 'SEGUIMIENTO';
            }
        }
        

        $respuesta->descripcion = $request->respu;
        $respuesta->id_ticket = $request->idticket;
        $respuesta->fecha = $fecha;
        $respuesta->tipo = $tipo;
        $respuesta->respuestanv = $request->respunv;
        $respuesta->id_userres = Auth::user()->id;

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

        if ($request->estadoresp) {
            switch ($request->estadoresp) {
                case '0':
                    $ticket->estado = 0;
                    break;
                case '1':
                    $ticket->estado = 1;
                    break;
                case '2':
                    $ticket->estado = 2;
                    break;
                case '3':
                    $ticket->estado = 3;
                    break;
            }
        }

        if ($request->reasignar==1) {

            $ticket->prioridad = NULL;
            $ticket->id_consultor = 1;
            $ticket->tipo = 'Sin asignar';
            $ticket->area = $request->area_;
            $ticket->estado = 4;
        }

        if ($request->asignarConsultor==1) {

            $ticket->prioridad = NULL;
            $ticket->id_consultor = $request->consultorNuevo_;
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
