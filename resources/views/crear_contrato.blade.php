@extends('layouts.app')

@section('title')
    Contratos
@endsection

@section('content')


    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main block-center">
        <h1 class="" style="margin-top: -1.2%; margin-left: 25%">Crear nuevo contrato</h1>
        <br>

        <form id="formcontrato">
            {{ csrf_field() }}
          <div class="row">
            <div class="col-md-6">
                <label for="">Tipo de contrato</label>
                <select name="tipocontrato" id="tipocontrato" class="form-control">
                        <option value="MONTAJE">MONTAJE</option>
                        <option value="CAPACITACIÓN">CAPACITACIÓN</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="">Empresa</label>
                <p id="errorempresacon" class="text-danger" style="font-size: 14px;"></p>
                <select name="empresa" id="empresa" class="form-control empresaSelect">
                    @foreach($empresas as $empresa)
                        <option value="{{$empresa->id}}">{{$empresa->nombre}}</option>
                    @endforeach
                </select>
            </div>
            
         </div><br>
         <div class="row">
            @foreach($modulos as $mod)
            <div class="col-md-2">
                <label class="label label-success" style="cursor: pointer;" onclick="Modulo({{$mod->id}}, '{{$mod->nombre}}')">{{$mod->nombre}} <i class="fa fa-plus"></i></label>
            </div>
            @endforeach
         </div>
         <br>


         <h3 style="margin-top: 2%; margin-left: 30%">Modulos agregados</h3>

         <table class="table table-responsive table-striped table-condensed text-center" id="tablaModulos" style="width: 80%">
            <tr style="font-weight: bold;">
                <td></td>
                <td>Módulo</td>
                <td>Horas</td>
                <td>Tipo pago</td>
            </tr>
            <tbody id="fila">
                <p id="errorfilas" class="text-danger" style="font-size: 14px;"></p>
            </tbody>
         </table> 
         <div class="row">
             <div class="col-md-4">
                <div class="form-group">
                    <input type="text" class="form-control" name="inputTotal" id="inputTotal" style="display: none;">
                </div>      
             </div>
         </div> 
          
          <button type="button" class="btn btn-primary" style="width: 10%" id="guardarContrato">Guardar</button>
        </form>
    </div>

    @endsection