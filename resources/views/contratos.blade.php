@extends('layouts.app')

@section('title')
    Contratos
@endsection

@section('content')
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main block-center">
	<h1 style="margin-left: 25%">Listado de contratos</h1>
	<table class="table table-striped">
	  <thead>
	  	<th>N°</th>
	  	<th>Tipo</th>
	  	<th>Horas</th>
	  	<th>Empresa</th>
	  	<th>Controles</th>
	  </thead>
	  @foreach($contratos as $con)
	  <tbody>
	  	<td>{{$con->id}}</td>
	  	<td>{{$con->tipo}}</td>
	  	<td>{{$con->totalhoras}}</td>
	  	<td>{{$con->nombre}}</td>
	  	<td></td>
	  </tbody>
	  @endforeach
	</table>
</div>

@endsection