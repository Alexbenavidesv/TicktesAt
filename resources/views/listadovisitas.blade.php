@extends('layouts.app')

@section('title')
  Admin
@endsection

@section('content')
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main block-center">
	<h1 class="text-center">Listado de Tickets</h1><br>
	<table class="table table-striped table-condensed" align="center" style="width: 100%">
		<thead>
			<th>Numero</th>
			<th>Tipo</th>
			<th>Empresa</th>
			<th>Fecha</th>
			<th>Consultor</th>
			<th>Controles</th>
		</thead>
		@foreach($visitas as $v)
		<tbody>
			<td>{{$v->id}}</td>
			<td>{{$v->tipo}}</td>
			<td>{{$v->empresa}}</td>
			<td>{{$v->fecha}}</td>
			<td>{{$v->consultor}}</td>
			<td>
				<a type="button" href="/visitaPdf/{{$v->id}}" class="btn btn-danger btn-sm" style="width: 30px" id="respuesta" target="_blank"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
				
				<a type="button" href="#" class="btn btn-success btn-sm" style="width: 30px" id="respuesta" target="_blank"><i class="fa fa-camera-retro" aria-hidden="true"></i></a>
			</td>
		</tbody>
		@endforeach
	</table>
</div>
@endsection