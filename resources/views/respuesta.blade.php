@extends('layouts.app')

@section('title')
  Admin
@endsection
@section('content')
<style media="screen">
  .thumb{
    width: 200px;
    transition: 300ms all ease;
  }
  .grande{
    width: 600px;
  }

</style>
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Crear nuevo usuario</h4>
      </div>
      <div class="modal-body">
        <form id="formrespuesta" method="POST" action="/saveResponse" enctype="multipart/form-data">
        {{ csrf_field() }}

          <div class="form-group">
            <div id="err1" style="color: red"></div>
            <label for="respuesta">Respuesta</label>
            <textarea class="form-control" rows="3" name="respu" id="respu" maxlength="1000" style="resize: none;"></textarea>
          </div>

          <div class="form-group">
            <div id="err2" style="color: red"></div>
            <label for="evidencia">Evidencia</label>
            <input type="file" id="evidencia" name="evidencia">
          </div>

          <div class="form-group">
              <label for="finalizado">¿Finalizado?</label>
              <select class="form-control" name="finalizado" id="finalizado">
                  <option value="NO">NO</option>
                  <option value="SI">SI</option>
              </select>
          </div>

          <div class="form-group">
            <input type="hidden" id="idticket" name="idticket" value="{{$respuesta[0]->id}}">
          </div>
          <button type="submit" class="btn btn-primary" id="guardarRes">Generar respuesta</button>
          <button  class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        </form>
      </div>
      <div class="modal-footer">
        <!--<button  class="btn btn-success"  id="respon">Responder</button>
        <button  class="btn btn-danger" data-dismiss="modal">Cerrar</button>-->
      </div>
    </div>

  </div>
</div>



<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main block-center">
    <!-- Timeline -->
    <div class="timeline">
        <h1 class="text-center">Respuestas</h1>
        @if($estado!=1)
        <button type="button" class="btn btn-primary" style="width: 150px; margin-left: 0px;" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus-square" aria-hidden="true"></i> Generar respuesta</button><br><br>
        @endif
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
                <div class="row">
                    <div class="col-md-4">
                        <img id="thumb" class="thumb" src="{{asset('imgEvidencia')}}/{{utf8_encode($r->evidencia1)}}"/ width="300" onclick="zoom();">
                    </div>
                    <div class="col-md-4">
                        <img id="thumbev2" class="thumb" src="{{asset('imgEvidencia')}}/{{utf8_encode($r->evidencia2)}}"/ width="300" onclick="zoom2();">
                    </div>
                    <div class="col-md-4">
                        <img id="thumbev3" class="thumb" src="{{asset('imgEvidencia')}}/{{utf8_encode($r->evidencia3)}}"/ width="300" onclick="zoom4();">
                    </div>
                </div>
            </div>
        </article>
        @endif

        @if($r->tipo=='SEGUIMIENTO')
        <article class="panel panel-primary">
            <div class="panel-heading">
                <h2 class="panel-title">Respuesta de seguimiento <strong>Ticket #{{$r->id}}</strong> <strong>En seguimiento</strong></h2>
            </div>
            <div class="panel-body">
                {{$r->descripcion}}
            </div>
        </article>

        <article class="panel panel-default panel-outline">
            <div class="panel-body d-inline-block">
                <img id="thumb1{{$r->resp}}" class="thumb" src="{{asset('imgEvidencia')}}/{{utf8_encode($r->evidencia1)}}" width="300" onclick="imagen({{$r->resp}});"/>
            </div>
        </article>
        @endif

        @if($r->tipo=='CIERRE')
        <article class="panel panel-success">
            <div class="panel-heading">
                <h2 class="panel-title">Respuesta de cierre <strong>Ticket #{{$r->id}}</strong> <strong>Ticket cerrado</strong></h2>
            </div>
            <div class="panel-body">
                {{$r->descripcion}}
            </div>
        </article>

        <article class="panel panel-default panel-outline">
            <div class="panel-body d-inline-block">
                <img id="thumbcierre" class="thumb" src="{{asset('imgEvidencia')}}/{{utf8_encode($r->evidencia1)}}" width="300" onclick="zoom3();"/>
            </div>
        </article>
        @endif
        @endforeach
    </div>
    <!-- /Timeline -->
</div>
<script type="text/javascript">
  var zoom = function() {
    var thumb = document.getElementById("thumb");
    if (thumb.className == "thumb") {
      thumb.setAttribute("class", "thumb grande");
    }else {
      thumb.setAttribute("class", "thumb");
    }
    //thumb.setAttribute("class", "thumb grande");//se puede usar className
  }

  var zoom2 = function() {
    var thumb = document.getElementById("thumbev2");
    if (thumb.className == "thumb") {
      thumb.setAttribute("class", "thumb grande");
    }else {
      thumb.setAttribute("class", "thumb");
    }
    //thumb.setAttribute("class", "thumb grande");//se puede usar className
  }

  var zoom4 = function() {
    var thumb = document.getElementById("thumbev3");
    if (thumb.className == "thumb") {
      thumb.setAttribute("class", "thumb grande");
    }else {
      thumb.setAttribute("class", "thumb");
    }
    //thumb.setAttribute("class", "thumb grande");//se puede usar className
  }

  var zoom3 = function() {
    var thumb = document.getElementById("thumbcierre");
    if (thumb.className == "thumb") {
      thumb.setAttribute("class", "thumb grande");
    }else {
      thumb.setAttribute("class", "thumb");
    }
    //thumb.setAttribute("class", "thumb grande");//se puede usar className
  }

  function imagen(id){
    var img = document.getElementById("thumb1"+id);
    //alert(img);
    if (img.className == "thumb") {
      img.setAttribute("class", "thumb grande");
    }else {
      img.setAttribute("class", "thumb");
    }
  }
</script>
@endsection