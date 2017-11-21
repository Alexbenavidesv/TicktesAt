@extends('layouts.app')

@section('title')
  Admin
@endsection

@section('content')
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main block-center">
	<h1 class="text-center">Listado de Visitas General</h1><br>
	<table class="table table-striped table-condensed" align="center" style="width: 100%">
		<thead>
			<th>Numero</th>
			<th>estado</th>
			<th>Tipo</th>
			<th>Empresa</th>
			<th>Fecha</th>
			<th>Motivo</th>
			<th>Recolección</th>
			<th>Prospecto visitado</th>
			<th>Consultor</th>
			<th>Controles</th>
		</thead>
		@foreach($visitas as $v)
		<tbody>
			<td>{{$v->id}}</td>
			@if($v->estado==1)
			<td><span class="label label-success">Con evidencia</span></td>
			@else
			<td><span class="label label-danger">Sin evidencia</span></td>
			@endif
			<td>{{$v->tipo}}</td>
			@if($v->tipo=='Capacitación')
			@foreach($visitas2 as $v2)
			<td>{{$v2->empresa}}</td>
			@endforeach
			@else
			<td>No registra</td>
			@endif
			<td>{{$v->fecha}}</td>
			@if($v->tipo=='Capacitación')
			<td>Capacitación</td>
			@else
			<td>{{$v->motivo}}</td>
			@endif
			@if($v->tipo=='Capacitación')
			<td>No registra</td>
			@else
			<td>{{$v->recoleccion}}</td>
			@endif
			@if($v->tipo=='Capacitación')
			<td>No es un prospecto</td>
			@else
			<td>{{$v->cliente}}</td>
			@endif
			<td>{{$v->consultor}}</td>
			<td>
				<a type="button" href="/visitaPdf/{{$v->id}}" class="btn btn-danger btn-sm" style="width: 30px" id="respuesta" target="_blank"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
				
				<a type="button" href="/evidenciaVisita/{{$v->id}}" class="btn btn-success btn-sm" style="width: 30px" id="respuesta" target="_blank"><i class="fa fa-camera-retro" aria-hidden="true"></i></a>
			</td>
		</tbody>
		@endforeach
	</table>
</div>
@endsection