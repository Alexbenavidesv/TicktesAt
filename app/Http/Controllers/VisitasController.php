<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use App\Empresa;
use App\Visita;
use App\Visitado;
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
                $visita->id_empresa = $request->empresavis;
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

                foreach($nombre as $key => $n ) 
                {   
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
               
                DB::commit();
            } catch (Exception $e) {
                DB::rollback();
            }

            $id_visita2 = Visita::max('id');

            $visitapdf = Visita::where('visitas.id', $id_visita2)
            ->join('empresa', 'visitas.id_empresa', 'empresa.id')
            ->join('consultores', 'visitas.id_consultor', 'consultores.id')
            ->select('empresa.nombre AS empresa', 'consultores.nombre AS consultor', 'visitas.tipo', 'visitas.lugar', 'visitas.fecha')
            ->get();


            $visitados = Visitado::where('visitados.id_visita', $id_visita2)->get();
            //dd($visitados);

             $pdf = \App::make('dompdf.wrapper');
             $pdf->loadView('pdfVisita', compact('visitapdf', 'visitados'));
             return $pdf->stream();
        }
	}



    public function listado(){
        $visitas = Visita::join('empresa', 'visitas.id_empresa', 'empresa.id')
        ->join('consultores', 'visitas.id_consultor', 'consultores.id')
        ->where('consultores.id', Auth::user()->id)
        ->select('consultores.nombre AS consultor', 'empresa.nombre AS empresa', 'visitas.id', 'visitas.tipo', 'visitas.fecha')
        ->get();

        return view('listadovisitas', compact('visitas'));
    }

    public function verPdf($id){
        $visitapdf = Visita::where('visitas.id', $id)
        ->join('empresa', 'visitas.id_empresa', 'empresa.id')
        ->join('consultores', 'visitas.id_consultor', 'consultores.id')
        ->select('empresa.nombre AS empresa', 'consultores.nombre AS consultor', 'visitas.tipo', 'visitas.lugar', 'visitas.fecha')
        ->get();


        $visitados = Visitado::where('visitados.id_visita', $id)->get();

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadView('pdfVisita', compact('visitapdf', 'visitados'));
        return $pdf->stream();
    }
}