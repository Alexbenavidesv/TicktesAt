@extends('layouts.app')

@section('title')
  Admin
@endsection

@section('content')
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main block-center">
	<div class="row">
	  <div class="col-md-2"></div>
	  <div class="col-md-8">
	  	<form id="formvisitas" method="POST" action="/guardarVisita">
	  		{{ csrf_field() }}
	  		<div class="form-group">
	  			<p id="errorempresavis" class="text-danger" style="font-size: 14px;"></p>
	  			<label for="empresa">Seleccione una empresa</label>
	  			<select class="form-control" name="empresavis" id="empresavis">
				  @foreach($empresas as $e)
				  @if($e->nombre != 'AT Soluciones')
				  <option value="{{$e->id}}">{{$e->nombre}}</option>
				  @endif
				  @endforeach
				</select>
	  		</div>

	  		<div class="form-group">
	  			<label for="tipovisita">Seleccione el tipo de visita</label>
	  			<select class="form-control" name="tipovis" id="tipovis">
				  <option value="Presentación">Presentación</option>
				  <option value="Capacitación">Capacitación</option>
				  <option value="Soporte">Soporte</option>
				</select>
	  		</div>
	  		
		    <div class="form-group">
		      <p id="errorfechavis" class="text-danger" style="font-size: 14px;"></p>
		      <label for="fechayhoravis">Fecha y hora</label>
		      <input type="datetime-local" class="form-control" id="fechayhoravis" name="fechayhoravis">
		    </div>
		    <div class="form-group">
		    	<p id="errorlugarvis" class="text-danger" style="font-size: 14px;"></p>
			    <label for="lugarvis">Lugar</label>
			    <input type="text" class="form-control" id="lugarvis" name="lugarvis" placeholder="Ej: Montería - Córdoba">
		    </div>
			
		  <label for="exampleInputPassword1">Participantes: </label>
          <div class="btn-group btn-group-xs" role="group" aria-label="...">
            <button type="button" class="btn btn-default" id="add" style="width: 50%"><i class="fa fa-plus" aria-hidden="true"></i></button>
            <button type="button" class="btn btn-default" id="del" style="width: 50%"><i class="fa fa-minus" aria-hidden="true"></i></button>
          </div><br>
    		
    	   <table id="tabla" class="table table-striped table-hover table-bordered table-condensed">
              <thead>
                <tr>
                  <th>Nombre</th>
                  <th>Cedula</th>
                  <th>Cargo</th>
                  <th>Telefono</th>
                  <th>Correo</th>
                  <th>Observación</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <p id="errornombrepar" class="text-danger" style="font-size: 14px;"></p>
                  <td><input type="text" name="nombrepar[]" id="nombrepar" class="form-control" placeholder="Nombre del participante"></td>
                  <td><input type="text" name="cedulapar[]" id="cedulapar" class="form-control" placeholder="Cedula del participante"></td>
                  <td>
                    <input type="text" name="cargopar[]" id="cargopar" class="form-control" placeholder="Cargo del participante">
                  </td>
                  <td><input type="text" name="telefonopar[]" id="telefonopar" class="form-control" placeholder="Telefono del participante"></td>
                  <td><input type="text" name="correopar[]" id="correopar" class="form-control" placeholder="Correo del participante"></td>
                  <td><input type="text" name="observacionpar[]" id="observacionpar" class="form-control" placeholder="Observación"></td>
                </tr>
              </tbody>
            </table>

            <button type="submit" id="btnvisita" class="btn btn-primary">Generar formato</button>
	     </form>
	  </div>
	  <div class="col-md-2"></div>
	</div>
</div>
@endsection