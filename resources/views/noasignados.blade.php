@extends('layouts.app')

@section('title')
  Admin
@endsection

@section('content')
<h1 class="text-center">Tickets no asignados</h1>
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main block-center">
	<table class="table table-striped" align="center" style="width: 100%">
		@if(count($tickets)>0)
		<thead>
			<th>Vista previa</th>
			<th>Numero</th>
			<th>Estado</th>
			@if(isset($tickets[0]->empresa))
			<th>Empresa</th>
			@endif
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
			<td>
				<a type="button" class="btn btn-warning btn-sm" style="width: 30px" id="infoticket{{$t->id}}" onclick="vistaPrevia({{$t->id}})"><i class="fa fa-eye" aria-hidden="true"></i></a>
				<a type="button"  class="btn btn-warning btn-sm" style="width: 30px; display:none" id="infoticket2{{$t->id}}" onclick="vistaPrevia2({{$t->id}})"><i class="fa fa-close" aria-hidden="true"></i></a>
			</td>
			<td>{{$t->id}}</td>
					@if($t->estado==0)
						<td><span class="label label-danger">Pendiente</span></td>
                        @endif
					@if($t->estado==2)
						<td><span class="label label-warning">En proceso</span></td>
                        @endif
					@if($t->estado==3)
						<td><span class="label label-primary">Por confirmar</span></td>
                        @endif
					@if($t->estado==4)
						<td><span class="label label-primary" style="background-color: grey;">Reasignado</span></td>
					@endif
                    @if($t->estado==1)
						<td><span class="label label-success">Cerrado</span></td>
					@endif
			@if(isset($t->empresa))
			<td>{{$t->empresa}}</td>
			@endif

			<td>{{$t->fecha}}</td>
			@if($t->prioridad=='')
			<td>No asignada</td>
			@else
			<td>{{$t->prioridad}}</td>
			@endif
			<td>{{$t->consultor}}</td>
			<td>{{$t->tipo}}</td>

			<td>
				<a type="button" href="/respuesta/{{$t->id}}" class="btn btn-primary btn-sm" style="width: 30px" id="respuesta"><i class="fa fa-eye" aria-hidden="true"></i></a>
			@if(Auth::user()->id_rol!=2)
				@if($t->prioridad=='')
			<a type="button" href="" class="btn btn-success btn-sm" data-toggle="modal" data-id="{{$t->id}}" data-target="#asignar1{{$t->id}}" style="width: 30px" id="respuesta"><i class="fa fa-cogs" aria-hidden="true"></i></a>
				@endif
				@endif
			</td>
		</tr>
		<div>
			<tr>
				<td colspan="9" style="display:none;" id="contenidoticket{{$t->id}}">
					<div class="alert alert-info">
					  <strong>{{$t->descripcion}}</strong>
					</div>
				</td>
			</tr>
		</div>
		<div id="asignar1{{$t->id}}" class="modal fade" role="dialog">
			<div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Asignar prioridad y consultor <b>Ticket #</b> {{$t->id}} </h4>
					</div>
					<div class="modal-body">
						<div class="alert alert-info text-center">
							<small><b>Una vez asignada la prioridad y el tipo no lo podra modificar.</b></small>
						</div>

						<div class="row text-center">
							<form >
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
								<input type="hidden" value="{{Auth::user()->id}}" id="user" name="user">
							</div>

							<div class="col-md-6">
								<label for="">Tipo</label>
								<p id="errorTipo{{$t->id}}" class="text-danger" style="font-size: 14px;"></p>
								<select name="tipo{{$t->id}}" id="tipo{{$t->id}}" class="form-control">
									<option value="">Selecciona el tipo...</option>
									<option value="Soporte">Soporte</option>
									<option value="Desarrollo">Desarrollo</option>
									<option value="Presentación">Presentación</option>
									<option value="Reporte">Reporte</option>
									<option value="Capacitación">Capacitación</option>
									<option value="Instalación">Instalación</option>
								</select>
							</div>


								@if(Auth::user()->id_rol==1)
									<div class="col-md-6">
										<label for="">Consultor</label>
										<p id="errorConsultor{{$t->id}}" class="text-danger" style="font-size: 14px;"></p>
										<select name="consultor{{$t->id}}" id="consultor{{$t->id}}" class="consultorSelect" style="width: 90%">
											<option value="">Selecciona un consultor...</option>
											@foreach($consultores as $consultor)
												<option value="{{$consultor->id}}">{{$consultor->name}}</option>
											@endforeach
										</select>
									</div>
								@else
									<input type="hidden" value="{{Auth::user()->id}}" id="consultor{{$t->id}}" name="consultor{{$t->id}}" name="user">
								@endif

							<input type="hidden" value="{{$t->id}}"  id="id_ticket{{$t->id}}" name="id_ticket{{$t->id}}">
							</form>
						</div>

					</div>
					<div class="modal-footer">
						<button class="btn btn-success" onclick="asignar({{$t->id}})">Asignar</button>
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