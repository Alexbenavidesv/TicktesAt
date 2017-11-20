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
                    <label for="" id="errorFecha"></label>
                <input type="text" class="form-control buscarFecha" id="buscarFecha" placeholder="Mes y año"> <br>
                <button class="btn btn-success" onclick="buscarFecha()" style="width: 60%"><i class="fa fa-search"></i> Buscar</button>

                </div>
            </div>
        </div>



        <div for="" class="">
            <h4><b>RESUMEN GENERAL DEL MES DE {{$mesActual}}</b></h4><br>
        </div>

        <div class="row text-center">
            <div class="col-md-2 alert alert-info">
               <h4> <i class="fa fa-ticket"></i> Solicitados </h4>
                <h1>{{count($ticketsMesActual)}}</h1>
            </div>
            <div class="col-md-2 alert alert-success" style="margin-left: 1%;">
                <h4> <i class="fa fa-check"></i> Resueltos </h4>
                <h1>{{count($ticketsResueltos)}}</h1>
            </div>
            <div class="col-md-2 alert alert-danger " style="margin-left: 1%;">
                <h4> <i class="fa fa-hourglass-half"></i> Por resolver </h4>
                <h1>{{count($ticketsPendientes)}}</h1>
            </div>

            <div class="col-md-2 alert alert-warning" style="margin-left: 1%;">
                <h4> <i class="fa fa-user-times"></i> Sin asignar</h4>
                <h1>{{count($sinAsignar)}}</h1>
            </div>

            <div class="col-md-2 alert alert-warning" style="margin-left: 1%;">
                <h4> <i class="fa fa-check-circle"></i> Solucionado</h4>
                <h1>{{$porcentaje}} %</h1>
            </div>
        </div>


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

                <tr>

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


        <div for="" class="">
            <h4><b>RESUMEN GENERAL AÑO {{$anioActual}}</b></h4><br>
            <table class="table table-responsive table-striped table-condensed text-center">
                <tr style="font-weight: bold">
                    <td><i class="fa fa-calendar"></i> Mes</td>
                    <td><i class="fa fa-ticket"></i> Solicitados</td>
                    <td><i class="fa fa-check"></i> Resueltos</td>
                    <td><i class="fa fa-hourglass-half"></i> Por resolver</td>
                    <td><i class="fa fa-user-times"></i> Sin asignar</td>
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

                    <tr>

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

                        <td>
                            {{count($informes[3])}}
                        </td>

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