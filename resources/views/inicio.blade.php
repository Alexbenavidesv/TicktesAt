@extends('layouts.app')

@section('title')
  Admin
@endsection

@section('content')

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main block-center">

  <div class="col-md-12">


      @if($limpendiente>0 || $limporconfirmar>0)

    @if($limpendiente>0)
          <div class="alert alert-danger">
             <h3> No puedes abrir mas tickets, porque tienes {{$limpendiente}} tickets en estado PENDIENTE</h3>
          </div>
        @endif


        @if($limporconfirmar>0)
            <div class="alert alert-danger">
            <h3>    No puedes abrir mas tickets, porque tienes {{$limporconfirmar}} tickets en estado POR CONFIRMAR </h3>
            </div>
        @endif


          @else


  	<h1 class="text-center" style="margin-top: -1%;">Reporte su caso</h1>
  	<br>
  	<div id="mensaje"></div>	
    <form id="formulario">
    {{ csrf_field() }}
	  <div class="form-group">
	  	<div id="error1" style="color: red"></div>
	    <label for="descripcion">Describa su caso</label>
	    <textarea class="form-control" rows="5" name="descripcion" id="desc" maxlength="2000" style="resize: none;"></textarea>
	  </div>

		<div class="form-group">
			<label for="">
				Módulo
			</label>
			<div id="errorModuloTicket" style="color: red"></div>
			<select name="moduloTicket" id="moduloTicket" class="form-control" style="width: 50%;">
				<option value="">Seleccione...</option>
				@foreach($modulos as $modulo)
					<option value="{{$modulo->nombre}}">{{$modulo->nombre}}</option>
					@endforeach
			</select>

		</div>

        <div class="row">

            <div class="col-md-4">
                <div class="form-group">
                    <div id="error2" style="color: red"></div>
                    <label for="exampleInputFile">Evidencia 1</label>
                    <input type="file" id="ev1" name="evidencia1">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <div id="error3" style="color: red"></div>
                    <label for="exampleInputFile">Evidencia 2</label>
                    <input type="file" id="ev2" name="evidencia2">
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <div id="error4" style="color: red"></div>
                    <label for="exampleInputFile">Evidencia 3</label>
                    <input type="file" id="ev3" name="evidencia3">
                </div>
            </div>

        </div>




	  <button type="submit" class="btn btn-primary" id="guardar"><i class="fa fa-ticket"></i> Generar Ticket</button>
	</form>
          @endif
  </div>
</div>

@endsection
