@extends('layouts.app')

@section('title')
  Admin
@endsection

@section('content')

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main block-center">
  <div class="col-md-2"></div>
  <div class="col-md-8">
  	<h1 class="text-center">Reporte su caso</h1>
  	<br>
  	<div id="mensaje"></div>	
    <form id="formulario">
    {{ csrf_field() }}
	  <div class="form-group">
	  	<div id="error1" style="color: red"></div>
	    <label for="descripcion">Describa su caso</label>
	    <textarea class="form-control" rows="3" name="descripcion" id="desc" maxlength="1000" style="resize: none;"></textarea>
	  </div>
	  <div class="form-group">
	  	<div id="error2" style="color: red"></div>
	    <label for="exampleInputFile">Evidencia 1</label>
	    <input type="file" id="ev1" name="evidencia1">
	  </div>
	  <div class="form-group">
	  	<div id="error3" style="color: red"></div>
	    <label for="exampleInputFile">Evidencia 2</label>
	    <input type="file" id="ev2" name="evidencia2">
	  </div>
	  <div class="form-group">
	  	<div id="error4" style="color: red"></div>
	    <label for="exampleInputFile">Evidencia 3</label>
	    <input type="file" id="ev3" name="evidencia3">
	  </div>
	  <button type="submit" class="btn btn-primary" id="guardar">Generar Ticket</button>
	</form>
  </div>
  <div class="col-md-2"></div>
</div>

@endsection
