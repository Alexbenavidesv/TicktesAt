@extends('layouts.app')

@section('title')
  Admin
@endsection

@section('content')
<h1 class="text-center">Tickets no asignados</h1>
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main block-center">
	<table class="table table-striped" align="center" style="width: 100%">
		@if(count($tickets)>0)
		<thead>
			<th>Numero</th>
			<th>Estado</th>
			@if(isset($tickets[0]->empresa))
			<th>Empresa</th>
			@endif
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
			<td>{{$t->id}}</td>
					@if($t->estado==0)
						<td><span class="label label-danger">Pendiente</span></td>
                        @endif
					@if($t->estado==2)
						<td><span class="label label-warning">En proceso</span></td>
                        @endif
					@if($t->estado==3)
						<td><span class="label label-primary">Por confirmar</span></td>
                        @endif
                    @if($t->estado==1)
						<td><span class="label label-success">Cerrado</span></td>
					@endif
			@if(isset($t->empresa))
			<td>{{$t->empresa}}</td>
			@endif

			<td>{{$t->fecha}}</td>
			@if($t->prioridad=='')
			<td>No asignada</td>
			@else
			<td>{{$t->prioridad}}</td>
			@endif
			<td>{{$t->consultor}}</td>
			<td>{{$t->tipo}}</td>

			<td>
				<a type="button" href="/respuesta/{{$t->id}}" class="btn btn-primary btn-sm" style="width: 30px" id="respuesta"><i class="fa fa-eye" aria-hidden="true"></i></a>
			@if(Auth::user()->id_rol!=2)
				@if($t->prioridad=='')
			<a type="button" href="" class="btn btn-success btn-sm" data-toggle="modal" data-id="{{$t->id}}" data-target="#asignar1{{$t->id}}" style="width: 30px" id="respuesta"><i class="fa fa-cogs" aria-hidden="true"></i></a>
				@endif
				@endif
			</td>
		</tr>
		<div id="asignar1{{$t->id}}" class="modal fade" role="dialog">
			<div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Asignar prioridad y consultor <b>Ticket #</b> {{$t->id}} </h4>
					</div>
					<div class="modal-body">
						<div class="alert alert-info text-center">
							<small><b>Una vez asignada la prioridad y el tipo no lo podra modificar.</b></small>
						</div>

						<div class="row text-center">
							<form >
								{{csrf_field()}}
							<div class="col-md-6">
								<label for="">Prioridad</label>
								<p id="errorPrioridad1{{$t->id}}" class="text-danger" style="font-size: 14px;"></p>
								<select name="prioridad1{{$t->id}}" id="prioridad1{{$t->id}}" class="form-control">
									<option value="">Selecciona una prioridad...</option>
									<option value="Baja">Baja</option>
									<option value="Media">Media</option>
									<option value="Alta">Alta</option>
								</select>
							</div>
							<div class="col-md-6">
								<input type="hidden" value="{{Auth::user()->id}}" id="user" name="user">
							</div>

							<div class="col-md-6">
								<label for="">Tipo</label>
								<p id="errorTipo1{{$t->id}}" class="text-danger" style="font-size: 14px;"></p>
								<select name="tipo1{{$t->id}}" id="tipo1{{$t->id}}" class="form-control">
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
						<button class="btn btn-success" onclick="noasignado({{$t->id}})">Asignar</button>
						<button  class="btn btn-danger" data-dismiss="modal">Cerrar</button>
					</div>
					<div class="modal-footer">
						
					</div>
				</div>

			</div>
		</div>
		@endforeach
		@else
		<div class="bg-danger text-center" style="padding-top: 50px; padding-bottom: 50px"><h4>No hay tickets para mostrar</h4></div>
		@endif
	</table>
</div>
<script>
function noasignado(id_ticket) {
    var id=id_ticket;
    var prio="#prioridad1"+id;
    var errprio="#errorPrioridad1"+id;
    var user="#user";
    var tip="#tipo1"+id;
    var errtip="#errorTipo1"+id;
    var tick="#id_ticket"+id;

    var tokken = $('input[name="_token"]').val();
    var prioridad=$(prio).val();
    var consultor=$(user).val();
    var tipo=$(tip).val();
    var id_ticket_=$(tick).val();

    $.ajax({
        url : "guardarasignacion",
        data : {prioridad: prioridad, consultor: consultor,tipo:tipo,id_ticket: id_ticket_, _token: tokken},
        type : 'POST',
        success:function (respuesta) {
            swal({
                    title: "Asignación realizada con exito!",
                    //text: "",
                    type: "success",
                    confirmButtonText: "Ok",
                    closeOnConfirm: false
                },
                function(isConfirm){
                    if (isConfirm) {
                        location.reload();
                    }
                });
            $(errprio).html('');
            //$(errcons).html('');
            $(errtip).html('');
            $(prio).val('');
            //$(cons).val('');
            $(tip).val('');
            $('#asignar1'+id_ticket).hide();
            location.href = '/consultartickets';
        },
        error:function (error) {
            var errores = JSON.parse(error.responseText);
            // console.log(errores);
            if (errores.lenght == 0) {
                swal({
                    title: "Se ha producido un error",
                    // text: "You will not be able to recover this imaginary file!",
                    type: "error",
                    confirmButtonText: "Ok",
                    closeOnConfirm: true
                });
            }
            else{
                if(errores.prioridad){
                    $(errprio).html(errores.prioridad);
                }
                else{
                    $(errprio).html('');
                }
                if(errores.tipo){
                    $(errtip).html(errores.tipo);
                }
                else{
                    $(errtip).html('');
                }


            }
        }
    });
}
</script>
@endsection