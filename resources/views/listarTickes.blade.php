@extends('layouts.app')

@section('title')
  Admin
@endsection

@section('content')



<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main block-center">
	<h1 class="text-center">Listado de Tickets</h1><br>
	<table class="table table-striped" align="center" style="width: 100%">
		@if(count($tickets)>0)
		<thead>
			<th>Numero</th>
			@if(isset($tickets[0]->empresa))
			<th>Empresa</th>
			@endif
			<th>Descripcion</th>
			<th>Fecha</th>
			<th>Prioridad</th>
			<th>Consultor</th>
			<th>Tipo</th>
			<th>Controles</th>
		</thead>
		@foreach($tickets as $t)
			@if($t->prioridad=='')
		<tr class="danger">
			@else
				<tr class="success">
		@endif
			<td>{{$t->id}}</td>
			@if(isset($t->empresa))
			<td>{{$t->empresa}}</td>
			@endif
			<td>{{$t->descripcion}}</td>
			<td>{{$t->fecha}}</td>
			@if($t->prioridad=='')
			<td>No asignada</td>
			@else
			<td>{{$t->prioridad}}</td>
			@endif
			<td>{{$t->consultor}}</td>
			<td>{{$t->tipo}}</td>
			<td><a type="button" href="/respuesta/{{$t->id}}" class="btn btn-primary btn-sm" style="width: 30px" id="respuesta"><i class="fa fa-reply-all" aria-hidden="true"></i></a></td>
			@if($t->prioridad=='')
			<td><a type="button" href="" class="btn btn-success btn-sm" data-toggle="modal" data-id="{{$t->id}}" data-target="#asignar{{$t->id}}" style="width: 30px" id="respuesta"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>
				@endif
		</tr>

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
									<form action="">
										{{csrf_field()}}
									<div class="col-md-6">
										<label for="">Prioridad</label>
										<p id="errorPrioridad{{$t->id}}" class="text-danger" style="font-size: 14px;"></p>
										<select name="prioridad{{$t->id}}" id="prioridad{{$t->id}}" class="form-control">
											<option value="">Selecciona una prioridad...</option>
											<option value="Baja">Baja</option>
											<option value="Media">Media</option>
											<option value="Alta">Alta</option>
										</select>
									</div>
									<div class="col-md-6">
										<label for="">Consultor</label>
										<p id="errorConsultor{{$t->id}}" class="text-danger" style="font-size: 14px;"></p>
										<select name="consultor{{$t->id}}" id="consultor{{$t->id}}" class="form-control">
											<option value="">Selecciona un consultor...</option>
										@foreach($consultores as $consultor)
												<option value="{{$consultor->id}}">{{$consultor->nombre}}</option>
											@endforeach
										</select>
									</div>

										<div class="col-md-6">
											<label for="">Tipo</label>
											<p id="errorTipo{{$t->id}}" class="text-danger" style="font-size: 14px;"></p>
											<select name="tipo{{$t->id}}" id="tipo{{$t->id}}" class="form-control">
												<option value="">Selecciona un consultor...</option>
												<option value="Soporte">Soporte</option>
												<option value="Desarrollo">Desarrollo</option>
												</select>
										</div>

									<input type="hidden" value="{{$t->id}}"  id="id_ticket{{$t->id}}" name="id_ticket{{$t->id}}">
									</form>
								</div>
							</div>
							<div class="modal-footer">
								<button  class="btn btn-success" onclick="asignar({{$t->id}})">Asignar</button>
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