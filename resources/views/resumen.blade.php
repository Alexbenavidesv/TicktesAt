@extends('layouts.app')

@section('title')
    Resumen
@endsection

@section('content')



    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main block-center">

        <div class="row">
            <div class="col-md-9">
                <h1 class="text-center" style="margin-top: -1.5%">Resumen de Tickets</h1>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <?php $var=date('m-Y');?>
                    <label for="" id="errorFecha"></label>
                <input type="text" class="form-control buscarFecha" id="buscarFecha" placeholder="Mes y año" value="{{$var}}"> <br>
                <button class="btn btn-success" onclick="buscarFecha()" style="width: 60%"><i class="fa fa-search"></i> Buscar</button>

                </div>
            </div>
        </div>
        <?php
        $days = date("t"); //total de dias del mes actual

        if(!(isset($mes_) && isset($anio_))){
            $mes=date('m');
            $anio=date('Y');
            $fechaInicio=$mes.'/01/'.$anio;
            $fechaFin=$mes.'/'.$days.'/'.$anio;
            }
            else{
                $mes=$mes_;
                $anio=$anio_;
                $fechaInicio=$mes.'/01/'.$anio;
                $fechaFin=$mes.'/'.$days.'/'.$anio;
        }

        ?>


        <div for="" class="">
            <h4><b>RESUMEN GENERAL DEL MES DE {{$mesActual}}</b></h4><br>
        </div>

        <div class="row text-center">
            <a href="/consultartickets">
                <div class="col-md-2 alert alert-info"  style="margin-left: 2%;">
               <h4> <i class="fa fa-ticket"></i>  @if(Auth::user()->id_rol==1)  Solicitados @else Asignados @endif </h4>
                <h3>{{count($ticketsMesActual)}}</h3>
            </div>
            </a>

            <a href="/filtrar_tickets?estado[]=1&filtroFechaInicio={{$fechaInicio}}&filtroFechaFin={{$fechaFin}}">
            <div class="col-md-2 alert alert-success" style="margin-left: 2%;">
                <h4> <i class="fa fa-check"></i> Resueltos </h4>
                <h3>{{count($ticketsResueltos)}}</h3>
            </div>
            </a>

            <a href="/filtrar_tickets?estado[]=0&estado[]=2&estado[]=3&filtroFechaInicio={{$fechaInicio}}&filtroFechaFin={{$fechaFin}}">
            <div class="col-md-2 alert alert-danger " style="margin-left: 2%;">
                <h4> <i class="fa fa-hourglass-half"></i> Por resolver </h4>
                <h3>{{count($ticketsPendientes)}}</h3>
            </div>
            </a>

            @if(Auth::user()->id_rol==1)
                <a href="/filtrar_tickets?consultor_[]=1&filtroFechaInicio={{$fechaInicio}}&filtroFechaFin={{$fechaFin}}">
                <div class="col-md-2 alert alert-warning" style="margin-left: 2%;">
                <h4> <i class="fa fa-user-times"></i> Sin asignar</h4>
                <h3>{{count($sinAsignar)}}</h3>
            </div>
                </a>

                <a href="/filtrar_tickets?estado[]=4&filtroFechaInicio={{$fechaInicio}}&filtroFechaFin={{$fechaFin}}">
                <div class="col-md-2 alert alert-warning" style="margin-left: 2%;">
                    <h4> <i class="fa fa-refresh"></i> Por reasignar</h4>
                    <h3>{{count($porReasignar)}}</h3>
                </div>
                </a>

            @endif

            <div class="col-md-2 alert alert-warning" style="margin-left: 2%;">
                <h4> <i class="fa fa-check-circle"></i> Solucionado</h4>
                <h3>{{$porcentaje}} %</h3>
            </div>
        </div>

@if(Auth::user()->id_rol==1)
        <div for="" class="">
            <h4><b>RESUMEN GENERAL POR CONSULTORES DEL MES DE {{$mesActual}}</b></h4><br>
        </div>

        <table class="table table-responsive table-striped text-center table-condensed">
        <tr style="font-weight: bold;">
            <td><i class="fa fa-user"></i> Consultor</td>
            <td><i class="fa fa-list"></i> Asignados</td>
            <td><i class="fa fa-check"></i> Resueltos</td>
            <td><i class="fa fa-hourglass-half"></i> Por resolver</td>
            <td><i class="fa fa-check-circle"></i> Solucionado</td>
        </tr>

            <?php
            $consultores1=array();
            $consultores=array();
            $id_consultores1=array();
            $id_consultores=array();
            foreach ($ticketsMesActual as $t){
                $consultores1[]=$t->nombre;
                $id_consultores1[]=$t->id_consultor;
            }

            $consultores1=array_unique($consultores1);
             foreach ($consultores1 as $aux){
                 $consultores[]=$aux;
             }
            $id_consultores1=array_unique($id_consultores1);
            foreach ($id_consultores1 as $aux){
                $id_consultores[]=$aux;
            }
            $i=0;
            ?>


            @foreach($consultores as $c)
                @if($id_consultores[$i]!=1)

                <?php
                $asignados=0;
                $resueltos=0;
                $pendientes=0;
                foreach ($ticketsMesActual as $t){
                    if($t->id_consultor==$id_consultores[$i]){
                        $asignados++;
                    }
                }

                foreach ($ticketsResueltos as $t){
                    if($t->id_consultor==$id_consultores[$i]){
                        $resueltos++;
                    }
                }

                foreach ($ticketsPendientes as $t){
                    if($t->id_consultor==$id_consultores[$i]){
                        $pendientes++;
                    }
                }

                $resolucion=($resueltos*100)/$asignados;
                $resolucion=number_format($resolucion,0);

                ?>

                @if($resolucion<55)
                <tr class="active danger">
                    @else
                        <tr>
                        @endif

                    <td>
                        {{$c}}
                    </td>

                    <td>
                        {{$asignados}}
                    </td>

                    <td>
                        {{$resueltos}}
                    </td>

                    <td>
                        {{$pendientes}}
                    </td>
                    <td>
                        {{$resolucion}} %
                    </td>

                </tr>
                @endif
            
                <?php $i++; ?>

            @endforeach


        </table>

        @endif


        <div for="" class="">
            <h4><b>RESUMEN GENERAL AÑO {{$anioActual}}</b></h4><br>
            <table class="table table-responsive table-striped table-condensed text-center">
                <tr style="font-weight: bold">
                    <td><i class="fa fa-calendar"></i> Mes</td>
                    <td><i class="fa fa-ticket"></i> Solicitados</td>
                    <td><i class="fa fa-check"></i> Resueltos</td>
                    <td><i class="fa fa-hourglass-half"></i> Por resolver</td>
                @if(Auth::user()->id_rol==1)   <td><i class="fa fa-user-times"></i> Sin asignar</td> @endif
                    <td><i class="fa fa-check-circle"></i> Solucionado</td>
                </tr>
<?php $i=1;?>
                    @foreach($informacionMeses as $informes)

                    <?php
                    switch ($i){
                        case 1:
                            $mes='ENERO';
                            break;
                        case 2:
                            $mes='FEBRERO';
                            break;
                        case 3:
                            $mes='MARZO';
                            break;
                        case 4:
                            $mes='ABRIL';
                            break;
                        case 5:
                            $mes='MAYO';
                            break;
                        case 6:
                            $mes='JUNIO';
                            break;
                        case 7:
                            $mes='JULIO';
                            break;
                        case 8:
                            $mes='AGOSTO';
                            break;
                        case 9:
                            $mes='SEPTIEMBRE';
                            break;
                        case 10:
                            $mes='OCTUBRE';
                            break;
                        case 11:
                            $mes='NOVIEMBRE';
                            break;
                        case 12:
                            $mes='DICIEMBRE';
                            break;
                    }
                    $porcentaje_=0;
                   if(count($informes[0])>0){
                     $porcentaje_=(count($informes[1])*100)/count($informes[0]);
                   $porcentaje_=number_format($porcentaje_,0);
                     }
                    ?>

                @if(count($informes[2])>0)
                    <tr class="active danger">
                        @else
                            <tr >
@endif
                        <td>
                            {{$mes}}
                        </td>

                        <td>
                            {{count($informes[0])}}
                        </td>

                        <td>
                            {{count($informes[1])}}
                        </td>

                        <td>
                            {{count($informes[2])}}
                        </td>

                        @if(Auth::user()->id_rol==1)
                        <td>
                            {{count($informes[3])}}
                        </td>
                        @endif

                        <td>
                        {{$porcentaje_}} %
                        </td>

                    </tr>
                        <?php $i++;?>
                        @endforeach


            </table>
        </div>


    </div>


@endsection