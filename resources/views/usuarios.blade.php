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
        	<div class="form-group">
			    <label for="nombre">Nombre</label>
			    <input type="text" class="form-control" id="nombre" placeholder="Email">
			</div>
			<div class="form-group">
			    <label for="cedula">Cedula</label>
			    <input type="text" class="form-control" id="cedula" placeholder="cedula">
			</div>
			<div class="form-group">
			    <label for="correo">Correo</label>
			    <input type="email" class="form-control" id="exampleInputPassword1" placeholder="Password">
			</div>
			<div class="form-group">
			    <label for="empresa">Empresa</label>
			    <select class="form-control">
				  <option value="0">Seleccione una empresa</option>
				  @foreach($empresa as $empre)
				  <option value="{{$empre->id}}">{{$empre->nombre}}</option>
				  @endforeach
				</select>
			</div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-dismiss="modal">Guardar</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
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