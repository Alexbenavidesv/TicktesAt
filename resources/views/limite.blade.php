@extends('layouts.app')

@section('title')
    Limite Tickets
@endsection

@section('content')


    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main block-center">
        <h1 class="text-center" style="margin-top: -1.2%">Limite de tickets por empresa</h1><br>


        <div id="nuevoLimite" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Crear limite de tickets</h4>
                    </div>
                    <div class="modal-body">

                        <form action="">
                            {{ csrf_field() }}
                            <div class="form-group">
                            <label for="">Empresa</label><br>
                                <label for="" style="color: red;" id="errorEm"></label>
                                <select name="empresaLimite"  id="empresaLimite" class="form-control empresaSelect" style="width: 100%">
                                    <option value="">Seleccione ...</option>
                                    @for($i=0;$i<count($empresas);$i++)
                                        <option value="{{$empresas[$i]->id}}">{{$empresas[$i]->nombre}}</option>
                                    @endfor
                                </select>
                            </div>

                            <div>   <label for="" style="color: red;" id="errorT"></label> </div>
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">No. maximo tickets pendientes</label>
                                        <input type="number" name="pendientesLimite" min="0" value="0" class="form-control" placeholder="Tickets pendientes">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">No. maximo tickets por confirmar</label>
                                        <input type="number" name="porconfirmarLimite" min="0" value="0" class="form-control" placeholder="Tickets por confirmar">
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                    <div class="modal-footer">
                        <button  class="btn btn-success"  id="guardarLimite" ><i class="fa fa-save"></i> Guardar</button>
                        <button  class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
                    </div>
                </div>

            </div>
        </div>


<button class="btn btn-success btn-sm" data-toggle="modal" data-target="#nuevoLimite" style="margin-bottom: 2%; width: 12%">
   <i class="fa fa-plus-circle"></i> Limitar empresa
</button>
        @if(count($limites)>0)
<div class="text-center">
            <table class="table table-responsive table-condensed table-striped" style="width: 80%" align="center">

                <thead>
                <th class="text-center">Empresa</th>
                <th class="text-center">No. máximo tickets pendientes</th>
                <th class="text-center">No. máximo tickets por confirmar</th>
                <th class="text-center">Controles</th>
                </thead>
                @foreach($limites as $limite)
                <tr>
                    <td>{{$limite->nombre}}</td>
                    <td>{{$limite->pendientes}}</td>
                    <td>{{$limite->por_confirmar}}</td>
                    <td>
                        <a class="btn btn-success btn-sm" data-toggle="modal" data-target="#editarLimite{{$limite->id}}" style="width: 30px"><i class="fa fa-edit" aria-hidden="true"></i></a>

                    </td>
                </tr>

                    <div id="editarLimite{{$limite->id}}" class="modal fade" role="dialog">
                        <div class="modal-dialog">

                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Editar</h4>
                                </div>
                                <div class="modal-body">

                                    <form action="">
                                        {{ csrf_field() }}

                                        <div>   <label for="" style="color: red;" id="errorT{{$limite->id}}"></label> </div>
                                        <div class="row">

                                            <input type="hidden" value="{{$limite->id}}" id="idLimite{{$limite->id}}">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">No. maximo tickets pendientes</label>
                                                    <input type="number" id="editarPendientesLimite{{$limite->id}}" min="0" value="{{$limite->pendientes}}" class="form-control" placeholder="Tickets pendientes">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">No. maximo tickets por confirmar</label>
                                                    <input type="number" id="editarPorconfirmarLimite{{$limite->id}}" min="0" value="{{$limite->por_confirmar}}" class="form-control" placeholder="Tickets por confirmar">
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                                <div class="modal-footer">
                                    <button  class="btn btn-success"  onclick="editarLimite({{$limite->id}})" ><i class="fa fa-save"></i> Guardar</button>
                                    <button  class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
                                </div>
                            </div>

                        </div>
                    </div>

                    @endforeach
            </table>
</div>
            @else

            <div class="alert alert-danger text-center">
                <strong> No existen limites de tickets para ninguna empresa </strong>
            </div>

            @endif

    </div>


@endsection