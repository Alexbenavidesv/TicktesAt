@extends('layouts.app')

@section('title')
    Contratos
@endsection

@section('content')
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main block-center">

	<div class="row text-center">
		<h1 style="margin-top: -1.2%;">Listado de contratos</h1> <BR>
		<div class="col col-md-2">


			<label class="label label-primary" style="font-weight: bold; font-size: 1.1em;">FILTROS</label>
			<br><br>
			<form action="/filtrarc" method="get" id="filtrosContratos">
				<label for="">Tipo</label>
				<select name="tipoContrato_" id="tipoContrato_" class="form-control">
					<option value="">Seleccione...</option>
					<option value="MONTAJE">MONTAJE</option>
					<option value="CAPACITACIÓN">CAPACITACIÓN</option>
				</select>
				<br>
				<label for="">Empresa</label>
				<select name="empresaContrato_[]"  id="empresaContrato_" class="form-control empresaSelect empresaSelect1" style="width: 100%">
					<option value="">Seleccione ...</option>
					@foreach($empresas as $empresa)
						<option value="{{$empresa->id}}">{{$empresa->nombre}}</option>
					@endforeach
				</select>
				<br><br>
				<button type="button" class="btn btn-success btn-sm" style="width: 100%;" id="filtroContratos"><i class="fa fa-search"></i> Buscar</button>
				<br><br>
				<button type="button" class="btn btn-warning btn-sm" style="width: 100%;" id="filtroContratosLimpiar"><i class="fa fa-list"></i> Ver todo</button>
			</form>

		</div>


		<div class="col col-md-10">
			<table class="table table-striped" style="width: 100%">
		    <tr class="text-center" >
		  	  <th style="text-align: center">N°</th>
		  	  <th style="text-align: center">Tipo</th>
		  	  <th style="text-align: center">Horas</th>
		  	  <th style="text-align: center">Empresa</th>
		  	  <th style="text-align: center">Vista previa</th>
		    </tr>
		    @foreach($contratos as $con)
		    <tr>
		  	  <td>{{$con->id}}</td>
		  	  <td>{{$con->tipo}}</td>
		  	  <td>{{$con->totalhoras}}</td>
		  	  <td>{{$con->nombre}}</td>
		  	  <td style="display: " id="">
		  	  	<button class="btn btn-warning text-center" style="width: 25%; height: 5%; display: " id="vercontrato{{$con->id}}" onclick="Ver({{$con->id}})"><i class="fa fa-eye"></i></button>

		  	  	<button class="btn btn-warning text-center" style="width: 25%; height: 5%; display:none" id="ocultarcontrato{{$con->id}}" onclick="Ocultar({{$con->id}})"><i class="fa fa-close"></i></button>
		  	  	
		  	  	<button class="btn btn-success text-center" style="width: 25%; height: 5%" data-toggle="modal" data-target="#Modalcontrato{{$con->id}}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>

		  	  	<div id="Modalcontrato{{$con->id}}" class="modal fade" role="dialog">
				  <div class="modal-dialog">

				    <!-- Modal content-->
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal">&times;</button>
				        <h4 class="modal-title">Módulos</h4>
				      </div>
				      <div class="modal-body">
				      	<form id="editadohoras{{$con->id}}">
				      		{{ csrf_field() }}
				      		@foreach($modulos as $mod)
				      		@if($mod->id_contrato==$con->id)
				      		<div class="row">	
				      			<input type="hidden" name="idcontrato" id="idcontrato" value="{{$con->id}}">
				      			<input type="hidden" name="idcontrato" id="idcontrato{{$con->id}}" value="{{$con->id}}">
				      			<input type="hidden" name="idmodulo[]" id="idmodulo[]" value="{{$mod->id}}">
				      			<div class="col-md-2"></div>
				      			<div class="col-md-4">
				      				<label for="">Módulo</label>
				      				<input type="text" class="form-control" name="nombremodulo[]" id="nombremodulo[]" value="{{$mod->nombre}}" disabled><br>
				      			</div>
				      			<div class="col-md-4">
				      				<label for="">Horas</label>
				      				<input type="number" min="1" class="form-control claseVal" name="horasmodulo[]" id="horasmodulo[]" value="{{$mod->horas}}"><br>
				      			</div>
				      			<div class="col-md-2">
				      			</div>
				      		</div>
				      		@endif
							@endforeach
							<div style="text-align: left">
								<button type="button" onclick="agregarModuloContrato({{$con->id}})" id="nmodulo{{$con->id}}" class="btn btn-warning btn-sm" style="width: 25%;"><i class="fa fa-plus"></i> Agregar módulos</button>
								<button type="button" onclick="cancelarAgregarModulos({{$con->id}})" id="cnmodulo{{$con->id}}" style="display: none" class="btn btn-danger btn-sm" style="width: 10%;"><i class="fa fa-close"></i> Cancelar nuevos módulos</button>
								<br><br>
								<div class="row">
									<div class="col-md-1"></div>
									<div class="col-md-10">
										<div id="modulosExtra{{$con->id}}" class="row">

										</div>
									</div>
									<div class="col-md-1"></div>
								</div>


							</div>

				      	</form>
				      </div>
				      <div class="modal-footer">
				      	<button type="button" class="btn btn-success btn-sm" data-dismiss="modal" onclick="editar({{$con->id}})">Guardar</button>
				        <button type="button" class="btn btn-danger btn-sm"  data-dismiss="modal">Cerrar</button>
				      </div>
				    </div>

				  </div>
				</div>

		  	  </td>
		    </tr>
		    <tr>
				<td colspan="9" style="display:none;" id="contenidocontrato{{$con->id}}">
					<div class="alert alert-info">
					  <strong>Modulos:</strong>
					  @foreach($modulos as $mod)
					  @if($mod->id_contrato==$con->id)
					  <p>{{$mod->nombre}}, {{$mod->horas}} Horas</p>
					  @endif
					  @endforeach
					</div>
				</td>
			</tr>
		    @endforeach
		  </table>
		</div>
	</div>
</div>

@endsection