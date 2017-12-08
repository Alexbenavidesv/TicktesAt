
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">
    <link href="/css/estilo.css" rel="stylesheet">

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-datepicker.min.css') }}" rel="stylesheet">

    <link href="{{ asset('css/style3.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-datetimepicker.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.9.0/sweetalert2.min.css">
    <link href="/css/select2.min.css" rel="stylesheet" />

    <style>
        .navbar-login
        {
            width: 305px;
            padding: 10px;
            padding-bottom: 0px;
        }

        .navbar-login-session
        {
            padding: 10px;
            padding-bottom: 0px;
            padding-top: 0px;
        }

        .icon-size
        {
            font-size: 87px;
        }
    </style>
    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
<div id="app">
    <nav class="navbar navbar-default navbar-static-top" style="position: fixed; width: 100%;">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}" >
                    <li class="fa fa-ticket" style="font-size: 1.5em;"></li>
                    <span style="font-weight: bold; font-size: 1.5em;">Tickets</span> <span style="font-weight: bold; font-size: 1.5em; color: deepskyblue;">AT</span>
                </a>
            </div>



            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    &nbsp;
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if(Auth::check())

                        <?php
                        $user=explode(' ',Auth::user()->name);
                        $user=$user[0];
                        ?>

                        <li class="dropdown">

                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                <span class="fa fa-user"></span> 
                                <strong>  <?php echo $user;?></strong>
                                <span class="fa fa-chevron-down"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <div class="navbar-login">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <p class="text-center">
                                                    <span class="fa fa-user icon-size"></span>
                                                </p>
                                            </div>
                                            <div class="col-lg-8">
                                                <p class="text-left"><strong>{{ Auth::user()->name}}</strong></p>
                                                <p class="text-left">
                                                    <a href="{{ url('/logout') }} "
                                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" class="btn btn-danger btn-block">
                                                        Cerrar Sesión
                                                    </a>
                                                </p>
                                                <!--   <p class="text-left">
                                                       <a href="#" class="btn btn-primary btn-block btn-sm">Actualizar Datos</a>
                                                   </p>-->
                                            </div>
                                        </div>
                                    </div>
                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-3 col-md-2 sidebar">
                <ul class="nav nav-sidebar">
                    @if(Auth::user()->id_rol !=2)

                        <li>
                            <div class="panel-group">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a style="text-decoration: none;" href="/"><i class="fa fa-home"></i> Inicio</a>
                                        </h4>
                                    </div>

                                </div>
                            </div>
                        </li>

                    @endif
                    @if(Auth::user()->id_rol ==1)
                            <li>
                                <div class="panel-group">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a style="text-decoration: none;" href="/usuarios"><i class="fa fa-address-card"></i> Usuarios</a>
                                            </h4>
                                        </div>

                                    </div>
                                </div>
                            </li>

                            <li>
                                <div class="panel-group">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a style="text-decoration: none;" href="/empresas"><i class="fa fa-industry"></i> Empresas</a>
                                            </h4>
                                        </div>

                                    </div>
                                </div>
                            </li>
                             @endif

                        <li>
                            <div class="panel-group">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" style="text-decoration: none;" href="#collapse1"><i class="fa fa-ticket"></i> Tickets</a>
                                        </h4>
                                    </div>
                                    <div id="collapse1" class="panel-collapse collapse">
                                        <ul class="list-group">

                                            @if(Auth::user()->id_rol !=3)
                                                <li id="btntickets" ><a href="/crear_ticket" class="list-group-item"><i class="fa fa-plus-circle" aria-hidden="true"></i> Crear Ticket <span class="sr-only">(current)</span></a></li>
                                            @endif
                                            @if(Auth::user()->id_rol ==1)
                                                <li id="btnconsultarticketsroot" ><a href="/misTickets" class="list-group-item"><i class="fa fa-address-card-o" aria-hidden="true"></i> Mis Tickets</a></li>
                                            @endif

                                                <li id="btnconsultartickets" ><a href="/consultartickets" class="list-group-item"><i class="fa fa-search" aria-hidden="true"></i> Consultar Tickets</a></li>

                                                @if(Auth::user()->id_rol !=2)
                                                <li id="btnconsultartickets" ><a href="/consultarticketsna" class="list-group-item"><i class="fa fa-minus-square-o" aria-hidden="true"></i> Tickets no asignados</a></li>
                                            @endif

                                                @if(Auth::user()->id_rol !=2)
                                                    <li ><a href="/tickets_reasignar" class="list-group-item"><i class="fa fa-hourglass-end" aria-hidden="true"></i> Tickets por reasignar</a></li>
                                                @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                        

                    @if(Auth::user()->id_rol !=2)
                            <li>
                                <div class="panel-group">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a style="text-decoration: none;" href="/modulos"><i class="fa fa-list-alt" aria-hidden="true"></i> Modulos</a>
                                            </h4>
                                        </div>

                                    </div>
                                </div>
                            </li>
                    @endif

                    @if(Auth::user()->id_rol ==1)

                        <li>
                            <div class="panel-group">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" style="text-decoration: none;" href="#collapse2"><i class="fa fa-ticket"></i> Contratos</a>
                                        </h4>
                                    </div>
                                    <div id="collapse2" class="panel-collapse collapse">
                                        <ul class="list-group">

                                            <li><a href="/crear_contrato" class="list-group-item"><i class="fa fa-plus-circle" aria-hidden="true"></i> Crear contratos</a></li>
                                            <li><a href="/contratos" class="list-group-item"><i class="fa fa-list" aria-hidden="true"></i> Consultar contratos</a></li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>

                @endif


        
                @if(Auth::user()->id_rol !=2)

                            <li>
                                <div class="panel-group">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" style="text-decoration: none;" href="#collapse3"><i class="fa fa-file-text-o"></i> Visitas</a>
                                            </h4>
                                        </div>
                                        <div id="collapse3" class="panel-collapse collapse">
                                            <ul class="list-group">

                                                <li><a href="/formatoVisita" class="list-group-item"><i class="fa fa-file-text-o" aria-hidden="true"></i> Formato de visita</a></li>
                                                <li><a href="/listarvisitas" class="list-group-item"><i class="fa fa-file-text" aria-hidden="true"></i> Mis visitas</a></li>
                                                @if(Auth::user()->id_rol ==1)
                                                    <li><a href="/listarvisitasgrl" class="list-group-item"><i class="fa fa-bars" aria-hidden="true"></i> Todas las visitas</a></li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </li>


                @endif


                        @if(Auth::user()->id_rol==1)

                            <li>
                                <div class="panel-group">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a style="text-decoration: none;" href="/empresas"><i class="fa fa-cogs"></i> Parametros</a>
                                            </h4>
                                        </div>

                                    </div>
                                </div>
                            </li>

                        @endif




                </ul>
            </div>

            <div style="margin-top: 5%;">

                @yield('content')
            </div>

        </div>
    </div>
</div>

<!-- Scripts -->
<script src="/js/app.js"></script>
<script src="{{ asset('js/jquery2.0.3.min.js')}}"></script>
<script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
<script src="/js/select2.min.js"></script>

<script >
    $(document).ready(function() {

        $(".estadoSelect").val("-");
        $('.estadoSelect1').attr('multiple','multiple');
        $('.estadoSelect').select2({
            placeholder: "Seleccione...",
        });


        $('.consultorSelect').val('-');
        $('.consultorSelect1').attr('multiple','multiple');
        $('.consultorSelect').select2(
            {
                placeholder: "Seleccione...",
            }
        );

        $('.tipoSelect').val('-');
        $('.tipoSelect1').attr('multiple','multiple');
        $('.tipoSelect').select2({
            placeholder: "Seleccione...",
        });

        $('.prioridadSelect').val('-');
        $('.prioridadSelect1').attr('multiple','multiple');
        $('.prioridadSelect').select2({
            placeholder: "Seleccione...",
        });


        $('.empresaSelect').val('-');
        $('.empresaSelect1').attr('multiple','multiple');
        $('.empresaSelect').select2({
            placeholder: "Seleccione...",
        });


        $('.moduloSelect').val('-');
        $('.moduloSelect1').attr('multiple','multiple');
        $('.moduloSelect').select2({
            placeholder: "Seleccione...",
        });


        $('.moduloSelect').val('-');
        $('.moduloSelect').attr('multiple','multiple');
        $('.moduloSelect').select2({
            placeholder: "Seleccione...",
        });


        $('.buscarFecha').datepicker( {
            format: "mm-yyyy",
            viewMode: "months",
            minViewMode: "months",
            language: "es",
        });

        $('#fechainicio').datepicker({
            format: "yyyy-mm-dd",
            locale: "es"
        });

        $('.input-daterange').datepicker({
            language: "es"
        });

    });
</script>

<script>window.jQuery || document.write('<script src="{{ asset("js/jquery2.0.3.min.js")}}"><\/script>')</script>
<!-- <script src="{{ asset('js/bootstrap.min.js') }}"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.9.0/sweetalert2.min.js"></script>
<script src="{{ asset('js/Moment.js') }}"></script>
<script src="{{ asset('js/usuarios.js') }}"></script>
<script src="{{ asset('js/ticket.js') }}"></script>
<script src="{{ asset('js/empresa.js') }}"></script>
<script src="{{ asset('js/asignar.js') }}"></script>
<script src="{{ asset('js/inicio.js') }}"></script>
<script src="{{ asset('js/guardartickets.js') }}"></script>
<script src="{{ asset('js/editarempresa1.js') }}"></script>
<script src="{{ asset('js/editarUsuario.js') }}"></script>
<script src="{{ asset('js/editarespuesta.js') }}"></script>
<script src="{{ asset('js/reabrir.js') }}"></script>
<script src="{{ asset('js/visitas.js') }}"></script>
<script src="{{ asset('js/guardarvisita.js') }}"></script>
<script src="{{ asset('js/filtrarResumen.js') }}"></script>
<script src="{{ asset('js/solicitar.js') }}"></script>
<script src="{{ asset('js/modulos.js') }}"></script>
<script src="{{ asset('js/contratos.js') }}"></script>
<script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>

<script>
    $(document).ready(function() {
        $('#datetimepicker3').datetimepicker({
            format: 'LT'
        });    
    });
</script>
</body>
</html>

