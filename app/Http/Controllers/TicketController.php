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
use App\Modulos;
use DB;


class TicketController extends Controller
{

    public function resumen()
    {

        $mesActual = date('m');
        $anioActual = date('Y');

        $informacionMeses = array();

        if (Auth::user()->id_rol == 1) {

            $ticketsMesActual = Ticket::join('respuesta', 'ticket.id', 'respuesta.id_ticket')
                ->where('respuesta.tipo', 'APERTURA')
                ->whereMonth('respuesta.fecha', $mesActual)
                ->join('consultores', 'ticket.id_consultor', 'consultores.id')
                ->get();
        } else {
            $ticketsMesActual = Ticket::join('respuesta', 'ticket.id', 'respuesta.id_ticket')
                ->where('respuesta.tipo', 'APERTURA')
                ->whereMonth('respuesta.fecha', $mesActual)
                ->join('consultores', 'ticket.id_consultor', 'consultores.id')
                ->where('consultores.id', Auth::user()->id)
                ->get();
        }

        $sinAsignar = Ticket::where('ticket.area', NULL)
            ->join('respuesta', 'ticket.id', 'respuesta.id_ticket')
            ->where('respuesta.tipo', 'APERTURA')
            ->whereMonth('respuesta.fecha', $mesActual)
            ->join('consultores', 'ticket.id_consultor', 'consultores.id')
            ->where('consultores.id', 1)
            ->get();

        $porReasignar = Ticket::where('ticket.area', '!=', NULL)
            ->join('respuesta', 'ticket.id', 'respuesta.id_ticket')
            ->where('respuesta.tipo', 'APERTURA')
            ->whereMonth('respuesta.fecha', $mesActual)
            ->join('consultores', 'ticket.id_consultor', 'consultores.id')
            ->where('consultores.id', 1)
            ->get();

        if (Auth::user()->id_rol == 1) {
            $ticketsResueltos = Ticket::where('estado', 1)
                ->join('respuesta', 'ticket.id', 'respuesta.id_ticket')
                ->where('respuesta.tipo', 'APERTURA')
                ->whereMonth('respuesta.fecha', $mesActual)
                ->get();
        } else {
            $ticketsResueltos = Ticket::where('estado', 1)
                ->join('respuesta', 'ticket.id', 'respuesta.id_ticket')
                ->where('respuesta.tipo', 'APERTURA')
                ->whereMonth('respuesta.fecha', $mesActual)
                ->join('consultores', 'ticket.id_consultor', 'consultores.id')
                ->where('consultores.id', Auth::user()->id)
                ->get();
        }


        if (Auth::user()->id_rol == 1) {
            $ticketsPendientes = Ticket::where('estado', '!=', 1)
                ->where('ticket.id_consultor', '!=', 1)
                ->join('respuesta', 'ticket.id', 'respuesta.id_ticket')
                ->where('respuesta.tipo', 'APERTURA')
                ->whereMonth('respuesta.fecha', $mesActual)
                ->get();
        } else {
            $ticketsPendientes = Ticket::where('estado', '!=', 1)
                ->where('ticket.id_consultor', '!=', 1)
                ->join('respuesta', 'ticket.id', 'respuesta.id_ticket')
                ->where('respuesta.tipo', 'APERTURA')
                ->whereMonth('respuesta.fecha', $mesActual)
                ->join('consultores', 'ticket.id_consultor', 'consultores.id')
                ->where('consultores.id', Auth::user()->id)
                ->get();
        }


        ///Sacar informacion de los meses
        for ($i = 1; $i < 13; $i++) {
            $informacion = array();

            if (Auth::user()->id_rol == 1) {
                $info1 = Ticket::join('respuesta', 'ticket.id', 'respuesta.id_ticket')
                    ->where('respuesta.tipo', 'APERTURA')
                    ->whereMonth('respuesta.fecha', $i)
                    ->join('consultores', 'ticket.id_consultor', 'consultores.id')
                    ->get();
            } else {
                $info1 = Ticket::join('respuesta', 'ticket.id', 'respuesta.id_ticket')
                    ->where('respuesta.tipo', 'APERTURA')
                    ->whereMonth('respuesta.fecha', $i)
                    ->join('consultores', 'ticket.id_consultor', 'consultores.id')
                    ->where('consultores.id', Auth::user()->id)
                    ->get();
            }

            if (Auth::user()->id_rol == 1) {
                $info2 = Ticket::where('ticket.estado', 1)
                    ->join('respuesta', 'ticket.id', 'respuesta.id_ticket')
                    ->where('respuesta.tipo', 'APERTURA')
                    ->whereMonth('respuesta.fecha', $i)
                    ->join('consultores', 'ticket.id_consultor', 'consultores.id')
                    ->get();
            } else {
                $info2 = Ticket::where('ticket.estado', 1)
                    ->join('respuesta', 'ticket.id', 'respuesta.id_ticket')
                    ->where('respuesta.tipo', 'APERTURA')
                    ->whereMonth('respuesta.fecha', $i)
                    ->join('consultores', 'ticket.id_consultor', 'consultores.id')
                    ->where('consultores.id', Auth::user()->id)
                    ->get();
            }

            if (Auth::user()->id_rol == 1) {
                $info3 = Ticket::where('ticket.estado', '!=', 1)
                    ->join('respuesta', 'ticket.id', 'respuesta.id_ticket')
                    ->where('respuesta.tipo', 'APERTURA')
                    ->whereMonth('respuesta.fecha', $i)
                    ->join('consultores', 'ticket.id_consultor', 'consultores.id')
                    ->get();
            } else {
                $info3 = Ticket::where('ticket.estado', '!=', 1)
                    ->join('respuesta', 'ticket.id', 'respuesta.id_ticket')
                    ->where('respuesta.tipo', 'APERTURA')
                    ->whereMonth('respuesta.fecha', $i)
                    ->join('consultores', 'ticket.id_consultor', 'consultores.id')
                    ->where('consultores.id', Auth::user()->id)
                    ->get();
            }

            $info4 = Ticket::where('ticket.estado', '!=', 1)
                ->join('respuesta', 'ticket.id', 'respuesta.id_ticket')
                ->where('respuesta.tipo', 'APERTURA')
                ->whereMonth('respuesta.fecha', $i)
                ->join('consultores', 'ticket.id_consultor', 'consultores.id')
                ->where('consultores.id', 1)
                ->get();

            $informacion[] = $info1;
            $informacion[] = $info2;
            $informacion[] = $info3;
            $informacion[] = $info4;
            $informacionMeses[] = $informacion;
        }


        switch ($mesActual) {
            case 1:
                $mesActual = 'ENERO';
                break;
            case 2:
                $mesActual = 'FEBRERO';
                break;
            case 3:
                $mesActual = 'MARZO';
                break;
            case 4:
                $mesActual = 'ABRIL';
                break;
            case 5:
                $mesActual = 'MAYO';
                break;
            case 6:
                $mesActual = 'JUNIO';
                break;
            case 7:
                $mesActual = 'JULIO';
                break;
            case 8:
                $mesActual = 'AGOSTO';
                break;
            case 9:
                $mesActual = 'SEPTIEMBRE';
                break;
            case 10:
                $mesActual = 'OCTUBRE';
                break;
            case 11:
                $mesActual = 'NOVIEMBRE';
                break;
            case 12:
                $mesActual = 'DICIEMBRE';
                break;
        }

        $porcentaje = 0;

        if (count($ticketsMesActual) > 0) {
            $porcentaje = ((count($ticketsResueltos) * 100) / count($ticketsMesActual));
            $porcentaje = number_format($porcentaje, 0);
        }

        return view('resumen', compact('ticketsMesActual', 'sinAsignar', 'porReasignar', 'ticketsResueltos', 'ticketsPendientes', 'mesActual', 'anioActual', 'porcentaje', 'informacionMeses'));

    }

    public function filtro_resumen($fecha)
    {
        $fechas = explode('-', $fecha);
        $mes = $fechas[0];
        $anio = $fechas[1];

        $mesActual = $mes;
        $anioActual = $anio;

        $informacionMeses = array();

        if (Auth::user()->id_rol == 1) {
            $ticketsMesActual = Ticket::join('respuesta', 'ticket.id', 'respuesta.id_ticket')
                ->where('respuesta.tipo', 'APERTURA')
                ->whereMonth('respuesta.fecha', $mesActual)
                ->whereYear('respuesta.fecha', $anio)
                ->join('consultores', 'ticket.id_consultor', 'consultores.id')
                ->get();
        } else {
            $ticketsMesActual = Ticket::join('respuesta', 'ticket.id', 'respuesta.id_ticket')
                ->where('respuesta.tipo', 'APERTURA')
                ->whereMonth('respuesta.fecha', $mesActual)
                ->whereYear('respuesta.fecha', $anio)
                ->join('consultores', 'ticket.id_consultor', 'consultores.id')
                ->where('consultores.id', Auth::user()->id)
                ->get();
        }


        $sinAsignar = Ticket::join('respuesta', 'ticket.id', 'respuesta.id_ticket')
            ->where('respuesta.tipo', 'APERTURA')
            ->whereMonth('respuesta.fecha', $mesActual)
            ->whereYear('respuesta.fecha', $anio)
            ->join('consultores', 'ticket.id_consultor', 'consultores.id')
            ->where('consultores.id', 1)
            ->get();


        $porReasignar = Ticket::where('ticket.area', '!=', NULL)
            ->join('respuesta', 'ticket.id', 'respuesta.id_ticket')
            ->where('respuesta.tipo', 'APERTURA')
            ->whereMonth('respuesta.fecha', $mesActual)
            ->join('consultores', 'ticket.id_consultor', 'consultores.id')
            ->where('consultores.id', 1)
            ->get();


        if (Auth::user()->id_rol == 1) {
            $ticketsResueltos = Ticket::where('estado', 1)
                ->join('respuesta', 'ticket.id', 'respuesta.id_ticket')
                ->where('respuesta.tipo', 'APERTURA')
                ->whereMonth('respuesta.fecha', $mesActual)
                ->whereYear('respuesta.fecha', $anio)
                ->get();
        } else {
            $ticketsResueltos = Ticket::where('estado', 1)
                ->join('respuesta', 'ticket.id', 'respuesta.id_ticket')
                ->where('respuesta.tipo', 'APERTURA')
                ->whereMonth('respuesta.fecha', $mesActual)
                ->whereYear('respuesta.fecha', $anio)
                ->join('consultores', 'ticket.id_consultor', 'consultores.id')
                ->where('consultores.id', Auth::user()->id)
                ->get();
        }

        if (Auth::user()->id_rol == 1) {
            $ticketsPendientes = Ticket::where('estado', '!=', 1)
                ->where('ticket.id_consultor', '!=', 1)
                ->join('respuesta', 'ticket.id', 'respuesta.id_ticket')
                ->where('respuesta.tipo', 'APERTURA')
                ->whereMonth('respuesta.fecha', $mesActual)
                ->whereYear('respuesta.fecha', $anio)
                ->get();
        } else {
            $ticketsPendientes = Ticket::where('estado', '!=', 1)
                ->where('ticket.id_consultor', '!=', 1)
                ->join('respuesta', 'ticket.id', 'respuesta.id_ticket')
                ->where('respuesta.tipo', 'APERTURA')
                ->whereMonth('respuesta.fecha', $mesActual)
                ->whereYear('respuesta.fecha', $anio)
                ->join('consultores', 'ticket.id_consultor', 'consultores.id')
                ->where('consultores.id', Auth::user()->id)
                ->get();
        }


        ///Sacar informacion de los meses
        for ($i = 1; $i < 13; $i++) {
            $informacion = array();

            if (Auth::user()->id_rol == 1) {
                $info1 = Ticket::join('respuesta', 'ticket.id', 'respuesta.id_ticket')
                    ->where('respuesta.tipo', 'APERTURA')
                    ->whereMonth('respuesta.fecha', $i)
                    ->whereYear('respuesta.fecha', $anio)
                    ->join('consultores', 'ticket.id_consultor', 'consultores.id')
                    ->get();
            } else {
                $info1 = Ticket::join('respuesta', 'ticket.id', 'respuesta.id_ticket')
                    ->where('respuesta.tipo', 'APERTURA')
                    ->whereMonth('respuesta.fecha', $i)
                    ->whereYear('respuesta.fecha', $anio)
                    ->join('consultores', 'ticket.id_consultor', 'consultores.id')
                    ->where('consultores.id', Auth::user()->id)
                    ->get();
            }

            if (Auth::user()->id_rol == 1) {
                $info2 = Ticket::where('ticket.estado', 1)
                    ->join('respuesta', 'ticket.id', 'respuesta.id_ticket')
                    ->where('respuesta.tipo', 'APERTURA')
                    ->whereMonth('respuesta.fecha', $i)
                    ->whereYear('respuesta.fecha', $anio)
                    ->join('consultores', 'ticket.id_consultor', 'consultores.id')
                    ->get();

            } else {
                $info2 = Ticket::where('ticket.estado', 1)
                    ->join('respuesta', 'ticket.id', 'respuesta.id_ticket')
                    ->where('respuesta.tipo', 'APERTURA')
                    ->whereMonth('respuesta.fecha', $i)
                    ->whereYear('respuesta.fecha', $anio)
                    ->join('consultores', 'ticket.id_consultor', 'consultores.id')
                    ->where('consultores.id', Auth::user()->id)
                    ->get();
            }

            if (Auth::user()->id_rol == 1) {
                $info3 = Ticket::where('ticket.estado', '!=', 1)
                    ->join('respuesta', 'ticket.id', 'respuesta.id_ticket')
                    ->where('respuesta.tipo', 'APERTURA')
                    ->whereMonth('respuesta.fecha', $i)
                    ->whereYear('respuesta.fecha', $anio)
                    ->join('consultores', 'ticket.id_consultor', 'consultores.id')
                    ->get();
            } else {
                $info3 = Ticket::where('ticket.estado', '!=', 1)
                    ->join('respuesta', 'ticket.id', 'respuesta.id_ticket')
                    ->where('respuesta.tipo', 'APERTURA')
                    ->whereMonth('respuesta.fecha', $i)
                    ->whereYear('respuesta.fecha', $anio)
                    ->join('consultores', 'ticket.id_consultor', 'consultores.id')
                    ->where('consultores.id', Auth::user()->id)
                    ->get();
            }

            $info4 = Ticket::where('ticket.estado', '!=', 1)
                ->join('respuesta', 'ticket.id', 'respuesta.id_ticket')
                ->where('respuesta.tipo', 'APERTURA')
                ->whereMonth('respuesta.fecha', $i)
                ->whereYear('respuesta.fecha', $anio)
                ->join('consultores', 'ticket.id_consultor', 'consultores.id')
                ->where('consultores.id', 1)
                ->get();

            $informacion[] = $info1;
            $informacion[] = $info2;
            $informacion[] = $info3;
            $informacion[] = $info4;
            $informacionMeses[] = $informacion;
        }


        switch ($mesActual) {
            case 1:
                $mesActual = 'ENERO';
                break;
            case 2:
                $mesActual = 'FEBRERO';
                break;
            case 3:
                $mesActual = 'MARZO';
                break;
            case 4:
                $mesActual = 'ABRIL';
                break;
            case 5:
                $mesActual = 'MAYO';
                break;
            case 6:
                $mesActual = 'JUNIO';
                break;
            case 7:
                $mesActual = 'JULIO';
                break;
            case 8:
                $mesActual = 'AGOSTO';
                break;
            case 9:
                $mesActual = 'SEPTIEMBRE';
                break;
            case 10:
                $mesActual = 'OCTUBRE';
                break;
            case 11:
                $mesActual = 'NOVIEMBRE';
                break;
            case 12:
                $mesActual = 'DICIEMBRE';
                break;
        }
        $porcentaje = 0;
        if (count($ticketsMesActual) > 0) {

            $porcentaje = ((count($ticketsResueltos) * 100) / count($ticketsMesActual));
            $porcentaje = number_format($porcentaje, 0);
        }

       return view('resumen', compact('ticketsMesActual', 'sinAsignar', 'porReasignar','ticketsResueltos', 'ticketsPendientes', 'mesActual', 'anioActual', 'porcentaje', 'informacionMeses'));


    }


    public function index()
    {
        $modulos = Modulos::all();
        return view("inicio", compact('modulos'));
    }

    public function nuevoTicket(Request $req)
    {
        date_default_timezone_set('America/Bogota');

        Validator::make($req->all(),
            [
                'descripcion' => 'required|string',
                'moduloTicket' => 'required',
                'evidencia1' => 'mimes:jpeg,bmp,png,zip,rar|max:5120',
                'evidencia2' => 'mimes:jpeg,bmp,png,zip,rar|max:5120',
                'evidencia3' => 'mimes:jpeg,bmp,png,zip,rar|max:5120'
            ],
            [
                'descripcion.required' => 'Usted debe ingresar una descripción',
                'descripcion.string' => 'La descripcion solo puede ser alfanumerica',
                'moduloTicket.required' => 'Debe escoger el modulo del ticket',
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
            $ticket->modulo = $req->moduloTicket;
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
            ->where('users.id', '!=', 1)
            ->select('users.id', 'users.name')
            ->get();

        $modulos = Modulos::all();

        $empresas = Empresa::all();

        $consulta = User::join('roles', 'users.id_rol', 'roles.id')
            ->where('users.id', $iduser)
            ->select('roles.nombre')
            ->get();
        //dd($consulta);
        $rol = $consulta[0]->nombre;

        //dd($rol);

        if ($rol == 'Root') {
            $tickets = Ticket::where('ticket.estado', '!=', 1)
                ->join('respuesta', 'ticket.id', 'respuesta.id_ticket')
                ->where('respuesta.tipo', 'APERTURA')
                ->join('users', 'ticket.id_user', 'users.id')
                ->join('empresa', 'users.id_empresa', 'empresa.id')
                ->join('consultores', 'ticket.id_consultor', 'consultores.id')
                ->select('ticket.id', 'ticket.tipo', 'ticket.modulo', 'ticket.estado', 'respuesta.descripcion', 'respuesta.fecha', 'ticket.prioridad',
                    'consultores.nombre AS consultor', 'empresa.nombre AS empresa')
                ->orderBy('id', 'desc')
                ->paginate(15);

            //echo $tickets;
        } elseif ($rol == 'Consultor') {
            $tickets = Ticket::where('ticket.estado', '!=', 1)
                ->join('users', 'ticket.id_user', 'users.id')
                ->join('empresa', 'users.id_empresa', 'empresa.id')
                ->join('respuesta', 'ticket.id', 'respuesta.id_ticket')
                ->where('respuesta.tipo', 'APERTURA')
                ->join('consultores', 'ticket.id_consultor', 'consultores.id')
                ->where('consultores.id', $iduser)
                ->select('ticket.id', 'ticket.tipo', 'ticket.modulo', 'ticket.estado', 'respuesta.descripcion', 'respuesta.fecha', 'ticket.prioridad',
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
            $tickets = Ticket::where('ticket.estado', '!=', 1)
                ->join('respuesta', 'ticket.id', 'respuesta.id_ticket')
                ->where('respuesta.tipo', 'APERTURA')
                ->join('users', 'ticket.id_user', 'users.id')
                ->where('id_empresa', $empresa)
                ->join('consultores', 'ticket.id_consultor', 'consultores.id')
                ->select('ticket.id', 'ticket.tipo', 'ticket.modulo', 'ticket.estado', 'respuesta.descripcion', 'respuesta.fecha', 'ticket.prioridad', 'consultores.nombre AS consultor')
                ->orderBy('id', 'desc')
                ->paginate(15);
        }
        return view('listarTickes', compact('tickets', 'consultores', 'empresas', 'modulos'));
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
            ->update(['prioridad' => $request->prioridad, 'id_consultor' => $request->consultor, 'tipo' => $request->tipo, 'estado' => 0]);

        return "OK";
    }

    public function filtros(Request $request)
    {
        if ($request->prioridad_ != '' || $request->consultor_ != '' || $request->estado != ''  || $request->empresa!='' ||
            $request->tipo_!='' || $request->numero!='' || $request->modulo_!='' || $request->filtroFechaInicio!='' ||
            $request->filtroFechaFin!='') {

          $iduser = Auth::user()->id;

          $fechas=array();

          $fechas[]=$request->filtroFechaInicio;
            $fechas[]=$request->filtroFechaFin;


            $consultores = User::where('users.id_rol', '!=', 2)
                ->where('users.id','!=',1)
                ->select('users.id', 'users.name')
                ->get();

$modulos=Modulos::all();
            $empresas=Empresa::all();

            $consulta = User::join('roles', 'users.id_rol', 'roles.id')
                ->where('users.id', $iduser)
                ->select('roles.nombre')
                ->get();
            //dd($consulta);
            $rol = $consulta[0]->nombre;

            //dd($rol);

            if ($rol == 'Root') {
                $tickets = Ticket::numero($request->numero)
                ->modulo($request->modulo)
                ->prioridad($request->prioridad_)
                    ->estado($request->estado)
                    ->tipo($request->tipo_)
                    ->join('respuesta', 'ticket.id', 'respuesta.id_ticket')
                    ->where('respuesta.tipo', 'APERTURA')
                   ->rango($fechas)
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
                $tickets = Ticket::numero($request->numero)
                    ->modulo($request->modulo)
                    ->prioridad($request->prioridad_)
                    ->estado($request->estado)
                    ->tipo($request->tipo_)
                ->join('users', 'ticket.id_user', 'users.id')
                    ->join('empresa', 'users.id_empresa', 'empresa.id')
                    ->empresa($request->empresa)
                    ->join('respuesta', 'ticket.id', 'respuesta.id_ticket')
                    ->where('respuesta.tipo', 'APERTURA')
                    ->rango($fechas)
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
                $tickets = Ticket::numero($request->numero)
                    ->modulo($request->modulo)
                    ->prioridad($request->prioridad_)
                    ->estado($request->estado)
                    ->tipo($request->tipo_)
                ->join('respuesta', 'ticket.id', 'respuesta.id_ticket')
                    ->where('respuesta.tipo', 'APERTURA')
                    ->rango($fechas)
                    ->join('users', 'ticket.id_user', 'users.id')
                    ->where('id_empresa', $empresa)
                    ->join('consultores','ticket.id_consultor', 'consultores.id')
                    ->consultor($request->consultor_)
                    ->select('ticket.id', 'ticket.tipo', 'ticket.estado','respuesta.descripcion', 'respuesta.fecha', 'ticket.prioridad', 'consultores.nombre AS consultor')
                    ->orderBy('id', 'desc')
                    ->paginate(15);
            }
            return view('listarTickes', compact('tickets', 'consultores','empresas','modulos'));

        }


       else{
           return redirect('consultartickets');
           //return "OK";
       }
    }

    public function ticketsNoAsignados(){

        $consultores = User::where('users.id_rol', '!=', 2)
            ->where('users.id','!=',1)
            ->select('users.id', 'users.name')
            ->get();

        $tickets = Ticket::where('ticket.id_consultor', 1)
            ->where('ticket.area',null)
            ->join('users', 'ticket.id_user', 'users.id')
            ->join('empresa', 'users.id_empresa', 'empresa.id')
            ->join('respuesta', 'ticket.id', 'respuesta.id_ticket')
            ->where('respuesta.tipo', 'APERTURA')
            ->join('consultores', 'ticket.id_consultor', 'consultores.id')
            //->where('consultores.id', $iduser)
            ->select('ticket.id', 'ticket.tipo', 'ticket.estado','ticket.modulo','respuesta.descripcion', 'respuesta.fecha', 'ticket.prioridad',
                'consultores.nombre AS consultor', 'empresa.nombre AS empresa', 'users.id AS iduser', 'users.name AS nomusuario')
            ->orderBy('id', 'desc')
            ->paginate(15);

            //dd($tickets);

            return view('noasignados', compact('tickets','consultores'));
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
        $ticket->area = NULL;
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
        $modulos=Modulos::all();
        $empresas=Empresa::all();

        $tickets = Ticket::join('users', 'ticket.id_user', 'users.id')
                ->join('empresa', 'users.id_empresa', 'empresa.id')
                ->join('respuesta', 'ticket.id', 'respuesta.id_ticket')
                ->where('respuesta.tipo', 'APERTURA')
                ->join('consultores', 'ticket.id_consultor', 'consultores.id')
                ->where('consultores.id', $iduser)
                ->select('ticket.id', 'ticket.tipo', 'ticket.modulo','ticket.estado','respuesta.descripcion', 'respuesta.fecha', 'ticket.prioridad',
                    'consultores.nombre AS consultor', 'empresa.nombre AS empresa')
                ->orderBy('id', 'desc')
                ->paginate(15);

        return view('mistickets', compact('tickets', 'consultores','empresas','modulos'));
    }


    public function filtros2(Request $request)
    {
        if ($request->prioridad_ != '' || $request->consultor_ != '' || $request->estado != ''  || $request->empresa!='' ||
            $request->tipo_!='' || $request->numero!='' || $request->modulo!='' || $request->filtroFechaInicio!='' ||
            $request->filtroFechaFin!='') {
            $iduser = Auth::user()->id;

            $consultores = User::where('users.id_rol', '!=', 2)
                ->select('users.id', 'users.name')
                ->get();
$modulos=Modulos::all();

            $fechas=array();

            $fechas[]=$request->filtroFechaInicio;
            $fechas[]=$request->filtroFechaFin;

            $empresas=Empresa::all();

            $consulta = User::join('roles', 'users.id_rol', 'roles.id')
                ->where('users.id', $iduser)
                ->select('roles.nombre')
                ->get();
            //dd($consulta);
            $rol = $consulta[0]->nombre;

            //dd($rol);
            $tickets = Ticket::numero($request->numero)
                ->modulo($request->modulo)
                ->prioridad($request->prioridad_)
                ->estado($request->estado)
                ->tipo($request->tipo_)
            ->join('users', 'ticket.id_user', 'users.id')
                ->join('empresa', 'users.id_empresa', 'empresa.id')
                ->empresa($request->empresa)
                ->join('respuesta', 'ticket.id', 'respuesta.id_ticket')
                ->where('respuesta.tipo', 'APERTURA')
                ->rango($fechas)
                ->join('consultores','ticket.id_consultor', 'consultores.id')
                ->where('consultores.id', $iduser)
                ->select('ticket.id', 'ticket.tipo', 'ticket.modulo','ticket.estado','respuesta.descripcion', 'respuesta.fecha', 'ticket.prioridad',
                    'consultores.nombre AS consultor', 'empresa.nombre AS empresa')
                ->orderBy('id', 'desc')
                ->paginate(15);

            $flag=0;
           
            return view('listarTickes', compact('tickets', 'consultores','empresas','modulos','flag'));
        }else{
           //return redirect('misTickets');
            return "OK";
       }
    }

    public function lista_reasignar(){
        $areas=array();
        $consultores = User::where('users.id_rol', '!=', 2)
            ->select('users.id', 'users.name')
            ->get();


        $tickets = Ticket::where('ticket.id_consultor', 1)
            ->where('area','!=',NULL)
            ->join('users', 'ticket.id_user', 'users.id')
            ->join('empresa', 'users.id_empresa', 'empresa.id')
            ->join('respuesta', 'ticket.id', 'respuesta.id_ticket')
            ->where('respuesta.tipo', 'APERTURA')
            ->join('consultores', 'ticket.id_consultor', 'consultores.id')
            ->select('ticket.id', 'ticket.tipo','ticket.area','ticket.modulo', 'ticket.estado','respuesta.descripcion', 'respuesta.fecha','ticket.prioridad',
                'consultores.nombre AS consultor', 'empresa.nombre AS empresa', 'users.id AS iduser', 'users.name AS nomusuario')
            ->orderBy('id', 'desc')
            ->get();

        foreach ($tickets as $area){
            $areas[]=$area->area;
        }

        $areas=array_unique($areas);

        return view('reasignar', compact('tickets','areas','consultores'));
    }
}
