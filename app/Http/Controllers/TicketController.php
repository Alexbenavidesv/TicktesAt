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
use DB;


class TicketController extends Controller
{
    public function index()
    {
        return view("inicio");
    }

    public function nuevoTicket(Request $req)
    {
        Validator::make($req->all(),
            [
                'descripcion' => 'required|string',
                'evidencia1' => 'mimes:jpeg,bmp,png,zip,rar|max:5120',
                'evidencia2' => 'mimes:jpeg,bmp,png,zip,rar|max:5120',
                'evidencia3' => 'mimes:jpeg,bmp,png,zip,rar|max:5120'
            ],
            [
                'descripcion.required' => 'Usted debe ingresar una descripción',
                'descripcion.string' => 'La descripcion solo puede ser alfanumerica',
                'evidencia1.mimes' => 'El archivo debe ser un archivo de tipo jpg, jpeg, bmp, png, rar, zip',
                'evidencia2.mimes' => 'El archivo debe ser un archivo de tipo jpg, jpeg, bmp, png, rar, zip',
                'evidencia3.mimes' => 'El archivo debe ser un archivo de tipo jpg, jpeg, bmp, png, rar, zip'
            ]
        )->validate();

        DB::beginTransaction();

        try {
            $usuario = Auth::user()->id;
            $fecha = date("Y/m/d H:i:s");

            $ticket = new Ticket;

            $ticket->id_user = $usuario;
            $ticket->save();


            //***************INSERTAR RESPUESTA*****************

            $id_ticket = Ticket::max('id');
            $tipo = 'APERTURA';

            $respuesta = new Respuesta();

            $respuesta->descripcion = $req->descripcion;
            $respuesta->id_ticket = $id_ticket;
            $respuesta->fecha = $fecha;
            $respuesta->tipo = $tipo;
            $respuesta->id_userres = Auth::user()->id;


            if ($req->evidencia1) {
                $img = $req->file('evidencia1');
                $file_rout = time() . '_' . $img->getClientOriginalName();//hora de unix
                $img->move(public_path() . '/imgEvidencia/', $file_rout);
                $respuesta->evidencia1 = $file_rout;
            }

            if ($req->evidencia2) {
                $img2 = $req->file('evidencia2');
                $file_rout2 = time() . '_' . $img2->getClientOriginalName();//hora de unix
                $img2->move(public_path() . '/imgEvidencia/', $file_rout2);
                $respuesta->evidencia2 = $file_rout2;
            }
            if ($req->evidencia3) {
                $img3 = $req->file('evidencia3');
                $file_rout3 = time() . '_' . $img3->getClientOriginalName();//hora de unix
                $img3->move(public_path() . '/imgEvidencia/', $file_rout3);
                $respuesta->evidencia3 = $file_rout3;
            }
            $respuesta->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
        }
            


        return $id_ticket;
    }


    public function listarTickes()
    {
        $iduser = Auth::user()->id;

        $consultores = User::where('users.id_rol', '!=', 2)
            ->select('users.id', 'users.name')
            ->get();

        $empresas=Empresa::all();

        $consulta = User::join('roles', 'users.id_rol', 'roles.id')
            ->where('users.id', $iduser)
            ->select('roles.nombre')
            ->get();
        //dd($consulta);
        $rol = $consulta[0]->nombre;

        //dd($rol);

        if ($rol == 'Root') {
            $tickets = Ticket::join('respuesta', 'ticket.id', 'respuesta.id_ticket')
                ->where('respuesta.tipo', 'APERTURA')
                ->join('users', 'ticket.id_user', 'users.id')
                ->join('empresa', 'users.id_empresa', 'empresa.id')
                ->join('consultores', 'ticket.id_consultor', 'consultores.id')
                ->select('ticket.id', 'ticket.tipo','ticket.estado', 'respuesta.descripcion', 'respuesta.fecha', 'ticket.prioridad',
                    'consultores.nombre AS consultor', 'empresa.nombre AS empresa')
                ->orderBy('id', 'desc')
                ->paginate(15);

            //echo $tickets;
        } elseif ($rol == 'Consultor') {
            $tickets = Ticket::join('users', 'ticket.id_user', 'users.id')
                ->join('empresa', 'users.id_empresa', 'empresa.id')
                ->join('respuesta', 'ticket.id', 'respuesta.id_ticket')
                ->where('respuesta.tipo', 'APERTURA')
                ->join('consultores', 'ticket.id_consultor', 'consultores.id')
                ->where('consultores.id', $iduser)
                ->select('ticket.id', 'ticket.tipo', 'ticket.estado','respuesta.descripcion', 'respuesta.fecha', 'ticket.prioridad',
                    'consultores.nombre AS consultor', 'empresa.nombre AS empresa')
                ->orderBy('id', 'desc')
                ->paginate(15);
        } else {
            $consulta2 = Empresa::join('users', 'empresa.id', 'users.id_empresa')
                ->where('users.id', $iduser)
                ->select('empresa.id AS empresa')
                ->get();

            $empresa = $consulta2[0]->empresa;
            //dd($empresa);
            $tickets = Ticket::join('respuesta', 'ticket.id', 'respuesta.id_ticket')
                ->where('respuesta.tipo', 'APERTURA')
                ->join('users', 'ticket.id_user', 'users.id')
                ->where('id_empresa', $empresa)
                ->join('consultores', 'ticket.id_consultor', 'consultores.id')
                ->select('ticket.id', 'ticket.tipo','ticket.estado' ,'respuesta.descripcion', 'respuesta.fecha', 'ticket.prioridad', 'consultores.nombre AS consultor')
                ->orderBy('id', 'desc')
                ->paginate(15);
        }
        //dd($tickets);
        return view('listarTickes', compact('tickets', 'consultores','empresas'));
    }

    public function asignar(Request $request)
    {
        Validator::make($request->all(),
            [
                'prioridad' => 'required',
                'consultor' => 'required',
                'tipo' => 'required',
            ],
            [
                'prioridad.required' => 'Debes escoger una prioridad',
                'consultor.required' => 'Debes escoger un consultor',
                'tipo.required' => 'Debes escoger un tipo',
            ]
        )->validate();

        Ticket::where('id', $request->id_ticket)
            ->update(['prioridad' => $request->prioridad, 'id_consultor' => $request->consultor, 'tipo' => $request->tipo]);

        return "OK";
    }

    public function filtros(Request $request)
    {
        if ($request->prioridad_ != '' || $request->consultor_ != '' || $request->estado != ''  || $request->empresa!='' || $request->tipo_!='') {

            $iduser = Auth::user()->id;

            $consultores = User::where('users.id_rol', '!=', 2)
            ->select('users.id', 'users.name')
            ->get();


            $empresas=Empresa::all();

            $consulta = User::join('roles', 'users.id_rol', 'roles.id')
                ->where('users.id', $iduser)
                ->select('roles.nombre')
                ->get();
            //dd($consulta);
            $rol = $consulta[0]->nombre;

            //dd($rol);

            if ($rol == 'Root') {
                $tickets = Ticket::prioridad($request->prioridad_)
                    ->estado($request->estado)
                    ->tipo($request->tipo_)
                    ->join('respuesta', 'ticket.id', 'respuesta.id_ticket')
                    ->where('respuesta.tipo', 'APERTURA')
                    ->join('users', 'ticket.id_user', 'users.id')
                    ->join('empresa', 'users.id_empresa', 'empresa.id')
                    ->empresa($request->empresa)
                    ->join('consultores', 'ticket.id_consultor', 'consultores.id')
                    ->consultor($request->consultor_)
                    ->select('ticket.id', 'ticket.tipo', 'ticket.estado','respuesta.descripcion', 'respuesta.fecha', 'ticket.prioridad',
                        'consultores.nombre AS consultor', 'empresa.nombre AS empresa')
                    ->orderBy('id', 'desc')
                    ->paginate(15);
            } elseif ($rol == 'Consultor') {
                $tickets = Ticket::prioridad($request->prioridad_)
                    ->estado($request->estado)
                    ->tipo($request->tipo_)
                ->join('users', 'ticket.id_user', 'users.id')
                    ->join('empresa', 'users.id_empresa', 'empresa.id')
                    ->empresa($request->empresa)
                    ->join('respuesta', 'ticket.id', 'respuesta.id_ticket')
                    ->where('respuesta.tipo', 'APERTURA')
                    ->join('consultores','ticket.id_consultor', 'consultores.id')
                    ->where('consultores.id', $iduser)
                    ->select('ticket.id', 'ticket.tipo', 'ticket.estado','respuesta.descripcion', 'respuesta.fecha', 'ticket.prioridad',
                        'consultores.nombre AS consultor', 'empresa.nombre AS empresa')
                    ->orderBy('id', 'desc')
                    ->paginate(15);
            } else {
                $consulta2 = Empresa::join('users', 'empresa.id', 'users.id_empresa')
                    ->where('users.id', $iduser)
                    ->select('empresa.id AS empresa')
                    ->get();

                $empresa = $consulta2[0]->empresa;
                //dd($empresa);
                $tickets = Ticket::prioridad($request->prioridad_)
                    ->estado($request->estado)
                    ->tipo($request->tipo_)
                ->join('respuesta', 'ticket.id', 'respuesta.id_ticket')
                    ->where('respuesta.tipo', 'APERTURA')
                    ->join('users', 'ticket.id_user', 'users.id')
                    ->where('id_empresa', $empresa)
                    ->join('consultores','ticket.id_consultor', 'consultores.id')
                    ->consultor($request->consultor_)
                    ->select('ticket.id', 'ticket.tipo', 'ticket.estado','respuesta.descripcion', 'respuesta.fecha', 'ticket.prioridad', 'consultores.nombre AS consultor')
                    ->orderBy('id', 'desc')
                    ->paginate(15);
            }
            return view('listarTickes', compact('tickets', 'consultores','empresas'));
        }


       else{
           return redirect('consultartickets');
       }
    }

    public function ticketsNoAsignados(){
        $tickets = Ticket::where('ticket.id_consultor', 1)
            ->join('users', 'ticket.id_user', 'users.id')
            ->join('empresa', 'users.id_empresa', 'empresa.id')
            ->join('respuesta', 'ticket.id', 'respuesta.id_ticket')
            ->where('respuesta.tipo', 'APERTURA')
            ->join('consultores', 'ticket.id_consultor', 'consultores.id')
            //->where('consultores.id', $iduser)
            ->select('ticket.id', 'ticket.tipo', 'ticket.estado','respuesta.descripcion', 'respuesta.fecha', 'ticket.prioridad',
                'consultores.nombre AS consultor', 'empresa.nombre AS empresa', 'users.id AS iduser', 'users.name AS nomusuario')
            ->orderBy('id', 'desc')
            ->paginate(15);

            //dd($tickets);

            return view('noasignados', compact('tickets'));
    }

    public function guardarAsignacion(Request $request){
        Validator::make($request->all(),
            [
                'prioridad' => 'required',
                'consultor' => 'required',
                'tipo' => 'required',
            ],
            [
                'prioridad.required' => 'Debes escoger una prioridad',
                'consultor.required' => 'Debes escoger un consultor',
                'tipo.required' => 'Debes escoger un tipo',
            ]
        )->validate();

        $idticket = $request->id_ticket;

        //dd($idticket);

        $ticket = Ticket::findOrFail($idticket);

        $ticket->prioridad = $request->prioridad;
        $ticket->id_consultor = $request->consultor;
        $ticket->tipo = $request->tipo;
        $ticket->save();  

        /*Ticket::where('id', $request->id_ticket)
            ->update(['prioridad' => $request->prioridad, 'id_consultor' => $request->consultor, 'tipo' => $request->tipo]);*/

        return "OK";
    }

    public function reabrir($id_ticket){

        $respuesta=Respuesta::where('tipo','CIERRE')
            ->where('id_ticket',$id_ticket)
            ->update(['tipo' => 'SEGUIMIENTO']);

        $ticket = Ticket::findOrFail($id_ticket);
        $ticket->estado=0;
        $ticket->save();

        return $id_ticket;
    }


    public function misTickets(){
        $iduser = Auth::user()->id;

        $consultores = User::where('users.id_rol', '!=', 2)
            ->select('users.id', 'users.name')
            ->get();

        $empresas=Empresa::all();

        $tickets = Ticket::join('users', 'ticket.id_user', 'users.id')
                ->join('empresa', 'users.id_empresa', 'empresa.id')
                ->join('respuesta', 'ticket.id', 'respuesta.id_ticket')
                ->where('respuesta.tipo', 'APERTURA')
                ->join('consultores', 'ticket.id_consultor', 'consultores.id')
                ->where('consultores.id', $iduser)
                ->select('ticket.id', 'ticket.tipo', 'ticket.estado','respuesta.descripcion', 'respuesta.fecha', 'ticket.prioridad',
                    'consultores.nombre AS consultor', 'empresa.nombre AS empresa')
                ->orderBy('id', 'desc')
                ->paginate(15);

        return view('mistickets', compact('tickets', 'consultores','empresas'));
    }


    public function filtros2(Request $request)
    {
        if ($request->prioridad_ != '' || $request->consultor_ != '' || $request->estado != ''  || $request->empresa!='' || $request->tipo_!='') {

            $iduser = Auth::user()->id;

            $consultores = User::where('users.id_rol', '!=', 2)
                ->select('users.id', 'users.name')
                ->get();


            $empresas=Empresa::all();

            $consulta = User::join('roles', 'users.id_rol', 'roles.id')
                ->where('users.id', $iduser)
                ->select('roles.nombre')
                ->get();
            //dd($consulta);
            $rol = $consulta[0]->nombre;

            //dd($rol);
            $tickets = Ticket::prioridad($request->prioridad_)
                ->estado($request->estado)
                ->tipo($request->tipo_)
            ->join('users', 'ticket.id_user', 'users.id')
                ->join('empresa', 'users.id_empresa', 'empresa.id')
                ->empresa($request->empresa)
                ->join('respuesta', 'ticket.id', 'respuesta.id_ticket')
                ->where('respuesta.tipo', 'APERTURA')
                ->join('consultores','ticket.id_consultor', 'consultores.id')
                ->where('consultores.id', $iduser)
                ->select('ticket.id', 'ticket.tipo', 'ticket.estado','respuesta.descripcion', 'respuesta.fecha', 'ticket.prioridad',
                    'consultores.nombre AS consultor', 'empresa.nombre AS empresa')
                ->orderBy('id', 'desc')
                ->paginate(15);
           
            return view('mistickets', compact('tickets', 'consultores','empresas'));
        }else{
           return redirect('misTickets');
       }
    }
}
