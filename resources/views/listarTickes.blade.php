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
      </div>
      <div class="modal-footer">
        <button  class="btn btn-success"  id="guardarUser">Responder</button>
        <button  class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>
    </div>

  </div>
</div>



<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main block-center">
	<h1 class="text-center">Listado de Tickets</h1><br>
	<table class="table table-striped" align="center" style="width: 80%">
		@if(count($tickets)>0)
		<thead>
			<th>Numero</th>
			<th>Descripcion</th>
			<th>Fecha</th>
			<th>Prioridad</th>
			<th>Consultor</th>
			<th>Controles</th>
		</thead>
		@foreach($tickets as $t)
		<tbody>
			<td>{{$t->id}}</td>
			<td>{{$t->descripcion}}</td>
			<td>{{$t->fecha}}</td>
			@if($t->prioridad=='')
			<td>No asignada</td>
			@else
			<td>{{$t->prioridad}}</td>
			@endif
			<td>{{$t->consultor}}</td>
			<td><a type="button" href="/respuesta/{{$t->id}}" class="btn btn-primary btn-sm" style="width: 30px" id="respuesta"><i class="fa fa-reply-all" aria-hidden="true"></i></a</td>
		</tbody>
		@endforeach
		@else
		<div class="bg-danger text-center" style="padding-top: 50px; padding-bottom: 50px"><h4>No hay tickets para mostrar</h4></div>
		@endif
		
		
	</table>
</div>
@endsection