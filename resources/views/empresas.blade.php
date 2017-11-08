@extends('layouts.app')

@section('title')
    Empresas
@endsection

@section('content')
    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Crear nueva empresa</h4>
                </div>
                <div class="modal-body">
                    <form action="">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="nombre">Nombre</label>

                            <p id="errorNombre" class="text-danger" style="font-size: 14px;"></p>
                            <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre de la empresa">
                        </div>
                        <div class="form-group">
                            <label for="cedula">Nit</label>
                            <p id="errorNit" class="text-danger" style="font-size: 14px;"></p>
                            <input type="text" class="form-control" name="nit" id="nit" placeholder="Nit de la empresa">
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button  class="btn btn-success"  id="guardarEmpresa">Guardar</button>
                    <button  class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                </div>
            </div>

        </div>
    </div>



    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main block-center">
        <h1 class="text-center">Listado de empresas</h1><br>
        <button type="submit" class="btn btn-primary" style="width: 150px; margin-left: 110px;" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus-square" aria-hidden="true"></i> Agregar empresa</button>

        @if(count($empresas)>0)
        <table class="table table-striped" align="center" style="width: 80%">
            <thead>
            <th>Id</th>
            <th>Nombre</th>
            <th>Nit</th>
            </thead>
            @foreach($empresas as $e)
                <tbody>
                <td>{{$e->id}}</td>
                <td>{{$e->nombre}}</td>
                <td>{{$e->nit}}</td>
                </tbody>
            @endforeach
        </table>
        @else
            <div class="bg-danger text-center" style="padding-top: 50px; padding-bottom: 50px"><h4>No hay empresas registradas</h4></div>
        @endif
    </div>

@endsection