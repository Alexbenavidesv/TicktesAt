@extends('layouts.app')

@section('title')
    Contratos
@endsection

@section('content')

    <div id="moduloNuevo" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Agregar nuevo módulo </h4>
                </div>

                <div class="modal-body">

                    <div class="row" >

                        <form id="newModulo">

                        <div class="center-block" style="width: 80%">

                            {{ csrf_field() }}
                        <label for="">Nombre del módulo</label>
                            <div style="color: red" id="errorModulo"></div>
                        <input type="text" id="nombreModulo" name="modulo" class="form-control" placeholder="Nombre">
                        </div>
                        <br>

                        <div class="center-block" style="width: 80%">
                            <label for="">Temas del módulo</label> <button type="button" onclick="agregarTema()"><i class="fa fa-plus"></i></button> <button type="button" onclick="eliminarTema()"><i class="fa fa-minus"></i></button>

                            <div style="font-weight: bold; color: red;" id="errorTemas"> </div>
                            <div style="font-weight: bold; color: red;" id="errorManuales"> </div>
                            <table id="temas" class="table" width="100%">

                                <tr>
                                <td>
                                    <label for="">
                                        Nombre del tema
                                    </label>
                                </td>
                                    <td>
                                        <label for="">Manual</label>
                                    </td>
                                </tr>

                                <tr>
                                    <td>

                                        <input type="text" name="temas[]" id="tema0" class='form-control'>
                                    </td>
                                    <td>
                                        <input id="manual0" name="manuales[]" type="file"  >
                                    </td>
                                </tr>
                            </table>

                        </div>
                        </form>
                    </div>

                </div>

                <div class="modal-footer">
                    <button  class="btn btn-success" onclick="agregarModulo()">Agregar</button>
                    <button  class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                </div>

            </div>

        </div>
    </div>



    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main block-center">


        <h1 class="text-center" style="margin-top: -1.2%">Listado de módulos</h1>

        <div class="row">
            <div class="col-md-2">
                <button class="btn btn-primary" style="width: 95%" data-toggle="modal" data-target="#moduloNuevo">
                    <i class="fa fa-plus"></i> Agregar modulo
                </button>
            </div>
        </div>
        <br><br>

        @if(count($modulos)>0)

            <div class="col-md-2">

            </div>

        <div class="col-md-10">
            <table class="table table-responsive table-condensed table-striped text-center" style="width: 100%">
            <tr style="font-weight: bold;">
                <td>Id</td>
                <td>Nombre</td>
                <td>Controles</td>
            </tr>

                @foreach($modulos as $modulo)
                <tr>
                    <td>
                    {{$modulo->id}}
                    </td>

                    <td>
                        {{$modulo->nombre}}
                    </td>
                    <td>
                        <a type="button" href="" class="btn btn-primary btn-sm"  data-toggle="modal" data-id="{{$modulo->id}}" data-target="#temas{{$modulo->id}}" style="width: 30px" id="respuesta"><i class="fa fa-eye" aria-hidden="true"></i></a>
                    <!--    <a type="button" href="" class="btn btn-success btn-sm"  style="width: 30px" id="respuesta"><i class="fa fa-edit" aria-hidden="true"></i></a>
-->
                    </td>
                </tr>

                <tr>
                    <td>
                        <div id="temas{{$modulo->id}}" class="modal fade" role="dialog">
                            <div class="modal-dialog">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Temas del modulo {{$modulo->nombre}} </h4>
                                    </div>

                                    <div class="modal-body">
                                        <div>
                                            @if(count($temas)>0)

                                                <table class="table table-responsive table-condensed tabled-triped">
                                                    <tr style="font-weight: bold">
                                                        <td>
                                                            Nombre del tema
                                                        </td>
                                                        <td>
                                                            Manual
                                                        </td>
                                                    </tr>

                                                    @foreach($temas as $tema)
                                                        @if($tema->id_modulo==$modulo->id)
                                                            <tr>
                                                                <td>
                                                                    {{$tema->nombre_tema}}
                                                                </td>

                                                                <td>
                                                                    @if($tema->manual!='')
                                                                        <div class="label label-success">
                                                                            <a href="descargar_manual/{{$tema->manual}}" style="text-decoration: none; font-size: 1.3em; color: black;">

                                                                                <i class="fa fa-download"></i>
                                                                    {{$tema->manual}}

                                                                            </a>
                                                                        </div>
                                                                        @else
                                                                        <div class="label label-danger">
                                                                            SIN MANUAL
                                                                        </div>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach

                                                </table>

                                            @else

                                                <div class="alert alert-danger">
                                                    No existen registros de temas
                                                </div>

                                            @endif


                                        </div>

                                    </div>

                                    <div class="modal-footer">
                                        <button  class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </td>
                </tr>



                    @endforeach
            </table>
            {{$modulos->links()}}
        </div>
            @else

            <div class="alert alert-danger">
                <h4>No existen registros</h4>
            </div>

        @endif

    </div>




@endsection