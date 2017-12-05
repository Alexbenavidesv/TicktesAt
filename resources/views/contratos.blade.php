@extends('layouts.app')

@section('title')
    Contratos
@endsection

@section('content')
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main block-center">
	<h1 style="margin-left: 25%">Listado de contratos</h1>
	<div class="row">
		<div class="col col-md-1"></div>
		<div class="col col-md-9">
			<table class="table table-striped" style="width: 100%">
		    <tr>
		  	  <th>N°</th>
		  	  <th>Tipo</th>
		  	  <th>Horas</th>
		  	  <th>Empresa</th>
		  	  <th>Vista previa</th>
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
				        <h4 class="modal-title">Modulos</h4>
				      </div>
				      <div class="modal-body">
				      	<form id="editadohoras{{$con->id}}">
				      		{{ csrf_field() }}
				      		@foreach($modulos as $mod)
				      		@if($mod->id_contrato==$con->id)
				      		<div class="row">	
				      			<input type="hidden" name="idcontrado" id="idcontrato" value="{{$con->id}}">
				      			<input type="hidden" name="idmodulo[]" id="idmodulo[]" value="{{$mod->id}}">
				      			<div class="col-md-1"></div>
				      			<div class="col-md-4">
				      				<label for="">Nombre modulo</label>
				      				<input type="text" class="form-control" name="nombremodulo[]" id="nombremodulo[]" value="{{$mod->nombre}}" disabled><br>
				      			</div>
				      			<div class="col-md-4">
				      				<label for="">Horas</label>
				      				<input type="number" min="1" class="form-control claseVal" name="horasmodulo[]" id="horasmodulo[]" value="{{$mod->horas}}"><br>
				      			</div>
				      			<div class="col-md-3">
				      			</div>
				      		</div>
				      		@endif
							@endforeach
				      	</form>
				      </div>
				      <div class="modal-footer">
				      	<button type="button" class="btn btn-success" data-dismiss="modal" onclick="editar({{$con->id}})">Guardar</button>
				        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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