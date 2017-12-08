<?php

namespace App\Http\Controllers;

use App\Empresa;
use Illuminate\Http\Request;
use App\Limite_ticket;
use Illuminate\Support\Facades\DB;

class ParametrosController extends Controller
{
    public function limite(){

        $limites=Limite_ticket::join('empresa','limite_ticket.id_empresa','empresa.id')
            ->select('empresa.nombre','limite_ticket.id','limite_ticket.pendientes','limite_ticket.por_confirmar')
            ->get();

        if(count($limites)>0){
            $sql='select * from empresa where not exists (select 1 from limite_ticket where limite_ticket.id_empresa = empresa.id)';

            $empresas=DB::select($sql);
        }else{
            $sql='select * from empresa';

            $empresas=DB::select($sql);
        }
        return view('limite',compact('limites','empresas'));
    }

    public function guardarLimite(Request $request){
       $limite= new Limite_ticket();
       $limite->por_confirmar=$request->porconfirmar;
       $limite->pendientes=$request->pendiente;
       $limite->id_empresa=$request->empresa;
       $limite->save();
       return "OK";
    }

    public function editarLimite(Request $request){

        $limite=  Limite_ticket::findOrFail($request->id);
        $limite->por_confirmar=$request->porconfirmar;
        $limite->pendientes=$request->pendiente;
        $limite->save();
        return "OK";
    }
}
