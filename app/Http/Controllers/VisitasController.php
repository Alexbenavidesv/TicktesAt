<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use App\Empresa;
use App\Visita;
use App\Visitado;
use App\Evidencia;
use DB;

class VisitasController extends Controller
{
	public function index(){
		$empresas = Empresa::all();

		return view('formulariovisita', compact('empresas'));
	}

	public function guardarVisita(Request $request){
		if($request->isMethod('post')) {
            Validator::make($request->all(), [
                'fechayhoravis' => 'required',
                'lugarvis' => 'required|string',
            ], [
                'fechayhoravis.required' => 'Debes ingresar la fecha y hora de la visita',
                'lugarvis.required' => 'Debes ingresar el lugar de la visita',
                'lugarvis.string' => 'El lugar de la visita debe ser alfanumerico',

            ])->validate();

            DB::beginTransaction();

            try {
                //INSERCION A LA TABLA VISITAS
                $visita = new Visita();

                $visita->tipo =  $request->tipovis;
                $visita->lugar = $request->lugarvis;
                $visita->fecha = $request->fechayhoravis;
                if ($request->motivovistext!='' || $request->motivovistext!=null) {
                    $visita->motivovisita = $request->motivovistext;
                }

                if ($request->recoleccionvistext!='' || $request->recoleccionvistext!=null) {
                    $visita->recoleccion = $request->recoleccionvistext;
                }

                if ($request->futurocliente!='' || $request->futurocliente!=null) {
                    $visita->cliente = $request->futurocliente;
                }

                if ($request->telfuturocliente!='' || $request->telfuturocliente!=null) {
                    $visita->telefono = $request->telfuturocliente;
                }

                if ($request->motivovistext!='' || $request->motivovistext!=null) {
                    $visita->id_empresa = null;
                }else{
                    $visita->id_empresa = $request->empresavis;
                }

                if ($request->motivovistext!='' || $request->motivovistext!=null) {
                    $visita->satisfaccion = $request->satisfaccion;
                }
                
                $visita->id_consultor = Auth::user()->id;
                $visita->save();


                //INSERCION A LA TABLA VISITADOS

                //$visitado = new Visitado();
                $id_visita = Visita::max('id');

                //$item_id = Input::get('item_id');
                //$user_id = Input::get('user_id');
                $nombre = Input::get('nombrepar');
                $identificacion = Input::get('cedulapar');
                $cargo = Input::get('cargopar');
                $telefono = Input::get('telefonopar');
                $correo = Input::get('correopar');
                $observacion = Input::get('observacionpar');

                if ($nombre[0]!='' || $nombre[0]!=null) {
                    foreach($nombre as $key => $n ) {   
                        //dd($cargo[$key]);
                        $arrData = array( 
                            "nombre" => $nombre[$key],
                            "identificacion" => $identificacion[$key], 
                            "cargo" => $cargo[$key], 
                            "telefono" => $telefono[$key], 
                            "correo" => $correo[$key],
                            "observacion" => $observacion[$key],
                            "id_visita" =>   $id_visita                
                        );
                        $visitado = new Visitado($arrData);
                        $visitado->save();
                    } 
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
	}



    public function listado(){
        $visitas = Visita::join('consultores', 'visitas.id_consultor', 'consultores.id')
        ->where('consultores.id', Auth::user()->id)
        //->join('empresa', 'visitas.id_empresa', 'empresa.id')
        //->where('visitas.id_empresa', '!=', null)
        ->select('consultores.nombre AS consultor', 'visitas.id', 'visitas.tipo', 'visitas.fecha', 'visitas.motivovisita AS motivo', 'visitas.recoleccion', 'visitas.cliente', 'visitas.estado')
        ->orderBy('id', 'desc')
        ->get();

        $visitas2 = Visita::join('consultores', 'visitas.id_consultor', 'consultores.id')
        ->where('consultores.id', Auth::user()->id)
        ->join('empresa', 'visitas.id_empresa', 'empresa.id')
        ->where('visitas.id_empresa', '!=', null)
        ->select('empresa.nombre AS empresa')
        ->get();

        return view('listadovisitas', compact('visitas', 'visitas2'));
    }

    public function verPdf($id){
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
            ->select('visitas.id', 'visitas.tipo', 'visitas.fecha', 'visitas.motivovisita AS motivo', 'visitas.recoleccion', 'visitas.cliente', 'visitas.telefono', 'consultores.nombre AS consultor', 'visitas.lugar')
            ->get();

            $visitados = '';
        }else if ($tipo=='Capacitación') {
            $visitapdf = Visita::where('visitas.id', $id)
            ->join('empresa', 'visitas.id_empresa', 'empresa.id')
            ->join('consultores', 'visitas.id_consultor', 'consultores.id')
            ->select('empresa.nombre AS empresa', 'consultores.nombre AS consultor', 'visitas.tipo', 'visitas.lugar', 'visitas.fecha')
            ->get();

            $visitados = Visitado::where('visitados.id_visita', $id)->get();
        }


        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadView('pdfVisita', compact('visitapdf', 'visitados'))->setPaper('a4', 'landscape');;
        return $pdf->stream();
    }

    public function evidencia($id){
        $evidencia = Visita::where('visitas.id', $id)
        ->join('evidencia', 'visitas.id', 'evidencia.id_visita')
        ->join('users', 'evidencia.id_user', 'users.id')
        ->select('visitas.id', 'evidencia.fecha', 'evidencia.id_user AS usuario', 'evidencia.imagen', 'users.name')
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
}