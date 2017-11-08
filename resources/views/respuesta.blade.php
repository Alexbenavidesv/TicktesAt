@extends('layouts.app')

@section('title')
  Admin
@endsection
@section('content')
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Crear nuevo usuario</h4>
      </div>
      <div class="modal-body">
        formulario
      </div>
      <div class="modal-footer">
        <button  class="btn btn-success"  id="responder">Responder</button>
        <button  class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>
    </div>

  </div>
</div>



<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main block-center">
    <!-- Timeline -->
    <div class="timeline">
        <h1 class="text-center">Respuestas</h1>
        <button type="button" class="btn btn-primary" style="width: 150px; margin-left: 0px;" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus-square" aria-hidden="true"></i> Generar respuesta</button><br><br>
        @foreach($respuesta as $r)
        @if($r->tipo=='APERTURA')
        <article class="panel panel-danger panel-outline">
            <div class="panel-heading icon">
                <h2 class="panel-title">Respuesta de apertura <strong>Ticket #{{$r->id}}</strong></h2>
            </div>
            <div class="panel-body">
                <strong>{{$r->descripcion}}</strong>
            </div>
        </article>
        
        <article class="panel panel-default panel-outline">
            <div class="panel-body d-inline-block">
                <img class="img-responsive img-rounded" src="{{asset('imgEvidencia')}}/{{utf8_encode($r->evidencia1)}}"/>
            </div>
        </article>
        @endif

        @if($r->tipo=='SEGUIMIENTO')
        <article class="panel panel-primary">
            <div class="panel-heading">
                <h2 class="panel-title">Respuesta de seguimiento <strong>Ticket #{{$r->id}}</strong></h2>
            </div>
            <div class="panel-body">
                {{$r->descripcion}}
            </div>
        </article>

        <article class="panel panel-default panel-outline">
            <div class="panel-body d-inline-block">
                <img class="img-responsive img-rounded" src="{{asset('imgEvidencia')}}/{{utf8_encode($r->evidencia1)}}"/>
            </div>
        </article>
        @endif

        @if($r->tipo=='CIERRE')
        <article class="panel panel-success">
            <div class="panel-heading">
                <h2 class="panel-title">Respuesta de cierre <strong>Ticket #{{$r->id}}</strong></h2>
            </div>
            <div class="panel-body">
                {{$r->descripcion}}
            </div>
        </article>

        <article class="panel panel-default panel-outline">
            <div class="panel-body d-inline-block">
                <img class="img-responsive img-rounded" src="{{asset('imgEvidencia')}}/{{utf8_encode($r->evidencia1)}}"/>
            </div>
        </article>
        @endif
        @endforeach
    </div>
    <!-- /Timeline -->
</div>
@endsection