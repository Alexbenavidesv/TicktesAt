<?php

namespace App\Http\Controllers;
use App\Consultor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use App\Empresa;
use App\Visita;
use App\Visitado;
use App\Evidencia;
use App\Contratos;
use App\Modulo_contrato;
use DB;
use Carbon\Carbon;

class VisitasController extends Controller
{
	public function index(){
		$empresas = Contratos::join('empresa', 'contrato.id_empresa', 'empresa.id')
        ->select('empresa.id', 'empresa.nombre')
        ->groupBy('id', 'nombre')
        ->get();

        //dd($empresas);

		return view('formulariovisita', compact('empresas'));
	}

	public function guardarVisita(Request $request){
        //dd($request->motivovistext);

        DB::beginTransaction();

        try {
           //INSERCION A LA TABLA VISITAS
            $visita = new Visita();

            if ($request->tipovis=='Capacitación') {
                $visita->tipo = $request->tipovis;
                $visita->lugar = $request->lugarvis;
                $visita->id_empresa = $request->empresavis;
                $visita->fecha = $request->fechainicio;
                $visita->id_modulo = $request->modulovis;
                $visita->id_consultor = Auth::user()->id;
                $visita->fechainicio = $request->horainicio;
                $visita->fechafin = $request->horafin;
                $visita->duracion = $request->oculto;
                $visita->id_contrato = $request->contratovis;

                $visita->save();

                $idmodulo = $request->modulovis;
                $idcontrato = $request->contratovis;
                //dd($request->oculto);
                $horas = $request->oculto;

                $consulta = Modulo_contrato::where('modulo_contrato.id_modulo', $idmodulo)
                ->where('modulo_contrato.id_contrato', $idcontrato)
                ->select('modulo_contrato.id', 'modulo_contrato.horas')
                ->get();

                $consulta2 = Contratos::where('contrato.id', $idcontrato)
                ->select('contrato.totalhoras')
                ->get(); 

                $contrato = Contratos::findOrFail($idcontrato);
                $modulo_contrato = Modulo_contrato::findOrFail($consulta[0]->id);

                //dd($horas);

                $contrato->totalhoras = $consulta2[0]->totalhoras - $horas;
                $contrato->save();

                $modulo_contrato->horas = $consulta[0]->horas - $horas;
                $modulo_contrato->save();


                //INSERCION A LA TABLA VISITADOS
                $visitado = new Visitado();
                $id_visita = Visita::max('id');

                $nombre = Input::get('nombrepar');
                $cargo = Input::get('cargopar');
                $telefono = Input::get('telefonopar');

                if ($nombre[0]!='' || $nombre[0]!=null) {
                    foreach($nombre as $key => $n ) {   
                        //dd($cargo[$key]);
                        $arrData = array( 
                            "nombre" => $nombre[$key],
                            "cargo" => $cargo[$key], 
                            "telefono" => $telefono[$key], 
                            "id_visita" =>   $id_visita                
                        );
                        $visitado = new Visitado($arrData);
                        $visitado->save();
                    } 
                }
            }



            if ($request->tipovis=='Presentación') {
                //dd($request->motivovistext);
                $fechahora = Carbon::parse($request->fechayhoravis);
                //dd($fechahora);
                $visita->tipo = $request->tipovis;
                $visita->lugar = $request->lugarvis;
                $visita->fecha = $fechahora;
                $visita->estado = 1;
                $visita->motivovisita = $request->motivovistext;
                $visita->recoleccion = $request->recoleccionvistext;
                $visita->cliente = $request->viscliente;
                $visita->telefono = $request->telfuturocliente;
                $visita->satisfaccion = $request->satisfaccion;
                $visita->id_consultor = Auth::user()->id;

                $visita->save();
            }



            if ($request->tipovis=='Consultoría') {
                $fechahora = Carbon::parse($request->fechayhoravis);
                //dd($request->tipovis);
                $visita->tipo = $request->tipovis;
                $visita->lugar = $request->lugarvis;
                $visita->fecha = $fechahora;
                $visita->estado = 1;
                $visita->motivovisita = $request->motivovistext;
                $visita->recoleccion = $request->recoleccionvistext;
                $visita->cliente = $request->viscliente;
                $visita->telefono = $request->telfuturocliente;
                $visita->satisfaccion = $request->satisfaccion;
                $visita->id_consultor = Auth::user()->id;

                $visita->save();
            }




            if ($request->tipovis=='Soporte') {
                $horainicio = $request->iniciosoporte;
                $horafin = $request->finsoporte;

                $horai = Carbon::parse($horainicio);
                $horaf = Carbon::parse($horafin);

                $diferencia = $horai->diffInHours($horaf);

                $visita->id_empresa = $request->empresavis;
                $visita->tipo = $request->tipovis;
                $visita->fechainicio = $horai;
                $visita->fechafin = $horaf;
                $visita->duracion = $diferencia;
                $visita->lugar = $request->lugarvis;
                $visita->motivovisita = $request->motivovistext;
                $visita->recoleccion = $request->recoleccionvistext;
                $visita->id_consultor = Auth::user()->id;

                $visita->save();
            }


            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
        }

        /*$id_visita2 = Visita::max('id');

        $visitapdf = Visita::where('visitas.id', $id_visita2)
        ->join('empresa', 'visitas.id_empresa', 'empresa.id')
        ->join('consultores', 'visitas.id_consultor', 'consultores.id')
        ->select('empresa.nombre AS empresa', 'consultores.nombre AS consultor', 'visitas.tipo', 'visitas.lugar', 'visitas.fecha')
        ->get();


        $visitados = Visitado::where('visitados.id_visita', $id_visita2)->get();
        //dd($visitados);

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadView('pdfVisita', compact('visitapdf', 'visitados'));
        return $pdf->stream();*/

        return back()->withInput();
	}



    public function listado(){
        $tipo1='Capacitación';
        $tipo2='Consultoría';
        $tipo3='Presentación';
        $tipo4='Soporte';
        
        $capacitacion = Visita::where('visitas.tipo', $tipo1)
        ->join('empresa', 'visitas.id_empresa', 'empresa.id')
        ->join('consultores', 'visitas.id_consultor', 'consultores.id')
        ->where('consultores.id', Auth::user()->id)
        ->join('modulos', 'visitas.id_modulo', 'modulos.id')
        ->select('visitas.id', 'visitas.lugar', 'visitas.fecha', 'empresa.nombre AS empresa', 'consultores.nombre AS consultor', 'modulos.nombre AS modulo', 'visitas.fechainicio', 'visitas.fechafin', 'visitas.duracion')
        ->get();

        $consultoria = Visita::where('visitas.tipo', $tipo2)
        ->join('consultores', 'visitas.id_consultor', 'consultores.id')
        ->where('consultores.id', Auth::user()->id)
        ->select('visitas.id', 'visitas.tipo', 'visitas.lugar', 'visitas.fecha', 'visitas.motivovisita', 'visitas.recoleccion', 'visitas.cliente', 'visitas.telefono', 'visitas.satisfaccion', 'consultores.nombre AS consultor', 'visitas.estado')
        ->get();

        $presentacion = Visita::where('visitas.tipo', $tipo3)
        ->join('consultores', 'visitas.id_consultor', 'consultores.id')
        ->where('consultores.id', Auth::user()->id)
        ->select('visitas.id', 'visitas.tipo', 'visitas.lugar', 'visitas.fecha', 'visitas.motivovisita', 'visitas.recoleccion', 'visitas.cliente', 'visitas.telefono', 'visitas.satisfaccion', 'consultores.nombre AS consultor', 'visitas.estado')
        ->get();

        $soporte = Visita::where('visitas.tipo', $tipo4)
        ->join('empresa', 'visitas.id_empresa', 'empresa.id')
        ->join('consultores', 'visitas.id_consultor', 'consultores.id')
        ->where('consultores.id', Auth::user()->id)
        ->select('visitas.id', 'visitas.tipo', 'visitas.lugar', 'visitas.fechainicio', 'visitas.fechafin', 'visitas.duracion', 'visitas.motivovisita', 'visitas.recoleccion','empresa.nombre AS empresa', 'consultores.nombre AS consultor')
        ->get();

        return view('listadovisitas', compact('capacitacion', 'consultoria', 'presentacion', 'soporte'));
    }


    public function filtroMisVisitas(Request $request){

        $fechas=array();

        $fechas[]=$request->fechaInicioMisVisita;
        $fechas[]=$request->fechaFinMisVisita;

        if(count($fechas)==2){
            $tipo1='Capacitación';
            $tipo2='Consultoría';
            $tipo3='Presentación';
            $tipo4='Soporte';

            $capacitacion = Visita::where('visitas.tipo', $tipo1)
                ->rango($fechas)
                ->join('empresa', 'visitas.id_empresa', 'empresa.id')
                ->join('consultores', 'visitas.id_consultor', 'consultores.id')
                ->where('consultores.id', Auth::user()->id)
                ->join('modulos', 'visitas.id_modulo', 'modulos.id')
                ->select('visitas.id', 'visitas.lugar', 'visitas.fecha', 'empresa.nombre AS empresa', 'consultores.nombre AS consultor', 'modulos.nombre AS modulo', 'visitas.fechainicio', 'visitas.fechafin', 'visitas.duracion')
                ->get();

            $consultoria = Visita::where('visitas.tipo', $tipo2)
                ->rango($fechas)
                ->join('consultores', 'visitas.id_consultor', 'consultores.id')
                ->where('consultores.id', Auth::user()->id)
                ->select('visitas.id', 'visitas.tipo', 'visitas.lugar', 'visitas.fecha', 'visitas.motivovisita', 'visitas.recoleccion', 'visitas.cliente', 'visitas.telefono', 'visitas.satisfaccion', 'consultores.nombre AS consultor', 'visitas.estado')
                ->get();

            $presentacion = Visita::where('visitas.tipo', $tipo3)
                ->rango($fechas)
                ->join('consultores', 'visitas.id_consultor', 'consultores.id')
                ->where('consultores.id', Auth::user()->id)
                ->select('visitas.id', 'visitas.tipo', 'visitas.lugar', 'visitas.fecha', 'visitas.motivovisita', 'visitas.recoleccion', 'visitas.cliente', 'visitas.telefono', 'visitas.satisfaccion', 'consultores.nombre AS consultor', 'visitas.estado')
                ->get();

            $soporte = Visita::where('visitas.tipo', $tipo4)
                ->rango($fechas)
                ->join('empresa', 'visitas.id_empresa', 'empresa.id')
                ->join('consultores', 'visitas.id_consultor', 'consultores.id')
                ->where('consultores.id', Auth::user()->id)
                ->select('visitas.id', 'visitas.tipo', 'visitas.lugar', 'visitas.fechainicio', 'visitas.fechafin', 'visitas.duracion', 'visitas.motivovisita', 'visitas.recoleccion','empresa.nombre AS empresa', 'consultores.nombre AS consultor')
                ->get();

            return view('listadovisitas', compact('capacitacion', 'consultoria', 'presentacion', 'soporte'));
        }

	}


    public function verPdf($id){
        //dd($id);
        $visita = Visita::where('visitas.id', $id)
        ->select('visitas.id', 'visitas.tipo')
        ->get();

        $tipo = $visita[0]->tipo;

        //dd($tipo);

        $visitapdf = '';
        $visitados = '';

        if ($tipo=='Consultoría'||$tipo=='Presentación') {
            $visitapdf = Visita::where('visitas.id', $id)
            ->join('consultores', 'visitas.id_consultor', 'consultores.id')
            ->select('visitas.id', 'visitas.tipo', 'visitas.fecha', 'visitas.motivovisita AS motivo', 'visitas.recoleccion', 'visitas.cliente', 'visitas.telefono', 'consultores.nombre AS consultor', 'visitas.lugar', 'visitas.satisfaccion')
            ->get();

            $visitados = '';

        }else if ($tipo=='Capacitación') {
            $visitapdf = Visita::where('visitas.id', $id)
            ->join('empresa', 'visitas.id_empresa', 'empresa.id')
            ->join('consultores', 'visitas.id_consultor', 'consultores.id')
            ->join('modulos', 'visitas.id_modulo', 'modulos.id')
            ->select('empresa.nombre AS empresa', 'consultores.nombre AS consultor', 'visitas.tipo', 'visitas.lugar', 'visitas.fechainicio', 'visitas.fechafin', 'visitas.duracion', 'modulos.nombre AS modulo')
            ->get();

            $visitados = Visitado::where('visitados.id_visita', $id)->get();

        }else if ($tipo=='Soporte') {
            $visitapdf = Visita::where('visitas.id', $id)
            ->join('empresa', 'visitas.id_empresa', 'empresa.id')
            ->join('consultores', 'visitas.id_consultor', 'consultores.id')            
            ->select('empresa.nombre AS empresa', 'consultores.nombre AS consultor', 'visitas.tipo', 'visitas.lugar', 'visitas.fechainicio', 'visitas.fechafin', 'visitas.duracion', 'visitas.motivovisita AS motivo', 'visitas.recoleccion')
            ->get();

            //dd($visitapdf);

            $visitados = '';
        }

		
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadView('pdfVisita', compact('visitapdf', 'visitados'))->setPaper('a4', 'landscape');
        return $pdf->stream();
    }




    public function evidencia($id){
        $evidencia = Visita::where('visitas.id', $id)
        ->join('evidencia', 'visitas.id', 'evidencia.id_visita')
        ->join('users', 'evidencia.id_user', 'users.id')
        ->select('visitas.id', 'evidencia.fecha', 'evidencia.id_user AS usuario', 'evidencia.imagen', 'users.name', 'evidencia.respvisible', 'evidencia.respnovisible', 'evidencia.id AS idevidencia')
        ->get();

        $visita = Visita::where('visitas.id', $id)->get();
        //dd($evidencia);

        return view('evidenciaVisita', compact('evidencia', 'visita'));
    }





    public function guardarEvidencia(Request $request){
        if($request->isMethod('post')) {
            Validator::make($request->all(), [
                'evidenciavis' => 'required|mimes:jpeg,bmp,png,zip,rar|max:5120',
            ], [
                'evidenciavis.required' => 'Debes ingresar la evidencia',
                'evidenciavis.mimes' => 'El archivo de evidencia debe ser jpeg,bmp,png,zip,rar',
            ])->validate();

            $evidencia = new Evidencia();

            date_default_timezone_set('America/Bogota');
            $fecha = date("Y/m/d H:i:s");

            $evidencia->respvisible = $request->comentariov;

            if ($request->evidenciavis) {
                $img = $request->file('evidenciavis');
                $file_rout = time() . '_' . $img->getClientOriginalName();//hora de unix
                $img->move(public_path() . '/imgEvidenciaVisitas/', $file_rout);
                $evidencia->imagen = $file_rout;
            }

            $evidencia->fecha = $fecha;
            $evidencia->id_user = Auth::user()->id;
            $evidencia->id_visita = $request->idvisitaevi;
            $evidencia->save();

            $visita = Visita::findOrFail($request->idvisitaevi);
            $visita->estado = 1;
            $visita->save();

            return back()->withInput();
        }
    }

    public function descargar($archivo){
        $url = public_path().'/imgEvidenciaVisitas/'.$archivo;
        if (file_exists($url)){
            return response()->download($url);
        }
        abort(404);
    }

    public function listGeneral(){
        $tipo1='Capacitación';
        $tipo2='Consultoría';
        $tipo3='Presentación';
        $tipo4='Soporte';

        $consultores=Consultor::all();
        
        $capacitacion = Visita::where('visitas.tipo', $tipo1)
        ->join('empresa', 'visitas.id_empresa', 'empresa.id')
        ->join('consultores', 'visitas.id_consultor', 'consultores.id')
        ->join('modulos', 'visitas.id_modulo', 'modulos.id')
        ->select('visitas.id', 'visitas.lugar', 'visitas.fecha', 'empresa.nombre AS empresa', 'consultores.nombre AS consultor', 'modulos.nombre AS modulo', 'visitas.fechainicio', 'visitas.fechafin', 'visitas.duracion')
        ->get();

        $consultoria = Visita::where('visitas.tipo', $tipo2)
        ->join('consultores', 'visitas.id_consultor', 'consultores.id')
        ->select('visitas.id', 'visitas.tipo', 'visitas.lugar', 'visitas.fecha', 'visitas.motivovisita', 'visitas.recoleccion', 'visitas.cliente', 'visitas.telefono', 'visitas.satisfaccion', 'consultores.nombre AS consultor', 'visitas.estado')
        ->get();

        $presentacion = Visita::where('visitas.tipo', $tipo3)
        ->join('consultores', 'visitas.id_consultor', 'consultores.id')
        ->select('visitas.id', 'visitas.tipo', 'visitas.lugar', 'visitas.fecha', 'visitas.motivovisita', 'visitas.recoleccion', 'visitas.cliente', 'visitas.telefono', 'visitas.satisfaccion', 'consultores.nombre AS consultor', 'visitas.estado')
        ->get();

        $soporte = Visita::where('visitas.tipo', $tipo4)
        ->join('empresa', 'visitas.id_empresa', 'empresa.id')
        ->join('consultores', 'visitas.id_consultor', 'consultores.id')
        ->select('visitas.id', 'visitas.tipo', 'visitas.lugar', 'visitas.fechainicio', 'visitas.fechafin', 'visitas.duracion', 'visitas.motivovisita', 'visitas.recoleccion','empresa.nombre AS empresa', 'consultores.nombre AS consultor')
        ->get();

        //dd($soporte[0]->fechainicio);

        return view('visitasGral', compact('capacitacion', 'consultoria', 'presentacion', 'soporte','consultores'));
    }

    public function filtroVisitas(Request $request){
        $consultor=$request->consultorVisita_;


        $fechas=array();

        $fechas[]=$request->fechaInicioVisita;
        $fechas[]=$request->fechaFinVisita;


	    if($consultor!=null || (count($fechas)==2) ){
            $tipo1='Capacitación';
            $tipo2='Consultoría';
            $tipo3='Presentación';
            $tipo4='Soporte';

            $consultores=Consultor::all();

            $capacitacion = Visita::where('visitas.tipo', $tipo1)
                ->consultor($consultor)
                ->rango($fechas)
                ->join('empresa', 'visitas.id_empresa', 'empresa.id')
                ->join('consultores', 'visitas.id_consultor', 'consultores.id')
                ->join('modulos', 'visitas.id_modulo', 'modulos.id')
                ->select('visitas.id', 'visitas.lugar', 'visitas.fecha', 'empresa.nombre AS empresa', 'consultores.nombre AS consultor', 'modulos.nombre AS modulo', 'visitas.fechainicio', 'visitas.fechafin', 'visitas.duracion')
                ->get();

            $consultoria = Visita::where('visitas.tipo', $tipo2)
                ->consultor($consultor)
                ->rango($fechas)
                ->join('consultores', 'visitas.id_consultor', 'consultores.id')
                ->select('visitas.id', 'visitas.tipo', 'visitas.lugar', 'visitas.fecha', 'visitas.motivovisita', 'visitas.recoleccion', 'visitas.cliente', 'visitas.telefono', 'visitas.satisfaccion', 'consultores.nombre AS consultor', 'visitas.estado')
                ->get();

            $presentacion = Visita::where('visitas.tipo', $tipo3)
                ->consultor($consultor)
                ->rango($fechas)
                ->join('consultores', 'visitas.id_consultor', 'consultores.id')
                ->select('visitas.id', 'visitas.tipo', 'visitas.lugar', 'visitas.fecha', 'visitas.motivovisita', 'visitas.recoleccion', 'visitas.cliente', 'visitas.telefono', 'visitas.satisfaccion', 'consultores.nombre AS consultor', 'visitas.estado')
                ->get();

            $soporte = Visita::where('visitas.tipo', $tipo4)
                ->consultor($consultor)
                ->rango($fechas)
                ->join('empresa', 'visitas.id_empresa', 'empresa.id')
                ->join('consultores', 'visitas.id_consultor', 'consultores.id')
                ->select('visitas.id', 'visitas.tipo', 'visitas.lugar', 'visitas.fechainicio', 'visitas.fechafin', 'visitas.duracion', 'visitas.motivovisita', 'visitas.recoleccion','empresa.nombre AS empresa', 'consultores.nombre AS consultor')
                ->get();

            return view('visitasGral', compact('capacitacion', 'consultoria', 'presentacion', 'soporte','consultores'));

        }
    }


    public function contratos($id){
        $contratos = Contratos::where('contrato.id_empresa', $id)
        ->select('contrato.id', 'contrato.tipo')
        ->get();

        return $contratos;
    }

    public function Modulos($id){
        $modulos = Modulo_contrato::where('modulo_contrato.id_contrato', $id)
        ->join('modulos', 'modulo_contrato.id_modulo', 'modulos.id')
        ->select('modulos.id', 'modulos.nombre')
        ->get();

        return $modulos;
    }

    public function horasModulos(Request $request){
        $horas = Modulo_contrato::where('modulo_contrato.id_modulo', $request->idmodulo)
        ->where('modulo_contrato.id_contrato', $request->idcontrato)
        ->select('modulo_contrato.horas')
        ->get();

        return $horas[0]->horas;
    }


    public function finalizar(Request $request){
        $visita = Visita::findOrFail($request->ocultoid);

        $visita->estado = 2;

        $visita->save();

        return 'ok';
    }
}