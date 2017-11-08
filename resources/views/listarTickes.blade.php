@extends('layouts.app')

@section('title')
  Admin
@endsection

@section('content')
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main block-center">
	<h1 class="text-center">Listado de Tickets</h1><br>
	<table class="table table-striped" align="center" style="width: 80%">
		<thead>
			<th>Numero</th>
			<th>Descripcion</th>
			<th>Fecha</th>
			<th>Prioridad</th>
			<th>Consultor</th>
		</thead>
		@foreach($tickets as $t)
		<tbody>
			<td>{{$t->id}}</td>
			<td>{{$t->descripcion}}</td>
			<td>{{$t->fecha}}</td>
			@if($t->prioridad=='')
			<td>No asignada</td>
			@else
			<td>{{$t->prioridad}}</td>
			@endif
			@if($t->id_consutor==null)
			<td>No asignado</td>
			@else
			<td>$nomconsultor</td>
			@endif
		</tbody>
		@endforeach
	</table>
</div>
@endsection