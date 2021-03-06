@extends('layouts.app')

@section('title')
  Admin
@endsection

@section('content')



<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main block-center">
	<h1 class="text-center" style="margin-top: -1.2%">Listado de Tickets</h1>
	<br>

        {!! Form::model(Request::all(),['url'=>'/filtrar_tickets','method'=>'GET','id'=>'formFiltros']) !!}

	<div class="row text-center">



		<div class="col-md-2">
			<label for=""><i class="fa fa-hashtag"></i> Número</label>
			<input type="number" min="1" class="form-control" id="filtroNumero" name="numero" placeholder="# del ticket">
		</div>

		<div class="col-md-2">
			<label for=""><i class="fa fa-bars"></i> Estado</label>
			<select name="estado[]"   id="filtroEstado" class="form-control estadoSelect estadoSelect1" style="width: 100%">
				<option value="">Seleccione ...</option>
				<option value="0">Pendiente</option>
				<option value="2">En proceso</option>
				<option value="3">Por confirmar</option>
				<option value="4">Reasignado</option>
				<option value="1">Cerrado</option>
			</select>
		</div>

		<div class="col-md-3">
			<label for=""><i class="fa fa-calendar"></i> Fechas</label>
			<div class="input-daterange input-group" id="rangoFecha">
				<input type="text" class="input-sm form-control"  name="filtroFechaInicio" id="filtroFechaInicio" />
				<span class="input-group-addon">A</span>
				<input type="text" class="input-sm form-control"  name="filtroFechaFin" id="filtroFechaFin" />
			</div>
		</div>

		<div class="col-md-2">
			<label for=""><i class="fa fa-bookmark"></i> Prioridad</label>
			<select name="prioridad_[]"  id="filtroPrioridad" class="form-control prioridadSelect prioridadSelect1" style="width: 100%">
				<option value="">Seleccione ...</option>
				<option value="Alta">Alta</option>
				<option value="Media">Media</option>
				<option value="Baja">Baja</option>
			</select>
		</div>

		@if(Auth::user()->id_rol ==1)
			<div class="col-md-2">

				<label for=""><i class="fa fa-user"></i> Consultor</label>
				<select name="consultor_[]" id="filtroConsultor" class="form-control consultorSelect consultorSelect1" style="width: 100%">
					<option value="">Seleccione ...</option>
					@foreach($consultores as $consultor)
						<option value="{{$consultor->id}}">{{$consultor->name}}</option>
					@endforeach
				</select>
			</div>
		@endif


	</div>

	<br>
	<div class="row text-center">

		@if(Auth::user()->id_rol !=2)
			<div class="col-md-2">

				<label for=""><i class="fa fa-hospital-o"></i> Empresa</label>
				<select name="empresa[]"  id="filtroEmpresa" class="form-control empresaSelect empresaSelect1" style="width: 100%">
					<option value="">Seleccione ...</option>
					@foreach($empresas as $empresa)
						<option value="{{$empresa->id}}">{{$empresa->nombre}}</option>
					@endforeach
				</select>
			</div>
		@endif

		<div class="col-md-2">
			<label for=""><i class="fa fa-dot-circle-o"></i> Tipo</label>
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


		<div class="col-md-2">
		<label for=""><i class="fa fa-list"></i> Módulo</label>
		<select name="modulo_[]" id="filtroModulo" class="form-control moduloSelect moduloSelect1">
			@foreach($modulos as $modulo)
				<option value="{{$modulo->nombre}}">{{$modulo->nombre}}</option>
			@endforeach
		</select>
	</div>

	</div>

	<br>
	<div class="row">


		<div class="btn-toolbar" role="toolbar">

			<div class="btn-group" role="group">
				<button class="btn btn-success btn-sm" type="button" id="filtrar" style="width: 100%">
					<span class="fa fa-search"></span> Filtrar
				</button>
			</div>

			<div class="btn-group" role="group">

				@if(isset($flag))
					<button class="btn btn-primary btn-sm"  type="button" onclick="location.href='/misTickets';" style="width: 100%">
						<span class="fa fa-refresh"></span> Limpiar
					</button>
				@else

				<button class="btn btn-primary btn-sm" type="button" onclick="location.href='/consultartickets';" style="width: 100%">
					<span class="fa fa-refresh"></span> Limpiar
				</button>
					@endif
			</div>

		</div>

	</div>

	{!! Form::close() !!}
	<br>
	<div class="row" id="contenidoTickets">


		<div class="col-md-12">
	<table class="table table-striped table-condensed" align="center" style="width: 100%">
		@if(count($tickets)>0)

			<thead>
				<th colspan="10">

					<div class="btn-toolbar" role="toolbar" aria-label="...">
						<div class="btn-group" role="group" aria-label="...">
							<button type="button" class="btn btn-warning btn-sm" id="verTodo" style="width: 100%;" onclick="verTodo()"><i class="fa fa-eye"></i></button>
							<button type="button" class="btn btn-danger btn-sm" id="cVerTodo" style="width: 100%; display: none;" onclick="cerrarVerTodo()"><i class="fa fa-eye-slash"></i></button>

						</div>
						@if(Auth::user()->id_rol ==1)
						<div class="btn-group" role="group" aria-label="...">
							<button type="button" id="multipleAsignacion" class="btn btn-info btn-sm" style="width: 100%;" >Asignación multiple</button>
							<button type="button" id="cancelarMultiple" class="btn btn-danger btn-sm" style="width: 100%; display:none;" >Cancelar selección</button>

						</div>

						<div class="btn-group" role="group" aria-label="...">
							<button type="button" id="crearAsignacionMultiple" data-toggle="modal" data-target="#asignacionConsultor" class="btn btn-info btn-sm" style=" display: none;width: 100%; background-color: #E1841CE6;" >Asignar a consultor</button>
						</div>
							@endif

					</div>


				</th>
			</thead>

		<thead>
		<th style="display: none;" class="tdMultiple"></th>
			<th>Ver</th>
			<th>N°</th>
			<th>Estado</th>
			@if(isset($tickets[0]->empresa))
			<th>Empresa</th>
			@endif
			<th>Módulo</th>
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
					<td style="display: none;" class="tdMultiple">
						@if(Auth::user()->id_rol ==1)
							@if($t->prioridad=='')
						<div class="checkbox">
							<label><input class="checkMultiple"  style="display: none;" type="checkbox" value="{{$t->id}}"></label>
						</div>
							@endif
							@endif
					</td>
			<td>
				<a type="button" class="btn btn-warning btn-sm verTicket" style="width: 30px" id="infoticket{{$t->id}}" onclick="vistaPrevia({{$t->id}})"><i class="fa fa-eye" aria-hidden="true"></i></a>
				<a type="button"  class="btn btn-warning btn-sm" style="width: 30px; display:none" id="infoticket2{{$t->id}}" onclick="vistaPrevia2({{$t->id}})"><i class="fa fa-close" aria-hidden="true"></i></a>
			</td>
			<td>{{$t->id}}</td>
					@if($t->estado==0)
						<td>
							<div class="progress">
								<div class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar"
									 aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%">
									<b>PENDIENTE</b>
								</div>
							</div>
						</td>
                        @endif
					@if($t->estado==2)
						<td>
							<div class="progress">
								<div class="progress-bar progress-bar-warning progress-bar-striped active" role="progressbar"
									 aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%">
									<b>PROCESO</b>
								</div>
							</div>
						</td>
                        @endif
					@if($t->estado==3)
						<td>
							<div class="progress">
								<div class="progress-bar progress-bar-primary progress-bar-striped active" role="progressbar"
									 aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%">
									<b>CONFIRMAR</b>
								</div>
							</div>
						</td>
                        @endif
					@if($t->estado==4)
						<td>
							<div class="progress">
								<div class="progress-bar progress-bar-primary progress-bar-striped"  role="progressbar"
									 aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%; background-color: grey;">
									<b>REASIGNADO</b>
								</div>
							</div>
						</td>
					@endif
                    @if($t->estado==1)
						<td>
						<div class="progress">
							<div class="progress-bar progress-bar-success progress-bar-striped"  role="progressbar"
								 aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%; ">
								<b>CERRADO</b>
							</div>
						</div>
						</td>
					@endif
			@if(isset($t->empresa))
			<td>{{$t->empresa}}</td>
			@endif

			<td>{{$t->modulo}}</td>
			<td>{{$t->fecha}}</td>
			@if($t->prioridad==NULL)
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
				<td colspan="9" style="display:none;" id="contenidoticket{{$t->id}}" class="contenidoT">
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


					<div id="asignacionConsultor" class="modal fade" role="dialog">
						<div class="modal-dialog">

							<!-- Modal content-->
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title">Asignar prioridad y consultor a tickets seleccionados </h4>
								</div>
								<div class="modal-body">
									<div class="alert alert-info text-center">
										<small><b>Aqui asignará los tickets seleccionados a un consultor</b></small>
									</div>

									<div class="row text-center">
										<form action="">
											{{csrf_field()}}
											<div class="col-md-6">
												<label for="">Prioridad</label>
												<p id="errorPrioridadMultiple" class="text-danger" style="font-size: 14px;"></p>
												<select name="prioridadMultiple" id="prioridadMultiple" class="prioridadSelect" style="width: 90%">
													<option value="">Selecciona una prioridad...</option>
													<option value="Baja">Baja</option>
													<option value="Media">Media</option>
													<option value="Alta">Alta</option>
												</select>
											</div>
											<div class="col-md-6">
												<label for="">Consultor</label>
												<p id="errorConsultorMultiple" class="text-danger" style="font-size: 14px;"></p>
												<select name="consultorMultiple" id="consultorMultiple" class="consultorSelect" style="width: 90%">
													<option value="">Selecciona un consultor...</option>
													@foreach($consultores as $consultor)
														<option value="{{$consultor->id}}">{{$consultor->name}}</option>
													@endforeach
												</select>
											</div>

											<div class="col-md-6">
												<label for="">Tipo</label>
												<p id="errorTipoMultiple" class="text-danger" style="font-size: 14px;"></p>
												<select name="tipoMultiple" id="tipoMultiple" class="tipoSelect" style="width: 90%">
													<option value="">Selecciona el tipo...</option>
													<option value="Soporte">Soporte</option>
													<option value="Desarrollo">Desarrollo</option>
													<option value="Presentación">Presentación</option>
													<option value="Reporte">Reporte</option>
													<option value="Capacitación">Capacitación</option>
													<option value="Instalación">Instalación</option>
												</select>
											</div>

										</form>
									</div>
								</div>
								<div class="modal-footer">
									<button  class="btn btn-success" id="crearAsignacionMultiple1">Asignar</button>
									<button  class="btn btn-danger" data-dismiss="modal">Cerrar</button>
								</div>
							</div>

						</div>
					</div>


				@else
		<div class="bg-danger text-center" style="padding-top: 50px; padding-bottom: 50px"><h4>No hay tickets para mostrar</h4></div>
		@endif
	</table>
            {{ $tickets->appends(Request::all())->render() }}
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