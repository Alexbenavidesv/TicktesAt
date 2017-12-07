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
    display:inline-block;
    border:0;
    width:500px;
    position: relative;
    -webkit-transition: all 200ms ease-in;
    -webkit-transform: scale(1); 
    -ms-transition: all 200ms ease-in;
    -ms-transform: scale(1); 
    -moz-transition: all 200ms ease-in;
    -moz-transform: scale(1);
    transition: all 200ms ease-in;
    transform: scale(1);  
  }

  .grande:hover
  {
    box-shadow: 0px 0px 150px #000000;
    z-index: 2;
    -webkit-transition: all 200ms ease-in;
    -webkit-transform: scale(1.5);
    -ms-transition: all 200ms ease-in;
    -ms-transform: scale(1.5);   
    -moz-transition: all 200ms ease-in;
    -moz-transform: scale(1.5);
    transition: all 200ms ease-in;
    transform: scale(1.5);
  }

  .btn span.fa {
      opacity: 0;
  }
  .btn.active span.fa {
      opacity: 1;
  }
</style>
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Generar nueva respuesta</h4>
      </div>
      <div class="modal-body">
        <form id="formrespuesta" method="POST" action="/saveResponse" enctype="multipart/form-data">
        {{ csrf_field() }}

          <div class="form-group">
            <div id="err1" style="color: red"></div>
            <label for="respuesta">Respuesta</label>
            <textarea class="form-control" rows="3" name="respu" id="respu" maxlength="2000" style="resize: none;"></textarea>
          </div>
          @if(Auth::user()->id_rol !=2)
          <div class="form-group">
            <div id="err1" style="color: red"></div>
            <label for="respuesta">Respuesta no visible al cliente</label>
            <textarea class="form-control" rows="3" name="respunv" id="respunv" maxlength="2000" style="resize: none;"></textarea>
          </div>
          @endif
          <div class="form-group">
            <div id="err2" style="color: red"></div>
            <label for="evidencia">Evidencia</label>
            <input type="file" id="evidencia" name="evidencia">
          </div>
          @if(Auth::user()->id_rol !=2)

                <div class="checkbox" style="background-color: lightgrey; border-radius: 0.1em;" id="reasignarTicket">
                    <input  style="margin-left: 3px" type="checkbox" value="" id="reasignar" name="reasignar">  <label style="font-size: 1.2em;"> <b>Solicitar reasignación</b></label>
                </div>


              <div id="area" style="display: none">
                  <br>
                  <label for="">Seleccione el area a donde va a reasignar el ticket</label>
                  <select name="area_" id="area_" class="form-control" style="width: 70%">
                      <option value="Desarrollo">Desarrollo</option>
                      <option value="Soporte">Soporte</option>
                  </select>
              </div>



          @endif

            @if(Auth::user()->id_rol == 1)
                <div class="checkbox" style="background-color: lightgrey; border-radius: 0.1em;" id="nuevoConsultor_">
                    <input  style="margin-left: 3px" type="checkbox" value="" id="asignarConsultor" name="asignarConsultor">  <label style="font-size: 1.2em;"> <b>Asignar consultor</b></label>
                </div>

                <div id="nuevoConsultor" style="display: none">
                    <br>
                    <label for="">Seleccione el consultor</label>
                    <select name="consultorNuevo_" id="consultorNuevo_" class="form-control" style="width: 70%">
                        @foreach($consultores as $consultor)
                            <option value="{{$consultor->id}}">{{$consultor->nombre}}</option>
                        @endforeach
                    </select>
                    <br>

                    <label for="">Prioridad</label><br>
                    <select name="prioridadTicket_" id="prioridadTicket_" class="form-control" style="width: 70%">
                        <option value="Baja">Baja</option>
                        <option value="Media">Media</option>
                        <option value="Alta">Alta</option>
                    </select>

                </div>
            @endif

          @if(Auth::user()->id_rol == 1 || Auth::user()->id_rol == 3)
          <div class="form-group" id="select">
              <label for="finalizado">Estado</label>
              <select class="form-control" name="estadoresp" id="estadoresp" style="width: 70%">
                  <option value="0">PENDIENTE</option>
                  <option value="2">EN PROCESO</option>
                  <option value="3">POR CONFIRMAR</option>
                  @if(Auth::user()->id_rol==1)
                  <option value="1">CERRADO</option>
                      @endif
              </select>
          </div>
          @endif
          @if(Auth::user()->id_rol == 2)
          <div class="form-group" id="select">
              <label for="finalizado">¿Finalizado?</label>
              <select class="form-control" name="finalizado" id="finalizado" style="width: 70%">
                  <option value="NO">NO</option>
                  <option value="SI">SI</option>
              </select>
          </div>
          @endif
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
        @if(Auth::user()->id == $idconsultor||Auth::user()->id == $iduser || Auth::user()->id_rol == 1)
        @if($estado!=1)
        <button type="button" class="btn btn-primary" style="width: 150px; margin-left: 0px;" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus-square" aria-hidden="true"></i> Generar respuesta</button><br><br>
        @endif
        @endif
        <?php
        $i=0;
         ?>
        @foreach($respuesta as $r)

        @if($r->tipo=='APERTURA')
        <article class="panel panel-danger panel-outline">
            <div class="panel-heading icon">
                <h2 class="panel-title"><strong>Ticket #{{$r->id}}</strong> Abierto por: <i class="fa fa-user" aria-hidden="true"></i>   {{$r->nomusuario}} <i class="fa fa-hospital-o" aria-hidden="true"></i>   {{$r->empresa}} <i class="fa fa-phone" aria-hidden="true"></i>   {{$r->telefono}} <i class="fa fa-calendar" aria-hidden="true"></i>   {{$r->fecha}}</h2>
            </div>
            <div class="panel-body">
                <strong>{{$r->descripcion}}</strong>
            </div>
        </article>

        <article class="panel panel-default panel-outline">
            <div class="panel-body d-inline-block">
                <div class="row">
                    <div class="col-md-1"></div>
                    @if($r->evidencia1!='')
                    <div class="col-md-3">
                        <img id="thumb" class="thumb" src="{{asset('imgEvidencia')}}/{{utf8_encode($r->evidencia1)}}"/ width="300" onclick="zoom();"><br>
                        <a href="{{url('/descarga', $r->evidencia1)}}"><i class="fa fa-download" aria-hidden="true"></i> Descargar</a>
                    </div>
                    @endif
                    @if($r->evidencia2!='')
                    <div class="col-md-3">
                        <img id="thumbev2" class="thumb" src="{{asset('imgEvidencia')}}/{{utf8_encode($r->evidencia2)}}"/ width="300" onclick="zoom2();"><br>
                        <a href="{{url('/descarga', $r->evidencia2)}}"><i class="fa fa-download" aria-hidden="true"></i> Descargar</a>
                    </div>
                    @endif
                    @if($r->evidencia3!='')
                    <div class="col-md-3">
                        <img id="thumbev3" class="thumb" src="{{asset('imgEvidencia')}}/{{utf8_encode($r->evidencia3)}}"/ width="300" onclick="zoom4();"><br>
                        <a href="{{url('/descarga', $r->evidencia3)}}"><i class="fa fa-download" aria-hidden="true"></i> Descargar</a>
                    </div>
                    @endif
                </div>
            </div>
        </article>
        @endif


            @if($r->tipo=='SEGUIMIENTO' && trim($r->descripcion)!='' && trim($r->respuestanv)!='')
                <article class="panel panel-primary">
                    <div class="panel-heading">
                        <h2 class="panel-title"><i class="fa fa-user" aria-hidden="true"></i>   {{$usuariorespuesta[$i]}} <i class="fa fa-calendar" aria-hidden="true"></i>   {{$r->fecha}}</h2>
                    </div>
                    <div class="panel-body">
                        {{$r->descripcion}}
                    </div>
                    @if(Auth::user()->id_rol !=2)
                        <div class="panel-body">
                            {{$r->respuestanv}}
                        </div>
                    @endif
                </article>

                <article class="panel panel-default panel-outline">
                    @if($r->evidencia1!='')
                        <div class="panel-body d-inline-block">
                            <div class="row">
                                <div class="col-md-2"></div>
                                <img id="thumb1{{$r->resp}}" class="thumb" src="{{asset('imgEvidencia')}}/{{utf8_encode($r->evidencia1)}}" width="300" onclick="imagen({{$r->resp}});"/><br>
                                <a href="{{url('/descarga', $r->evidencia1)}}"><i class="fa fa-download" aria-hidden="true"></i> Descargar</a>
                            </div>
                        </div>
                    @endif
                </article>
            @endif

            @if($r->tipo=='SEGUIMIENTO' && trim($r->descripcion)!='' && trim($r->respuestanv)=='')
                <article class="panel panel-primary">
                    <div class="panel-heading">
                        <h2 class="panel-title"><i class="fa fa-user" aria-hidden="true"></i>   {{$usuariorespuesta[$i]}} <i class="fa fa-calendar" aria-hidden="true"></i>   {{$r->fecha}}</h2>
                    </div>
                    <div class="panel-body">
                        {{$r->descripcion}}
                    </div>
                    @if(Auth::user()->id_rol !=2)
                        <div class="panel-body">
                            {{$r->respuestanv}}
                        </div>
                    @endif
                </article>

                <article class="panel panel-default panel-outline">
                    @if($r->evidencia1!='')
                        <div class="panel-body d-inline-block">
                            <div class="row">
                                <div class="col-md-2"></div>
                                <img id="thumb1{{$r->resp}}" class="thumb" src="{{asset('imgEvidencia')}}/{{utf8_encode($r->evidencia1)}}" width="300" onclick="imagen({{$r->resp}});"/><br>
                                <a href="{{url('/descarga', $r->evidencia1)}}"><i class="fa fa-download" aria-hidden="true"></i> Descargar</a>
                            </div>
                        </div>
                    @endif
                </article>
            @endif


            @if($r->tipo=='SEGUIMIENTO' && trim($r->descripcion)=='' && trim($r->respuestanv)!='' && Auth::user()->id_rol !=2)
                <article class="panel panel-primary">
                    <div class="panel-heading">
                        <h2 class="panel-title"><i class="fa fa-user" aria-hidden="true"></i>   {{$usuariorespuesta[$i]}} <i class="fa fa-calendar" aria-hidden="true"></i>   {{$r->fecha}}</h2>
                    </div>

                        <div class="panel-body">
                            {{$r->respuestanv}}
                        </div>

                </article>

                <article class="panel panel-default panel-outline">
                    @if($r->evidencia1!='')
                        <div class="panel-body d-inline-block">
                            <div class="row">
                                <div class="col-md-2"></div>
                                <img id="thumb1{{$r->resp}}" class="thumb" src="{{asset('imgEvidencia')}}/{{utf8_encode($r->evidencia1)}}" width="300" onclick="imagen({{$r->resp}});"/><br>
                                <a href="{{url('/descarga', $r->evidencia1)}}"><i class="fa fa-download" aria-hidden="true"></i> Descargar</a>
                            </div>
                        </div>
                    @endif
                </article>
            @endif


        @if($r->tipo=='CIERRE')
        <article class="panel panel-success">
            <div class="panel-heading">
                  <h2 class="panel-title">Respuesta de cierre <strong>Ticket #{{$r->id}}</strong> <strong>Ticket cerrado</strong> - Cerrado por: <i class="fa fa-user" aria-hidden="true"></i>   {{$usuariorespuesta[$i]}}   <i class="fa fa-calendar" aria-hidden="true"></i>   {{$r->fecha}}</h2>
                  <input type="hidden" id="idrespuesta" name="idrespuesta" value="{{$r->idresp}}">
                  <input type="hidden" id="estadoticket" name="estadoticket" value="{{$estado}}">
                  @if(Auth::user()->id_rol == 3)
                  <button type="button" class="btn btn-success btn-sm" style="width: 30px" data-toggle="modal" data-target="#editarespuesta" id="editempresa"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                  @endif
            </div>
            <div class="panel-body">
                {{$r->descripcion}}
            </div>
            @if(Auth::user()->id_rol !=2)
            @if($r->respuestanv!='')
            <div class="panel-body">
                {{$r->respuestanv}}
            </div>
            @endif
            @endif
        </article>

        <article class="panel panel-default panel-outline">
          @if($r->evidencia1!='')
            <div class="panel-body d-inline-block">
                <div class="row">
                    <div class="col-md-2"></div>
                    <img id="thumbcierre" class="thumb" src="{{asset('imgEvidencia')}}/{{utf8_encode($r->evidencia1)}}" width="300" onclick="zoom3();"/><br>
                        <a href="{{url('/descarga', $r->evidencia1)}}"><i class="fa fa-download" aria-hidden="true"></i> Descargar</a>
                </div>
            </div>
          @endif
        </article>
            <div id="editarespuesta" class="modal fade" role="dialog">
              <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Editar respuesta</h4>
                    </div>
                    <div class="modal-body">
                        <form action="/editarRespuesta" method="POST" enctype="multipart/form-data">
                           {{ csrf_field() }}
                           <div class="form-group">
                              <p id="errordescrespuesta" class="text-danger" style="font-size: 14px;">
                              </p>
                              <label for="nempre">Descripcion</label>
                              <textarea class="form-control" rows="3" name="respuupdt" id="respuupdt" maxlength="1000" style="resize: none;">{{$r->descripcion}}</textarea>
                           </div>
                           <div class="form-group">
                              <p id="errordescrespuestanv" class="text-danger" style="font-size: 14px;">
                              </p>
                              <label for="respuupdtnv">Descripcion no visible al cliente</label>
                              <textarea class="form-control" rows="3" name="respuupdtnv" id="respuupdtnv" maxlength="1000" style="resize: none;">{{$r->respuestanv}}</textarea>
                           </div>
                           <div class="form-group">
                              <div id="errorevidenciares" style="color: red"></div>
                              <label for="evidenciaedit">Evidencia</label><br>
                              <p>{{$r->evidencia1}}</p>
                              <img id="thumbcierre" class="thumb" src="{{asset('imgEvidencia')}}/{{utf8_encode($r->evidencia1)}}" width="300" onclick="zoom3();"/><br>
                              <input type="file" id="evidenciaedit" name="evidenciaedit">
                          </div>
                          <input type="hidden" id="idrespu" name="idrespu" value="{{$r->idresp}}">
                          <input type="hidden" id="idticketupdt" name="idticketupdt" value="{{$r->id}}">
                          <div class="modal-footer">
                              <button type="submit" class="btn btn-success"  id="respuestaupdt">Editar</button>
                              <button  class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                          </div>
                        </form>
                    </div>
                </div>
              </div>
            </div>

        @endif
          <?php $i++; ?>
        @endforeach
    </div>
    <!-- /Timeline -->
</div>
<script>
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