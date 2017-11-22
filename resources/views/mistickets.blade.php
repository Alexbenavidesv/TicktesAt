@extends('layouts.app')

@section('title')
  Admin
@endsection

@section('content')



<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main block-center">
	<h1 class="text-center">Listado de Tickets</h1>



		{{csrf_field() }}

		<div class="row text-center">



			<div class="col-md-2">
				<label for="">Número</label>
				<input type="number" min="1" class="form-control" id="filtroNumero" name="numero" placeholder="# del ticket">
			</div>

			<div class="col-md-2">
				<label for="">Estado</label>
				<select name="estado[]"   id="filtroEstado" class="form-control estadoSelect estadoSelect1" style="width: 100%">
					<option value="">Seleccione ...</option>
					<option value="0">Pendiente</option>
					<option value="2">En proceso</option>
					<option value="3">Por confirmar</option>
					<option value="4">Reasignado</option>
					<option value="1">Cerrado</option>
				</select>
			</div>
			<div class="col-md-2">
				<label for="">Prioridad</label>
				<select name="prioridad_[]"  id="filtroPrioridad" class="form-control prioridadSelect prioridadSelect1" style="width: 100%">
					<option value="">Seleccione ...</option>
					<option value="Alta">Alta</option>
					<option value="Media">Media</option>
					<option value="Baja">Baja</option>
				</select>
			</div>

			@if(Auth::user()->id_rol ==1)
				<div class="col-md-2">

					<label for="">Consultor</label>
					<select name="consultor_[]" id="filtroConsultor" class="form-control consultorSelect consultorSelect1" style="width: 100%">
						<option value="">Seleccione ...</option>
						@foreach($consultores as $consultor)
							<option value="{{$consultor->id}}">{{$consultor->name}}</option>
						@endforeach
					</select>
				</div>
			@endif

			@if(Auth::user()->id_rol !=2)
				<div class="col-md-2">

					<label for="">Empresa</label>
					<select name="empresa[]"  id="filtroEmpresa" class="form-control empresaSelect empresaSelect1" style="width: 100%">
						<option value="">Seleccione ...</option>
						@foreach($empresas as $empresa)
							<option value="{{$empresa->id}}">{{$empresa->nombre}}</option>
						@endforeach
					</select>
				</div>
			@endif

			<div class="col-md-2">
				<label for="">Tipo</label>
				<select name="tipo_[]" id="filtroTipo" class="form-control  tipoSelect tipoSelect1" style="width: 100%">
					<option value="">Seleccione ...</option>
					<option value="Sin asignar">Sin asignar</option>
					<option value="Soporte">Soporte</option>
					<option value="Desarrollo">Desarrollo</option>
					<option value="Presentación">Presentación</option>
					<option value="Reporte">Reporte</option>
					<option value="Capacitación">Capacitación</option>
					<option value="Instalación">Instalación</option>
				</select>
			</div>

			<br><br>
		</div>
		<br>
		<div class="row">

			<div class="btn-toolbar" role="toolbar">

				<div class="btn-group" role="group">
					<button class="btn btn-success" onclick="filtrarTicket(1)" style="width: 100%">
						<span class="fa fa-search"></span> Filtrar
					</button>
				</div>

				<div class="btn-group" role="group">
					<button class="btn btn-primary" onclick="location.href='/misTickets';" style="width: 100%">
						<span class="fa fa-refresh"></span> Limpiar
					</button>
				</div>

			</div>

		</div>
				<br><br>


	<div class="row" id="contenidoTickets">

		<div class="col-md-12">
	<table class="table table-striped table-condensed" align="center" style="width: 100%">
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
			@if(Auth::user()->id_rol ==1)
				@if($t->prioridad=='')
			<a type="button" href="" class="btn btn-success btn-sm" data-toggle="modal" data-id="{{$t->id}}" data-target="#asignar{{$t->id}}" style="width: 30px" id="respuesta"><i class="fa fa-cogs" aria-hidden="true"></i></a>
				@endif
				@if($t->estado==1)
						<a class="btn btn-info btn-sm"  style="width: 30px" onclick="reabrir({{$t->id}})"><i class="fa fa-undo" aria-hidden="true"></i></a>
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
									<small><b>Aqui asignará el ticket a un consultor</b></small>
								</div>

								<div class="row text-center">
									<form action="">
										{{csrf_field()}}
									<div class="col-md-6">
										<label for="">Prioridad</label>
										<p id="errorPrioridad{{$t->id}}" class="text-danger" style="font-size: 14px;"></p>
										<select name="prioridad{{$t->id}}" id="prioridad{{$t->id}}" class="prioridadSelect" style="width: 90%">
											<option value="">Selecciona una prioridad...</option>
											<option value="Baja">Baja</option>
											<option value="Media">Media</option>
											<option value="Alta">Alta</option>
										</select>
									</div>
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

										<div class="col-md-6">
											<label for="">Tipo</label>
											<p id="errorTipo{{$t->id}}" class="text-danger" style="font-size: 14px;"></p>
											<select name="tipo{{$t->id}}" id="tipo{{$t->id}}" class="tipoSelect" style="width: 90%">
												<option value="">Selecciona el tipo...</option>
												<option value="Soporte">Soporte</option>
												<option value="Desarrollo">Desarrollo</option>
												<option value="Presentación">Presentación</option>
												<option value="Reporte">Reporte</option>
												<option value="Capacitación">Capacitación</option>
												<option value="Instalación">Instalación</option>
												</select>
										</div>

									<input type="hidden" value="{{$t->id}}"  id="id_ticket{{$t->id}}" name="id_ticket{{$t->id}}">
									</form>
								</div>
							</div>
							<div class="modal-footer">
								<button  class="btn btn-success" onclick="asignar({{$t->id}})">Asignar</button>
								<button  class="btn btn-danger" onclick="cerrar({{$t->id}})">Cerrar</button>
							</div>
						</div>

					</div>
				</div>




		@endforeach
				@else
		<div class="bg-danger text-center" style="padding-top: 50px; padding-bottom: 50px"><h4>No hay tickets para mostrar</h4></div>
		@endif
	</table>
			{{ $tickets->links() }}
		</div>
	</div>

</div>

<script>
	function cerrar(id){
		//alert('cerrando');
		$('#asignar'+id).hide();
		location.href = '/consultartickets';
	};


</script>
@endsection