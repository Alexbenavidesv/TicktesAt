@extends('layouts.app')

@section('title')
    Empresas
@endsection

@section('content')
    <!-- Modal -->
    <div id="empresas" class="modal fade" role="dialog">
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

    <div id="editarempre" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Crear nueva empresa</h4>
                </div>
                <div class="modal-body">
                    formulario de edicion
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
        <button type="submit" class="btn btn-primary" style="width: 150px; margin-left: 110px;" data-toggle="modal" data-target="#empresas"><i class="fa fa-plus-square" aria-hidden="true"></i> Agregar empresa</button>

        @if(count($empresas)>0)
        <table class="table table-striped" align="center" style="width: 80%">
            <thead>
            <th>Id</th>
            <th>Nombre</th>
            <th>Nit</th>
            <th>Controle</th>
            </thead>
            @foreach($empresas as $e)
                <tbody>
                <td id="idem">{{$e->id}}</td>
                <td id="nom">{{$e->nombre}}</td>
                <td id="nitem">{{$e->nit}}</td>
                <td><button type="button" class="btn btn-success btn-sm" style="width: 30px" data-toggle="modal" data-target="#editarempre{{$e->id}}" id="editempresa"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></td>
                </tbody>
                <div id="editarempre{{$e->id}}" class="modal fade" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Crear nueva empresa</h4>
                            </div>
                            <div class="modal-body">
                                <form>
                                  {{ csrf_field() }}
                                  <div class="form-group">
                                    <p id="errornombreupdt{{$e->id}}" class="text-danger" style="font-size: 14px;">
                                    </p>
                                    <label for="nempre">Nombre</label>
                                    <input type="text" class="form-control" id="nempre{{$e->id}}" name="nempre" value="{{$e->nombre}}">
                                  </div>
                                  <div class="form-group">
                                    <p id="errornitupdt{{$e->id}}" class="text-danger" style="font-size: 14px;">
                                    </p>
                                    <label for="nitempre">Nit</label>
                                    <input type="text" class="form-control" id="nitempre{{$e->id}}" name="nitempre" value="{{$e->nit}}">
                                    <input type="hidden" id="idempreupdt{{$e->id}}" name="idempreupdt" value="{{$e->id}}">
                                  </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button  class="btn btn-success"  onclick="editarEmpresa({{$e->id}})">Editar</button>
                                <button  class="btn btn-danger" onclick="cerrar({{$e->id}})">Cerrar</button>
                            </div>
                        </div>

                    </div>
                </div>
            @endforeach
        </table>
        @else
            <div class="bg-danger text-center" style="padding-top: 50px; padding-bottom: 50px"><h4>No hay empresas registradas</h4></div>
        @endif
    </div>
<script>
function cerrar(id){
    //alert('cerrando');
    $('#asignar'+id).hide();
    location.href = '/empresas';
};
</script>
@endsection