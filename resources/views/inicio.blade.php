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
    <form>
	  <div class="form-group">
	    <label for="descripcion">Describa su caso</label>
	    <textarea class="form-control" rows="3" name="descripcion" maxlength="1000"></textarea>
	  </div>
	  <div class="form-group">
	    <label for="exampleInputFile">Evidencia 1</label>
	    <input type="file" id="exampleInputFile" name="evidencia1">
	  </div>
	  <div class="form-group">
	    <label for="exampleInputFile">Evidencia 2</label>
	    <input type="file" id="exampleInputFile" name="evidencia2">
	  </div>
	  <div class="form-group">
	    <label for="exampleInputFile">Evidencia 3</label>
	    <input type="file" id="exampleInputFile" name="evidencia3">
	  </div>
	  <button type="submit" class="btn btn-primary">Generar Ticket</button>
	</form>
  </div>
  <div class="col-md-2"></div>
</div>

@endsection
