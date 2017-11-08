@extends('layouts.app')

@section('title')
  Admin
@endsection

@section('content')



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
			<td><a type="button" href="/respuesta/{{$t->id}}" class="btn btn-primary btn-sm" style="width: 30px" id="respuesta"><i class="fa fa-reply-all" aria-hidden="true"></i></a></td>
			<td><a type="button" href="" class="btn btn-success btn-sm" data-toggle="modal" data-id="{{$t->id}}" data-target="#asignar{{$t->id}}" style="width: 30px" id="respuesta"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>
		</tbody>

				<div id="asignar{{$t->id}}" class="modal fade" role="dialog">
					<div class="modal-dialog">

						<!-- Modal content-->
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">Asignar prioridad y consultor <b>Ticket #</b> {{$t->id}} </h4>
							</div>
							<div class="modal-body">
								<div class="alert alert-info text-center">
									<small><b>Una vez asignada la prioridad y el consultor no lo podra modificar.</b></small>
								</div>

								<div class="row text-center">
									<div class="col-md-6">
										<label for="">Prioridad</label>
										<select name="prioridad" id="prioridad" class="form-control">
											<option value="Baja">Baja</option>
											<option value="Media">Media</option>
											<option value="Alta">Alta</option>
										</select>
									</div>
									<div class="col-md-6">
										<label for="">Consultor</label>
										<select name="consultor" id="consultor" class="form-control">

										</select>
									</div>
									<input type="hidden" value="{{$t->id}}">
								</div>
							</div>
							<div class="modal-footer">
								<button  class="btn btn-success">Asignar</button>
								<button  class="btn btn-danger" data-dismiss="modal">Cerrar</button>
							</div>
						</div>

					</div>
				</div>
		@endforeach
		@else
		<div class="bg-danger text-center" style="padding-top: 50px; padding-bottom: 50px"><h4>No hay tickets para mostrar</h4></div>
		@endif
		
		
	</table>
</div>
@endsection