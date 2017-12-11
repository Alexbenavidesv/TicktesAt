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
	  		<div class="form-group"  style="display: none" id="visempresa">
	  			<p id="errorempresavis" class="text-danger" style="font-size: 14px;"></p>
	  			<label for="empresa">Seleccione una empresa</label>
	  			<select class="form-control" name="empresavis" id="empresavis">
          <option value="">Seleccione</option>
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
  				  <option value="Consultoría">Consultoría</option>
  				  <option value="Capacitación">Capacitación</option>
            <option value="Soporte">Soporte</option>
				 </select>
	  		</div>


        <div class="row" id="otrodiv" style="display: none">
          <p id="errorsoporte1" class="text-danger" style="font-size: 14px;"></p>
          <p id="errorsoporte" class="text-danger" style="font-size: 14px;"></p>
          <div class="col-md-6">
            <label for="">Fecha y hora inicio</label>
            <input type="datetime-local" class="form-control" id="iniciosoporte" name="iniciosoporte" step="3600">
          </div>
          <div class="col-md-6">
            <label for="">Fecha y hora fin</label>
            <input type="datetime-local" class="form-control" id="finsoporte" name="finsoporte" step="3600">
          </div>
        </div>

        <div class="row">
          <div class="col-md-6" id="divselectcontrato">
            <p id="errorcontrato" class="text-danger" style="font-size: 14px;"></p>
            <div class="form-group"  style="display: none" id="divcontratovis">
              <label for="tipovisita">Seleccione el Contrato</label>
              <select class="form-control" name="contratovis" id="contratovis">
             </select>
            </div>       
          </div>
          <div class="col-md-6">
            <p id="errormodulo" class="text-danger" style="font-size: 14px;"></p>
            <div class="form-group"  style="display: none" id="divmodulovis">
              <label for="tipovisita">Seleccione el Modulo</label>
              <select class="form-control" name="modulovis" id="modulovis">
                <option value="">Selecccione el modulo</option>
             </select>
            </div>       
          </div>
        </div>

        <div class="row">
          <div class="col-md-6" id="divhoras" style="display: none">
             <label for="tipovisita">Horas disponibles</label>
             <div id="horasmodulo"></div>            
          </div>
        </div>
        
 
          <div class="row" id="divhorasing" style="display: none">
            <p id="errorhoras" class="text-danger" style="font-size: 14px;"></p>
            <p id="errorhoras2" class="text-danger" style="font-size: 14px;"></p>
            <div class="form-group col-md-6">
               <label for="">Fecha y hora inicio</label>
               <input type="datetime-local" class="form-control" id="horainicio" name="horainicio" onblur="Calcular()" step="3600">
            </div>

            <div class="form-group col-md-6">
               <label for="">Fecha y hora fin</label>
               <input type="datetime-local" class="form-control" id="horafin" name="horafin" onblur="Calcular()" step="3600">

               <input type="hidden" value="" id="oculto" name="oculto">

               <div id="algo"></div>
            </div>
          </div><br>
	  		
		    <div class="form-group" style="display: block" id="visfechahora">
		      <p id="errorfechavis" class="text-danger" style="font-size: 14px;"></p>
		      <label for="fechayhoravis">Fecha y hora</label>
		      <input type="datetime-local" class="form-control" id="fechayhoravis" name="fechayhoravis">
		    </div>

		    <div class="form-group">
		    	<p id="errorlugarvis" class="text-danger" style="font-size: 14px;"></p>
			    <label for="lugarvis">Lugar</label>
			    <input type="text" class="form-control" id="lugarvis" name="lugarvis" placeholder="Ej: Montería - Córdoba">
		    </div>

		    <div id="motivovis" style="display: block">
          <br>
          <p id="errormotivovis" class="text-danger" style="font-size: 14px;"></p>
          <label for="">Motivo de visita</label>
          <textarea class="form-control" rows="3" name="motivovistext" id="motivovistext" maxlength="1000" style="resize: none;"></textarea>
        </div>

        <div id="recoleccionvis" style="display: block">
          <br>
          <p id="errorrecoleccionvis" class="text-danger" style="font-size: 14px;"></p>
          <label for="">Recolección de la visita</label>
          <textarea class="form-control" rows="3" name="recoleccionvistext" id="recoleccionvistext" maxlength="1000" style="resize: none;"></textarea>
        </div>
        <br>

        <div id="clientefut" style="display: block">
          <div class="row">
            <div class="col-md-6" style="display: block" id="visitado">
              <p id="errorclientenvis" class="text-danger" style="font-size: 14px;"></p>
              <label for="">Cliente visitado</label>
              <input type="text" class="form-control" id="viscliente" name="viscliente">
            </div>
          </div>
          <br>
        </div>

        <div id="clientefuttel" style="display: block">
          <br>
          <p id="errortelclientenvis" class="text-danger" style="font-size: 14px;"></p>
          <label for="">Telefono cliente visitado</label>
          <input type="text" class="form-control" id="telfuturocliente" name="telfuturocliente">
        </div>

        <div id="satisdiv" style="display: block">
          <br>
          <label for="">Interes del cliente</label>
          <select class="form-control" name="satisfaccion" id="satisfaccion">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
          </select>
        </div>

		  <div id="participantes" style="display: none">
			  <label for="exampleInputPassword1">Participantes: </label>
	          <div class="btn-group btn-group-xs" role="group" aria-label="...">
	            <button type="button" class="btn btn-default" id="add" style="width: 50%"><i class="fa fa-plus" aria-hidden="true"></i></button>
	            <button type="button" class="btn btn-default" id="del" style="width: 50%"><i class="fa fa-minus" aria-hidden="true"></i></button>
	           </div><br>
    	   </div>	
         <p id="errortabla" class="text-danger" style="font-size: 14px;"></p>
    	   <table id="tabla" class="table table-striped table-hover table-bordered table-condensed" style="display: none">
              <thead>
                <tr>
                  <th>Nombre</th>
                  <th>Cargo</th>
                  <th>Telefono</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <p id="errornombrepar" class="text-danger" style="font-size: 14px;"></p>
                  <td><input type="text" name="nombrepar[]" id="nombrepar" class="form-control clase" placeholder="Nombre del participante"></td>
                  <td>
                    <input type="text" name="cargopar[]" id="cargopar" class="form-control clase1" placeholder="Cargo del participante">
                  </td>
                  <td><input type="text" name="telefonopar[]" id="telefonopar" class="form-control clase2" placeholder="Telefono del participante"></td>
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