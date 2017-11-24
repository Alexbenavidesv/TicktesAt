<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Modulos;
use App\Temas;
use DB;

class ContratosController extends Controller
{
    public function lista(){
        return view('contratos');
    }

    public function crear(){
        return view('crear_contrato');
    }

    public function modulos(){

        $modulos=Modulos::where('id','>',0)->paginate(15);
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
}
