<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Modulos;
use App\Temas;
use App\Empresa;
use App\Contratos;
use App\Modulo_contrato;
use DB;

class ContratosController extends Controller
{
    public function lista(){
        $contratos = Contratos::join('empresa', 'contrato.id_empresa', 'empresa.id')
        ->select('empresa.nombre', 'contrato.id', 'contrato.tipo', 'contrato.totalhoras')
        ->get();
        //dd($contratos);
        return view('contratos', compact('contratos'));
    }

    public function crear(){
        $empresas=Empresa::all();
        $modulos=Modulos::all();
        return view('crear_contrato',compact('empresas','modulos'));
    }

    public function modulos(){

        $modulos=Modulos::where('id','>',0)->orderBy('id','DESC')->paginate(15);
        $temas=Temas::all();

        return view('modulos',compact('modulos','temas'));
    }

    public function guardar_modulo(Request $request){

        $temas=$request->temas;
        $manuales=$request->file('manuales');

         $i=0;


             DB::beginTransaction();

             try {

                 $modulo= new Modulos();
                 $modulo->nombre=$request->modulo;
                 $modulo->save();


                 for($i=0;$i<count($temas);$i++){
                     $tem=new Temas();
                     $tem->nombre_tema=$temas[$i];

                     if(isset($manuales[$i])){

                         $man = $manuales[$i];
                         $nombreManual = time().'.'.$man->getClientOriginalExtension();
                         $man->move(public_path() . '/manuales/', $nombreManual);
                         $tem->manual = $nombreManual;
                     }
                     else{
                         $tem->manual=null;
                     }

                     $tem->id_modulo=$modulo->id;
                     $tem->save();
                 }


             DB::commit();
             } catch (Exception $e) {
                 DB::rollback();
             }

             return "OK";

    }

    public function descargar($file){
        $url = public_path().'/manuales/'.$file;
        if (file_exists($url)){
            return response()->download($url);
        }
        abort(404);
    }

    public function guardarContrato(Request $request){
        DB::beginTransaction();

        try {
            $contrato = new Contratos();

            $contrato->tipo = $request->tipocontrato;
            $contrato->totalhoras = $request->inputTotal; 
            $contrato->id_empresa = $request->empresa;
            $contrato->estado = 1;
            $contrato->save();

            $id_contrato = Contratos::max('id');
            $idmodulo = Input::get('idmodulo');
            $horas = Input::get('horasmodulo');
            $tipopago = Input::get('tipopago');

            foreach($idmodulo as $key => $n ) {  
                $arrData = array( 
                    "horas" => $horas[$key],
                    "id_contrato" => $id_contrato,
                    "id_modulo" => $idmodulo[$key],
                    "tipo_pago" => $tipopago[$key]             
                );
                $modulo_contrato = new modulo_contrato($arrData);
                $modulo_contrato->save();
            } 
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
        }
        return 'ok';
    }
}