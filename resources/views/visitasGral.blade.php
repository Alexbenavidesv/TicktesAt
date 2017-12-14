@extends('layouts.app')

@section('title')
  Admin
@endsection

@section('content')
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main block-center">
	<h1 style="margin-top:-1.2%" class="text-center">Listado de visitas general</h1><br>

<div>
	<form action="/filtroVisitas" method="get" id="filtroVisitas">
		<div class="row text-center">
			<div class="col-md-2">
				<label for=""><i class="fa fa-user"></i> Consultor</label>
				<select name="consultorVisita_[]" id="filtroConsultorVisita" class="form-control input-sm consultorSelect consultorSelect1" style="width: 100%">
					<option value="">Seleccione ...</option>
					@foreach($consultores as $consultor)
						<option value="{{$consultor->id}}">{{$consultor->nombre}}</option>
					@endforeach
				</select>
			</div>


			<div class="col-md-3">
				<label for=""><i class="fa fa-calendar"></i> Fechas</label>
				<div class="input-daterange input-group" id="rangoFecha">
					<input type="text" class="input-sm form-control"  name="fechaInicioVisita" id="fechaInicioVisita" />
					<span class="input-group-addon">A</span>
					<input type="text" class="input-sm form-control"  name="fechaFinVisita" id="fechaFinVisita" />
				</div>
			</div>

		</div>
	</form>
</div>
	<br>
	<div class="col-md-2">
	<button id="filtrarVisitas" class="btn btn-success btn-sm" style="width: 80%">
	<i class="fa fa-search"></i> Filtrar
	</button>
	</div>

	<div class="col-md-2">
	<button id="" onclick="location.href='/listarvisitasgrl'" class="btn btn-primary btn-sm" style="width: 80%; margin-left: -30%;">
	<i class="fa fa-refresh"></i> Ver todo
	</button>
	</div>

	<br><br>

		<!--CAPACITACION-->
		<div class="panel panel-warning">
		  <div class="panel-heading">Capacitación</div>
		  <div class="panel-body">
		  	@if(count($capacitacion)>0)
		  	<table class="table table-striped table-condensed" align="center" style="width: 100%">
			  	<tr>
			  		<th>Numero</th>
			  		<th>Lugar</th>
			  		<th>Fecha inicio</th>
			  		<th>Fecha fin</th>
			  		<th>Duración</th>
			  		<th>Empresa</th>
			  		<th>Consultor</th>
			  		<th>Modulo</th>
			  		<th>Controles</th>
			  	</tr>
			  	@foreach($capacitacion as $cap)
			  	<tr>
			  		<td>{{$cap->id}}</td>
			  		<td>{{$cap->lugar}}</td>
			  		<td>{{date_format(date_create($cap->fechainicio), 'Y-m-d g:i A')}}</td>
			  		<td>{{date_format(date_create($cap->fechafin), 'Y-m-d g:i A')}}</td>
			  		<td>{{$cap->duracion}} horas</td>
			  		<td>{{$cap->empresa}}</td>
			  		<td>{{$cap->consultor}}</td>
			  		<td>{{$cap->modulo}}</td>
			  		<td>
			  			<a type="button" href="/visitaPdf/{{$cap->id}}" class="btn btn-danger btn-sm" style="width: 30px" id="respuesta" target="_blank"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
			  			<a type="button" href="/evidenciaVisita/{{$cap->id}}" class="btn btn-success btn-sm" style="width: 30px" id="respuesta"><i class="fa fa-camera-retro" aria-hidden="true"></i></a>
			  		</td>
			  	</tr>
			  	@endforeach
		  	</table>
		  	@else
		  	<div class="alert alert-danger">
			  <strong>No hay visitas de tipo capacitación</strong>
			</div>
		  	@endif
		  </div>
	   </div>



		<!--CONSULTORIA-->
	   	<div class="panel panel-warning">
		  <div class="panel-heading">Consultoría</div>
		  <div class="panel-body">
		  	@if(count($consultoria)>0)
		  	<table class="table table-striped table-condensed" align="center" style="width: 100%">
			  	<tr>
			  		<th>Numero</th>
			  		<th>Lugar</th>
			  		<th>Fecha</th>
			  		<th>Empresa prospecto</th>
			  		<th>Telefono prospecto</th>
			  		<th>Interes</th>
			  		<th>Consultor</th>
			  		<th>Controles</th>
			  	</tr>
			  	@foreach($consultoria as $con)
			  	<tr>
			  		<td>{{$con->id}}</td>
			  		<td>{{$con->lugar}}</td>
			  		@if($con->estado==2)
			  		<td><label class="label label-success">{{date_format(date_create($con->fecha), 'Y-m-d g:i A')}}</label></td>
			  		@else
			  		<td>{{date_format(date_create($con->fecha), 'Y-m-d g:i A')}}</td>
			  		@endif
			  		<td>{{$con->cliente}}</td>
			  		<td>{{$con->telefono}}</td>
			  		<td>{{$con->satisfaccion}}</td>
			  		<td>{{$con->consultor}}</td>
			  		<td>
			  			<a type="button" href="/visitaPdf/{{$con->id}}" class="btn btn-danger btn-sm" style="width: 30px" id="respuesta" target="_blank"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>

			  			<a type="button" href="/evidenciaVisita/{{$con->id}}" class="btn btn-success btn-sm" style="width: 30px" id="respuesta"><i class="fa fa-camera-retro" aria-hidden="true"></i></a>

			  			<a type="button" class="btn btn-primary btn-sm" style="width: 30px" data-toggle="modal" data-target="#myModal{{$con->id}}"><i class="fa fa-pencil-square" aria-hidden="true"></i></a>


			  			<div id="myModal{{$con->id}}" class="modal fade" role="dialog">
						  <div class="modal-dialog">

						    <!-- Modal content-->
						    <div class="modal-content">
						      <div class="modal-header">
						        <button type="button" class="close" data-dismiss="modal">&times;</button>
						        <h4 class="modal-title"></h4>
						      </div>
						      <div class="modal-body">
						        <p class="text-center">¿Ya se realizó la visita <b>#{{$con->id}}</b>?</p>
						        <form id="finalizarvisita">
						        	{{ csrf_field() }}
						        	<select name="finalizadovis" id="finalizadovis{{$con->id}}" class="form-control" style="width: 20%; margin-left: 40%">
							           <option value="NO">NO</option>
							           <option value="SI">SI</option>
							        </select>
							        <input type="hidden" value="{{$con->id}}" id="idoculto{{$con->id}}" name="idoculto">
						        </form>
						      </div>
						      <div class="modal-footer">
						      	<button type="button" onclick="finalizar({{$con->id}})" class="btn btn-success" data-dismiss="modal">Enviar</button>
						        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
						      </div>
						    </div>

						  </div>
						</div>
			  		</td>
			  	</tr>
			  	@endforeach
		  	</table>
		  	@else
		  	<div class="alert alert-danger">
			  <strong>No hay visitas de tipo consultoría</strong>
			</div>
		  	@endif
		  </div>
	   </div>





	   <!--PRESENTACION-->
	   	<div class="panel panel-warning">
		  <div class="panel-heading">Presentación</div>
		  <div class="panel-body">
		  	@if(count($presentacion)>0)
		  	<table class="table table-striped table-condensed" align="center" style="width: 100%">
			  	<tr>
			  		<th>Numero</th>
			  		<th>Lugar</th>
			  		<th>Fecha</th>
			  		<th>Empresa prospecto</th>
			  		<th>Telefono prospecto</th>
			  		<th>Interes</th>
			  		<th>Consultor</th>
			  		<th>Controles</th>
			  	</tr>
			  	@foreach($presentacion as $pre)
			  	<tr>
			  		<td>{{$pre->id}}</td>
			  		<td>{{$pre->lugar}}</td>
			  		@if($pre->estado==2)
			  		<td><label class="label label-success">{{date_format(date_create($pre->fecha), 'Y-m-d g:i A')}}</label></td>
			  		@else
			  		<td>{{date_format(date_create($pre->fecha), 'Y-m-d g:i A')}}</td>
			  		@endif
			  		<td>{{$pre->cliente}}</td>
			  		<td>{{$pre->telefono}}</td>
			  		<td>{{$pre->satisfaccion}}</td>
			  		<td>{{$pre->consultor}}</td>
			  		<td>
			  			<a type="button" href="/visitaPdf/{{$pre->id}}" class="btn btn-danger btn-sm" style="width: 30px" id="respuesta" target="_blank"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>

			  			<a type="button" href="/evidenciaVisita/{{$pre->id}}" class="btn btn-success btn-sm" style="width: 30px" id="respuesta"><i class="fa fa-camera-retro" aria-hidden="true"></i></a>

			  			<a type="button" class="btn btn-primary btn-sm" style="width: 30px" data-toggle="modal" data-target="#myModal{{$pre->id}}"><i class="fa fa-pencil-square" aria-hidden="true"></i></a>


			  			<div id="myModal{{$pre->id}}" class="modal fade" role="dialog">
						  <div class="modal-dialog">

						    <!-- Modal content-->
						    <div class="modal-content">
						      <div class="modal-header">
						        <button type="button" class="close" data-dismiss="modal">&times;</button>
						        <h4 class="modal-title"></h4>
						      </div>
						      <div class="modal-body">
						        <p class="text-center">¿Ya se realizó la visita <b>#{{$pre->id}}</b>?</p>
						        <form id="finalizarvisita">
						        	{{ csrf_field() }}
						        	<select name="finalizadovis" id="finalizadovis{{$pre->id}}" class="form-control" style="width: 20%; margin-left: 40%">
							           <option value="NO">NO</option>
							           <option value="SI">SI</option>
							        </select>
							        <input type="hidden" value="{{$pre->id}}" id="idoculto{{$pre->id}}" name="idoculto">
						        </form>
						      </div>
						      <div class="modal-footer">
						      	<button type="button" onclick="finalizar({{$pre->id}})" class="btn btn-success" data-dismiss="modal">Enviar</button>
						        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
						      </div>
						    </div>

						  </div>
						</div>
			  		</td>
			  	</tr>
			  	@endforeach
		  	</table>
		  	@else
		  	<div class="alert alert-danger">
			  <strong>No hay visitas de tipo presentación</strong>
			</div>
		  	@endif
		  </div>
	   </div>




	   <!--SOPORTE-->
   	   <div class="panel panel-warning">
		  <div class="panel-heading">Soporte</div>
		  <div class="panel-body">
		  	@if(count($soporte)>0)
		  	<table class="table table-striped table-condensed" align="center" style="width: 100%">
			  	<tr>
			  		<th>Numero</th>
			  		<th>Tipo</th>
			  		<th>Lugar</th>
			  		<th>Fecha inicio</th>
			  		<th>Fecha fin</th>
			  		<th>Duración</th>
			  		<th>Empresa</th>
			  		<th>Consultor</th>
			  		<th>Controles</th>
			  	</tr>
			  	@foreach($soporte as $sop)
			  	<tr>
			  		<td>{{$sop->id}}</td>
			  		<td>{{$sop->tipo}}</td>
			  		<td>{{$sop->lugar}}</td>
			  		<td>{{date_format(date_create($sop->fechainicio), 'Y-m-d g:i A')}}</td>
			  		<td>{{date_format(date_create($sop->fechafin), 'Y-m-d g:i A')}}</td>
			  		<td>{{$sop->duracion}} Horas</td>
			  		<td>{{$sop->empresa}}</td>
			  		<td>{{$sop->consultor}}</td>
			  		<td>
			  			<a type="button" href="/visitaPdf/{{$sop->id}}" class="btn btn-danger btn-sm" style="width: 30px" id="respuesta" target="_blank"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>

			  			<a type="button" href="/evidenciaVisita/{{$sop->id}}" class="btn btn-success btn-sm" style="width: 30px" id="respuesta"><i class="fa fa-camera-retro" aria-hidden="true"></i></a>
			  		</td>
			  	</tr>
			  	@endforeach
		  	</table>
		  	@else
		  	<div class="alert alert-danger">
			  <strong>No hay visitas de tipo soporte</strong>
			</div>
		  	@endif
		  </div>
	   </div>
</div>
@endsection