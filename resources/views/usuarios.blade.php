@extends('layouts.app')

@section('title')
  Admin
@endsection

@section('content')
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Crear nuevo usuario</h4>
      </div>
      <div class="modal-body">
        <form action="">
			{{ csrf_field() }}
        	<div class="form-group">
			    <label for="nombre">Nombre</label>

				<p id="errorNombre" class="text-danger" style="font-size: 14px;"></p>
			    <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre completo">
			</div>
			<div class="form-group">
			    <label for="cedula">Cedula</label>
				<p id="errorCedula" class="text-danger" style="font-size: 14px;"></p>
				<input type="text" class="form-control" name="email" id="cedula" placeholder="cedula">
			</div>
			<div class="form-group">
			    <label for="correo">Correo</label>
				<p id="errorCorreo" class="text-danger" style="font-size: 14px;"></p>
			    <input type="email" class="form-control" name="correo" id="correo" placeholder="Correo">
			</div>
			<div class="form-group">
			    <label for="empresa">Empresa</label>
				<p id="errorEmpresa" class="text-danger" style="font-size: 14px;"></p>
			    <select class="form-control" name="empresa">
				  @foreach($empresa as $empre)
				  <option value="{{$empre->id}}">{{$empre->nombre}}</option>
				  @endforeach
				</select>
			</div>
			<div class="form-group">
				<label for="empresa">Rol</label>
				<p id="errorRol" class="text-danger" style="font-size: 14px;"></p>
				<select class="form-control" name="rol">
					@foreach($roles as $r)
						<option value="{{$r->id}}">{{$r->nombre}}</option>
					@endforeach
				</select>
			</div>
        </form>
      </div>
      <div class="modal-footer">
        <button  class="btn btn-success"  id="guardarUser">Guardar</button>
        <button  class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>
    </div>

  </div>
</div>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main block-center">
	<h1 class="text-center">Listado de usuarios</h1><br>
	<button type="submit" class="btn btn-primary" style="width: 150px; margin-left: 110px;" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus-square" aria-hidden="true"></i> Crear usuario</button>
	<table class="table table-striped" align="center" style="width: 80%">
		<thead>
			<th>Nombre</th>
			<th>Empresa</th>
			<th>Correo</th>
			<th>Rol</th>
		</thead>
		@foreach($users as $us)
		<tbody>
			<td>{{$us->name}}</td>
			<td>{{$us->empresa}}</td>
			<td>{{$us->correo}}</td>
			<td>{{$us->rol}}</td>
		</tbody>
		@endforeach
	</table>
</div>

@endsection