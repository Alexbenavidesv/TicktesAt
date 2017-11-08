<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Ticket;
use App\Respuesta;
use App\User;
use App\Role_users;


class TicketController extends Controller
{
    public function index(){
    	return view("inicio");
    }

    public function nuevoTicket(Request $req){
    	Validator::make($req->all(),
            [
                'descripcion' => 'required|string',
                'evidencia1' => 'required|mimes:jpeg,bmp,png',
                'evidencia2' => 'mimes:jpeg,bmp,png',
                'evidencia3' => 'mimes:jpeg,bmp,png'
            ],
            [
                'descripcion.required' => 'Usted debe ingresar una descripción',
                'descripcion.string' => 'La descripcion solo puede ser alfanumerica',
                'evidencia1.required' => 'Debe ingresar por lo menos la primera evidencia',
                'evidencia1.mimes' => 'El archivo debe ser una imagen (jpg, jpeg, bmp, png)',
                'evidencia2.mimes' => 'El archivo debe ser una imagen (jpg, jpeg, bmp, png)',
                'evidencia3.mimes' => 'El archivo debe ser una imagen (jpg, jpeg, bmp, png)'
            ]
        )->validate();

        $usuario = Auth::user()->id;
        $fecha = date("Y/m/d");

        $ticket = new Ticket;

        $ticket->id_user = $usuario;
        $ticket->save();


        //***************INSERTAR RESPUESTA*****************

        $id_ticket = Ticket::max('id');
        $tipo = 'APERTURA';
        
        $img = $req->file('evidencia1');
		$file_rout = time().'_'.$img->getClientOriginalName();//hora de unix
        $img->move(public_path().'/imgEvidencia/', $file_rout);

        $respuesta = new Respuesta();

        $respuesta->descripcion = $req->descripcion;
        $respuesta->id_ticket = $id_ticket;
        $respuesta->fecha = $fecha;
        $respuesta->tipo = $tipo;
        $respuesta->evidencia1 = $file_rout;
        if ($req->evidencia2) {
        	$img2 = $req->file('evidencia2');
			$file_rout2 = time().'_'.$img2->getClientOriginalName();//hora de unix
	        $img2->move(public_path().'/imgEvidencia/', $file_rout2);
        	$respuesta->evidencia2 = $file_rout2;
        }
        if ($req->evidencia3) {
        	$img3 = $req->file('evidencia3');
			$file_rout3 = time().'_'.$img3->getClientOriginalName();//hora de unix
	        $img3->move(public_path().'/imgEvidencia/', $file_rout3);
        	$respuesta->evidencia3 = $file_rout3;
        }
        $respuesta->save();

        return 'ok';
    }




    public function listarTickes(){
    	$iduser = Auth::user()->id;

    	$consulta = User::join('role_users', 'users.id', 'role_users.id_users')
    	->where('users.id', $iduser)
    	->join('roles', 'role_users.id_rol', 'roles.id')
    	->select('roles.nombre')
    	->get();

    	$rol = $consulta[0]->nombre;

    	//dd($rol);
    	if ($rol == 'Root') {
    		$tickets = Ticket::join('respuesta', 'ticket.id', 'respuesta.id_ticket')
    					   ->select('ticket.id', 'respuesta.descripcion', 'respuesta.fecha', 'ticket.prioridad','ticket.id_consultor')
    					   ->orderBy('id', 'desc')
    					   ->get();
    	}else{
    		$consulta2 = User::join('empresa', 'users.id_empresa', 'empresa.id')
    		->where('users.id', $iduser)
    		->select('empresa.id')
    		->get();

    		$empresa = $consulta2[0]->id;

    		$tickets = Ticket::join('respuesta', 'ticket.id', 'respuesta.id_ticket')
    					   ->join('users', 'ticket.id_user', 'users.id')
    					   ->where('id_empresa', $empresa)
    					   ->select('ticket.id', 'respuesta.descripcion', 'respuesta.fecha', 'ticket.prioridad','ticket.id_consultor')
    					   ->orderBy('id', 'desc')
    					   ->get();
    	}
    	
    	$var = $tickets[0]->id_consultor;
    	$nomconsultor = '';
    	if ($var!=null) {
    		$consultor = User::where('id', $var)->get();
    		$nomconsultor = $consultor[0]->name;
    	}

    	return view('listarTickes', compact('tickets', 'nomconsultor'));
    }
}
