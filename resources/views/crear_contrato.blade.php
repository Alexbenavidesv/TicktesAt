@extends('layouts.app')

@section('title')
    Contratos
@endsection

@section('content')


    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main block-center">
        <h1 class="text-center" style="margin-top: -1.2%">Crear nuevo contrato</h1>

        <br>
        <div class="row">

            <div class="col-md-4">
                <label for="">Empresa</label>
            <select name="empresa" id="empresa" class="form-control empresaSelect">
                @foreach($empresas as $empresa)
                    <option value="{{$empresa->id}}">{{$empresa->nombre}}</option>
                @endforeach
            </select>
            </div>

            <div class="col-md-8">
                <label for="">Modulos</label>
                <select name="modulos" id="modulos" class="form-control moduloSelect">
                    @foreach($modulos as $modulo)
                        <option value="{{$modulo->id}}">{{$modulo->nombre}}</option>
                    @endforeach
                </select>
            </div>

        </div>
        <br>


        <h3 class="text-center" style="margin-top: 2%">Modulos agregados</h3>

        <table class="table table-responsive table-striped table-condensed text-center" id="tablaModulos" style="width: 80%">
<tr style="font-weight: bold;">
    <td>Módulo</td>
    <td>Horas</td>
    <td>Tipo pago</td>
</tr>
        </table>


        <div class="row">
            <br>
            <div id="listModulos">

            </div>
            <br>


        </div>
        <div id="boton">

        </div>
    </div>

    @endsection