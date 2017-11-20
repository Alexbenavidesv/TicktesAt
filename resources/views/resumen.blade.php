@extends('layouts.app')

@section('title')
    Resumen
@endsection

@section('content')



    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main block-center">
        <h1 class="text-center" style="margin-top: -1.5%">Resumen de Tickets</h1>
        <div for="" class="">
            <h4><b>RESUMEN GENERAL MES DE {{$mesActual}}</b></h4><br>
        </div>

        <div class="row text-center">
            <div class="col-md-3 alert alert-info">
               <h4> <i class="fa fa-ticket"></i> Solicitados </h4>
                <h1>{{count($ticketsMesActual)}}</h1>
            </div>
            <div class="col-md-3 alert alert-success" style="margin-left: 1%;">
                <h4> <i class="fa fa-check"></i> Resueltos </h4>
                <h1>{{count($ticketsResueltos)}}</h1>
            </div>
            <div class="col-md-3 alert alert-danger " style="margin-left: 1%;">
                <h4> <i class="fa fa-clock-o"></i> Por resolver </h4>
                <h1>{{count($ticketsPendientes)}}</h1>
            </div>
            <div class="col-md-2 alert alert-warning" style="margin-left: 1%;">
                <h4> <i class="fa fa-percent"></i></h4>
                <h1>{{$porcentaje}} %</h1>
            </div>
        </div>


        <div for="" class="">
            <h4><b>RESUMEN POR CONSULTORES MES DE  {{$mesActual}}</b></h4><br>
        </div>

        <table class="table table-responsive table-striped text-center">
        <tr style="font-weight: bold;">
            <td>Consultor</td>
            <td>Asignados</td>
            <td>Resueltos</td>
            <td>Por resolver</td>
            <td>Resolución</td>
        </tr>

            <?php
                $consultores=array();
                $id_consultores=array();
            foreach ($ticketsMesActual as $t){
                $consultores[]=$t->nombre;
                $id_consultores[]=$t->id_consultor;
            }

            $consultores=array_unique($consultores);
            $id_consultores=array_unique($id_consultores);
            $i=0;
            ?>

            @foreach($consultores as $c)

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
                <?php $i++; ?>
                @endforeach
        </table>

    </div>


@endsection