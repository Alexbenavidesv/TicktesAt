@extends('layouts.app')

@section('title')
  Admin
@endsection
<style media="screen">
  .thumb{
    width: 200px;
    transition: 300ms all ease;
    margin-left: 30%;
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

<div id="ModalEvidencia" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Agregar evidencia</h4>
			</div>
			<div class="modal-body">
				<form id="formevidenciavis" action="/guardarEvidenciaVisita" method="POST"  enctype="multipart/form-data">
					{{ csrf_field() }}
				  <div class="form-group">
            <div id="errorespvisible" style="color: red"></div>
            <label for="">Comentario</label>
            <textarea class="form-control" rows="3" name="comentariov" id="comentariov" maxlength="1000" style="resize: none;"></textarea><br>

				  	<div id="errevidenciavis" style="color: red"></div>
				    <label for="exampleInputFile">Evidencia</label>
				    <input type="file" id="evidenciavis" name="evidenciavis">
				    <input type="hidden" value="{{$visita[0]->id}}" name="idvisitaevi">
				  </div>
				  <div class="modal-footer">
					 <button type="submit" class="btn btn-success" id="enviarevidenciavis">Añadir</button>
					 <button  class="btn btn-danger" data-dismiss="modal">Cerrar</button>
				  </div>
				</form>
			</div>
		</div>

	</div>
</div>

@section('content')
<h3 class="text-center">Listado de comentarios Visita de <b>{{$visita[0]->tipo}}</b> <b>#{{$visita[0]->id}}</b> </h1>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main block-center">
	<button type="button" class="btn btn-primary" style="width: 150px; margin-left: 0px;" data-toggle="modal" data-target="#ModalEvidencia"><i class="fa fa-plus-square" aria-hidden="true"></i> Agregar evidencia</button><br><br>

@if(count($evidencia)>0)
@foreach($evidencia as $evi)
<article class="panel panel-danger panel-outline">
	<div class="panel-heading icon">
	    <h2 class="panel-title"><strong></strong> #{{$evi->id}} <i class="fa fa-user" aria-hidden="true"></i>  {{$evi->name}}  <i class="fa fa-calendar" aria-hidden="true"></i> {{$evi->fecha}} </h2>
	</div>
  <div class="panel-body">
      <strong>{{$evi->respvisible}}</strong>
  </div>
</article>

<article class="panel panel-default panel-outline">
    <div class="panel-body d-inline-block">
      <strong><img id="thumb1{{$evi->idevidencia}}" class="thumb" src="{{asset('imgEvidenciaVisitas')}}/{{utf8_encode($evi->imagen)}}"/ width="200" onclick="imagen({{$evi->idevidencia}});"></strong>
      <a href="{{url('/descargar', $evi->imagen)}}"><i class="fa fa-download" aria-hidden="true"></i> Descargar</a>
    </div>
</article>
@endforeach
@else
<div class="alert alert-danger">
  <strong>No hay comentarios para esta visita</strong>
</div>
@endif
</div>
<script>
function cerrar(id){
	//alert('cerrando');
	$('#asignar'+id).hide();
};

  var zoom = function() {
    var thumb = document.getElementById("thumb");
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